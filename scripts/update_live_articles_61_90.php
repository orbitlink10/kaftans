<?php

declare(strict_types=1);

const BASE_URL = 'https://lasafi.co.ke';
const LOGIN_EMAIL = 'admin@servicelink.co.ke';
const LOGIN_PASSWORD = 'password';

$live = in_array('--live', $argv, true);
$targetIds = range(61, 90);
$workspace = dirname(__DIR__);

$generatedImages = [
    'disinfection' => $workspace.'/storage/app/public/pages/generated-61-90/lasafi-disinfection-services-nairobi-generated.png',
    'cleaning' => $workspace.'/storage/app/public/pages/generated-61-90/lasafi-residential-deep-cleaning-nairobi-generated.png',
    'office' => $workspace.'/storage/app/public/pages/generated-61-90/lasafi-office-cleaning-nairobi-generated.png',
    'upholstery' => $workspace.'/storage/app/public/pages/generated-61-90/lasafi-sofa-carpet-mattress-cleaning-generated.png',
    'pest' => $workspace.'/storage/app/public/pages/generated-61-90/lasafi-pest-control-fumigation-nairobi-generated.png',
    'termite' => $workspace.'/storage/app/public/pages/generated-61-90/lasafi-termite-rodent-control-nairobi-generated.png',
];

foreach ($generatedImages as $name => $path) {
    if (! is_file($path)) {
        fwrite(STDERR, "Missing generated image for {$name}: {$path}\n");
        exit(1);
    }
}

$client = new HttpClient(BASE_URL);
$client->login(LOGIN_EMAIL, LOGIN_PASSWORD);

$rows = $client->fetchPageRows();
$targets = array_values(array_filter($rows, fn (array $row): bool => in_array((int) $row['id'], $targetIds, true)));
usort($targets, fn (array $a, array $b): int => ((int) $a['id']) <=> ((int) $b['id']));
$backupPath = $workspace.'/storage/app/live-pages-61-90-backup-'.date('Ymd-His').'.json';

if (count($targets) !== count($targetIds)) {
    $found = implode(', ', array_column($targets, 'id'));
    fwrite(STDERR, 'Expected 30 target pages, found '.count($targets).": {$found}\n");
    exit(1);
}

$originals = [];
$reports = [];

foreach ($targets as $target) {
    $edit = $client->get('/pages/'.$target['id'].'/edit');
    $fields = parseEditForm($edit['body']);
    $rawDescription = $fields['description'] ?? '';
    $imagePath = selectGeneratedImage($fields['title'], $generatedImages);

    $description = buildArticleHtml($rawDescription, $fields['title'], null, $target, $targets);
    $payload = buildPayload($fields, $description);
    $counts = articleCounts($description);

    $originals[(int) $target['id']] = [
        'target' => $target,
        'fields' => $fields,
        'raw' => $rawDescription,
        'image' => $imagePath,
    ];

    if (! $live) {
        $reports[] = sprintf(
            'DRY %d | %s | h2=%d h3=%d imgs=%d links=%d | image=%s',
            $target['id'],
            $fields['title'],
            $counts['h2'],
            $counts['h3'],
            $counts['images'],
            $counts['internal_links'],
            basename($imagePath),
        );
        continue;
    }

    file_put_contents($backupPath, json_encode($originals, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    $client->post('/pages/'.$target['id'], $payload, $imagePath);
    $preview = $client->get('/'.$target['slug']);
    $heroUrl = extractHeroImageUrl($preview['body']);
    $finalDescription = buildArticleHtml($rawDescription, $fields['title'], $heroUrl, $target, $targets);
    $finalCounts = articleCounts($finalDescription);
    $client->post('/pages/'.$target['id'], buildPayload($fields, $finalDescription), null);

    $reports[] = sprintf(
        'LIVE %d | %s | h2=%d h3=%d imgs=%d links=%d | hero=%s',
        $target['id'],
        $fields['title'],
        $finalCounts['h2'],
        $finalCounts['h3'],
        $finalCounts['images'],
        $finalCounts['internal_links'],
        $heroUrl ?: 'not-found',
    );
}

echo implode(PHP_EOL, $reports).PHP_EOL;

if (! $live) {
    echo PHP_EOL.'Dry run only. Re-run with --live to update the live dashboard.'.PHP_EOL;
} else {
    echo PHP_EOL.'Original live fields backed up to '.$backupPath.PHP_EOL;
}

final class HttpClient
{
    private string $cookieFile;

    public function __construct(private readonly string $baseUrl)
    {
        $this->cookieFile = tempnam(sys_get_temp_dir(), 'lasafi-cookies-');
    }

    public function __destruct()
    {
        if (is_file($this->cookieFile)) {
            @unlink($this->cookieFile);
        }
    }

    public function login(string $email, string $password): void
    {
        $login = $this->get('/login');
        $token = extractCsrfToken($login['body']);

        $response = $this->request('POST', '/login', [
            '_token' => $token,
            'email' => $email,
            'password' => $password,
        ]);

        if (! str_contains($response['url'], '/dashboard') && ! str_contains($response['url'], '/pages')) {
            $pages = $this->get('/pages');
            if (! str_contains($pages['body'], 'Post List')) {
                throw new RuntimeException('Login did not reach an authenticated dashboard page.');
            }
        }
    }

    /**
     * @return array<int, array{id:int,title:string,slug:string}>
     */
    public function fetchPageRows(): array
    {
        $rows = [];

        for ($page = 1; $page <= 3; $page++) {
            $response = $this->get('/pages?page='.$page);
            preg_match_all('/<tr>\s*<td>.*?<\/tr>/is', $response['body'], $matches);

            foreach ($matches[0] as $rowHtml) {
                if (! preg_match('/<td class="pages-no">\s*(\d+)\s*<\/td>/i', $rowHtml, $idMatch)) {
                    continue;
                }

                preg_match_all('/<td(?:[^>]*)>(.*?)<\/td>/is', $rowHtml, $cellMatches);
                $cells = $cellMatches[1] ?? [];
                $title = isset($cells[3]) ? cleanCellText($cells[3]) : '';

                $slug = '';
                if (preg_match('/href="https:\/\/lasafi\.co\.ke\/([^"]+)"\s+target="_blank"/i', $rowHtml, $slugMatch)) {
                    $slug = html_entity_decode($slugMatch[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }

                $rows[] = [
                    'id' => (int) $idMatch[1],
                    'title' => $title,
                    'slug' => $slug,
                ];
            }
        }

        return $rows;
    }

    /**
     * @return array{status:int,url:string,body:string}
     */
    public function get(string $path): array
    {
        return $this->request('GET', $path);
    }

    /**
     * @param array<string, string> $fields
     * @return array{status:int,url:string,body:string}
     */
    public function post(string $path, array $fields, ?string $imagePath = null): array
    {
        if ($imagePath !== null) {
            $fields['image'] = new CURLFile($imagePath, mime_content_type($imagePath) ?: 'image/png', basename($imagePath));
        }

        return $this->request('POST', $path, $fields);
    }

    /**
     * @param null|array<string, mixed> $fields
     * @return array{status:int,url:string,body:string}
     */
    private function request(string $method, string $path, ?array $fields = null): array
    {
        $url = str_starts_with($path, 'http') ? $path : $this->baseUrl.$path;
        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 8,
            CURLOPT_COOKIEJAR => $this->cookieFile,
            CURLOPT_COOKIEFILE => $this->cookieFile,
            CURLOPT_USERAGENT => 'Lasafi Article Formatter/1.0',
            CURLOPT_TIMEOUT => 60,
        ]);

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            $hasFile = $fields !== null && array_filter($fields, fn ($value): bool => $value instanceof CURLFile);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $hasFile ? $fields : http_build_query($fields ?? []));
        }

        $body = curl_exec($curl);
        if ($body === false) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new RuntimeException($error);
        }

        $status = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $effectiveUrl = (string) curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        curl_close($curl);

        if ($status >= 400) {
            throw new RuntimeException("HTTP {$status} for {$url}");
        }

        return [
            'status' => $status,
            'url' => $effectiveUrl,
            'body' => (string) $body,
        ];
    }
}

/**
 * @return array<string, string>
 */
function parseEditForm(string $html): array
{
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);

    $fields = [];
    foreach (['_token', 'meta_title', 'meta_description', 'title', 'alt', 'heading_2', 'type', 'description'] as $name) {
        $fields[$name] = fieldValue($xpath, $name);
    }

    if ($fields['_token'] === '' || $fields['title'] === '' || $fields['description'] === '') {
        throw new RuntimeException('Could not parse edit form fields.');
    }

    return $fields;
}

function fieldValue(DOMXPath $xpath, string $name): string
{
    $nodes = $xpath->query('//*[@name="'.$name.'"]');
    if (! $nodes || $nodes->length === 0) {
        return '';
    }

    $node = $nodes->item(0);
    if (! $node instanceof DOMElement) {
        return '';
    }

    if ($node->tagName === 'textarea') {
        return trim($node->textContent);
    }

    if ($node->tagName === 'select') {
        foreach ($node->getElementsByTagName('option') as $option) {
            if ($option instanceof DOMElement && $option->hasAttribute('selected')) {
                return trim($option->getAttribute('value') ?: $option->textContent);
            }
        }

        $first = $node->getElementsByTagName('option')->item(0);
        return $first instanceof DOMElement ? trim($first->getAttribute('value') ?: $first->textContent) : '';
    }

    return trim($node->getAttribute('value'));
}

/**
 * @param array<string, string> $fields
 * @return array<string, string>
 */
function buildPayload(array $fields, string $description): array
{
    return [
        '_token' => $fields['_token'],
        '_method' => 'PUT',
        'meta_title' => truncate($fields['meta_title'] ?: $fields['title'].' | Lasafi', 160),
        'meta_description' => truncate($fields['meta_description'] ?: excerpt($description, 155), 255),
        'title' => truncate($fields['title'], 180),
        'alt' => truncate($fields['alt'] ?: $fields['title'], 160),
        'heading_2' => truncate($fields['heading_2'] ?: overviewHeading($fields['title']), 180),
        'type' => $fields['type'] ?: 'Post',
        'description' => $description,
    ];
}

function buildArticleHtml(string $source, string $title, ?string $inlineImageUrl, array $target, array $allTargets): string
{
    if (preg_match('/<(p|h2|h3|ul|ol|li|blockquote|table|img)\b/i', $source)) {
        $html = ensureFormattedHtml($source);
    } else {
        $html = markdownToHtml($source, $title, $inlineImageUrl);
    }

    if ($inlineImageUrl !== null && ! preg_match('/<img\b/i', $html)) {
        $html = insertInlineImage($html, $inlineImageUrl, $title);
    }

    $html = removeDuplicateRelatedSection($html);
    $html .= "\n\n".relatedSection($target, $allTargets);

    if (! preg_match('/<h2\b/i', $html)) {
        $html = '<h2>'.e(overviewHeading($title)).'</h2>'."\n\n".$html;
    }

    if (! preg_match('/<h3\b/i', $html)) {
        $html = addFallbackH3($html, $title);
    }

    return trim($html);
}

function markdownToHtml(string $source, string $title, ?string $inlineImageUrl): string
{
    $source = str_replace(["\r\n", "\r"], "\n", html_entity_decode($source, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $lines = explode("\n", $source);
    $html = [];
    $paragraph = [];
    $list = [];
    $listType = null;
    $blockquote = [];
    $table = [];
    $imageInserted = false;

    $flushParagraph = function () use (&$html, &$paragraph): void {
        if ($paragraph === []) {
            return;
        }

        $text = trim(implode(' ', $paragraph));
        if ($text !== '') {
            $html[] = '<p>'.inlineMarkdown($text).'</p>';
        }

        $paragraph = [];
    };

    $flushList = function () use (&$html, &$list, &$listType): void {
        if ($list === []) {
            return;
        }

        $tag = $listType === 'ol' ? 'ol' : 'ul';
        $items = array_map(fn (string $item): string => '<li>'.inlineMarkdown($item).'</li>', $list);
        $html[] = '<'.$tag.'>'.implode('', $items).'</'.$tag.'>';
        $list = [];
        $listType = null;
    };

    $flushBlockquote = function () use (&$html, &$blockquote): void {
        if ($blockquote === []) {
            return;
        }

        $html[] = '<blockquote>'.inlineMarkdown(trim(implode(' ', $blockquote))).'</blockquote>';
        $blockquote = [];
    };

    $flushTable = function () use (&$html, &$table): void {
        if (count($table) < 2) {
            $table = [];
            return;
        }

        $rows = [];
        foreach ($table as $line) {
            $cells = array_values(array_filter(array_map('trim', explode('|', trim($line, " \t|"))), fn (string $cell): bool => $cell !== ''));
            if ($cells === [] || preg_match('/^-+$/', str_replace([' ', ':'], '', implode('', $cells)))) {
                continue;
            }
            $rows[] = $cells;
        }

        if ($rows === []) {
            $table = [];
            return;
        }

        $head = array_shift($rows);
        $htmlRows = ['<thead><tr>'.implode('', array_map(fn (string $cell): string => '<th>'.inlineMarkdown($cell).'</th>', $head)).'</tr></thead>'];
        $bodyRows = [];
        foreach ($rows as $row) {
            $bodyRows[] = '<tr>'.implode('', array_map(fn (string $cell): string => '<td>'.inlineMarkdown($cell).'</td>', $row)).'</tr>';
        }
        if ($bodyRows !== []) {
            $htmlRows[] = '<tbody>'.implode('', $bodyRows).'</tbody>';
        }
        $html[] = '<table>'.implode('', $htmlRows).'</table>';
        $table = [];
    };

    foreach ($lines as $line) {
        $trimmed = trim($line);

        if ($trimmed === '') {
            $flushParagraph();
            $flushList();
            $flushBlockquote();
            $flushTable();
            continue;
        }

        if (preg_match('/^\*?\[Image:\s*(.+?)\]\*?$/i', $trimmed, $match)) {
            $flushParagraph();
            $flushList();
            $flushBlockquote();
            $flushTable();
            if ($inlineImageUrl !== null && ! $imageInserted) {
                $html[] = '<img src="'.e($inlineImageUrl).'" alt="'.e($match[1]).'">';
                $imageInserted = true;
            }
            continue;
        }

        if (preg_match('/^#{1,6}\s+(.+)$/', $trimmed, $match)) {
            $flushParagraph();
            $flushList();
            $flushBlockquote();
            $flushTable();

            $hashes = strspn($trimmed, '#');
            if ($hashes === 1) {
                continue;
            }

            $tag = $hashes === 2 ? 'h2' : 'h3';
            $html[] = '<'.$tag.'>'.inlineMarkdown($match[1]).'</'.$tag.'>';
            continue;
        }

        if (preg_match('/^>\s*(.+)$/', $trimmed, $match)) {
            $flushParagraph();
            $flushList();
            $flushTable();
            $blockquote[] = $match[1];
            continue;
        }

        if (str_starts_with($trimmed, '|')) {
            $flushParagraph();
            $flushList();
            $flushBlockquote();
            $table[] = $trimmed;
            continue;
        }

        if (preg_match('/^[-*]\s+(.+)$/', $trimmed, $match)) {
            $flushParagraph();
            $flushBlockquote();
            $flushTable();
            if ($listType !== null && $listType !== 'ul') {
                $flushList();
            }
            $listType = 'ul';
            $list[] = $match[1];
            continue;
        }

        if (preg_match('/^\d+[.)]\s+(.+)$/', $trimmed, $match)) {
            $flushParagraph();
            $flushBlockquote();
            $flushTable();
            if ($listType !== null && $listType !== 'ol') {
                $flushList();
            }
            $listType = 'ol';
            $list[] = $match[1];
            continue;
        }

        $paragraph[] = $trimmed;
    }

    $flushParagraph();
    $flushList();
    $flushBlockquote();
    $flushTable();

    $htmlText = implode("\n\n", $html);
    if ($inlineImageUrl !== null && ! $imageInserted) {
        $htmlText = insertInlineImage($htmlText, $inlineImageUrl, $title);
    }

    return $htmlText;
}

function inlineMarkdown(string $text): string
{
    $escaped = e($text);
    $escaped = preg_replace('/\[(.+?)\]\((\/[^)\s]+)\)/', '<a href="$2">$1</a>', $escaped) ?? $escaped;
    $escaped = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $escaped) ?? $escaped;
    $escaped = preg_replace('/(?<!\*)\*(?!\s)(.+?)(?<!\s)\*(?!\*)/s', '<em>$1</em>', $escaped) ?? $escaped;
    return $escaped;
}

function ensureFormattedHtml(string $source): string
{
    $html = trim($source);
    $html = preg_replace('/<h1\b[^>]*>.*?<\/h1>/is', '', $html) ?? $html;
    return trim($html);
}

function insertInlineImage(string $html, string $url, string $title): string
{
    $image = '<img src="'.e($url).'" alt="'.e($title).'">';
    $parts = preg_split('/(<\/p>)/i', $html, 3, PREG_SPLIT_DELIM_CAPTURE);

    if (is_array($parts) && count($parts) >= 4) {
        return $parts[0].$parts[1].$parts[2].$parts[3]."\n\n".$image.($parts[4] ?? '');
    }

    return $image."\n\n".$html;
}

function addFallbackH3(string $html, string $title): string
{
    $fallback = '<h3>What to confirm before booking</h3>'."\n\n".
        '<p>Before booking '.e($title).', confirm the location, property type, priority rooms, access details, timing, and any special surfaces or pest concerns. Clear details help Lasafi match the request to the right service team.</p>';

    return preg_replace('/(<h2\b[^>]*>.*?<\/h2>)/is', '$1'."\n\n".$fallback, $html, 1) ?? ($fallback."\n\n".$html);
}

function removeDuplicateRelatedSection(string $html): string
{
    return preg_replace('/\s*<h2>Related Lasafi Guides<\/h2>.*$/is', '', $html) ?? $html;
}

function relatedSection(array $target, array $allTargets): string
{
    $links = relatedLinks($target, $allTargets);
    $items = array_map(fn (array $link): string => '<li><a href="/'.e($link['slug']).'">'.e($link['title']).'</a></li>', $links);

    return '<h2>Related Lasafi Guides</h2>'."\n\n".
        '<p>Use these internal Lasafi resources to compare related services, plan the right scope, and move from research to booking without leaving the site.</p>'."\n\n".
        '<ul>'.implode('', $items).'<li><a href="/services">Lasafi services</a></li><li><a href="/bookings/create">Book a Lasafi service</a></li></ul>'."\n\n".
        '<h3>Next step with Lasafi</h3>'."\n\n".
        '<p>If this service fits your situation, prepare the property location, preferred time, priority areas, and any photos that explain the condition. Then use the booking page so the Lasafi team can review the request clearly.</p>';
}

/**
 * @return array<int, array{id:int,title:string,slug:string}>
 */
function relatedLinks(array $target, array $allTargets): array
{
    $title = strtolower($target['title']);
    $keywords = match (true) {
        str_contains($title, 'pest') || str_contains($title, 'fumigation') || str_contains($title, 'bed bug') || str_contains($title, 'termite') || str_contains($title, 'rat') || str_contains($title, 'mosquito') => ['pest', 'fumigation', 'bed bug', 'termite', 'rat', 'mosquito'],
        str_contains($title, 'office') || str_contains($title, 'business') => ['office', 'business', 'cleaning company'],
        str_contains($title, 'sofa') || str_contains($title, 'carpet') || str_contains($title, 'mattress') || str_contains($title, 'stain') => ['sofa', 'carpet', 'mattress', 'stain'],
        default => ['cleaning', 'deep', 'affordable', 'move', 'professional'],
    };

    $related = [];
    foreach ($allTargets as $row) {
        if ((int) $row['id'] === (int) $target['id'] || $row['slug'] === '') {
            continue;
        }

        $rowTitle = strtolower($row['title']);
        foreach ($keywords as $keyword) {
            if (str_contains($rowTitle, $keyword)) {
                $related[$row['slug']] = $row;
                break;
            }
        }
    }

    if (count($related) < 3) {
        foreach ($allTargets as $row) {
            if ((int) $row['id'] !== (int) $target['id'] && $row['slug'] !== '') {
                $related[$row['slug']] = $row;
            }
            if (count($related) >= 3) {
                break;
            }
        }
    }

    return array_slice(array_values($related), 0, 4);
}

/**
 * @param array<string, string> $generatedImages
 */
function selectGeneratedImage(string $title, array $generatedImages): string
{
    $lower = strtolower($title);

    return match (true) {
        str_contains($lower, 'disinfection') => $generatedImages['disinfection'],
        str_contains($lower, 'office') || str_contains($lower, 'business') => $generatedImages['office'],
        str_contains($lower, 'sofa') || str_contains($lower, 'carpet') || str_contains($lower, 'mattress') || str_contains($lower, 'stain') => $generatedImages['upholstery'],
        str_contains($lower, 'termite') || str_contains($lower, 'rat') || str_contains($lower, 'rodent') => $generatedImages['termite'],
        str_contains($lower, 'pest') || str_contains($lower, 'fumigation') || str_contains($lower, 'bed bug') || str_contains($lower, 'mosquito') => $generatedImages['pest'],
        default => $generatedImages['cleaning'],
    };
}

function extractHeroImageUrl(string $html): ?string
{
    if (preg_match('/<figure class="article-hero">\s*<img src="([^"]+)"/is', $html, $match)) {
        return html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    return null;
}

/**
 * @return array{h2:int,h3:int,images:int,internal_links:int}
 */
function articleCounts(string $html): array
{
    preg_match_all('/<h2\b/i', $html, $h2);
    preg_match_all('/<h3\b/i', $html, $h3);
    preg_match_all('/<img\b/i', $html, $images);
    preg_match_all('/<a\s+href="\/[^"]*"/i', $html, $links);

    return [
        'h2' => count($h2[0]),
        'h3' => count($h3[0]),
        'images' => count($images[0]),
        'internal_links' => count(array_unique($links[0])),
    ];
}

function overviewHeading(string $title): string
{
    return trim(preg_replace('/\s*\|.*$/', '', $title) ?? $title);
}

function excerpt(string $html, int $length): string
{
    $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)) ?? '');
    return truncate($text, $length);
}

function truncate(string $value, int $length): string
{
    $value = trim($value);
    if (mb_strlen($value) <= $length) {
        return $value;
    }

    return rtrim(mb_substr($value, 0, $length - 1)).'...';
}

function cleanCellText(string $html): string
{
    return trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?? '');
}

function extractCsrfToken(string $html): string
{
    if (! preg_match('/name="_token"\s+value="([^"]+)"/i', $html, $match)) {
        throw new RuntimeException('Could not find CSRF token.');
    }

    return html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}
