<?php

$store = __DIR__.'/../storage/app/private/pages.json';
$pages = file_exists($store) ? json_decode(file_get_contents($store), true) : [];
if (! is_array($pages)) {
    $pages = [];
}

$images = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1563453392212-326f5e854473?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=1200&q=80',
];

function p(string $text): string
{
    return '<p>'.$text.'</p>';
}

function fig(string $url, string $alt): string
{
    return '<figure><img src="'.$url.'" alt="'.htmlspecialchars($alt, ENT_QUOTES).'"></figure>';
}

$body = implode("\n\n", [
    p('Lasafi Cleaning Services in Kenya is built for people who want clean, healthy, organised spaces without turning every service request into a long search for someone reliable. Homes, apartments, offices, rental units, shops, clinics, and hospitality spaces all need cleaning, but they do not need the same cleaning plan. A family home in Nairobi, a short-stay apartment in Kilimani, an office in Westlands, a move-out unit in Ruaka, and a carpeted reception area in Mombasa Road each carry different dirt, timing pressure, access rules, and expectations. Lasafi helps customers turn that messy reality into a clear cleaning request.'),
    p('The most useful cleaning service is not the one with the loudest promise. It is the one that understands the space, asks the right questions, brings the right tools, and finishes the agreed work with enough care that the customer can see and feel the difference. This guide explains how Lasafi cleaning support works across Kenya, what customers should expect, how to choose the right cleaning category, and how to prepare so the service runs smoothly. If you want to compare cleaning with other support options, start from the <a href="/">Lasafi homepage</a> or browse the wider <a href="/#services">Lasafi services</a> section.'),

    '<h2>Why professional cleaning matters in Kenya</h2>',
    p('Kenyan homes and businesses deal with cleaning conditions that change from one area to another. Dust can collect quickly near busy roads, unpaved parking areas, construction sites, and open windows. Rainy weather brings mud into entrances, staircases, corridors, balconies, and reception areas. Warm days can make odours more noticeable in bins, carpets, drains, upholstery, and closed rooms. In busy households, cooking, school routines, visitors, pets, and daily movement create a cleaning load that can become difficult to manage alone.'),
    p('For businesses, cleaning is also part of reputation. A customer notices a dusty reception desk, stained carpet, smelly washroom, sticky counter, or overflowing bin before they read a company profile. Staff also work better in a space that feels cared for. Clean floors reduce slips, fresh washrooms reduce complaints, and organised kitchens or break areas reduce daily frustration. Cleaning is not only a cosmetic task. It protects health, comfort, property value, and trust.'),
    p('Professional cleaning matters because it brings structure. Instead of guessing what should be done first, the service can follow a room-by-room checklist. Instead of treating every job as the same, Lasafi customers can describe whether they need residential cleaning, apartment cleaning, deep cleaning, office cleaning, sofa cleaning, carpet cleaning, mattress cleaning, move-in cleaning, or move-out cleaning. That clarity helps the provider arrive prepared.'),
    fig($images[1], 'Professional cleaner preparing supplies for Lasafi cleaning services in Kenya'),

    '<h2>How Lasafi cleaning services are different from casual cleaning</h2>',
    p('Casual cleaning often depends on assumptions. A customer assumes the cleaner will bring products. The cleaner assumes the customer has a mop, bucket, water, power, parking, and enough time. A landlord assumes move-out cleaning includes inside cabinets. A tenant assumes it includes walls, windows, carpets, and balcony scrubbing. These assumptions create disappointment because the real scope was never discussed. Lasafi cleaning services are strongest when the customer explains the job clearly before the visit.'),
    p('A managed cleaning request looks at the type of property, number of rooms, current condition, priority areas, preferred date, access instructions, available supplies, and any special tasks. It also separates routine cleaning from specialist work. Sofa cleaning, carpet cleaning, mattress cleaning, heavy stain treatment, post-renovation dust removal, and full move-out cleaning may need more time or equipment than ordinary sweeping and mopping. Clear scoping makes pricing fairer and results easier to judge.'),
    p('This is also what makes the service more human. A good cleaner listens for what matters to the customer. One family may care most about a baby room and bathrooms. A landlord may care about inspection readiness. A business may care about reception, meeting rooms, and washrooms before clients arrive. A short-stay host may care about guest confidence, fresh bedding areas, and spotless mirrors. The best cleaning plan follows those priorities instead of treating every space like a generic checklist.'),

    '<h2>Residential cleaning for everyday homes</h2>',
    p('Residential cleaning is for lived-in homes: apartments, maisonettes, townhouses, family houses, and rental units where people cook, rest, host visitors, and move through rooms every day. A home should not be cleaned like an empty office. It has private items, children\'s spaces, wardrobes, personal documents, food storage, laundry corners, and delicate surfaces that need respect.'),
    p('A practical residential clean usually covers floors, dusting, bathrooms, kitchen surfaces, bins, mirrors, reachable shelves, visible glass, door handles, switches, and general room resetting. The kitchen and bathroom often need the most attention because they combine water, grease, food, soap residue, odours, and many hand-contact points. Living rooms and bedrooms need a gentler approach, especially where personal items are present.'),
    p('Customers can make residential cleaning more effective by preparing the home before the team arrives. Put away valuables, secure documents, clear counters where possible, explain rooms that should not be entered, and identify the most important areas. If you need a deeper household reset, read the Lasafi guide to <a href="/deep-cleaning-services-nairobi">Deep Cleaning Services Nairobi</a> for more detail on hidden dirt, grout, kitchen grease, and post-renovation dust.'),
    fig($images[2], 'Residential cleaning in a Kenyan home kitchen and living area'),

    '<h2>Apartment cleaning for compact Nairobi living</h2>',
    p('Apartment cleaning deserves its own approach because compact homes show dirt quickly. In a studio, one-bedroom, or two-bedroom apartment, the kitchen, living area, bedroom, and balcony sit close together. Cooking smells can settle into curtains and sofas. Balcony dust can blow back into the sitting room. A small bathroom can feel damp if it is not dried properly. Clutter on one table can make the whole apartment feel untidy.'),
    p('Lasafi apartment cleaning should focus on flow. The cleaner should handle the entrance, kitchen, living area, bathroom, bedroom, balcony, bins, and touch points in a sequence that makes the entire unit feel fresh. In apartments with limited ventilation, odour control matters. In buildings with strict security, the customer should share gate instructions, lift rules, parking details, and allowed service hours before the visit.'),
    p('Short-stay apartments and furnished rentals need extra consistency because guests notice small details. Hair in drains, crumbs in drawers, fingerprints on mirrors, stale sofa smells, dusty bedside tables, and sticky fridge handles can affect reviews. For compact-space planning, customers can compare the full article on <a href="/apartment-cleaning-nairobi">Apartment Cleaning Nairobi</a>.'),

    '<h2>Deep cleaning when ordinary cleaning is not enough</h2>',
    p('Deep cleaning is the service people need when a space requires a reset. A home may look tidy but still have dark grout, greasy cabinet handles, dusty window tracks, stained carpets, stale odours, or dirt behind furniture. An office may have clean desks but dull carpets and neglected corners. A rental unit may need attention after months or years of occupancy.'),
    p('A proper deep clean takes more time than a routine visit. It may include kitchen degreasing, bathroom scale removal, grout scrubbing, skirting boards, shelves, appliance exteriors, cabinet fronts, balcony corners, window tracks, high dusting, under-furniture areas, and detailed floor work. If carpets, sofas, or mattresses are included, drying time must be planned. Rushing a deep clean creates frustration because the cleaner cannot reach the buildup that made the job necessary in the first place.'),
    p('Customers should be honest about the condition of the space. A lightly used apartment needs a different plan from a post-renovation house or a neglected move-out unit. Photos help when the job is unusual. So does a clear list of priority areas. Lasafi can support better matching when the request explains what has built up and what result is expected.'),
    fig($images[3], 'Deep cleaning services for kitchens bathrooms and floors in Kenya'),

    '<h2>Move-in cleaning before settling into a new place</h2>',
    p('Move-in cleaning gives a household a fresh start before furniture, food, clothes, bedding, and personal items fill the rooms. This is one of the best times to clean because the home is still empty. Cleaners can reach wardrobes, cabinets, shelves, corners, skirting, window tracks, bathrooms, kitchen counters, and balcony edges without moving boxes around.'),
    p('A move-in clean should focus on the surfaces people will use immediately: kitchen cabinets, drawers, counters, sinks, taps, bathrooms, toilets, showers, wardrobe interiors, bedroom floors, switches, handles, and main living areas. If the unit came with appliances, inspect them before use. A fridge, cooker, oven, or microwave may need extra attention before food is stored or prepared.'),
    p('New tenants and homeowners should schedule cleaning before movers arrive whenever possible. If timing is tight, clean the kitchen, bathrooms, and bedrooms first. These are the areas that affect the first night most. For detailed pre-occupation planning, read <a href="/move-in-cleaning-nairobi">Move In Cleaning Nairobi</a>.'),

    '<h2>Move-out cleaning for handover and inspection</h2>',
    p('Move-out cleaning is about leaving a property ready for inspection, photography, or the next occupant. Once furniture is removed, hidden dust lines, wall marks, balcony dirt, cabinet crumbs, and bathroom buildup become more visible. A property that looked acceptable while occupied may look neglected when empty.'),
    p('Tenants use move-out cleaning to support deposit conversations and reduce handover disputes. Landlords and agents use it to prepare a unit for viewings and faster occupation. The service should cover floors, kitchen surfaces, cabinet interiors where agreed, bathrooms, mirrors, bins, balcony, window tracks, and visible marks that can be cleaned without repair work. Damage such as broken fixtures, cracked tiles, missing handles, or paint problems should be handled separately from cleaning.'),
    p('Customers should remove personal belongings and waste before the cleaning team arrives. If disposal is needed, mention it early because cleaning and waste removal are not always the same service. For end-of-tenancy detail, see <a href="/move-out-cleaning-nairobi">Move Out Cleaning Nairobi</a>.'),
    fig($images[4], 'Move out cleaning for a vacant apartment before handover'),

    '<h2>Sofa, carpet, and mattress cleaning</h2>',
    p('Soft furnishings hold dirt differently from floors and counters. A sofa can carry dust, sweat, food crumbs, pet hair, cooking smells, and body oils. A carpet can trap grit, mud, allergens, and odours deep in its fibres. A mattress can collect sweat, skin particles, spills, and stale smells beneath clean sheets. These items may look fine at a glance while still needing professional attention.'),
    p('Sofa cleaning should consider fabric type, stain history, colour sensitivity, and drying conditions. Carpet cleaning should focus on traffic lanes, stains, rugs, wall-to-wall carpets, and ventilation. Mattress cleaning should be booked early enough in the day so the mattress can dry before bedtime. In all three services, the customer should point out stains before cleaning begins instead of hiding them under cushions, furniture, or bedding.'),
    p('For more specific guidance, Lasafi has separate pages on <a href="/sofa-cleaning-nairobi">Sofa Cleaning Nairobi</a>, <a href="/carpet-cleaning-nairobi">Carpet Cleaning Nairobi</a>, and <a href="/mattress-cleaning-nairobi">Mattress Cleaning Nairobi</a>. These services can be booked alone or combined with a larger home cleaning plan when timing and drying conditions allow.'),
    fig($images[5], 'Sofa carpet and mattress cleaning for homes and rentals in Kenya'),

    '<h2>Office and commercial cleaning</h2>',
    p('Cleaning is just as important for offices and commercial spaces. Reception areas, meeting rooms, workstations, washrooms, kitchens, corridors, and glass doors all shape how staff and visitors experience the business. A clean office feels more organised, safer, and more professional. A neglected office can quietly damage confidence before a meeting even begins.'),
    p('Office cleaning needs timing discipline. Some businesses prefer cleaning before staff arrive. Others prefer evening cleaning after work. Busy offices may need daytime washroom checks and bin removal. Clinics, salons, shops, schools, and customer-facing spaces may need more frequent attention because many people use the same surfaces throughout the day.'),
    p('A commercial cleaning brief should mention working hours, sensitive rooms, access rules, waste points, parking, water, power, and priority areas. If carpets, glass partitions, upholstery, or deep washroom cleaning are required, list them clearly. Office cleaning is easiest to manage when the checklist is written and reviewed regularly.'),

    '<h2>How Lasafi customers can prepare for a cleaning visit</h2>',
    p('Preparation makes cleaning faster and better. Before the team arrives, clear clutter from floors and counters, put away valuables, secure private documents, identify delicate surfaces, and explain rooms that should not be entered. If inside-cabinet cleaning is required, empty the cabinets. If linen should be changed, place clean sheets where the cleaner can find them. If pets are present, decide where they will stay during the service.'),
    p('Access information is just as important. Share estate gate procedures, apartment block entry rules, parking guidance, lift access, preferred contact person, water points, power availability, and any building restrictions. In Nairobi and other busy towns, cleaners can lose valuable time at security or parking if these details are not ready.'),
    p('Customers should also be specific about success. If the kitchen and bathrooms matter most, say so. If guests are arriving and the sitting room, balcony, and guest bedroom are priorities, include that in the request. If the job is for inspection, mention handover. Cleaning is better when the provider knows what the customer will check first.'),

    '<h2>Cost factors for Lasafi cleaning services</h2>',
    p('Cleaning costs vary because spaces vary. Price can depend on property size, number of rooms, number of bathrooms, condition, location, timing, level of dirt, equipment required, whether supplies are included, and whether specialist tasks are added. A light apartment clean is different from a full move-out clean. A routine floor and bathroom visit is different from a deep clean that includes carpets, sofas, mattresses, appliances, windows, and balcony scrubbing.'),
    p('The best way to get fair pricing is to describe the job honestly. Share the location, rooms, condition, priorities, and any extras. Photos can help when there are stains, renovation dust, heavy grease, or a large property. A clear brief helps Lasafi avoid underestimating the job and helps the customer avoid surprise costs.'),
    p('Affordable service does not mean hiding the scope. It means choosing priorities wisely. If the budget is limited, focus first on bathrooms, kitchen, floors, entrance areas, and the rooms people use most. Specialist tasks can be scheduled separately. For budget-focused planning, read <a href="/affordable-cleaning-services-nairobi">Affordable Cleaning Services Nairobi</a>.'),

    '<h2>How to book cleaning with Lasafi</h2>',
    p('Booking begins with choosing the cleaning category and describing the space. Mention whether the job is residential cleaning, apartment cleaning, deep cleaning, move-in cleaning, move-out cleaning, sofa cleaning, carpet cleaning, mattress cleaning, office cleaning, or a custom combination. Then add the location, preferred date, preferred time, number of rooms, condition, access details, and priority areas.'),
    p('You can use <a href="/bookings/create">book a cleaning service online</a> when you are ready to schedule. If the site asks you to log in or create an account, that step helps organise contact details, service requests, and booking history. Customers who want to understand the process first can review <a href="/#how-it-works">how Lasafi works</a> and compare the service promise through <a href="/#why-lasafi">why customers choose Lasafi</a>.'),
    p('After booking, be available at the start of the visit to confirm priorities. At the end, walk through the cleaned areas before the team leaves. If something is missed, point to the exact place. Specific feedback helps more than general comments and improves future visits.'),

    '<h2>Final thoughts</h2>',
    p('Lasafi Cleaning Services in Kenya is about making cleaning easier to request, easier to plan, and easier to judge. The service works best when customers describe the real space instead of using vague words. A small apartment, a family home, a vacant rental, a furnished Airbnb, a carpeted office, and a mattress cleaning request each need a different approach.'),
    p('The human side of cleaning is attention. A good cleaner notices where dust returns, which room smells stale, which surface should not be scrubbed, which stain needs care, and which area matters most to the customer. A good customer explains priorities, prepares access, and checks the work fairly. When both sides do that, Lasafi cleaning becomes more than a one-time tidy-up. It becomes practical support for cleaner homes, better rentals, healthier bedrooms, fresher fabrics, and more professional workplaces across Kenya.'),
]);

$found = false;
foreach ($pages as &$page) {
    if (($page['slug'] ?? '') === 'lasafi-cleaning-services-in-kenya') {
        $page = array_merge($page, [
            'title' => 'Lasafi Cleaning Services in Kenya',
            'slug' => 'lasafi-cleaning-services-in-kenya',
            'alt' => 'Lasafi Cleaning Services in Kenya',
            'heading_2' => 'Professional Cleaning Services in Kenya',
            'type' => 'Page',
            'description' => $body,
            'image' => $images[0],
            'meta_title' => 'Lasafi Cleaning Services in Kenya | Lasafi',
            'meta_description' => 'Book Lasafi cleaning services in Kenya for homes, apartments, offices, deep cleaning, move-in cleaning, move-out cleaning, sofas, carpets, and mattresses.',
        ]);
        $found = true;
        break;
    }
}
unset($page);

if (! $found) {
    $maxId = 0;
    foreach ($pages as $page) {
        $maxId = max($maxId, (int) ($page['id'] ?? 0));
    }
    $pages[] = [
        'id' => $maxId + 1,
        'title' => 'Lasafi Cleaning Services in Kenya',
        'slug' => 'lasafi-cleaning-services-in-kenya',
        'alt' => 'Lasafi Cleaning Services in Kenya',
        'heading_2' => 'Professional Cleaning Services in Kenya',
        'type' => 'Page',
        'description' => $body,
        'image' => $images[0],
        'meta_title' => 'Lasafi Cleaning Services in Kenya | Lasafi',
        'meta_description' => 'Book Lasafi cleaning services in Kenya for homes, apartments, offices, deep cleaning, move-in cleaning, move-out cleaning, sofas, carpets, and mattresses.',
    ];
}

file_put_contents($store, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

preg_match_all('/<img\b/i', $body, $imageMatches);
preg_match_all('/<a\s+href="(\/[^"]*)"/i', $body, $linkMatches);
echo 'lasafi-cleaning-services-in-kenya: '.str_word_count(strip_tags($body)).' words, '.(count($imageMatches[0]) + 1).' images, '.count(array_unique($linkMatches[1] ?? []))." internal links\n";

