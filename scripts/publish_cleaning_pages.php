<?php

$store = __DIR__.'/../storage/app/private/pages.json';

$existing = file_exists($store) ? json_decode(file_get_contents($store), true) : [];
if (! is_array($existing)) {
    $existing = [];
}

$topics = [
    [
        'title' => 'Residential Cleaning Nairobi',
        'slug' => 'residential-cleaning-nairobi',
        'service' => 'residential cleaning',
        'audience' => 'homeowners, tenants, estate managers, and families',
        'property' => 'houses, maisonettes, townhouses, and family homes',
        'primaryNeed' => 'a clean, healthy, and easier-to-manage home',
        'angle' => 'regular home care, detailed room-by-room cleaning, and practical support for busy Nairobi households',
    ],
    [
        'title' => 'Affordable Cleaning Services Nairobi',
        'slug' => 'affordable-cleaning-services-nairobi',
        'service' => 'affordable cleaning services',
        'audience' => 'households, tenants, landlords, small offices, and property managers',
        'property' => 'homes, apartments, small offices, rentals, and shared spaces',
        'primaryNeed' => 'reliable cleaning that fits a sensible budget',
        'angle' => 'how to control cost without sacrificing hygiene, reliability, or useful scope',
    ],
    [
        'title' => 'Deep Cleaning Services Nairobi',
        'slug' => 'deep-cleaning-services-nairobi',
        'service' => 'deep cleaning services',
        'audience' => 'families, tenants, landlords, office managers, and anyone resetting a neglected space',
        'property' => 'homes, apartments, kitchens, bathrooms, offices, carpets, upholstery, and move-related spaces',
        'primaryNeed' => 'a complete reset that goes beyond normal sweeping and mopping',
        'angle' => 'detailed cleaning for hidden dirt, stains, grease, dust, odours, and hygiene risks',
    ],
    [
        'title' => 'Move In Cleaning Nairobi',
        'slug' => 'move-in-cleaning-nairobi',
        'service' => 'move in cleaning',
        'audience' => 'new tenants, homeowners, landlords, relocating families, and property agents',
        'property' => 'empty apartments, houses, townhouses, and rental units before occupation',
        'primaryNeed' => 'a fresh, hygienic home before furniture, clothes, and food arrive',
        'angle' => 'pre-occupation cleaning that makes a new space ready for safe and comfortable living',
    ],
    [
        'title' => 'Move Out Cleaning Nairobi',
        'slug' => 'move-out-cleaning-nairobi',
        'service' => 'move out cleaning',
        'audience' => 'departing tenants, landlords, property managers, agents, and families relocating within Nairobi',
        'property' => 'vacated apartments, houses, offices, and rental units awaiting handover',
        'primaryNeed' => 'a clean handover that reduces disputes and prepares the space for inspection',
        'angle' => 'end-of-tenancy cleaning for deposits, landlord inspections, and faster re-letting',
    ],
    [
        'title' => 'Apartment Cleaning Nairobi',
        'slug' => 'apartment-cleaning-nairobi',
        'service' => 'apartment cleaning',
        'audience' => 'apartment residents, short-stay hosts, landlords, tenants, and property managers',
        'property' => 'studio, one-bedroom, two-bedroom, and larger Nairobi apartments',
        'primaryNeed' => 'a neat apartment that stays fresh despite limited space and daily use',
        'angle' => 'compact-space cleaning for kitchens, bathrooms, balconies, bedrooms, and shared building realities',
    ],
    [
        'title' => 'Sofa Cleaning Nairobi',
        'slug' => 'sofa-cleaning-nairobi',
        'service' => 'sofa cleaning',
        'audience' => 'families, apartment residents, offices, Airbnb hosts, and anyone with fabric or upholstered seats',
        'property' => 'fabric sofas, sectional seats, dining chairs, office lounge seats, and upholstered furniture',
        'primaryNeed' => 'fresher upholstery with less dust, odour, staining, and everyday buildup',
        'angle' => 'fabric-safe cleaning, stain management, drying, and long-term sofa care',
    ],
    [
        'title' => 'Carpet Cleaning Nairobi',
        'slug' => 'carpet-cleaning-nairobi',
        'service' => 'carpet cleaning',
        'audience' => 'homeowners, tenants, offices, landlords, hotels, and serviced apartments',
        'property' => 'wall-to-wall carpets, area rugs, runners, office carpets, and bedroom carpets',
        'primaryNeed' => 'cleaner flooring with less dust, odour, grit, and visible staining',
        'angle' => 'planned carpet care for hygiene, appearance, drying time, and longer carpet life',
    ],
    [
        'title' => 'Mattress Cleaning Nairobi',
        'slug' => 'mattress-cleaning-nairobi',
        'service' => 'mattress cleaning',
        'audience' => 'families, apartment residents, landlords, Airbnb hosts, hotels, and allergy-sensitive households',
        'property' => 'bedroom mattresses, guest beds, children\'s mattresses, rental beds, and serviced apartment bedding',
        'primaryNeed' => 'a cleaner sleeping surface with less dust, odour, sweat residue, and hidden allergens',
        'angle' => 'bed hygiene, stain reduction, odour control, drying, and practical mattress maintenance',
    ],
];

$imagePool = [
    'pages/house-cleaning-services-nairobi-hero.png',
    'pages/house-cleaning-services-nairobi-kitchen.png',
    'pages/house-cleaning-services-nairobi-bathroom.png',
    'pages/house-cleaning-services-nairobi-bedroom.png',
    'pages/house-cleaning-services-nairobi-checklist.png',
    'pages/office-cleaning-services-nairobi-hero.png',
    'pages/office-cleaning-services-nairobi-workstations.png',
    'pages/office-cleaning-services-nairobi-boardroom.png',
    'pages/office-cleaning-services-nairobi-washrooms.png',
    'pages/office-cleaning-services-nairobi-checklist.png',
];

$internalLinks = [
    ['href' => '/', 'label' => 'Lasafi homepage'],
    ['href' => '/#services', 'label' => 'Lasafi services'],
    ['href' => '/#how-it-works', 'label' => 'how Lasafi works'],
    ['href' => '/#why-lasafi', 'label' => 'why customers choose Lasafi'],
    ['href' => '/#service-areas', 'label' => 'Lasafi service areas'],
    ['href' => '/bookings/create', 'label' => 'book a cleaning service online'],
];

function paragraph(string $text): string
{
    return '<p>'.$text.'</p>';
}

function figure(string $image, string $alt): string
{
    return '<figure><img src="/page-images/'.$image.'" alt="'.htmlspecialchars($alt, ENT_QUOTES).'"></figure>';
}

function linkHtml(array $link): string
{
    return '<a href="'.$link['href'].'">'.$link['label'].'</a>';
}

function articleBody(array $topic, array $images, array $links, array $allTopics): string
{
    $service = $topic['service'];
    $title = $topic['title'];
    $audience = $topic['audience'];
    $property = $topic['property'];
    $need = $topic['primaryNeed'];
    $angle = $topic['angle'];

    $related = array_values(array_filter($allTopics, fn ($item) => $item['slug'] !== $topic['slug']));
    $relatedLinks = array_slice($related, 0, 3);

    $html = [];
    $html[] = paragraph("$title is a practical service for $audience who want $need without losing whole weekends to scrubbing, dusting, moving furniture, and chasing small details. Nairobi homes and buildings collect dust from busy roads, construction activity, open windows, dry seasons, rainy-season mud, daily cooking, visitors, pets, children, and constant movement between rooms. A space can look acceptable at first glance while still hiding grease on handles, fine dust on shelves, residue in bathrooms, odours in soft furnishings, and grit inside floor edges. Professional $service turns those scattered tasks into a planned cleaning process.");
    $html[] = paragraph("Lasafi helps customers think about cleaning as a complete service, not a vague request to make a place look tidy. The goal is to define the rooms, surfaces, priorities, timing, access rules, and expected result before the team starts. That makes the work easier to quote, easier to supervise, and easier to repeat. If you are comparing several cleaning options, start from the ".linkHtml($links[0])." and review the wider ".linkHtml($links[1])." section so this page sits inside the full service picture.");

    $html[] = '<h2>Why '.$title.' matters in Nairobi</h2>';
    $html[] = paragraph("Cleaning in Nairobi is shaped by real local conditions. Dust settles quickly in many neighbourhoods, especially near main roads, construction sites, open fields, parking areas, and busy apartment blocks. Rain brings mud into entrances, lifts, staircases, balconies, kitchens, and living rooms. Warm weather can make odours more noticeable when bins, carpets, upholstery, drains, or damp bathrooms are ignored. For $property, these small issues build up quietly until the whole space feels harder to live or work in.");
    $html[] = paragraph("A professional $service plan creates a baseline. Instead of reacting only when the dirt is obvious, the space is cleaned according to a checklist. Floors are not only mopped where people walk; edges, corners, and under movable furniture are also considered. Bathrooms are not only perfumed; fixtures, tiles, drains, mirrors, and touch points are treated. Kitchens are not only wiped where food is prepared; handles, bins, splashbacks, appliance exteriors, and hidden grease points are reviewed. That baseline is what keeps a space feeling controlled.");
    $html[] = paragraph("The value is not just visual. Cleaner spaces reduce odours, improve comfort, make surfaces safer, protect fabrics and finishes, and help people use rooms without frustration. For landlords and agents, clean spaces photograph better and show better. For families, the home becomes easier to maintain between visits. For offices and serviced apartments, cleaning supports reputation and guest confidence. The strongest results come when $service is matched to how the space is actually used.");
    $html[] = figure($images[1], "$title cleaning team preparing a detailed Nairobi service area");

    $html[] = '<h2>What a good service should include</h2>';
    $html[] = paragraph("A clear scope is the most important part of $service. The cleaning request should list rooms, surfaces, special items, access details, and tasks that are outside normal routine cleaning. In many cases, the work includes sweeping, vacuuming, mopping, dusting, wiping high-touch points, cleaning bathrooms, refreshing kitchens, removing cobwebs, emptying bins, cleaning visible glass, and resetting rooms after the job. More detailed work may include inside cabinets, appliances, window tracks, balcony scrubbing, stain attention, upholstery care, carpet cleaning, mattress cleaning, or post-renovation dust removal.");
    $html[] = paragraph("The kitchen usually needs a separate checklist because it combines food, water, grease, appliances, bins, and many hand-contact points. Counters, sinks, taps, splashbacks, cabinet handles, cooker surfaces, microwave exteriors, fridge handles, floors, and bins should be addressed. If the customer wants inside-fridge, oven, or cabinet cleaning, those tasks should be agreed early because they take more time and may require the customer to remove food or personal items.");
    $html[] = paragraph("Bathrooms need more than a quick scrub. A proper routine includes toilet bowls, seats, taps, sinks, shower areas, mirrors, tiles, grout lines, drains, shelves, bins, handles, floors, and ventilation points. Where there is scale, soap residue, odour, dampness, or stained grout, the team may need additional time. Good bathroom cleaning also includes drying and inspection, because a bathroom that is left wet can still feel poorly cleaned.");
    $html[] = paragraph("Living areas and bedrooms require careful handling of personal property. Cleaners can dust, vacuum, mop, wipe, arrange agreed items, and clean reachable surfaces, but customers should secure documents, jewellery, medicine, devices, and private items before the team arrives. If wardrobes, drawers, shelves, or storage areas need internal cleaning, they should be emptied first. This keeps the service respectful, efficient, and less likely to disturb personal belongings.");

    $html[] = '<h2>Room-by-room planning</h2>';
    $html[] = paragraph("A room-by-room plan keeps $service from becoming too general. Entrances need attention because they collect mud, dust, shoe marks, and first impressions. Living rooms need dusting, upholstery checks, rug or carpet care, remote-control touch points, table surfaces, and floor edges. Dining areas need chair legs, table undersides, food marks, and surrounding floors. Bedrooms need bedside dusting, wardrobes, mirrors, floors, bed areas, and window sills. Balconies need dust, railings, drainage points, and outdoor dirt removed.");
    $html[] = paragraph("Kitchens and bathrooms often take the most time because dirt there is sticky, wet, or built up. A realistic booking should allow enough time for these rooms instead of spreading the cleaners too thin across the whole property. If the customer has a limited budget, it may be better to prioritise bathrooms, kitchen, floors, and high-use rooms first, then schedule deeper extras later. That approach is often more useful than asking for every task in too little time.");
    $html[] = paragraph("For $property, access also matters. A cleaner cannot properly clean under heavy furniture if it cannot be moved safely. High windows may require special tools. Delicate stone, wood, stainless steel, glass, leather, or fabric surfaces may need specific products. The customer should point out anything that is fragile, newly installed, stained, cracked, or already damaged. That information protects both the property and the service provider.");
    $html[] = figure($images[2], "$title kitchen bathroom and living area cleaning detail in Nairobi");

    $html[] = '<h2>How often should you book '.$service.'?</h2>';
    $html[] = paragraph("Frequency depends on the size of the space, number of occupants, cooking habits, pets, visitors, dust exposure, floor type, and the standard the customer wants to maintain. A single person in a small apartment may need a lighter schedule than a family with children, pets, and daily cooking. A serviced apartment may need cleaning between guests. A rental unit may need deep cleaning only before or after tenancy. An office may need daily cleaning with deeper work at intervals.");
    $html[] = paragraph("Weekly cleaning works well for many homes because it handles floors, bathrooms, kitchens, dust, bins, and general order before the dirt becomes difficult. Bi-weekly cleaning can work where the home is lightly used. Monthly deep cleaning is useful when the customer already handles daily basics but needs help with corners, grout, upholstery, carpets, cabinets, windows, and hidden dust. One-off deep cleaning is useful before guests, after travel, after renovations, before moving, after moving, or when a property has been empty.");
    $html[] = paragraph("The best schedule is usually a mix. Routine cleaning keeps the space manageable, while scheduled deep cleaning handles the areas that build up slowly. This avoids the stressful cycle of ignoring cleaning until every room feels urgent. If the household or business changes, the schedule should change too. School holidays, new tenants, renovations, events, new babies, guests, or business growth can all increase cleaning needs temporarily.");

    $html[] = '<h2>Products, equipment, and surface care</h2>';
    $html[] = paragraph("Good cleaning depends on matching products and tools to the surface. Strong products are not always better. Food-contact surfaces need safe products and proper rinsing. Wood and laminate need controlled moisture. Stainless steel needs methods that reduce streaks. Glass needs the right cloths. Fabric needs care to avoid over-wetting. Carpets need suitable extraction or shampooing methods and enough drying time. Mattresses and sofas need hygiene-focused cleaning without leaving them damp for too long.");
    $html[] = paragraph("Customers should ask whether the team brings equipment and products or whether the property should provide them. Professional equipment can improve results, especially for carpets, sofas, mattresses, windows, and post-renovation dust. However, access to water, power, parking, and disposal points still matters. If a building has rules about lifts, noise, cleaning times, or waste removal, those rules should be shared before the booking.");
    $html[] = paragraph("Surface care also includes knowing when cleaning is not enough. A stained carpet may need specialist treatment. A blocked drain may need plumbing. A mould problem may need ventilation and repair. A loose tile, leaking tap, cracked grout line, or damaged seal may need maintenance. Good cleaners report these problems instead of hiding them under fragrance or a quick wipe.");
    $html[] = figure($images[3], "$title equipment products and professional cleaning checklist in Nairobi");

    $html[] = '<h2>Preparing before the cleaning team arrives</h2>';
    $html[] = paragraph("Preparation saves time and improves the final result. Customers should clear clutter from floors and counters, put away valuables, secure documents, identify rooms that should not be entered, and explain priority areas. If inside-cabinet cleaning is required, cabinets should be emptied. If linen should be changed, clean sheets should be placed where the cleaner can find them. If pets are present, the customer should decide whether they will stay in another room during the service.");
    $html[] = paragraph("Access instructions are just as important as the cleaning list. Share the estate gate process, apartment block entry rules, parking guidance, lift access, water points, power availability, and the name of the contact person. In some Nairobi buildings, a cleaner can lose a lot of time at security if authorization is not arranged. Time lost at the gate is time not spent on the actual cleaning.");
    $html[] = paragraph("It also helps to separate cleaning from organizing. A cleaning team can scrub, dust, mop, vacuum, sanitise, and reset agreed spaces, but they should not decide where private paperwork, jewellery, medicines, school items, stored goods, or office files belong. When a room is heavily cluttered, grouping items before arrival gives the team more time for cleaning and reduces the risk of misplaced belongings.");

    $html[] = '<h2>Cost factors for '.$title.'</h2>';
    $html[] = paragraph("The cost of $service in Nairobi depends on size, condition, location, frequency, timing, number of rooms, number of bathrooms, floor type, level of dirt, whether products and equipment are included, and whether specialist tasks are required. A light apartment clean costs less than a neglected move-out clean. A basic floor and bathroom visit is different from a full deep clean that includes carpets, upholstery, cabinets, balconies, windows, and appliances.");
    $html[] = paragraph("Affordable cleaning should still be realistic. The cheapest quote is not useful if the scope is unclear, the team lacks equipment, the booking is rushed, or important tasks are excluded. A good quote explains what is included, what is not included, how long the job may take, how many cleaners are expected, and what the customer must prepare. That makes price comparison fairer.");
    $html[] = paragraph("If you want to control cost, prioritise the areas with the biggest impact: bathrooms, kitchen, floors, entry areas, bins, and the rooms people use most. Then add specialist work such as sofa cleaning, carpet cleaning, mattress cleaning, window detailing, oven cleaning, or balcony scrubbing as needed. This phased approach often gives better value than forcing too many tasks into one short visit.");
    $html[] = figure($images[4], "$title affordable cleaning quote and service planning in Nairobi");

    $html[] = '<h2>Choosing a cleaning provider</h2>';
    $html[] = paragraph("When choosing a provider for $service, look for clear communication, realistic scope, punctuality, respectful handling of property, and a willingness to explain the process. The provider should ask useful questions before quoting: location, number of rooms, condition, preferred date, access, parking, water, power, special surfaces, pets, and priority areas. A provider who asks nothing may be guessing.");
    $html[] = paragraph("Trust matters because cleaners often work inside private homes, rental units, offices, or furnished spaces. The customer should feel comfortable explaining boundaries and expectations. The provider should treat property carefully, report accidental damage honestly, follow agreed instructions, and avoid moving sensitive items without permission. Consistency matters too. A cleaning service is easier to use when customers know what to expect each time.");
    $html[] = paragraph("Lasafi is designed to make service requests easier to organise. You can review ".linkHtml($links[2]).", compare the service promise through ".linkHtml($links[3]).", and check ".linkHtml($links[4])." before scheduling. Those internal pages help customers understand the service flow before booking.");

    $html[] = '<h2>Related cleaning services to consider</h2>';
    $html[] = paragraph("$title often connects with other cleaning needs. A home that needs $service may also need carpet cleaning, sofa cleaning, mattress cleaning, deep cleaning, move-in cleaning, move-out cleaning, apartment cleaning, or residential cleaning. Thinking about related services helps customers avoid repeat disruptions. For example, it may be efficient to clean carpets and sofas during the same planned visit if drying time and equipment allow.");
    foreach ($relatedLinks as $related) {
        $html[] = paragraph("Customers comparing options can also read the Lasafi guide for <a href=\"/".$related['slug']."\">".$related['title']."</a>. It explains a related cleaning scenario and helps you decide whether that service should be booked together with $title or scheduled separately.");
    }
    $html[] = figure($images[5], "$title related cleaning services across Nairobi homes and apartments");

    $html[] = '<h2>Common mistakes to avoid</h2>';
    $html[] = paragraph("The first mistake is using a vague brief. A request such as \"clean the house\" or \"clean the apartment\" can mean different things to different people. Does it include inside cabinets, windows, carpets, upholstery, balcony, fridge, oven, walls, grout, or mattress cleaning? If those tasks matter, list them. The clearer the checklist, the fewer surprises after the job.");
    $html[] = paragraph("The second mistake is underestimating time. Dirt that has built up over months cannot be removed properly in the same time as a light weekly clean. Grease, scale, stains, grout, dust after renovation, and neglected bathrooms need patient work. If the booking is too short, the team must either rush or leave some tasks for another day. A realistic schedule protects quality.");
    $html[] = paragraph("The third mistake is ignoring drying time. Carpets, sofas, mattresses, and heavily mopped areas need ventilation and time before normal use. Customers should plan cleaning when windows can be opened safely, fans can run, and people do not need to use the cleaned items immediately. This is especially important for bedrooms, rentals, and offices that reopen quickly after cleaning.");

    $html[] = '<h2>How to book '.$title.' with Lasafi</h2>';
    $html[] = paragraph("To book $service, define the property type, location, preferred date, preferred time, number of rooms, number of bathrooms, priority areas, and any special tasks. Mention whether the space is occupied or empty, whether there are pets, whether parking is available, and whether the team should bring products or equipment. If the job is unusual, photos can help explain the condition before arrival.");
    $html[] = paragraph("You can use ".linkHtml($links[5])." to start a cleaning request. If the site asks you to sign in or create an account, that step helps keep customer details, booking history, and job records organised. Once the scope is clear, the service can be matched to the right cleaning plan instead of relying on guesswork.");
    $html[] = paragraph("$title works best when expectations are specific and timing is realistic. Whether the job is a one-off reset, a move-related clean, a recurring routine, or a specialist fabric and floor service, the goal is the same: a cleaner space that feels easier to use, easier to maintain, and better prepared for daily life in Nairobi.");

    $html[] = '<h2>Final thoughts</h2>';
    $html[] = paragraph("$title is most effective when the cleaning plan reflects the property, the people using it, and the result expected after the team leaves. Nairobi spaces face dust, traffic, weather changes, busy households, compact apartments, and demanding rental schedules. A professional plan brings order to those conditions through clear scope, proper products, realistic timing, and respectful service.");
    $html[] = paragraph("For $audience, the right $service provider should reduce stress rather than create another management task. Start with the rooms that matter most, agree on the checklist, prepare access, and keep feedback specific. With that structure, Lasafi can help turn cleaning from an occasional emergency into a dependable part of keeping Nairobi homes, apartments, and properties ready for everyday use.");

    return implode("\n\n", $html);
}

$pagesBySlug = [];
foreach ($existing as $page) {
    if (! empty($page['slug'])) {
        $pagesBySlug[$page['slug']] = $page;
    }
}

$maxId = 0;
foreach ($existing as $page) {
    $maxId = max($maxId, (int) ($page['id'] ?? 0));
}

$report = [];
foreach ($topics as $index => $topic) {
    $images = [];
    for ($i = 0; $i < 6; $i++) {
        $images[] = $imagePool[($index + $i) % count($imagePool)];
    }

    $body = articleBody($topic, $images, $internalLinks, $topics);
    $id = $pagesBySlug[$topic['slug']]['id'] ?? ++$maxId;

    $pagesBySlug[$topic['slug']] = [
        'id' => $id,
        'title' => $topic['title'],
        'slug' => $topic['slug'],
        'alt' => $topic['title'].' professional cleaning service in Nairobi',
        'heading_2' => $topic['title'].' Guide',
        'type' => 'Page',
        'description' => $body,
        'image' => $images[0],
        'meta_title' => $topic['title'].' | Lasafi',
        'meta_description' => 'Book '.$topic['service'].' in Nairobi with Lasafi for '.$topic['angle'].'.',
    ];

    $wordCount = str_word_count(strip_tags($body));
    preg_match_all('/<img\b/i', $body, $imageMatches);
    preg_match_all('/<a\s+href="(\/[^"]*)"/i', $body, $linkMatches);
    $uniqueLinks = count(array_unique($linkMatches[1] ?? []));
    $report[] = [$topic['slug'], $wordCount, count($imageMatches[0] ?? []) + 1, $uniqueLinks];
}

$pages = array_values($pagesBySlug);
usort($pages, fn ($a, $b) => ((int) ($a['id'] ?? 0)) <=> ((int) ($b['id'] ?? 0)));

file_put_contents($store, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

foreach ($report as [$slug, $words, $images, $links]) {
    echo $slug.': '.$words.' words, '.$images.' images, '.$links." internal links\n";
}
