@extends('layouts.app')

@section('title', $page['meta_title'] ?? $page['title'])
@section('meta_description', $page['meta_description'] ?? '')

@section('content')
@php
    $body = $page['description'] ?? '';
    $headings = [];

    preg_match_all('/<h([2-3])[^>]*>(.*?)<\/h[2-3]>/is', $body, $matches, PREG_SET_ORDER);

    foreach ($matches as $index => $match) {
        $text = trim(strip_tags($match[2]));

        if ($text === '') {
            continue;
        }

        $id = \Illuminate\Support\Str::slug($text) ?: 'section-'.$index;
        $headings[] = [
            'id' => $id,
            'level' => (int) $match[1],
            'text' => $text,
        ];

        $body = preg_replace('/'.preg_quote($match[0], '/').'/', '<h'.$match[1].' id="'.$id.'">'.$match[2].'</h'.$match[1].'>', $body, 1);
    }

    if (empty($headings) && ! empty($page['heading_2'])) {
        $headings[] = [
            'id' => \Illuminate\Support\Str::slug($page['heading_2']),
            'level' => 2,
            'text' => $page['heading_2'],
        ];
    }
@endphp
<style>
    .article-page, .article-page button, .article-page input { font-family:Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; letter-spacing:0; }
    .article-page { background:#fff; color:#191b23; font-size:18px; line-height:1.68; }
    .article-shell { max-width:1180px; margin:0 auto; padding:34px 20px 72px; }
    .article-grid { display:grid; grid-template-columns:minmax(0, 760px) 300px; gap:72px; align-items:start; }
    .article-title { max-width:820px; margin:0 0 18px; color:#111827; font-size:clamp(42px, 5vw, 64px); line-height:.98; font-weight:800; letter-spacing:0; }
    .article-hero { width:100%; margin:0 0 34px; border-radius:8px; overflow:hidden; background:#eef1f5; }
    .article-hero img { display:block; width:100%; aspect-ratio:16 / 9; object-fit:cover; }
    .article-summary { margin:0 0 32px; color:#343946; font-size:21px; line-height:1.55; font-weight:400; }
    .article-toc { border-top:1px solid #e6e8ee; border-bottom:1px solid #e6e8ee; padding:22px 0; margin:0 0 34px; }
    .article-toc h2 { margin:0 0 14px; color:#111827; font-size:20px; line-height:28px; font-weight:800; }
    .article-toc ol { display:grid; gap:8px; margin:0; padding-left:22px; color:#111827; font-size:16px; line-height:24px; }
    .article-toc a { color:#111827; text-decoration:none; font-weight:650; }
    .article-toc a:hover { color:#ff642d; }
    .article-content { color:#242936; }
    .article-content h2 { margin:52px 0 18px; color:#111827; font-size:34px; line-height:1.18; font-weight:800; letter-spacing:0; scroll-margin-top:94px; }
    .article-content h3 { margin:34px 0 14px; color:#111827; font-size:25px; line-height:1.28; font-weight:800; letter-spacing:0; scroll-margin-top:94px; }
    .article-content p { margin:0 0 20px; }
    .article-content a { color:#1264d8; font-weight:650; text-decoration:underline; text-underline-offset:3px; }
    .article-content ul, .article-content ol { margin:0 0 24px; padding-left:28px; }
    .article-content li { margin-bottom:10px; padding-left:4px; }
    .article-content img { display:block; width:100%; height:auto; margin:28px 0; border:1px solid #e5e7eb; border-radius:8px; }
    .article-content blockquote { margin:28px 0; padding:22px 26px; border-left:4px solid #ff642d; background:#fff4ee; color:#20242f; font-size:19px; line-height:1.58; }
    .article-content table { width:100%; margin:28px 0; border-collapse:collapse; font-size:16px; line-height:24px; }
    .article-content th, .article-content td { border:1px solid #e5e7eb; padding:13px 15px; vertical-align:top; }
    .article-content th { background:#f5f7fb; color:#111827; font-weight:800; }
    .article-aside { position:sticky; top:98px; }
    .aside-panel { border:1px solid #e7e9ef; border-radius:8px; padding:22px; background:#fff; box-shadow:0 10px 30px rgba(17, 24, 39, .06); }
    .aside-panel + .aside-panel { margin-top:18px; }
    .aside-panel h2 { margin:0 0 14px; color:#111827; font-size:18px; line-height:24px; font-weight:800; }
    .aside-list { display:grid; gap:10px; margin:0; padding:0; list-style:none; font-size:14px; line-height:20px; }
    .aside-list a { color:#272d39; text-decoration:none; font-weight:650; }
    .aside-list a:hover { color:#ff642d; }
    .share-row { display:flex; gap:8px; }
    .share-row a { width:38px; height:38px; display:grid; place-items:center; border:1px solid #d9dde6; border-radius:50%; color:#111827; text-decoration:none; font-size:14px; font-weight:800; }
    .article-author { display:flex; gap:18px; align-items:flex-start; margin-top:52px; padding:26px 0 0; border-top:1px solid #e6e8ee; }
    .author-avatar { flex:0 0 58px; width:58px; height:58px; border-radius:50%; display:grid; place-items:center; background:#111827; color:#fff; font-size:18px; font-weight:800; }
    .article-author h2 { margin:0 0 6px; color:#111827; font-size:20px; line-height:28px; font-weight:800; }
    .article-author p { margin:0; color:#4b5563; font-size:15px; line-height:24px; }
    .article-cta { margin:0 0 48px; padding:34px; border-radius:8px; background:#421983; color:#fff; text-align:center; }
    .article-cta h2 { margin:0 0 8px; font-size:30px; line-height:38px; font-weight:800; }
    .article-cta p { margin:0 0 20px; color:#eee9ff; font-size:17px; line-height:26px; }
    .article-cta a { display:inline-flex; align-items:center; justify-content:center; min-height:44px; padding:10px 18px; border-radius:6px; background:#ff642d; color:#fff; font-size:16px; line-height:22px; font-weight:800; text-decoration:none; }
    @media (max-width: 991.98px) {
        .article-shell { padding:24px 18px 56px; }
        .article-grid { grid-template-columns:1fr; gap:34px; }
        .article-aside { position:static; order:-1; }
        .article-title { font-size:40px; line-height:1.05; }
        .article-summary { font-size:19px; }
        .article-content h2 { font-size:29px; }
        .article-content h3 { font-size:23px; }
    }
    @media (max-width: 575.98px) {
        .article-page { font-size:17px; line-height:1.62; }
        .article-shell { padding-left:16px; padding-right:16px; }
        .article-title { font-size:34px; }
        .article-hero img { aspect-ratio:4 / 3; }
        .article-meta { font-size:14px; }
        .article-author { flex-direction:column; }
        .article-cta { padding:26px 22px; }
    }
</style>
<article class="article-page">
    <div class="article-shell">
        <section class="article-cta">
            <h2>Book trusted home and office services</h2>
            <p>Schedule cleaning, moving, repairs, CCTV, networking, or maintenance support from vetted Lasafi providers.</p>
            <a href="{{ route('bookings.create') }}">Book a service</a>
        </section>

        <div class="article-grid">
            <main>
                <h1 class="article-title">{{ $page['title'] }}</h1>

                <figure class="article-hero">
                    <img src="{{ $image }}" alt="{{ $page['alt'] ?? $page['title'] }}">
                </figure>

                @if(! empty($page['meta_description']))
                    <p class="article-summary">{{ $page['meta_description'] }}</p>
                @endif

                @if(! empty($page['heading_2']))
                    <section class="article-toc" aria-labelledby="article-overview">
                        <h2 id="article-overview">{{ $page['heading_2'] }}</h2>
                        @if(! empty($headings))
                            <ol>
                                @foreach($headings as $heading)
                                    <li><a href="#{{ $heading['id'] }}">{{ $heading['text'] }}</a></li>
                                @endforeach
                            </ol>
                        @endif
                    </section>
                @elseif(! empty($headings))
                    <section class="article-toc" aria-labelledby="article-overview">
                        <h2 id="article-overview">Table of contents</h2>
                        <ol>
                            @foreach($headings as $heading)
                                <li><a href="#{{ $heading['id'] }}">{{ $heading['text'] }}</a></li>
                            @endforeach
                        </ol>
                    </section>
                @endif

                <div class="article-content">
                    {!! $body !!}
                </div>

                <section class="article-author" aria-label="Author">
                    <div class="author-avatar">LA</div>
                    <div>
                        <h2>Lasafi Editorial Team</h2>
                        <p>Service guides, maintenance advice, and practical planning resources from the Lasafi team for homes and businesses in Kenya.</p>
                    </div>
                </section>
            </main>

            <aside class="article-aside" aria-label="Article sidebar">
                @if(! empty($headings))
                    <section class="aside-panel">
                        <h2>Table of contents</h2>
                        <ul class="aside-list">
                            @foreach($headings as $heading)
                                <li><a href="#{{ $heading['id'] }}">{{ $heading['text'] }}</a></li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                <section class="aside-panel">
                    <h2>Share</h2>
                    <div class="share-row">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" aria-label="Share on Facebook">f</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}" aria-label="Share on LinkedIn">in</a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($page['title']) }}" aria-label="Share on X">x</a>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</article>
@endsection
