<?php

use Illuminate\Support\Str;

// PRIVATE PREVIEW ONLY. Sample prices and inventory are invented for testing, not offers for sale.
// Photography: https://www.ikojn.com/ ; original source filenames recorded below.
$looks = [
    ['The everyday edit', 'dresses', 4200, 'look-9.jpg', 'WQP4723-Edit_e47d275b-2b2a-4696-9257-e6aab0832a02.jpg'],
    ['A softer silhouette', 'dresses', 4800, 'look-2.webp', 'WQP8091-Edit.webp'],
    ['The weekend dress', 'dresses', 3900, 'look-9.jpg', 'WQP4723-Edit_e47d275b-2b2a-4696-9257-e6aab0832a02.jpg'],
    ['The city essential', 'tops', 2600, 'look-3.jpg', 'WQP1628.jpg'],
    ['The effortless layer', 'outerwear', 5100, 'look-1.webp', 'WQP6374.webp'],
    ['The relaxed edit', 'bottoms', 3400, 'look-10.jpg', 'WQP1614-Edit.jpg'],
    ['The coordinated look', 'matching-sets', 6200, 'look-4.jpg', 'APRILSHOOT-763-Edit.jpg'],
    ['The after-hours edit', 'dresses', 4600, 'look-2.webp', 'WQP8091-Edit.webp'],
    ['The daily rotation', 'tops', 2800, 'look-5.jpg', 'WQP3444-Edit.jpg'],
    ['The considered classic', 'bottoms', 3700, 'look-10.jpg', 'WQP1614-Edit.jpg'],
];

return array_map(function ($p, $i) {
    return ['id' => 'demo-'.$i, 'slug' => Str::slug($p[0]), 'name' => $p[0], 'collection' => $p[1], 'price' => $p[2], 'image' => '/reyana/'.$p[3],
        'alt' => match ($p[3]) {
            'look-9.jpg' => 'Model wearing a short-sleeved patterned shift dress','look-2.webp' => 'Model wearing a mustard fitted dress with a scarf neckline','look-3.jpg' => 'Model wearing a lilac V-neck top','look-1.webp' => 'Model wearing a mustard cropped jacket','look-10.jpg' => 'Model wearing blue and green wide-leg trousers','look-4.jpg' => 'Model wearing a rust long-sleeved top with beige shorts','look-5.jpg' => 'Model wearing a yellow V-neck top with dark trousers',default => 'Fashion styling reference'
        }, 'source' => 'https://www.ikojn.com/cdn/shop/files/'.$p[4], 'demo' => true,
        'description' => 'A styling concept from the Reyana preview collection. The reference photograph does not represent confirmed Reyana stock. Names, prices and options are demonstration data.',
        'care' => null, 'variants' => [['id' => 's', 'size' => 'S', 'color' => 'Reference colour', 'stock' => 3], ['id' => 'm', 'size' => 'M', 'color' => 'Reference colour', 'stock' => 5], ['id' => 'l', 'size' => 'L', 'color' => 'Reference colour', 'stock' => 0]]];
}, $looks, array_keys($looks));
