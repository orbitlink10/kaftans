<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('fashion_categories', 'is_indexable')) {
            Schema::table('fashion_categories', function (Blueprint $table) {
                $table->boolean('is_indexable')->default(true)->after('image');
            });
        }

        $now = now();
        $categories = [
            'kaftan-dresses-for-ladies' => [
                'name' => 'Kaftan Dresses for Ladies',
                'meta_title' => 'Kaftan Dresses for Ladies in Kenya | Kaftan Dress Kenya',
                'meta_description' => 'Shop kaftan dresses for ladies in Kenya. Browse wedding, casual, plus-size, embroidered and beach kaftans with prices in KSh.',
                'description' => '<p>Find kaftan dresses for ladies in Kenya in one considered edit. Our <a href="/collections/wedding-kaftan-dresses">wedding kaftans</a> suit guest and occasion dressing, while <a href="/collections/casual-kaftan-dresses">casual kaftans</a> keep everyday outfits easy. Looking for more room or detail? Browse <a href="/collections/plus-size-kaftan-dresses">plus-size kaftans</a> and <a href="/collections/embroidered-kaftan-dresses">embroidered kaftans</a>. Every price is shown in KSh.</p>',
                'is_indexable' => true,
            ],
            'kaftan-dresses-nairobi' => [
                'name' => 'Kaftan Dresses in Nairobi',
                'parent' => 'kaftan-dresses-for-ladies',
                'meta_title' => 'Kaftan Dresses in Nairobi | Shop Prices in KSh',
                'meta_description' => 'Browse kaftan dresses available to Nairobi shoppers with clear prices in KSh. Compare styles, sizes and fabrics in the Nairobi edit.',
                'description' => '<p>Shop kaftan dresses in Nairobi with the same clear KSh prices shown on every product. This edit groups the styles currently offered to Nairobi shoppers. Delivery charges and any pickup details are confirmed by the store before dispatch.</p>',
                'is_indexable' => false,
            ],
            'wedding-kaftan-dresses' => [
                'name' => 'Kaftan Dresses for Weddings',
                'parent' => 'kaftan-dresses-for-ladies',
                'meta_title' => 'Kaftan Dresses for Weddings in Kenya | Wedding Guest Kaftans',
                'meta_description' => 'Shop kaftan dresses for wedding guests in Kenya. Find occasion-ready kaftans with clear KSh prices, available sizes and fabric details.',
                'description' => '<p>Kaftan dresses for wedding guests in Kenya bring an easy, graceful silhouette to a long day of celebration. Choose a <a href="/collections/embroidered-kaftan-dresses">detailed embroidered kaftan</a> for a dressier occasion or keep the look relaxed in a <a href="/collections/casual-kaftan-dresses">casual kaftan</a>. Check each product for its listed fabric, fit notes and available sizes.</p>',
                'is_indexable' => true,
            ],
            'casual-kaftan-dresses' => [
                'name' => 'Casual Kaftan Dresses',
                'parent' => 'kaftan-dresses-for-ladies',
                'meta_title' => 'Casual Kaftan Dresses in Kenya | Everyday Kaftans',
                'meta_description' => 'Shop casual kaftan dresses in Kenya for everyday wear. Browse easy silhouettes, sizes and prices in KSh from Kaftan Dress Kenya.',
                'description' => '<p>Everyday kaftan dresses in Kenya are an easy choice for work-from-home days, weekends and simple outings. This collection focuses on relaxed shapes and comfortable styling. Pair a casual kaftan with sandals for daytime or add a layer for evening. See the <a href="/collections/beach-kaftans">beach kaftans</a> edit for lighter cover-up styles.</p>',
                'is_indexable' => true,
            ],
            'plus-size-kaftan-dresses' => [
                'name' => 'Plus-Size Kaftan Dresses',
                'parent' => 'kaftan-dresses-for-ladies',
                'meta_title' => 'Plus-Size Kaftan Dresses in Kenya | Kaftan Dress Kenya',
                'meta_description' => 'Shop plus-size kaftan dresses in Kenya with clear KSh prices, available sizes and fit notes. Browse generous, easy silhouettes.',
                'description' => '<p>Find plus-size kaftan dresses in Kenya with the measurements and size options listed on each product. Kaftans are naturally forgiving in shape, but fit still varies by cut. Check the size guide and the individual garment notes before choosing. For a more relaxed everyday look, explore <a href="/collections/casual-kaftan-dresses">casual kaftans</a>.</p>',
                'is_indexable' => true,
            ],
            'embroidered-kaftan-dresses' => [
                'name' => 'Embroidered Kaftan Dresses',
                'parent' => 'kaftan-dresses-for-ladies',
                'meta_title' => 'Embroidered Kaftan Dresses in Kenya | Kaftan Dress Kenya',
                'meta_description' => 'Shop embroidered kaftan dresses in Kenya. Browse detailed occasion styles with prices in KSh, available sizes and fabric information.',
                'description' => '<p>Embroidered kaftans in Kenya add detail to an otherwise simple silhouette. This edit is suited to celebrations and dressier evenings, including <a href="/collections/wedding-kaftan-dresses">wedding guest kaftans</a>. Each product lists the available sizes and any verified care notes so you can compare the finish before ordering.</p>',
                'is_indexable' => true,
            ],
            'beach-kaftans' => [
                'name' => 'Beach Kaftans',
                'parent' => 'kaftan-dresses-for-ladies',
                'meta_title' => 'Beach Kaftans and Cover-Ups in Kenya | Kaftan Dress Kenya',
                'meta_description' => 'Shop beach kaftans and cover-ups in Kenya. Browse light, easy layers with prices in KSh, available sizes and care details.',
                'description' => '<p>Beach kaftans and cover-ups in Kenya make an easy layer for coastal weekends and poolside days. Look for the fabric and care notes on each product, then choose a size that gives you the coverage you want. For an everyday kaftan you can wear beyond the beach, see <a href="/collections/casual-kaftan-dresses">casual kaftan dresses</a>.</p>',
                'is_indexable' => true,
            ],
        ];

        DB::table('fashion_categories')->insertOrIgnore([
            'name' => $categories['kaftan-dresses-for-ladies']['name'],
            'slug' => 'kaftan-dresses-for-ladies',
            'meta_title' => $categories['kaftan-dresses-for-ladies']['meta_title'],
            'meta_description' => $categories['kaftan-dresses-for-ladies']['meta_description'],
            'description' => $categories['kaftan-dresses-for-ladies']['description'],
            'is_indexable' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $root = DB::table('fashion_categories')->where('slug', 'kaftan-dresses-for-ladies')->first();

        foreach ($categories as $slug => $category) {
            if ($slug === 'kaftan-dresses-for-ladies') {
                continue;
            }
            DB::table('fashion_categories')->insertOrIgnore([
                'name' => $category['name'],
                'slug' => $slug,
                'meta_title' => $category['meta_title'],
                'meta_description' => $category['meta_description'],
                'description' => $category['description'],
                'parent_id' => $root?->id,
                'is_indexable' => $category['is_indexable'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('fashion_categories', 'is_indexable')) {
            Schema::table('fashion_categories', function (Blueprint $table) {
                $table->dropColumn('is_indexable');
            });
        }
    }
};
