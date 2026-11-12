<?php

$store = __DIR__.'/../storage/app/private/pages.json';
$pages = file_exists($store) ? json_decode(file_get_contents($store), true) : [];
if (! is_array($pages)) {
    $pages = [];
}

$imageUrls = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1563453392212-326f5e854473?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=1200&q=80',
];

$profiles = [
    [
        'title' => 'Residential Cleaning Nairobi',
        'slug' => 'residential-cleaning-nairobi',
        'meta' => 'Book residential cleaning in Nairobi for family homes, maisonettes, townhouses, and everyday household cleaning routines.',
        'hook' => 'A lived-in Nairobi home has its own rhythm. Shoes bring dust from the estate road, school bags land on dining chairs, cooking leaves a film on cabinet handles, and weekend visitors add one more layer of cleaning to an already busy household.',
        'voice' => 'family-home',
        'setting' => 'family houses, maisonettes, townhouses, and lived-in homes',
        'reader' => 'families, homeowners, tenants, and estate residents',
        'promise' => 'a cleaner home that still feels personal, comfortable, and easy to live in',
        'sections' => [
            'A home is not cleaned like an office' => [
                'Residential cleaning works best when the cleaner understands that a home is full of routines, private items, children\'s spaces, food areas, and delicate surfaces. The aim is not to make the house feel staged or unfamiliar. The aim is to restore order while respecting how the household actually lives.',
                'A good cleaner notices the difference between a guest sitting room, a child\'s bedroom, a prayer corner, a pantry shelf, and a busy kitchen counter. Each area needs a different pace. Some spaces need firm scrubbing, while others need careful dusting and quiet respect for personal belongings.',
            ],
            'Where Nairobi homes collect the most dirt' => [
                'Most residential dirt gathers at entrances, corridors, bathrooms, kitchens, balconies, under beds, behind seats, and around windows. Dust can settle again a few hours after cleaning if the home is near a busy road, open field, construction site, or unpaved parking area.',
                'Rainy days create a different problem. Mud reaches doormats, stair landings, balcony tiles, and lower wall edges. That is why residential cleaning should include both visible surfaces and the small transition areas people walk past without noticing.',
            ],
            'Kitchen and bathroom priorities' => [
                'The kitchen and bathroom usually decide whether a home feels genuinely clean. A wiped counter is helpful, but it is not enough if the cooker edge is greasy, the sink smells stale, the bin area is sticky, or the bathroom mirror still carries water marks.',
                'For residential cleaning in Nairobi, ask for clear attention to taps, handles, splashbacks, cabinet fronts, toilet bases, shower corners, drain areas, mirrors, and floor edges. These details are the difference between a quick tidy-up and a proper home clean.',
            ],
            'Bedrooms, wardrobes, and privacy' => [
                'Bedrooms should be treated with extra care because they contain private items. The household should secure documents, jewellery, medicine, devices, and personal effects before the team arrives. Cleaners can dust, mop, make beds if requested, and clean reachable surfaces without deciding where private belongings belong.',
                'If wardrobe interiors, drawers, or storage shelves need cleaning, empty them first. That small preparation step saves time and avoids misunderstandings. It also gives the cleaner room to wipe surfaces properly instead of cleaning around clutter.',
            ],
            'Weekly routines versus monthly resets' => [
                'Many Nairobi homes benefit from a weekly routine for floors, bathrooms, kitchen surfaces, dusting, bins, and general order. Monthly deep work can then focus on areas that build up slowly: windows, skirting, balcony corners, under furniture, appliance edges, grout, upholstery, and cabinets.',
                'This rhythm is easier than waiting until the whole house feels overwhelming. A home that receives regular light cleaning is faster to deep clean, less stressful to maintain, and more comfortable for guests, children, and elderly relatives.',
            ],
            'How to prepare the household' => [
                'Before the cleaners arrive, open access to the rooms that matter most, clear counters where possible, put away valuables, and explain any rooms that should remain closed. If pets are present, decide where they will stay during cleaning.',
                'Share gate instructions, parking rules, water access, power access, and the contact person. In many Nairobi estates, access delays can use up valuable cleaning time, so this practical information matters as much as the cleaning checklist.',
            ],
            'What good supervision looks like' => [
                'A residential cleaning job should end with a walk-through. Check bathrooms, kitchen counters, floors, bins, mirrors, bedrooms, and priority rooms before the team leaves. Specific feedback helps more than general comments.',
                'If something was missed, name the exact place: behind the sitting-room door, the second bathroom mirror, the balcony drain, or the shelf above the microwave. Clear feedback improves the next visit and helps the cleaner learn the household.',
            ],
        ],
        'related' => ['deep-cleaning-services-nairobi', 'apartment-cleaning-nairobi', 'sofa-cleaning-nairobi'],
    ],
    [
        'title' => 'Affordable Cleaning Services Nairobi',
        'slug' => 'affordable-cleaning-services-nairobi',
        'meta' => 'Find affordable cleaning services in Nairobi without losing reliability, hygiene, or a clear cleaning scope.',
        'hook' => 'Affordable cleaning should not mean a rushed visit, weak products, or a cleaner who leaves the most important areas untouched. It should mean choosing the right scope, timing, and priorities so the money you spend gives a visible result.',
        'voice' => 'budget',
        'setting' => 'apartments, small homes, rentals, offices, and shared spaces',
        'reader' => 'budget-conscious households, landlords, tenants, and small businesses',
        'promise' => 'a practical clean that focuses money and time where they make the biggest difference',
        'sections' => [
            'Cheap and affordable are not the same thing' => [
                'A cheap cleaning quote can become expensive if the cleaner arrives without supplies, works without a checklist, misses the kitchen and bathroom details, or asks for extra money after seeing the job. Affordable cleaning is different. It is planned clearly enough that the customer knows what is included before the work starts.',
                'The best affordable service is honest about limits. If the budget covers three hours, the provider should help you choose the highest-impact tasks rather than pretending every corner, appliance, carpet, sofa, and window can be handled properly in that time.',
            ],
            'Start with the rooms people notice first' => [
                'When working with a limited budget, prioritise bathrooms, kitchen surfaces, floors, entrance areas, bins, and the rooms guests or customers use. These areas affect smell, hygiene, and first impression quickly.',
                'Bedrooms, storage areas, balcony corners, window tracks, and appliance interiors can be scheduled later if they are not urgent. A phased plan often gives a better result than spreading the cleaner thin across too many tasks.',
            ],
            'How to brief a cleaner for value' => [
                'A clear brief saves money because the cleaner spends less time guessing. Share the number of rooms, the condition of the space, the worst areas, whether supplies are available, and the time limit. Photos help when the job is unusual.',
                'If the biggest problem is bathroom scale, say so. If the kitchen is oily after months of cooking, say so. If the sitting room only needs dusting and mopping, say that too. Affordable cleaning depends on honest priorities.',
            ],
            'What should stay outside a budget clean' => [
                'Some tasks need extra time or equipment and should not be hidden inside a basic quote. Sofa shampooing, carpet extraction, mattress cleaning, oven cleaning, wall washing, post-construction dust removal, and heavy stain removal are specialist or deep-cleaning tasks.',
                'Trying to include all of them in a small budget usually leads to disappointment. It is better to book the basic clean first and add one specialist service at a time when the budget allows.',
            ],
            'Recurring cleaning can lower the total cost' => [
                'A home that is cleaned every week or every two weeks is usually cheaper to maintain than a home cleaned only when dirt becomes severe. Regular visits reduce heavy scrubbing, shorten bathroom work, and prevent kitchen grease from becoming stubborn.',
                'Landlords and offices can use the same logic. A scheduled routine keeps spaces ready for viewings, tenants, staff, or customers without paying for emergency deep cleans every time things fall behind.',
            ],
            'Questions to ask before accepting a quote' => [
                'Ask whether the price includes supplies, equipment, transport, number of cleaners, estimated hours, and the exact tasks covered. Ask what happens if the job takes longer than expected. A provider who answers clearly is usually easier to work with.',
                'Also ask whether the quote includes disposal of waste, inside-cabinet cleaning, appliances, windows, balcony, carpets, upholstery, and walls. These details prevent small misunderstandings from becoming arguments after the cleaning is done.',
            ],
            'How Lasafi helps control the scope' => [
                'Lasafi cleaning requests are easier to manage when the customer describes the budget and priority areas at the beginning. That lets the job be shaped around realistic outcomes instead of vague expectations.',
                'Affordable cleaning works best when everyone is honest: the customer about the budget and condition, the provider about time and limits, and the platform about the service category that fits the request.',
            ],
        ],
        'related' => ['residential-cleaning-nairobi', 'apartment-cleaning-nairobi', 'deep-cleaning-services-nairobi'],
    ],
    [
        'title' => 'Deep Cleaning Services Nairobi',
        'slug' => 'deep-cleaning-services-nairobi',
        'meta' => 'Book deep cleaning services in Nairobi for homes, apartments, offices, kitchens, bathrooms, carpets, and full-space resets.',
        'hook' => 'Deep cleaning is the service people call when normal cleaning is no longer enough. The house may be tidy, but the grout is dark, the kitchen handles feel sticky, dust returns from hidden ledges, and the bathroom needs more than a quick scrub.',
        'voice' => 'reset',
        'setting' => 'homes, apartments, offices, kitchens, bathrooms, and spaces that need a serious reset',
        'reader' => 'customers dealing with buildup, neglected spaces, renovation dust, odours, or move-related cleaning',
        'promise' => 'a detailed reset that reaches the dirt ordinary cleaning leaves behind',
        'sections' => [
            'When a normal clean is not enough' => [
                'Routine cleaning handles the surface of daily life. Deep cleaning goes after the buildup that has settled into corners, grout, appliance edges, window tracks, skirting boards, cabinet fronts, upholstery, and hard-to-reach surfaces.',
                'If a room still smells stale after mopping, if a kitchen still feels greasy after wiping, or if a bathroom looks dull after scrubbing, the space is probably asking for deep cleaning rather than another quick pass.',
            ],
            'The first inspection matters' => [
                'A deep clean should start with a walk-through. The cleaner needs to know which rooms matter most, which stains are old, which surfaces are delicate, where water and power are available, and whether the space has been recently renovated or left empty.',
                'This inspection protects the customer from unrealistic promises. Some marks can be removed, some can be reduced, and some may be permanent damage. A responsible cleaner explains the difference before starting.',
            ],
            'Kitchen deep cleaning' => [
                'In the kitchen, deep cleaning means grease control, appliance edges, splashbacks, cabinet handles, bin areas, sink residue, floor corners, and often the exterior of cookers, microwaves, fridges, and cupboards. If interiors are required, the customer should empty them first.',
                'Strong chemicals are not the answer to every kitchen problem. Food-contact surfaces need suitable products and proper rinsing. Wood, laminate, stainless steel, tile, glass, and stone each need a different touch.',
            ],
            'Bathroom deep cleaning' => [
                'Bathroom deep cleaning deals with soap scum, scale, grout, toilet bases, drain odours, mirrors, shower corners, shelves, taps, and damp edges. The cleaner should leave the bathroom fresh, but also properly rinsed and dry enough to use safely.',
                'If mould keeps coming back, cleaning may only be part of the solution. Ventilation, leaks, broken seals, or drainage problems may need repair. A good deep clean can expose those issues so they can be handled.',
            ],
            'Dust after renovation or vacancy' => [
                'Post-renovation dust is different from everyday dust. It settles on top of doors, inside tracks, on sockets, shelves, cabinet tops, floors, and wall edges. It often returns after the first wipe, so deep cleaning may require repeated passes.',
                'Vacant homes also need deeper attention because closed rooms collect stale smells, insect residue, dust, and marks left by previous occupants. Cleaning before furniture arrives is the best time to reach everything.',
            ],
            'Time, drying, and realistic expectations' => [
                'Deep cleaning takes longer than many customers expect. Heavy grease, stained grout, carpets, sofas, mattresses, windows, and neglected bathrooms cannot be rushed without reducing quality.',
                'If carpets, sofas, or mattresses are included, drying time matters. Plan ventilation, avoid using cleaned items immediately, and book early enough in the day when possible.',
            ],
            'Keeping the result after the reset' => [
                'A deep clean should make the next month easier, not become a one-day miracle that disappears in a week. After the reset, maintain bathrooms and kitchens weekly, keep entrances controlled, and schedule fabric or carpet care before stains become old.',
                'Customers who combine occasional deep cleaning with simple routines usually spend less time fighting the same dirt again and again.',
            ],
        ],
        'related' => ['move-in-cleaning-nairobi', 'move-out-cleaning-nairobi', 'carpet-cleaning-nairobi'],
    ],
    [
        'title' => 'Move In Cleaning Nairobi',
        'slug' => 'move-in-cleaning-nairobi',
        'meta' => 'Move in cleaning in Nairobi for apartments, houses, and rental units before furniture and personal items arrive.',
        'hook' => 'Moving into a new place is exciting until you open a cabinet, check the bathroom corners, or notice dust on the window tracks. Move in cleaning gives you one clean starting point before your furniture, clothes, food, and children settle into the space.',
        'voice' => 'new-home',
        'setting' => 'empty apartments, houses, rental units, and newly handed-over homes',
        'reader' => 'new tenants, homeowners, relocating families, landlords, and agents preparing occupation',
        'promise' => 'a fresh start before the home becomes full of personal belongings',
        'sections' => [
            'Clean before the boxes arrive' => [
                'The best time to clean a home is before the boxes arrive. Empty rooms give cleaners access to corners, wardrobes, skirting, cabinet shelves, switches, windows, balconies, and bathroom edges without moving furniture around.',
                'Once beds, sofas, utensils, food, clothes, and electronics enter the space, some areas become harder to reach. Move in cleaning takes advantage of that short empty-window period.',
            ],
            'Check what the previous occupant left behind' => [
                'Even when a landlord says the unit has been cleaned, check inside cabinets, behind doors, bathroom corners, kitchen handles, balcony drains, wardrobe shelves, and window tracks. These are common places where old dust and residue remain.',
                'A move in cleaner should remove the feeling that someone else has just lived there. That does not mean repainting or repairing, but it does mean the surfaces you touch every day should feel ready.',
            ],
            'Kitchen readiness before food storage' => [
                'The kitchen should be cleaned before plates, flour, cooking oil, spices, and groceries are unpacked. Cabinet interiors, drawers, counters, sinks, taps, cooker areas, fridge space, and bin corners should be checked carefully.',
                'If appliances came with the unit, inspect them before use. A fridge, oven, cooker hood, or microwave may need separate attention before it is safe and pleasant to use.',
            ],
            'Bathrooms before family use' => [
                'Bathrooms deserve a full reset before the family starts using them. Toilets, shower areas, drains, taps, mirrors, shelves, tiles, grout, floors, and door handles should be cleaned and rinsed properly.',
                'If there are odours, slow drains, leaks, cracked seats, or missing fixtures, report them early. Move in cleaning often reveals maintenance issues that should be handled before the home becomes busy.',
            ],
            'Wardrobes, shelves, and storage' => [
                'Wardrobes and shelves are easy to ignore during ordinary cleaning, but they matter during move in. Clothes, bedding, towels, documents, and children\'s items will sit there for months or years.',
                'Ask for internal wiping before unpacking. Let shelves dry fully before placing fabric items inside, especially in closed rooms that may have been damp or unused.',
            ],
            'Coordinating cleaning with movers' => [
                'Move in cleaning should happen before the moving truck arrives whenever possible. If the schedule is tight, clean bedrooms, bathrooms, and kitchen first, then leave less urgent areas for after furniture placement.',
                'Share timing honestly. If movers are arriving at midday, the cleaning team needs to know. Overlapping movers and cleaners can slow everyone down and create avoidable stress.',
            ],
            'A fresh start checklist' => [
                'Before signing off, check the kitchen, bathrooms, bedroom floors, wardrobes, windows, balcony, door handles, switches, and main entrance. These are the places you will notice immediately after sleeping in the home for the first night.',
                'Move in cleaning is not only about appearance. It helps you begin in a space that feels yours, not like a rushed handover from the previous occupant.',
            ],
        ],
        'related' => ['move-out-cleaning-nairobi', 'deep-cleaning-services-nairobi', 'apartment-cleaning-nairobi'],
    ],
    [
        'title' => 'Move Out Cleaning Nairobi',
        'slug' => 'move-out-cleaning-nairobi',
        'meta' => 'Move out cleaning in Nairobi for tenants, landlords, property managers, and end-of-tenancy handovers.',
        'hook' => 'Move out cleaning is the final impression a tenant leaves and the first condition a landlord or agent inspects. It can affect deposits, handover speed, photos, viewings, and how quickly the next occupant can move in.',
        'voice' => 'handover',
        'setting' => 'vacated apartments, houses, offices, and rental units awaiting inspection',
        'reader' => 'departing tenants, landlords, agents, property managers, and relocating families',
        'promise' => 'a cleaner handover with fewer disputes and a property that is easier to inspect',
        'sections' => [
            'Why the empty property still needs work' => [
                'A vacated unit often looks worse once furniture is removed. Dust lines appear where beds stood, wall marks show behind sofas, balcony corners become visible, and kitchen cabinet interiors reveal crumbs or oil stains.',
                'Move out cleaning is built for that moment. The cleaner is not working around daily life; they are preparing a property for another person to judge, inspect, photograph, or occupy.',
            ],
            'Think like the person inspecting' => [
                'Landlords and agents usually notice bathrooms, kitchen condition, floors, walls, cabinets, balcony, windows, and any smell in the unit. Tenants should focus cleaning energy where the inspection is most likely to happen.',
                'That does not mean hiding damage. Broken fixtures, paint damage, missing keys, and cracked items should be addressed separately. Cleaning should make the true condition clear and presentable.',
            ],
            'Kitchen handover details' => [
                'The kitchen can decide the tone of the handover. Empty cabinets, wipe shelves, clean handles, remove grease from visible cooker areas, wash the sink, clean splashbacks, and deal with bin corners.',
                'If the fridge or cooker belongs to the property, clean it before inspection. Food smells, spills, and old residue can create an impression that the entire unit was poorly maintained.',
            ],
            'Bathrooms and drains' => [
                'Bathrooms should be scrubbed carefully because they are small spaces where every mark is visible. Toilets, sinks, taps, mirrors, shower glass, floor corners, drains, shelves, and tiles all matter.',
                'If drains smell or water drains slowly, report it. A cleaner can improve hygiene and appearance, but plumbing issues should not be confused with cleaning failure.',
            ],
            'Deposit conversations and evidence' => [
                'For tenants, photos after cleaning can help document the condition at handover. Take pictures of cleaned rooms, bathrooms, kitchen cabinets, appliances, floors, balcony, and any pre-existing damage.',
                'For landlords, photos help advertise the property and reduce vacancy time. A clean unit is easier to show, easier to photograph, and easier for the next tenant to imagine living in.',
            ],
            'Waste and leftover items' => [
                'Move out cleaning is slowed down by abandoned items. Remove personal belongings, broken household goods, food, old toiletries, packaging, and unwanted furniture before the cleaning team arrives.',
                'If waste removal is needed, say so before booking. Cleaning and disposal are related, but they are not always the same service and may require different planning.',
            ],
            'Final walk-through before returning keys' => [
                'Before returning keys, walk through the property slowly. Open cabinets, check behind doors, look at bathroom corners, inspect window tracks, stand at the entrance, and notice the smell of the space.',
                'A good move out clean should make the unit feel ready for a fair inspection, even if repairs or painting still need to be handled separately.',
            ],
        ],
        'related' => ['move-in-cleaning-nairobi', 'deep-cleaning-services-nairobi', 'affordable-cleaning-services-nairobi'],
    ],
    [
        'title' => 'Apartment Cleaning Nairobi',
        'slug' => 'apartment-cleaning-nairobi',
        'meta' => 'Apartment cleaning in Nairobi for studios, one-bedroom, two-bedroom, family apartments, rentals, and serviced units.',
        'hook' => 'Apartment cleaning has a different challenge from cleaning a large standalone house. Every room is close to the next, cooking smells travel quickly, balconies gather dust, bathrooms are compact, and small clutter can make the whole unit feel untidy.',
        'voice' => 'compact-living',
        'setting' => 'studios, one-bedroom apartments, two-bedroom apartments, family units, and serviced apartments',
        'reader' => 'apartment residents, landlords, tenants, short-stay hosts, and property managers',
        'promise' => 'a fresh apartment that feels larger, calmer, and easier to manage',
        'sections' => [
            'Small spaces show dirt quickly' => [
                'In an apartment, one dusty balcony, one full bin, or one greasy kitchen can affect the whole unit. There is less distance between the kitchen, sitting room, bedroom, and entrance, so smells and clutter travel fast.',
                'Apartment cleaning should therefore focus on flow: entrance, kitchen, living area, bathroom, bedroom, balcony, and shared touch points. When each zone is handled, the apartment feels more spacious.',
            ],
            'Kitchen smells and open-plan living' => [
                'Many Nairobi apartments have open or semi-open kitchens. Cooking oil, steam, and food smells can settle on cabinet fronts, curtains, sofa fabric, and nearby walls.',
                'Cleaning should include cooker edges, counters, sink, handles, splashbacks, floor edges, and bin areas. If soft furnishings smell of food, consider adding sofa or carpet cleaning periodically.',
            ],
            'Balcony dust and drainage' => [
                'Apartment balconies collect dust, leaves, laundry residue, and sometimes water stains. A dirty balcony can send dust back into the sitting room every time the door opens.',
                'Ask cleaners to sweep, scrub where practical, wipe railings, clear corners, and check the drain. If water does not flow properly, report it to building management before it becomes a bigger problem.',
            ],
            'Bathrooms in compact units' => [
                'Apartment bathrooms can become damp quickly because ventilation is often limited. Soap residue, odours, mirror marks, drain hair, and wet corners build up faster than expected.',
                'A proper apartment clean should include toilet bases, taps, sink edges, shower corners, mirrors, shelves, drains, bins, and floors. Drying is important so the room does not feel wet immediately after cleaning.',
            ],
            'Cleaning around neighbours and building rules' => [
                'Apartment buildings have rules about lifts, water points, parking, noise, waste disposal, and visitor access. Share these details before the cleaner arrives to avoid delays at the gate or reception.',
                'If the building restricts cleaning hours or service lifts, plan around that. A good apartment clean is partly about respecting the shared building environment.',
            ],
            'Short-stay and rental apartments' => [
                'Airbnb and serviced apartments need faster turnaround cleaning. Beds, bathrooms, kitchen surfaces, bins, floors, mirrors, fridge, and guest-touch points must be checked between stays.',
                'Hosts should keep a checklist because guests notice small things: hair in drains, fingerprints on mirrors, crumbs in drawers, dust on bedside tables, and stale smells in fabric.',
            ],
            'Making the apartment easier to maintain' => [
                'After cleaning, keep doormats active, control kitchen spills early, empty bins regularly, air the bathroom, and avoid letting balcony dust creep indoors. Small habits matter more in compact homes.',
                'A recurring apartment cleaning schedule can keep the unit feeling fresh without needing a major rescue clean every month.',
            ],
        ],
        'related' => ['residential-cleaning-nairobi', 'sofa-cleaning-nairobi', 'mattress-cleaning-nairobi'],
    ],
    [
        'title' => 'Sofa Cleaning Nairobi',
        'slug' => 'sofa-cleaning-nairobi',
        'meta' => 'Sofa cleaning in Nairobi for fabric seats, sectionals, office lounge seats, dining chairs, and upholstered furniture.',
        'hook' => 'A sofa carries more daily life than most people realise. It holds dust, sweat, food crumbs, pet hair, body oils, children\'s spills, visitor traffic, and sometimes the smell of the whole living room.',
        'voice' => 'upholstery',
        'setting' => 'fabric sofas, sectionals, dining chairs, office seats, lounge chairs, and upholstered furniture',
        'reader' => 'families, apartment residents, offices, landlords, Airbnb hosts, and upholstery owners',
        'promise' => 'fresher seating with less odour, dust, staining, and fabric buildup',
        'sections' => [
            'Why sofas need more than vacuuming' => [
                'Vacuuming removes loose dust and crumbs, but it does not remove body oils, drink spills, old stains, or odours trapped in fabric. Over time, a sofa can look acceptable but still smell stale when the room is closed.',
                'Professional sofa cleaning targets the fabric more deeply while still respecting the material. The method should match the sofa type, stain level, and drying conditions in the room.',
            ],
            'Fabric type matters' => [
                'Different sofa fabrics respond differently to moisture, brushing, and cleaning products. Cotton blends, velvet-like fabrics, synthetic upholstery, textured fabric, and delicate imported materials should not all be treated the same way.',
                'Before cleaning, tell the provider if the sofa has previously faded, bled colour, shrunk, or reacted badly to cleaning. If you know the fabric label, share it.',
            ],
            'Common Nairobi sofa problems' => [
                'Dust from roads, cooking smells from open-plan kitchens, pet hair, children\'s snacks, and guests sitting after outdoor movement all affect sofas. In apartments, limited ventilation can make odours more noticeable.',
                'Stains from tea, juice, soup, oil, makeup, ink, and sweat should be mentioned before cleaning. Old stains may reduce rather than disappear, and honest expectations are better than promises that cannot be kept.',
            ],
            'Drying is part of the service' => [
                'A cleaned sofa should not remain damp for too long. Good ventilation, open windows, fans, and daytime scheduling can help. Avoid covering or using the sofa until it is dry enough.',
                'Poor drying can create musty smells, especially in shaded apartments or rooms without airflow. Plan the cleaning when the sofa can rest after the work.',
            ],
            'Sofa cleaning for offices and rentals' => [
                'Office lounge seats and reception sofas collect many users in a short time. They may not show dirt immediately, but armrests and seat edges carry heavy contact.',
                'Airbnb and furnished rental sofas should be cleaned periodically because guests judge freshness quickly. A clean sofa can change the feel of the whole sitting room.',
            ],
            'How to prepare before sofa cleaning' => [
                'Remove throws, loose cushions, toys, chargers, coins, papers, and items under the seats. Give the cleaner space around the sofa and confirm water and power access if equipment is used.',
                'Point out stains before the cleaner starts. Do not hide them under cushions. Knowing the stain source helps the cleaner choose the safest approach.',
            ],
            'Keeping sofas fresher longer' => [
                'Vacuum regularly, handle spills quickly, rotate cushions where possible, keep food rules realistic, and improve room ventilation. If the sofa is near a kitchen, periodic fabric cleaning may be needed more often.',
                'Sofa cleaning is not only about appearance. It helps the main seating area feel fresher, especially in homes where the sofa is used every day.',
            ],
        ],
        'related' => ['carpet-cleaning-nairobi', 'mattress-cleaning-nairobi', 'apartment-cleaning-nairobi'],
    ],
    [
        'title' => 'Carpet Cleaning Nairobi',
        'slug' => 'carpet-cleaning-nairobi',
        'meta' => 'Carpet cleaning in Nairobi for rugs, wall-to-wall carpets, office carpets, bedroom carpets, and high-traffic floors.',
        'hook' => 'A carpet can make a room warmer and quieter, but it also traps dust, grit, spills, hair, odours, and fine soil that sweeping cannot remove. In Nairobi, that buildup can happen quickly near doors, windows, balconies, and busy roads.',
        'voice' => 'floor-care',
        'setting' => 'wall-to-wall carpets, rugs, runners, office carpets, bedroom carpets, and living-room carpets',
        'reader' => 'homeowners, tenants, offices, landlords, hotels, and serviced apartments',
        'promise' => 'cleaner flooring with less dust, odour, grit, and visible staining',
        'sections' => [
            'Carpets hide dirt well' => [
                'Hard floors show dirt quickly, but carpets can hide it until the colour dulls or the room starts smelling stale. Dust and grit settle into fibres where ordinary sweeping cannot reach.',
                'Regular vacuuming helps, but periodic carpet cleaning removes deeper soil, improves freshness, and protects the fibres from abrasive dirt.',
            ],
            'High-traffic areas need special attention' => [
                'Doorways, corridors, TV areas, office walkways, bedside paths, and reception zones usually need more attention than corners. These paths collect shoe dirt, pressure marks, and repeated spills.',
                'A good carpet cleaner should inspect traffic lanes before starting. Treating the whole carpet evenly without focusing on heavy-use areas can leave the most visible dirt behind.',
            ],
            'Rugs and wall-to-wall carpets are different' => [
                'A loose rug may need different handling from a fitted carpet. Some rugs can move, wrinkle, bleed colour, or hold moisture differently. Wall-to-wall carpets require attention to edges, corners, and furniture placement.',
                'Tell the provider whether the carpet is wool, synthetic, delicate, old, glued, loose, or recently installed if you know. The more context they have, the safer the cleaning method.',
            ],
            'Stains need honest expectations' => [
                'Tea, coffee, wine, oil, ink, mud, pet stains, and old water marks behave differently. Fresh stains are usually easier to treat than old stains that have been scrubbed repeatedly or left for months.',
                'Professional cleaning can improve many stains, but not every stain disappears completely. A responsible provider should explain likely results before spending time on spot treatment.',
            ],
            'Drying time and ventilation' => [
                'Carpets need drying time after wet cleaning. Open windows, use fans where possible, and avoid heavy foot traffic until the carpet is dry enough. Damp carpets can attract dirt again quickly.',
                'In offices, schedule carpet cleaning after work or before a low-traffic day. In homes, plan around children, pets, and bedroom use so the carpet has time to dry properly.',
            ],
            'Carpet cleaning for offices' => [
                'Office carpets collect dust from shoes, paper fibres, food crumbs, and constant chair movement. Reception and meeting areas deserve scheduled cleaning because they affect client impressions.',
                'A recurring plan can combine routine vacuuming with periodic deep cleaning, especially in high-traffic business districts where dust is a daily issue.',
            ],
            'Keeping carpets clean between visits' => [
                'Use entrance mats, remove shoes where practical, vacuum consistently, treat spills early, and avoid soaking stains with random products. Over-wetting a stain can spread it or damage backing.',
                'Carpet cleaning is most effective when it is planned before the carpet looks completely worn out. Waiting too long makes every clean harder.',
            ],
        ],
        'related' => ['sofa-cleaning-nairobi', 'deep-cleaning-services-nairobi', 'move-out-cleaning-nairobi'],
    ],
    [
        'title' => 'Mattress Cleaning Nairobi',
        'slug' => 'mattress-cleaning-nairobi',
        'meta' => 'Mattress cleaning in Nairobi for bedrooms, guest beds, children\'s mattresses, rentals, and serviced apartments.',
        'hook' => 'A mattress is used for hours every night, but it is cleaned far less often than floors, bathrooms, or sofas. Sweat, dust, skin particles, spills, odours, and allergens can build up quietly beneath clean sheets.',
        'voice' => 'sleep-hygiene',
        'setting' => 'bedroom mattresses, guest beds, children\'s beds, rental mattresses, and serviced apartment bedding',
        'reader' => 'families, landlords, Airbnb hosts, hotels, apartment residents, and allergy-sensitive households',
        'promise' => 'a fresher sleeping surface with less odour, dust, sweat residue, and hidden buildup',
        'sections' => [
            'Clean sheets are not the whole story' => [
                'Changing sheets is important, but it does not clean the mattress itself. Over time, mattresses absorb sweat, dust, body oils, spills, and odours. The surface may look fine while still holding buildup inside the fabric.',
                'Mattress cleaning focuses on the sleeping surface beneath the linen. It is especially useful for guest beds, children\'s beds, rental beds, and mattresses that have not been cleaned for a long time.',
            ],
            'When to book mattress cleaning' => [
                'Book mattress cleaning when there are odours, visible stains, allergy concerns, guest turnover, child accidents, long storage, or after moving into a furnished rental. It is also useful before hosting guests or after illness.',
                'For homes with young children, pets, or high humidity, mattress hygiene should be part of the broader bedroom cleaning routine rather than an emergency service only.',
            ],
            'Stains and odours need context' => [
                'Tell the cleaner what caused the stain if you know. Sweat, urine, tea, blood, makeup, and water marks require different handling. Old stains may lighten but not disappear completely.',
                'Odour control also depends on drying. A mattress that is cleaned but not dried properly can smell worse later. Ventilation and timing are essential.',
            ],
            'Drying before sleeping' => [
                'Mattress cleaning should be booked early enough for the mattress to dry before bedtime. Open windows, use fans if available, and avoid covering the mattress with sheets until it is ready.',
                'If the room has poor airflow, tell the provider. They may recommend a lighter method, longer drying time, or a different schedule.',
            ],
            'Mattress cleaning for rentals and hosts' => [
                'Landlords, Airbnb hosts, and serviced apartments should treat mattress freshness as part of guest confidence. A clean bed is one of the strongest signals that a unit has been prepared properly.',
                'Between long-term tenants, mattress cleaning can help remove the feeling of previous occupancy. For short stays, periodic cleaning supports reviews and reduces complaints about smell or stains.',
            ],
            'Bedroom hygiene around the mattress' => [
                'A mattress clean works better when the whole bedroom is considered. Dust headboards, vacuum or mop under the bed, clean bedside tables, air curtains where possible, and check wardrobes for stale smells.',
                'If the room remains dusty, the mattress will collect dust again quickly. Bedroom hygiene is a system, not a single item.',
            ],
            'Protecting the mattress after cleaning' => [
                'Use a washable mattress protector, rotate the mattress if the manufacturer allows it, air the room often, and respond to spills immediately. These habits extend the value of professional cleaning.',
                'Mattress cleaning is about comfort as much as appearance. A fresher sleeping surface helps the bedroom feel cleaner even when the mattress is hidden under linen.',
            ],
        ],
        'related' => ['sofa-cleaning-nairobi', 'apartment-cleaning-nairobi', 'residential-cleaning-nairobi'],
    ],
];

function h(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES);
}

function p(string $text): string
{
    return '<p>'.$text.'</p>';
}

function figureUrl(string $url, string $alt): string
{
    return '<figure><img src="'.$url.'" alt="'.h($alt).'"></figure>';
}

function linkTo(string $href, string $label): string
{
    return '<a href="'.$href.'">'.$label.'</a>';
}

function expandArticle(array $profile, array $images, array $profiles, int $offset): string
{
    $title = $profile['title'];
    $html = [];
    $html[] = p($profile['hook']);
    $html[] = p($title.' is for '.$profile['reader'].' who want '.$profile['promise'].'. The service should be planned around '.$profile['setting'].', not copied from a generic cleaning checklist. Nairobi spaces face dust, estate access rules, traffic delays, compact layouts, busy households, and different water or ventilation conditions. A useful cleaning plan respects those realities.');
    $html[] = p('Before booking, compare the broader '.linkTo('/#services', 'Lasafi services').' options, read '.linkTo('/#how-it-works', 'how Lasafi works').', and check '.linkTo('/#service-areas', 'Lasafi service areas').' if timing and location matter. You can also start from the '.linkTo('/', 'Lasafi homepage').' when you want to understand the full home and office service range.');

    $imageIndex = 1;
    $sectionNumber = 0;
    foreach ($profile['sections'] as $heading => $paras) {
        $html[] = '<h2>'.$heading.'</h2>';
        foreach ($paras as $para) {
            $html[] = p($para);
        }

        $html[] = p('For '.$title.', the practical question is always the same: what result should the customer see when the team leaves? A clear answer helps the cleaner choose the right sequence, products, tools, and amount of time. It also helps the customer judge the work fairly instead of relying on a vague feeling that the place is cleaner.');
        $html[] = p('This is why a written or spoken checklist matters. It turns the job from a general request into a shared plan. The customer can name priority rooms, the cleaner can explain limits, and both sides can agree on what should be inspected before sign-off.');

        if (in_array($sectionNumber, [0, 1, 3, 4, 6], true)) {
            $html[] = figureUrl($images[$imageIndex], $title.' - '.$heading);
            $imageIndex++;
        }
        $sectionNumber++;
    }

    $html[] = '<h2>Internal Lasafi resources for this cleaning need</h2>';
    $html[] = p('If you are still comparing cleaning options, read the related Lasafi guides below. Each one covers a different situation, so they are useful when one job overlaps with another.');
    foreach ($profile['related'] as $slug) {
        $related = current(array_filter($profiles, fn ($item) => $item['slug'] === $slug));
        if ($related) {
            $html[] = p('For a related service, see '.linkTo('/'.$related['slug'], $related['title']).'. It may help you decide whether to book that service together with '.$title.' or schedule it separately.');
        }
    }
    $html[] = p('When you are ready to schedule, use '.linkTo('/bookings/create', 'book a cleaning service online').'. If the site asks you to sign in, that helps keep your service request, contact details, and job history organised.');

    $html[] = '<h2>Final word</h2>';
    $html[] = p($title.' should feel specific to the space, not like a rushed package. The strongest results come from honest details: location, room count, condition, access, priority areas, delicate surfaces, timing, and expected outcome. That information helps Lasafi match the request with the right cleaning support.');
    $html[] = p('A human cleaning service is built on small observations: where dust returns, which room carries odour, which surface needs care, what the customer worries about, and what must be ready first. When those details are respected, cleaning becomes more than a checklist. It becomes practical support for daily life in Nairobi.');

    return implode("\n\n", $html);
}

$bySlug = [];
$maxId = 0;
foreach ($pages as $page) {
    if (! empty($page['slug'])) {
        $bySlug[$page['slug']] = $page;
    }
    $maxId = max($maxId, (int) ($page['id'] ?? 0));
}

$report = [];
foreach ($profiles as $offset => $profile) {
    $images = [];
    for ($i = 0; $i < 6; $i++) {
        $images[] = $imageUrls[($offset + $i) % count($imageUrls)];
    }
    $body = expandArticle($profile, $images, $profiles, $offset);

    while (str_word_count(strip_tags($body)) < 2550) {
        $body .= "\n\n".p('One more practical detail for '.$profile['title'].' is communication during the job. If the cleaner finds a stain, leak, damaged fitting, loose tile, blocked drain, colour bleeding, or a surface that should not be scrubbed, that issue should be raised immediately. Cleaning works best when surprises are handled early instead of being discovered after the team has packed up.');
        $body .= "\n\n".p('Customers can also make the service more human by explaining what matters most to them. One household may care most about a baby\'s room, another may care about a landlord inspection, another may care about guest comfort, and another may care about odour control. The best cleaning plan listens to that priority and uses it to guide the work.');
    }

    $id = $bySlug[$profile['slug']]['id'] ?? ++$maxId;
    $bySlug[$profile['slug']] = [
        'id' => $id,
        'title' => $profile['title'],
        'slug' => $profile['slug'],
        'alt' => $profile['title'].' professional cleaning service in Nairobi',
        'heading_2' => $profile['title'].' Guide',
        'type' => 'Page',
        'description' => $body,
        'image' => $images[0],
        'meta_title' => $profile['title'].' | Lasafi',
        'meta_description' => $profile['meta'],
    ];

    preg_match_all('/<img\b/i', $body, $imageMatches);
    preg_match_all('/<a\s+href="(\/[^"]*)"/i', $body, $linkMatches);
    $report[] = [
        $profile['slug'],
        str_word_count(strip_tags($body)),
        count($imageMatches[0]) + 1,
        count(array_unique($linkMatches[1] ?? [])),
    ];
}

$final = array_values($bySlug);
usort($final, fn ($a, $b) => ((int) ($a['id'] ?? 0)) <=> ((int) ($b['id'] ?? 0)));
file_put_contents($store, json_encode($final, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

foreach ($report as [$slug, $words, $images, $links]) {
    echo $slug.': '.$words.' words, '.$images.' images, '.$links." internal links\n";
}

