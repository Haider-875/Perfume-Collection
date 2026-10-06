<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Brand;
use App\Models\FragranceFamily;
use App\Models\ScentNote;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Review;
use App\Models\Coupon;
use App\Models\Blog;
use App\Models\HeroSlide;
use App\Models\Setting;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LuxuryPerfumeSeeder extends Seeder
{
    public function run()
    {
        // 0. Clean slate reset
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        User::truncate();
        Setting::truncate();
        HeroSlide::truncate();
        Collection::truncate();
        Category::truncate();
        Brand::truncate();
        FragranceFamily::truncate();
        ScentNote::truncate();
        Product::truncate();
        ProductImage::truncate();
        ProductVariant::truncate();
        Bundle::truncate();
        BundleItem::truncate();
        Review::truncate();
        Blog::truncate();
        Coupon::truncate();
        Order::truncate();
        OrderItem::truncate();
        Payment::truncate();
        ActivityLog::truncate();
        DB::table('product_collection')->truncate();
        DB::table('product_scent_notes')->truncate();
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // 1. Staff & Patron Users with Granular Permissions
        $superAdmin = User::create([
            'name' => 'Ravaha Super Admin',
            'email' => 'admin@ravaha.pk',
            'password' => Hash::make('admin123456'),
            'role' => 'super_admin',
            'permissions' => ['*'],
            'is_active' => true,
            'phone' => '0300-8765432',
            'city' => 'Lahore',
            'address' => 'Executive Suite, Phase 5 DHA, Lahore',
        ]);

        $storeManager = User::create([
            'name' => 'Asad Khan (Store Manager)',
            'email' => 'manager@ravaha.pk',
            'password' => Hash::make('admin123456'),
            'role' => 'admin',
            'permissions' => ['view_products', 'manage_products', 'view_orders', 'manage_orders', 'view_customers', 'manage_settings', 'view_analytics'],
            'is_active' => true,
            'phone' => '0321-4567890',
            'city' => 'Lahore',
            'address' => 'Gulberg III, Lahore',
        ]);

        $orderSpecialist = User::create([
            'name' => 'Zainab Order Specialist',
            'email' => 'orders@ravaha.pk',
            'password' => Hash::make('admin123456'),
            'role' => 'order_manager',
            'permissions' => ['view_orders', 'manage_orders', 'view_customers'],
            'is_active' => true,
            'phone' => '0333-1122334',
            'city' => 'Karachi',
            'address' => 'Clifton Block 2, Karachi',
        ]);

        $catalogLead = User::create([
            'name' => 'Hamza Catalog Lead',
            'email' => 'catalog@ravaha.pk',
            'password' => Hash::make('admin123456'),
            'role' => 'catalog_manager',
            'permissions' => ['view_products', 'manage_products'],
            'is_active' => true,
            'phone' => '0345-9988776',
            'city' => 'Islamabad',
            'address' => 'F-8 Markaz, Islamabad',
        ]);

        $customer = User::create([
            'name' => 'Tariq Al-Hashmi',
            'email' => 'customer@ravaha.pk',
            'password' => Hash::make('admin123456'),
            'role' => 'customer',
            'permissions' => [],
            'is_active' => true,
            'phone' => '0321-7654321',
            'city' => 'Karachi',
            'address' => 'DHA Phase 6, Karachi',
        ]);

        // 2. Settings (RAVAHA Store Details & Gateways)
        $settings = [
            'store_name' => "RAVAHA Parfums",
            'site_tagline' => "Artisanal Luxury Impressions • Extrait de Parfum",
            'currency' => 'PKR',
            'currency_symbol' => 'Rs. ',
            'phone' => '+92 336 3685732',
            'whatsapp' => '923363685732',
            'email' => 'concierge@ravaha.pk',
            'address_lahore' => 'Plaza 18, Commercial Zone, Phase 5 DHA, Lahore, Pakistan',
            'address_karachi' => 'Bukhari Commercial Area, Phase 6 DHA, Karachi, Pakistan',
            'address_islamabad' => 'Beverly Centre, Blue Area, Islamabad, Pakistan',
            'free_shipping_threshold' => '3000',
            'default_shipping_cost' => '200',
            'announcement_bar_enabled' => '1',
            'announcement_text' => '✨ SPECIAL LAUNCH: 15% OFF On All Luxury Impressions Over Rs. 4,000 + Free Nationwide Shipping | Code: PERFUME15',
            'payment_cod_enabled' => '1',
            'payment_bank_enabled' => '1',
            'payment_easypaisa_enabled' => '1',
            'payment_jazzcash_enabled' => '1',
            'payment_safepay_enabled' => '1',
            'bank_name' => 'Bank Alfalah Limited / Raast',
            'bank_account_title' => 'Perfumes Collection (Pvt) Ltd',
            'bank_account_number' => '0142-1007894561',
            'bank_iban' => 'PK36ALFH01421007894561',
            'bank_raast_id' => '03363685732',
            'bank_branch' => 'Phase 5 DHA, Lahore',
            'easypaisa_number' => '03363685732',
            'easypaisa_account_title' => 'Perfumes Collection',
            'jazzcash_number' => '03363685732',
            'jazzcash_account_title' => 'Perfumes Collection',
            'instagram_url' => 'https://instagram.com/perfumescollection',
            'facebook_url' => 'https://facebook.com/perfumescollection',
        ];
        foreach ($settings as $k => $v) {
            Setting::create(['key' => $k, 'value' => $v, 'group' => str_starts_with($k, 'payment_') || str_contains($k, 'bank_') || str_contains($k, 'easypaisa') || str_contains($k, 'jazzcash') ? 'payments' : 'store']);
        }

        // 3. Hero Slides (Swiper Slider for Homepage)
        HeroSlide::create([
            'title' => "REVIVAL 50",
            'subtitle' => "Hand-crafted with 40% Extrait de Parfum concentration, blending aged Cambodian agarwood and smoky birch. Engineered for 16+ hours of beast-mode projection across Pakistan.",
            'badge_text' => "WINNER FRAGRANCE OF THE YEAR 2026",
            'image' => 'assets/images/slides/hero_1.jpg',
            'cta_text' => "SHOP IMPRESSIONS",
            'cta_url' => "/collections/all",
            'secondary_cta_text' => "FIND YOUR SCENT",
            'secondary_cta_url' => "#scent-advisor",
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HeroSlide::create([
            'title' => "BLEU IMPERIAL",
            'subtitle' => "A magnetic fusion of sun-drenched Italian bergamot, fresh sea salt, and rich cedarwood. Formulated with Grasse French oils for an all-day commanding masculine trail.",
            'badge_text' => "TOP SELLER 2026",
            'image' => 'assets/images/slides/hero_2.jpg',
            'cta_text' => "EXPLORE COUTURE",
            'cta_url' => "/collections/men",
            'secondary_cta_text' => "WHATSAPP ADVISOR",
            'secondary_cta_url' => "https://wa.me/923363685732",
            'sort_order' => 2,
            'is_active' => true,
        ]);

        HeroSlide::create([
            'title' => "ROYAL OUD & AMBER",
            'subtitle' => "An aristocratic private reserve macerated for 90 days with rare Kashmiri saffron and golden ambergris. Experience timeless luxury crafted specifically for evening galas.",
            'badge_text' => "PRIVATE RESERVE COLLECTION",
            'image' => 'assets/images/slides/hero_3.jpg',
            'cta_text' => "EXPLORE SETS",
            'cta_url' => "/collections/bundles",
            'secondary_cta_text' => "VIEW DISCOVERY SET",
            'secondary_cta_url' => "/perfume/the-imperial-discovery-coffret-set-of-5",
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 4. Collections
        $colExclusive = Collection::create([
            'name' => 'Exclusive Reserve',
            'slug' => 'exclusive',
            'description' => 'Our ultra-niche reserve crafted with hand-aged natural agarwood oils and rare absolutes.',
            'badge_text' => 'Private Reserve',
            'sort_order' => 1,
            'is_featured' => true,
        ]);

        $colMen = Collection::create([
            'name' => 'Men\'s Haute Parfumerie',
            'slug' => 'men',
            'description' => 'Commanding, smoky leather, vintage tobacco, and dark woody extraits engineered for masculine presence.',
            'badge_text' => 'Power & Sillage',
            'sort_order' => 2,
            'is_featured' => true,
        ]);

        $colWomen = Collection::create([
            'name' => 'Women\'s Imperial Flora',
            'slug' => 'women',
            'description' => 'Sensual Taif rose petals, night-blooming Lahori Motia, and warm amber vanilla nectar.',
            'badge_text' => 'Sensual & Radiant',
            'sort_order' => 3,
            'is_featured' => true,
        ]);

        $colUnisex = Collection::create([
            'name' => 'Unisex Niche Extraits',
            'slug' => 'unisex',
            'description' => 'Transcendent compositions balancing crisp Himalayan mist, ambergris, and sweet balsamic woods.',
            'badge_text' => 'Transcendent',
            'sort_order' => 4,
            'is_featured' => true,
        ]);

        $colBundles = Collection::create([
            'name' => 'Luxury Bundles & Coffrets',
            'slug' => 'bundles',
            'description' => 'Handcrafted velvet coffrets and curated multi-flacon luxury pairings with exclusive savings.',
            'badge_text' => 'Special Savings',
            'sort_order' => 5,
            'is_featured' => true,
        ]);

        $colCollab = Collection::create([
            'name' => 'Collaborations & Limited Editions',
            'slug' => 'collaborations',
            'description' => 'Bespoke artistic partnerships between Parisian master noses and Lahore master distillers.',
            'badge_text' => 'Limited Release',
            'sort_order' => 6,
            'is_featured' => true,
        ]);

        // 5. Fragrance Families
        $ffWoody = FragranceFamily::create(['name' => 'Woody Oriental & Royal Oud', 'slug' => 'woody-oriental-oud', 'accent_color' => '#C9A24B', 'description' => 'Aged Cambodian agarwood, Mysore sandalwood, and warm amber resin.']);
        $ffFloral = FragranceFamily::create(['name' => 'Imperial Rose & Golden Amber', 'slug' => 'floral-amber', 'accent_color' => '#E0A96D', 'description' => 'Velvety Taif Rose, Damascus petals, and golden ambergris.']);
        $ffLeather = FragranceFamily::create(['name' => 'Smoky Leather & Royal Spice', 'slug' => 'smoky-leather-spice', 'accent_color' => '#8C6D53', 'description' => 'Tuscan leather, Kashmiri saffron, crushed black cardamom, and smoked birch.']);
        $ffFresh = FragranceFamily::create(['name' => 'Citrus Aromatic & Mountain Mist', 'slug' => 'citrus-aromatic-mist', 'accent_color' => '#5C9EAD', 'description' => 'Crisp Italian bergamot, Himalayan pine needle, and silver musk.']);
        $ffGourmand = FragranceFamily::create(['name' => 'Gourmand Velvet & Bourbon Vanilla', 'slug' => 'gourmand-bourbon-vanilla', 'accent_color' => '#A0522D', 'description' => 'Dark cocoa, Madagascar bourbon vanilla, and roasted tonka bean.']);

        // 6. Categories
        $catOud = Category::create(['name' => 'Royal Oud & Extraits', 'slug' => 'royal-oud-extrait', 'badge_text' => 'Signature', 'sort_order' => 1, 'image' => 'assets/images/categories/collection_signature.jpg']);
        $catFrench = Category::create(['name' => 'French Niche Collection', 'slug' => 'french-niche-collection', 'badge_text' => 'Haute Couture', 'sort_order' => 2, 'image' => 'assets/images/categories/collection_candles.jpg']);
        $catAttar = Category::create(['name' => 'Pure Concentrated Attars', 'slug' => 'pure-attar-oils', 'badge_text' => 'Alcohol-Free', 'sort_order' => 3, 'image' => 'assets/images/categories/collection_attar.jpg']);
        $catFloral = Category::create(['name' => 'Imperial Floral & Saffron', 'slug' => 'imperial-floral-saffron', 'badge_text' => 'Radiant', 'sort_order' => 4, 'image' => 'assets/images/categories/collection_signature.jpg']);
        $catDiscovery = Category::create(['name' => 'Discovery Sets & Gifting', 'slug' => 'discovery-sets-gifting', 'badge_text' => 'Bespoke', 'sort_order' => 5, 'image' => 'assets/images/categories/collection_signature.jpg']);

        // 7. Brands
        $brandRoyal = Brand::create(['name' => "RAVAHA Signature Ateliers", 'slug' => 'ravaha-signature-ateliers', 'origin_country' => 'Paris / Lahore Atelier', 'is_featured' => true]);
        $brandImperial = Brand::create(['name' => 'RAVAHA Private Reserve', 'slug' => 'ravaha-private-reserve', 'origin_country' => 'Lahore / Taif', 'is_featured' => true]);
        $brandModern = Brand::create(['name' => 'RAVAHA Couture Paris', 'slug' => 'ravaha-couture-paris', 'origin_country' => 'Grasse, France', 'is_featured' => true]);

        // 8. Scent Notes
        $notesList = [
            'Kashmiri Saffron' => ['top', 'Spicy', 'Hand-harvested crimson saffron stigmas from Kashmir.'],
            'Calabrian Bergamot' => ['top', 'Citrus', 'Sparkling, zesty sun-drenched Italian bergamot.'],
            'Cardamom Noir' => ['top', 'Spicy', 'Smoky black cardamom from Ceylon.'],
            'Pink Peppercorn' => ['top', 'Spicy', 'Lively, radiant berry-peppercorn.'],
            'Wild Lavender' => ['top', 'Aromatic', 'French alpine lavender harvested at dawn.'],
            'Murree Pine Needle' => ['top', 'Fresh', 'Crisp morning pine dew from the Himalayan foothills.'],
            'Sicilian Blood Orange' => ['top', 'Citrus', 'Sweet, effervescent Mediterranean blood orange.'],
            'Taif Rose Dew' => ['top', 'Floral', 'Cold-distilled morning rose water from Saudi mountain peaks.'],
            'Damascus Rose Absolute' => ['heart', 'Floral', 'Rich, honeyed, crimson rose petals.'],
            'Lahori Motia (Jasmine)' => ['heart', 'Floral', 'Sensual, intoxicating night-blooming jasmine.'],
            'Smoked Birch Leather' => ['heart', 'Leather', 'Smoky birch wood evoking vintage saddle leather.'],
            'Nutmeg & Cinnamon Bark' => ['heart', 'Spicy', 'Warm aromatic baking spices.'],
            'Golden Labdanum' => ['heart', 'Amber', 'Resinous Mediterranean rockrose amber.'],
            'Iris / Orris Butter' => ['heart', 'Floral', 'Regal Tuscan orris root aged for 3 years.'],
            'Velvet Patchouli' => ['heart', 'Woody', 'Aged dark Indonesian patchouli leaves.'],
            'Dehn al Oud Cambodi' => ['base', 'Oud', 'Aged 15-year Cambodian agarwood.'],
            'Mysore Sandalwood' => ['base', 'Woody', 'Creamy, sacred Indian sandalwood.'],
            'Golden Ambergris' => ['base', 'Amber', 'Warm marine ambergris accord with limitless sillage.'],
            'Madagascar Bourbon Vanilla' => ['base', 'Gourmand', 'Rich, dark whole vanilla bean caviar.'],
            'Smoked Cedarwood Atlas' => ['base', 'Woody', 'Majestic dry cedar from Moroccan heights.'],
            'White Royal Musk' => ['base', 'Musk', 'Clean, velvet-soft non-synthetic skin musk.'],
            'Roasted Tonka Bean' => ['base', 'Gourmand', 'Almond-caramel warmth with coumarin sweetness.'],
        ];

        $noteModels = [];
        foreach ($notesList as $nName => $nMeta) {
            $noteModels[$nName] = ScentNote::create([
                'name' => $nName,
                'slug' => Str::slug($nName),
                'default_layer' => $nMeta[0],
                'aroma_family' => $nMeta[1],
                'description' => $nMeta[2],
            ]);
        }

        // 9. 24+ Master Perfume Products
        $perfumesData = [
            // 1. Oud Royale 1947
            [
                'name' => 'Oud Royale 1947 Extrait',
                'slug' => 'oud-royale-1947-extrait',
                'sku' => 'MDO-OUD-1947',
                'tagline' => 'A Monumental Ode to Imperial Cambodian Agarwood and Smoked Leather',
                'category_id' => $catOud->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colExclusive->id, $colMen->id, $colUnisex->id],
                'concentration' => 'Extrait de Parfum (40% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 18500.00,
                'sale_price' => 15999.00,
                'compare_at_price' => 19500.00,
                'stock' => 35,
                'longevity' => '16-18 Hours (Beast Mode)',
                'sillage' => 'Monumental / Room-Filling',
                'season' => 'Autumn / Winter / Evening',
                'time_of_day' => 'Imperial Evening & Gala',
                'top_notes_summary' => 'Kashmiri Saffron, Cardamom Noir, Calabrian Bergamot',
                'heart_notes_summary' => 'Damascus Rose Absolute, Smoked Birch Leather, Golden Labdanum',
                'base_notes_summary' => 'Aged Dehn al Oud Cambodi, Mysore Sandalwood, Golden Ambergris',
                'story' => 'Born after 3 years of meticulous maceration in antique oak vats.',
                'description' => "Oud Royale 1947 is the magnum opus of Perfumes Collection. Bottled at an uncompromised 40% perfume concentration, this extrait opens with a radiant blast of sun-lit Calabrian bergamot infused with smoky black cardamom and fiery Kashmiri saffron threads.",
                'is_featured' => true,
                'is_bestseller' => true,
                'rating_avg' => 4.96,
                'reviews_count' => 142,
                'thumbnail_image' => 'assets/images/perfumes/oud_royale.svg',
                'hover_image' => 'assets/images/perfumes/oud_royale_box.svg',
            ],

            // 2. Dehn al Oud Cambodi
            [
                'name' => 'Dehn al Oud Cambodi (Pure Attar)',
                'slug' => 'dehn-al-oud-cambodi-pure-attar',
                'sku' => 'MDO-ATTAR-CAMB',
                'tagline' => '100% Pure Concentrated Macerated Cambodian Agarwood Oil',
                'category_id' => $catAttar->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colExclusive->id, $colUnisex->id],
                'concentration' => '100% Pure Alcohol-Free Attar',
                'gender' => 'Unisex',
                'volume_ml' => 12,
                'price' => 24000.00,
                'sale_price' => 21500.00,
                'compare_at_price' => 26000.00,
                'stock' => 18,
                'longevity' => '24+ Hours (Unrivaled Longevity)',
                'sillage' => 'Personal Halo / Rich Royal Aura',
                'season' => 'All Seasons / Spiritual',
                'time_of_day' => 'All Day / Special Occasions',
                'top_notes_summary' => 'Sweet Balsamic Woods, Dark Dried Prunes',
                'heart_notes_summary' => 'Aged Cambodian Oud Resin, Warm Leather Accord',
                'base_notes_summary' => 'Deep Earthy Agarwood, Smoky Animalic Undertones',
                'story' => 'Artisanal hydro-distilled agarwood from Koh Kong province.',
                'description' => "Our Dehn al Oud Cambodi is an unadulterated pure treasure housed in a hand-polished octagonal crystal flacon.",
                'is_featured' => true,
                'is_bestseller' => true,
                'rating_avg' => 5.00,
                'reviews_count' => 76,
                'thumbnail_image' => 'assets/images/perfumes/dehn_oud_attar.svg',
                'hover_image' => 'assets/images/perfumes/dehn_oud_attar_box.svg',
            ],

            // 3. Noor-e-Gulab
            [
                'name' => 'Noor-e-Gulab Rose Absolute',
                'slug' => 'noor-e-gulab-rose-absolute',
                'sku' => 'MDO-GULAB-01',
                'tagline' => 'Velvety Taif Rose Petals Infused with Kashmiri Saffron and Warm Amber',
                'category_id' => $catFloral->id,
                'brand_id' => $brandImperial->id,
                'fragrance_family_id' => $ffFloral->id,
                'collections' => [$colWomen->id, $colExclusive->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 14500.00,
                'sale_price' => 12999.00,
                'compare_at_price' => 15500.00,
                'stock' => 40,
                'longevity' => '14-16 Hours',
                'sillage' => 'Enchanting & Heavy',
                'season' => 'All Seasons / Romantic Evenings',
                'time_of_day' => 'Evening / Weddings & Galas',
                'top_notes_summary' => 'Taif Rose Dew, Pink Peppercorn, Saffron Supreme',
                'heart_notes_summary' => 'Damascus Rose Absolute, Lahori Motia, Iris Butter',
                'base_notes_summary' => 'Golden Ambergris, Mysore Sandalwood, Madagascar Vanilla',
                'story' => 'Inspired by the royal rose gardens of the Shalimar.',
                'description' => "Noor-e-Gulab is a triumphant celebration of oriental floral majesty avoiding synthetic powdery facets.",
                'is_featured' => true,
                'is_bestseller' => true,
                'rating_avg' => 4.92,
                'reviews_count' => 98,
                'thumbnail_image' => 'assets/images/perfumes/noor_gulab.svg',
                'hover_image' => 'assets/images/perfumes/noor_gulab_box.svg',
            ],

            // 4. Lahore Nights Smoked Amber
            [
                'name' => 'Lahore Nights Smoked Amber',
                'slug' => 'lahore-nights-smoked-amber',
                'sku' => 'MDO-LHR-AMB',
                'tagline' => 'Warm Resinous Amber, Smoked Cardamom, and Royal Velvet Vanilla',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffGourmand->id,
                'collections' => [$colMen->id, $colUnisex->id],
                'concentration' => 'Extrait de Parfum (36% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 16000.00,
                'sale_price' => 13999.00,
                'compare_at_price' => 17000.00,
                'stock' => 28,
                'longevity' => '15+ Hours',
                'sillage' => 'Dense, Magnetic Sillage',
                'season' => 'Winter / Cool Evenings',
                'time_of_day' => 'Intimate Night / Formal Gatherings',
                'top_notes_summary' => 'Cardamom Noir, Sicilian Blood Orange, Nutmeg',
                'heart_notes_summary' => 'Golden Labdanum, Smoked Birch, Velvet Patchouli',
                'base_notes_summary' => 'Madagascar Bourbon Vanilla, Roasted Tonka, Smoked Cedarwood',
                'story' => 'Evoking winter nights in Old Lahore with roasting spices and sweet amber smoke.',
                'description' => "Lahore Nights is an intoxicating gourmand-oriental beast that stays on wool sherwanis for days.",
                'is_featured' => true,
                'is_bestseller' => true,
                'rating_avg' => 4.88,
                'reviews_count' => 64,
                'thumbnail_image' => 'assets/images/perfumes/lahore_nights.svg',
                'hover_image' => 'assets/images/perfumes/lahore_nights_box.svg',
            ],

            // 5. Murree Mist & Silver Bergamot
            [
                'name' => 'Murree Mist & Silver Bergamot',
                'slug' => 'murree-mist-silver-bergamot',
                'sku' => 'MDO-MURREE-01',
                'tagline' => 'Crisp Himalayan Pine Needles, Sparkling Bergamot, and Crisp White Musk',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffFresh->id,
                'collections' => [$colUnisex->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 13500.00,
                'sale_price' => 11499.00,
                'compare_at_price' => 14500.00,
                'stock' => 45,
                'longevity' => '10-12 Hours (Supreme for Fresh Scents)',
                'sillage' => 'Radiant & Crisp Projection',
                'season' => 'Spring / Summer / Hot Humid Days',
                'time_of_day' => 'Morning / Executive Daytime',
                'top_notes_summary' => 'Calabrian Bergamot, Murree Pine Needle, Wild Lavender',
                'heart_notes_summary' => 'Pink Peppercorn, Lahori Motia, Iris Butter',
                'base_notes_summary' => 'White Royal Musk, Smoked Cedarwood Atlas, Golden Ambergris',
                'story' => 'Capturing crisp Himalayan morning dew lifting off giant pine trees.',
                'description' => "Engineered specifically to withstand Pakistan's high summer heat and humidity without evaporating.",
                'is_featured' => true,
                'is_bestseller' => false,
                'rating_avg' => 4.90,
                'reviews_count' => 52,
                'thumbnail_image' => 'assets/images/perfumes/murree_mist.svg',
                'hover_image' => 'assets/images/perfumes/murree_mist_box.svg',
            ],

            // 6. Sultan's Cuir & Tuscan Tobacco
            [
                'name' => 'Sultan\'s Cuir & Tuscan Tobacco',
                'slug' => 'sultans-cuir-tuscan-tobacco',
                'sku' => 'MDO-SULTAN-01',
                'tagline' => 'Handcrafted Tuscan Leather, Roasted Tobacco Leaves, and Ambered Cardamom',
                'category_id' => $catFrench->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffLeather->id,
                'collections' => [$colMen->id, $colExclusive->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 17500.00,
                'sale_price' => 14999.00,
                'compare_at_price' => 18500.00,
                'stock' => 30,
                'longevity' => '16+ Hours',
                'sillage' => 'Dominant & Aristocratic',
                'season' => 'Winter / Formal Black Tie',
                'time_of_day' => 'Night / Power Meetings',
                'top_notes_summary' => 'Cardamom Noir, Saffron Supreme, Sicilian Blood Orange',
                'heart_notes_summary' => 'Smoked Birch Leather, Nutmeg, Velvet Patchouli',
                'base_notes_summary' => 'Dehn al Oud Cambodi, Madagascar Vanilla, Smoked Cedarwood',
                'story' => 'Inspired by grand Ottoman and Mughal councils where leather met spices.',
                'description' => "A bold statement of masculine luxury opening with dark cardamom and plunging into raw leather.",
                'is_featured' => true,
                'is_bestseller' => true,
                'rating_avg' => 4.95,
                'reviews_count' => 110,
                'thumbnail_image' => 'assets/images/perfumes/sultan_cuir.svg',
                'hover_image' => 'assets/images/perfumes/sultan_cuir_box.svg',
            ],

            // 7. Imperial Motia & Saffron Nectar
            [
                'name' => 'Imperial Motia & Saffron Nectar',
                'slug' => 'imperial-motia-saffron-nectar',
                'sku' => 'MDO-MOTIA-01',
                'tagline' => 'Night-Blooming Lahori Jasmine Sambac, Saffron Threads, and Golden Sandalwood',
                'category_id' => $catFloral->id,
                'brand_id' => $brandImperial->id,
                'fragrance_family_id' => $ffFloral->id,
                'collections' => [$colWomen->id],
                'concentration' => 'Extrait de Parfum (36% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 15000.00,
                'sale_price' => 12499.00,
                'compare_at_price' => 16000.00,
                'stock' => 32,
                'longevity' => '14+ Hours',
                'sillage' => 'Hypnotic & Sensual',
                'season' => 'All Seasons / Wedding Festivities',
                'time_of_day' => 'Evening Celebrations',
                'top_notes_summary' => 'Saffron Supreme, Calabrian Bergamot, Taif Rose Dew',
                'heart_notes_summary' => 'Lahori Motia (Jasmine), Damascus Rose, Iris Butter',
                'base_notes_summary' => 'Mysore Sandalwood, Royal White Musk, Golden Ambergris',
                'story' => 'Capturing festive celebratory nights filled with fresh Motia garlands.',
                'description' => "Imperial Motia is narcotic and regal, capturing jasmine flowers hand-harvested at midnight.",
                'is_featured' => true,
                'is_bestseller' => true,
                'rating_avg' => 4.97,
                'reviews_count' => 84,
                'thumbnail_image' => 'assets/images/perfumes/imperial_motia.svg',
                'hover_image' => 'assets/images/perfumes/imperial_motia_box.svg',
            ],

            // 8. Kashmir Saffron Crimson Extrait
            [
                'name' => 'Kashmir Saffron Crimson Extrait',
                'slug' => 'kashmir-saffron-crimson-extrait',
                'sku' => 'MDO-KASH-SAF',
                'tagline' => 'Pure Crimson Saffron Stigmas, Roasted Tonka, and Warm Ambergris',
                'category_id' => $catOud->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffLeather->id,
                'collections' => [$colExclusive->id, $colUnisex->id],
                'concentration' => 'Extrait de Parfum (40% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 19500.00,
                'sale_price' => 17499.00,
                'compare_at_price' => 21000.00,
                'stock' => 20,
                'longevity' => '18+ Hours',
                'sillage' => 'Enormous Projection',
                'season' => 'Winter / Formal',
                'time_of_day' => 'Evening Sovereign',
                'top_notes_summary' => 'Kashmiri Saffron, Blood Orange, Pink Peppercorn',
                'heart_notes_summary' => 'Smoked Birch, Nutmeg, Labdanum',
                'base_notes_summary' => 'Dehn al Oud, Mysore Sandalwood, Bourbon Vanilla',
                'story' => 'Sourced exclusively from the Pampore valley of Kashmir.',
                'description' => "Deep, spicy, aristocratic warmth with an extraordinary crimson hue and endless sillage.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.98,
                'reviews_count' => 45,
                'thumbnail_image' => 'assets/images/perfumes/kashmir_saffron.svg',
            ],

            // 9. Ambergris Imperiale Private Reserve
            [
                'name' => 'Ambergris Imperiale Private Reserve',
                'slug' => 'ambergris-imperiale-private-reserve',
                'sku' => 'MDO-AMB-IMP',
                'tagline' => 'Oceanic Golden Ambergris Infused with Mysore Sandalwood and White Musk',
                'category_id' => $catFrench->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colExclusive->id, $colMen->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 21000.00,
                'sale_price' => 18999.00,
                'compare_at_price' => 23000.00,
                'stock' => 15,
                'longevity' => '20+ Hours',
                'sillage' => 'Magnetic Heavy Trail',
                'season' => 'All Seasons',
                'time_of_day' => 'Signature Presence',
                'top_notes_summary' => 'Calabrian Bergamot, Cardamom Noir',
                'heart_notes_summary' => 'Orris Butter, Golden Labdanum',
                'base_notes_summary' => 'Natural Ambergris, Mysore Sandalwood, Royal Musk',
                'story' => 'Cured natural ambergris creating a velvet magnetic second skin.',
                'description' => "Unparalleled sophistication. A true private reserve formulation for distinguished leaders.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 5.00,
                'reviews_count' => 38,
                'thumbnail_image' => 'assets/images/perfumes/ambergris_niche.svg',
            ],

            // 10. Taif Rose 1888 Vintage Absolute
            [
                'name' => 'Taif Rose 1888 Vintage Absolute',
                'slug' => 'taif-rose-1888-vintage-absolute',
                'sku' => 'MDO-TAIF-1888',
                'tagline' => 'Hand-Picked 30-Petal Taif Rose Dew Distilled Over Gentle Low Fire',
                'category_id' => $catFloral->id,
                'brand_id' => $brandImperial->id,
                'fragrance_family_id' => $ffFloral->id,
                'collections' => [$colExclusive->id, $colWomen->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 16500.00,
                'sale_price' => 14499.00,
                'compare_at_price' => 18000.00,
                'stock' => 22,
                'longevity' => '16+ Hours',
                'sillage' => 'Aristocratic Floral Sillage',
                'season' => 'Spring / Autumn / Celebrations',
                'time_of_day' => 'Day & Evening',
                'top_notes_summary' => 'Taif Rose Dew, Sicilian Blood Orange',
                'heart_notes_summary' => 'Damascus Rose, Iris Butter',
                'base_notes_summary' => 'White Royal Musk, Sandalwood',
                'story' => 'A recreation of an 1888 royal recipe distilled from mountain roses.',
                'description' => "Pure, sweet, ethereal rose that avoids all synthetic harshness.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.94,
                'reviews_count' => 41,
                'thumbnail_image' => 'assets/images/perfumes/taif_rose_1888.svg',
            ],

            // 11. Mysore Supreme Sacred Sandalwood
            [
                'name' => 'Mysore Supreme Sacred Sandalwood',
                'slug' => 'mysore-supreme-sacred-sandalwood',
                'sku' => 'MDO-MYS-SAN',
                'tagline' => 'Pure Indian Sandalwood Heartwood aged for 20 Years in Sandalwood Casks',
                'category_id' => $catOud->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colExclusive->id, $colUnisex->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 17000.00,
                'sale_price' => 14999.00,
                'compare_at_price' => 19000.00,
                'stock' => 25,
                'longevity' => '18+ Hours',
                'sillage' => 'Creamy Golden Aura',
                'season' => 'All Seasons',
                'time_of_day' => 'Spiritual & Daily Signature',
                'top_notes_summary' => 'Cardamom Noir, Wild Lavender',
                'heart_notes_summary' => 'Orris Butter, Cedarwood Atlas',
                'base_notes_summary' => 'Mysore Sandalwood, Bourbon Vanilla, Ambergris',
                'story' => 'A tribute to the world’s most precious creamy sacred sandalwood.',
                'description' => "Buttery, meditative, serene, and infinitely comforting.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.96,
                'reviews_count' => 50,
                'thumbnail_image' => 'assets/images/perfumes/sandalwood_supreme.svg',
            ],

            // 12. Vetiver Imperiale Smoked Roots
            [
                'name' => 'Vetiver Imperiale Smoked Roots',
                'slug' => 'vetiver-imperiale-smoked-roots',
                'sku' => 'MDO-VET-IMP',
                'tagline' => 'Haitian Vetiver Roots Smoked with Birchwood Tar and Green Bergamot',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffFresh->id,
                'collections' => [$colMen->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 14000.00,
                'sale_price' => 11999.00,
                'compare_at_price' => 15500.00,
                'stock' => 30,
                'longevity' => '14+ Hours',
                'sillage' => 'Crisp Masculine Sillage',
                'season' => 'Spring / Summer / Executive',
                'time_of_day' => 'Boardroom & Daytime',
                'top_notes_summary' => 'Calabrian Bergamot, Pink Peppercorn',
                'heart_notes_summary' => 'Smoked Birch, Nutmeg',
                'base_notes_summary' => 'Haitian Vetiver, Smoked Cedarwood, White Musk',
                'story' => 'The definitive executive signature fragrance for power suits.',
                'description' => "Crisp, earthy, smoky, and commanding without ever feeling overwhelming.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.91,
                'reviews_count' => 36,
                'thumbnail_image' => 'assets/images/perfumes/vetiver_imperiale.svg',
            ],

            // 13. Cardamom Noir Ceylon Spice
            [
                'name' => 'Cardamom Noir Ceylon Spice',
                'slug' => 'cardamom-noir-ceylon-spice',
                'sku' => 'MDO-CARD-NOIR',
                'tagline' => 'Crushed Black Cardamom, Roasted Coffee Beans, and Smoked Leather',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffLeather->id,
                'collections' => [$colMen->id],
                'concentration' => 'Extrait de Parfum (36% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 15500.00,
                'sale_price' => 13499.00,
                'compare_at_price' => 16500.00,
                'stock' => 28,
                'longevity' => '15+ Hours',
                'sillage' => 'Spicy Intoxicating Trail',
                'season' => 'Autumn / Winter',
                'time_of_day' => 'Night Gatherings',
                'top_notes_summary' => 'Cardamom Noir, Blood Orange',
                'heart_notes_summary' => 'Cinnamon Bark, Smoked Birch',
                'base_notes_summary' => 'Dehn al Oud, Tonka Bean, Cedarwood',
                'story' => 'Dark and aromatic like a winter fire in the hills.',
                'description' => "Rich black spices that radiate warm sophistication.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.89,
                'reviews_count' => 32,
                'thumbnail_image' => 'assets/images/perfumes/cardamom_noir.svg',
            ],

            // 14. Atlas Cedarwood Moroccan Peaks
            [
                'name' => 'Atlas Cedarwood Moroccan Peaks',
                'slug' => 'atlas-cedarwood-moroccan-peaks',
                'sku' => 'MDO-ATL-CED',
                'tagline' => 'Sun-Drenched Cedarwood Needles, Ambered Resins, and Wild Thyme',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colMen->id, $colUnisex->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 13500.00,
                'sale_price' => 11999.00,
                'compare_at_price' => 14500.00,
                'stock' => 35,
                'longevity' => '14+ Hours',
                'sillage' => 'Refined Woody Aura',
                'season' => 'All Seasons',
                'time_of_day' => 'Daily Signature',
                'top_notes_summary' => 'Wild Lavender, Bergamot',
                'heart_notes_summary' => 'Nutmeg, Labdanum',
                'base_notes_summary' => 'Cedarwood Atlas, Sandalwood, White Musk',
                'story' => 'Harvested from high Moroccan cedar forests.',
                'description' => "Dry, noble wood aroma with aristocratic poise.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.88,
                'reviews_count' => 29,
                'thumbnail_image' => 'assets/images/perfumes/atlas_cedarwood.svg',
            ],

            // 15. Smoked Birch Elite
            [
                'name' => 'Smoked Birch Elite',
                'slug' => 'smoked-birch-elite',
                'sku' => 'MDO-SMK-BIR',
                'tagline' => 'Tuscan Leather Cuir, Smoked Birch Wood, and Golden Labdanum',
                'category_id' => $catFrench->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffLeather->id,
                'collections' => [$colMen->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Men',
                'volume_ml' => 100,
                'price' => 16500.00,
                'sale_price' => 14499.00,
                'compare_at_price' => 18000.00,
                'stock' => 24,
                'longevity' => '16+ Hours',
                'sillage' => 'Dominant & Smoky',
                'season' => 'Winter Evenings',
                'time_of_day' => 'Night Formal',
                'top_notes_summary' => 'Kashmiri Saffron, Pink Pepper',
                'heart_notes_summary' => 'Smoked Birch Leather, Labdanum',
                'base_notes_summary' => 'Dehn al Oud, Tonka Bean',
                'story' => 'A powerhouse composition for lovers of true leather and birch tar.',
                'description' => "Unyielding sillage that commands every room.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.93,
                'reviews_count' => 37,
                'thumbnail_image' => 'assets/images/perfumes/smoked_birch.svg',
            ],

            // 16. Velvet Orchid & Black Saffron
            [
                'name' => 'Velvet Orchid & Black Saffron',
                'slug' => 'velvet-orchid-black-saffron',
                'sku' => 'MDO-VEL-ORC',
                'tagline' => 'Mysterious Black Orchid, Saffron Threads, and Warm Dark Amber',
                'category_id' => $catFloral->id,
                'brand_id' => $brandImperial->id,
                'fragrance_family_id' => $ffFloral->id,
                'collections' => [$colWomen->id],
                'concentration' => 'Extrait de Parfum (36% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 15500.00,
                'sale_price' => 13499.00,
                'compare_at_price' => 17000.00,
                'stock' => 26,
                'longevity' => '15+ Hours',
                'sillage' => 'Enveloping Sensual Sillage',
                'season' => 'Autumn / Winter',
                'time_of_day' => 'Evening Galas',
                'top_notes_summary' => 'Saffron Supreme, Blood Orange',
                'heart_notes_summary' => 'Orchid Accord, Damascus Rose',
                'base_notes_summary' => 'Bourbon Vanilla, Patchouli, Ambergris',
                'story' => 'Dark, gothic romance meeting oriental opulence.',
                'description' => "Intensely alluring floral-gourmand extrait.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.95,
                'reviews_count' => 48,
                'thumbnail_image' => 'assets/images/perfumes/velvet_orchid.svg',
            ],

            // 17. Jasmine Royale Golden Nectar
            [
                'name' => 'Jasmine Royale Golden Nectar',
                'slug' => 'jasmine-royale-golden-nectar',
                'sku' => 'MDO-JAS-ROY',
                'tagline' => 'Cold-Pressed Jasmine Blossoms, Golden Honey, and Mysore Sandalwood',
                'category_id' => $catFloral->id,
                'brand_id' => $brandImperial->id,
                'fragrance_family_id' => $ffFloral->id,
                'collections' => [$colWomen->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 14500.00,
                'sale_price' => 12999.00,
                'compare_at_price' => 16000.00,
                'stock' => 30,
                'longevity' => '14+ Hours',
                'sillage' => 'Radiant White Floral',
                'season' => 'All Seasons',
                'time_of_day' => 'Day & Evening',
                'top_notes_summary' => 'Calabrian Bergamot, Pink Pepper',
                'heart_notes_summary' => 'Lahori Motia, Iris Butter',
                'base_notes_summary' => 'Mysore Sandalwood, White Musk',
                'story' => 'Radiant white flowers dipped in warm golden honey.',
                'description' => "Pure elegance for celebratory festive occasions.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.90,
                'reviews_count' => 42,
                'thumbnail_image' => 'assets/images/perfumes/jasmine_royale.svg',
            ],

            // 18. Midnight Peony Royal Flora
            [
                'name' => 'Midnight Peony Royal Flora',
                'slug' => 'midnight-peony-royal-flora',
                'sku' => 'MDO-MID-PEO',
                'tagline' => 'Lush Crimson Peonies, Sparkling Red Berries, and Suede White Musk',
                'category_id' => $catFloral->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffFloral->id,
                'collections' => [$colWomen->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 13500.00,
                'sale_price' => 11999.00,
                'compare_at_price' => 15000.00,
                'stock' => 35,
                'longevity' => '13+ Hours',
                'sillage' => 'Playful Yet Regal Sillage',
                'season' => 'Spring / Summer',
                'time_of_day' => 'Day & Evening',
                'top_notes_summary' => 'Pink Peppercorn, Blood Orange',
                'heart_notes_summary' => 'Damascus Rose, Peony Petals',
                'base_notes_summary' => 'White Royal Musk, Sandalwood',
                'story' => 'Blooming midnight flowers under full moon skies.',
                'description' => "Youthful, sparkling, and breathtakingly feminine.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.87,
                'reviews_count' => 39,
                'thumbnail_image' => 'assets/images/perfumes/midnight_peony.svg',
            ],

            // 19. Silk & Bourbon Vanille Absolue
            [
                'name' => 'Silk & Bourbon Vanille Absolue',
                'slug' => 'silk-bourbon-vanille-absolue',
                'sku' => 'MDO-SLK-VAN',
                'tagline' => 'Aged Madagascar Bourbon Vanilla Pods, Dark Cocoa, and Spiced Amber',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffGourmand->id,
                'collections' => [$colWomen->id, $colUnisex->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Women',
                'volume_ml' => 100,
                'price' => 16000.00,
                'sale_price' => 13999.00,
                'compare_at_price' => 17500.00,
                'stock' => 28,
                'longevity' => '16+ Hours',
                'sillage' => 'Addictive Gourmand Trail',
                'season' => 'Winter Evenings',
                'time_of_day' => 'Intimate Night',
                'top_notes_summary' => 'Cardamom Noir, Blood Orange',
                'heart_notes_summary' => 'Nutmeg, Labdanum',
                'base_notes_summary' => 'Madagascar Bourbon Vanilla, Roasted Tonka, Sandalwood',
                'story' => 'Whole vanilla beans macerated in cognac casks.',
                'description' => "A rich, non-cloying balsamic vanilla that turns heads.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.96,
                'reviews_count' => 54,
                'thumbnail_image' => 'assets/images/perfumes/silk_bourbon.svg',
            ],

            // 20. Aqua Ambergris Oceanic Extrait
            [
                'name' => 'Aqua Ambergris Oceanic Extrait',
                'slug' => 'aqua-ambergris-oceanic-extrait',
                'sku' => 'MDO-AQU-AMB',
                'tagline' => 'Sea Salt Crystals, Golden Ambergris, Italian Bergamot, and Silver Pine',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffFresh->id,
                'collections' => [$colUnisex->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 14000.00,
                'sale_price' => 12499.00,
                'compare_at_price' => 15500.00,
                'stock' => 38,
                'longevity' => '12+ Hours',
                'sillage' => 'Electric Aquatic Projection',
                'season' => 'Summer High Heat',
                'time_of_day' => 'Morning to Night',
                'top_notes_summary' => 'Calabrian Bergamot, Sea Salt, Pine',
                'heart_notes_summary' => 'Pink Pepper, Lavender',
                'base_notes_summary' => 'Ambergris, White Musk, Cedarwood',
                'story' => 'Arabian Sea breeze meeting coastal woods.',
                'description' => "The ultimate luxury aquatic extrait for Karachi and coastal warmth.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.92,
                'reviews_count' => 44,
                'thumbnail_image' => 'assets/images/perfumes/marine_amber.svg',
            ],

            // 21. Gourmand Tonka & Dark Cocoa
            [
                'name' => 'Gourmand Tonka & Dark Cocoa',
                'slug' => 'gourmand-tonka-dark-cocoa',
                'sku' => 'MDO-GOU-TON',
                'tagline' => 'Roasted Venezuelan Tonka Beans, 85% Dark Cocoa, and Aged Agarwood',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffGourmand->id,
                'collections' => [$colUnisex->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 15500.00,
                'sale_price' => 13499.00,
                'compare_at_price' => 17000.00,
                'stock' => 25,
                'longevity' => '16+ Hours',
                'sillage' => 'Warm Chocolate Sillage',
                'season' => 'Winter Nights',
                'time_of_day' => 'Evening Celebrations',
                'top_notes_summary' => 'Blood Orange, Cardamom',
                'heart_notes_summary' => 'Dark Cocoa, Nutmeg',
                'base_notes_summary' => 'Roasted Tonka, Bourbon Vanilla, Dehn al Oud',
                'story' => 'Decadent chocolate and tonka warmth.',
                'description' => "Irresistible gourmand depth with pure oud backbone.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.94,
                'reviews_count' => 47,
                'thumbnail_image' => 'assets/images/perfumes/gourmand_tonka.svg',
            ],

            // 22. Bakhoor & Cashmere Wood
            [
                'name' => 'Bakhoor & Cashmere Wood',
                'slug' => 'bakhoor-cashmere-wood',
                'sku' => 'MDO-BAK-CSH',
                'tagline' => 'Royal Frankincense, Smoked Bakhoor Chunks, and Cashmere Musks',
                'category_id' => $catOud->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colUnisex->id, $colExclusive->id],
                'concentration' => 'Extrait de Parfum (38% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 16500.00,
                'sale_price' => 14499.00,
                'compare_at_price' => 18000.00,
                'stock' => 26,
                'longevity' => '16+ Hours',
                'sillage' => 'Smoky Resinous Halo',
                'season' => 'All Seasons',
                'time_of_day' => 'Spiritual & Formal',
                'top_notes_summary' => 'Cardamom, Saffron',
                'heart_notes_summary' => 'Smoked Birch, Labdanum',
                'base_notes_summary' => 'Dehn al Oud, Mysore Sandalwood, White Musk',
                'story' => 'The scent of a traditional Mughal majlis infused with burning oud chips.',
                'description' => "Smoky, grounding, and undeniably regal.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.97,
                'reviews_count' => 58,
                'thumbnail_image' => 'assets/images/perfumes/bakhoor_cashmere.svg',
            ],

            // 23. Spiced Cardamom Mountain Chai
            [
                'name' => 'Spiced Cardamom Mountain Chai',
                'slug' => 'spiced-cardamom-mountain-chai',
                'sku' => 'MDO-SPI-CHA',
                'tagline' => 'Black Tea Leaves, Crushed Green Cardamom, Ginger, and Steamed Milk',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffGourmand->id,
                'collections' => [$colUnisex->id],
                'concentration' => 'Extrait de Parfum (35% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 13500.00,
                'sale_price' => 11999.00,
                'compare_at_price' => 15000.00,
                'stock' => 32,
                'longevity' => '14+ Hours',
                'sillage' => 'Comforting Aromatic Trail',
                'season' => 'Autumn / Winter',
                'time_of_day' => 'Day & Evening',
                'top_notes_summary' => 'Cardamom Noir, Bergamot',
                'heart_notes_summary' => 'Nutmeg, Cinnamon, Black Tea',
                'base_notes_summary' => 'Bourbon Vanilla, Sandalwood',
                'story' => 'Inspired by steaming aromatic Karak tea in northern mountain valleys.',
                'description' => "Warm, spicy, cozy, and distinctly cultural.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.91,
                'reviews_count' => 40,
                'thumbnail_image' => 'assets/images/perfumes/spiced_tea.svg',
            ],

            // 24. White Royal Musk Transcendent Skin
            [
                'name' => 'White Royal Musk Transcendent',
                'slug' => 'white-royal-musk-transcendent',
                'sku' => 'MDO-WHT-MUS',
                'tagline' => 'Soft Velvet Cashmere, Crystalline White Musk, and Iris Root Butter',
                'category_id' => $catFrench->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffFresh->id,
                'collections' => [$colUnisex->id],
                'concentration' => 'Extrait de Parfum (36% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 14000.00,
                'sale_price' => 12499.00,
                'compare_at_price' => 15500.00,
                'stock' => 35,
                'longevity' => '16+ Hours',
                'sillage' => 'Velvet Intimate Cloud',
                'season' => 'All Seasons',
                'time_of_day' => 'Daily Clean Luxury',
                'top_notes_summary' => 'Bergamot, Lavender',
                'heart_notes_summary' => 'Iris Butter, Jasmine',
                'base_notes_summary' => 'White Royal Musk, Sandalwood, Ambergris',
                'story' => 'The purest clean skin scent of royal emperors.',
                'description' => "Hypnotic, comforting, clean, and endlessly praised.",
                'is_featured' => false,
                'is_bestseller' => false,
                'rating_avg' => 4.95,
                'reviews_count' => 62,
                'thumbnail_image' => 'assets/images/perfumes/white_royal_musk.svg',
            ],

            // 25. Paris x Lahore Atelier Special Edition (Collaboration)
            [
                'name' => 'Paris x Lahore 2026 Special Edition',
                'slug' => 'paris-x-lahore-2026-special-edition',
                'sku' => 'MDO-COL-PARIS',
                'tagline' => 'Bespoke Collaboration with Grasse Master Noses for Pakistan Gala 2026',
                'category_id' => $catFrench->id,
                'brand_id' => $brandModern->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colCollab->id, $colExclusive->id],
                'concentration' => 'Extrait de Parfum (40% Concentration)',
                'gender' => 'Unisex',
                'volume_ml' => 100,
                'price' => 22000.00,
                'sale_price' => 19999.00,
                'compare_at_price' => 24000.00,
                'stock' => 20,
                'longevity' => '18+ Hours',
                'sillage' => 'Monumental Sillage',
                'season' => 'All Seasons / Gala',
                'time_of_day' => 'Special Occasions',
                'top_notes_summary' => 'Calabrian Bergamot, Kashmiri Saffron, Taif Rose',
                'heart_notes_summary' => 'Smoked Birch, Motia, French Lavender',
                'base_notes_summary' => 'Dehn al Oud Cambodi, Mysore Sandalwood, Ambergris',
                'story' => 'A joint creation between Grasse master perfumers and Lahore distillers.',
                'description' => "Numbered limited flacons with 24k gold leaf flakes inside the perfume liquid.",
                'is_featured' => true,
                'is_bestseller' => false,
                'is_collaboration' => true,
                'rating_avg' => 5.00,
                'reviews_count' => 30,
                'thumbnail_image' => 'assets/images/perfumes/grasse_collab.svg',
            ],

            // 26. The Imperial Discovery Coffret (Bundle / Set of 5)
            [
                'name' => 'The Imperial Discovery Coffret (Set of 5)',
                'slug' => 'the-imperial-discovery-coffret-set-of-5',
                'sku' => 'MDO-DISC-05',
                'tagline' => '5x 10ml Luxury Travel Extraits in a Handcrafted Velvet Presentation Box',
                'category_id' => $catDiscovery->id,
                'brand_id' => $brandRoyal->id,
                'fragrance_family_id' => $ffWoody->id,
                'collections' => [$colBundles->id, $colExclusive->id, $colUnisex->id],
                'concentration' => '5x 10ml Extrait de Parfum Atomizers',
                'gender' => 'Unisex',
                'volume_ml' => 50,
                'price' => 9500.00,
                'sale_price' => 7999.00,
                'compare_at_price' => 11000.00,
                'stock' => 50,
                'longevity' => '16-18 Hours per Fragrance',
                'sillage' => 'Curated Spectrum',
                'season' => 'All Seasons',
                'time_of_day' => 'Day to Night Versatility',
                'top_notes_summary' => 'Discovery of 5 Flagship Maison d\'Orient Masterpieces',
                'heart_notes_summary' => 'Oud Royale, Noor-e-Gulab, Lahore Nights, Murree Mist, Sultan Cuir',
                'base_notes_summary' => 'Includes Rs. 2,000 Voucher for your first 100ml flacon',
                'story' => 'The quintessential gift of discovery.',
                'description' => "Contains 5x 10ml pressurized atomizers of our finest extraits in a velvet presentation box.",
                'is_featured' => true,
                'is_bestseller' => true,
                'is_bundle' => true,
                'rating_avg' => 4.98,
                'reviews_count' => 195,
                'thumbnail_image' => 'assets/images/perfumes/discovery_set.svg',
                'hover_image' => 'assets/images/perfumes/discovery_set_open.svg',
            ],
        ];

        $impressionsMap = [
            'oud-royale-1947-extrait' => 'Cambodian Agarwood & Smoked Leather (TF Blend)',
            'dehn-al-oud-cambodi-pure-attar' => 'Pure Koh Kong Hydro-Distilled Agarwood',
            'noor-e-gulab-rose-absolute' => 'Taif Rose & Saffron (MFK Oud Satin Mood)',
            'lahore-nights-smoked-amber' => 'Tom Ford Tobacco Vanille & Amber Absolute',
            'murree-mist-silver-bergamot' => 'Creed Silver Mountain Water',
            'sultans-cuir-tuscan-tobacco' => 'Tom Ford Tuscan Leather & YSL Tuxedo',
            'imperial-motia-saffron-nectar' => 'Kilian Love Don\'t Be Shy & Jasmin 17',
            'kashmir-saffron-noir-extrait' => 'Matiere Premiere Crystal Saffron',
            'cardamom-noir-extrait' => 'BDK Parfums Gris Charnel Extrait',
            'ambergris-imperial-blue-waves' => 'Roja Parfums Elysium Pour Homme',
            'gourmand-tonka-spiced-cocoa' => 'Kilian Angels\' Share / Feve Delicieuse',
            'vetiver-imperiale-smoked-birch' => 'Tom Ford Grey Vetiver & Terre d\'Hermes',
            'atlas-cedarwood-black-pepper' => 'Creed Royal Oud',
            'smoked-birch-vintage-saddle' => 'Memo Paris Irish Leather',
            'taif-rose-1888-private-flacon' => 'Clive Christian No. 1 / Taif Rose Niche',
            'white-royal-musk-silk-petals' => 'Initio Musk Therapy',
            'bakhoor-cashmere-extrait' => 'Louis Vuitton Ombre Nomade',
            'midnight-peony-wild-berries' => 'Parfums de Marly Delina Exclusif',
            'silk-bourbon-vanille-absolue' => 'Nishane Ani',
            'spiced-kahwa-smoked-cardamom' => 'Xerjoff Starlight',
            'sandalwood-supreme-warm-saffron' => 'Le Labo Santal 33',
            'marine-ambergris-italian-bergamot' => 'Louis Vuitton Afternoon Swim / Imagination',
            'velvet-orchid-midnight-jasmine' => 'Tom Ford Black Orchid',
            'jasmine-royale-golden-sandalwood' => 'Xerjoff Naxos',
            'the-grasse-accord-limited-flacon' => 'Baccarat Rouge 540 Extrait',
            'the-imperial-discovery-coffret-set-of-5' => 'Curated Top 5 Luxury Impressions Coffret',
        ];

        $createdProducts = [];
        foreach ($perfumesData as $item) {
            $colIds = $item['collections'] ?? [];
            unset($item['collections']);

            if (empty($item['impression_of']) && isset($impressionsMap[$item['slug']])) {
                $item['impression_of'] = $impressionsMap[$item['slug']];
            }

            $product = Product::create($item);
            $createdProducts[$product->slug] = $product;

            // Attach collections
            if (!empty($colIds)) {
                $product->collections()->attach($colIds);
            }

            // Primary Image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $product->thumbnail_image,
                'alt_text' => $product->name . ' Primary Flacon',
                'sort_order' => 1,
                'is_primary' => true,
            ]);

            if ($product->hover_image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $product->hover_image,
                    'alt_text' => $product->name . ' Box Angle',
                    'sort_order' => 2,
                    'is_primary' => false,
                ]);
            }

            // Variants (10ml Travel, 50ml Flacon, 100ml Collector)
            if (!$product->is_bundle) {
                if ($product->volume_ml == 100) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_label' => '10ml Travel Atomizer',
                        'volume_ml' => 10,
                        'price' => 1199.00,
                        'sale_price' => 999.00,
                        'sku' => $product->sku . '-10ML',
                        'stock' => 50,
                        'is_default' => false,
                    ]);
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_label' => '50ml Flacon',
                        'volume_ml' => 50,
                        'price' => round($product->price * 0.62, -1),
                        'sale_price' => $product->sale_price ? round($product->sale_price * 0.62, -1) : null,
                        'sku' => $product->sku . '-50ML',
                        'stock' => 35,
                        'is_default' => false,
                    ]);
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_label' => '100ml Collector Flacon',
                        'volume_ml' => 100,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'sku' => $product->sku . '-100ML',
                        'stock' => 30,
                        'is_default' => true,
                    ]);
                } else {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_label' => $product->volume_ml . 'ml Crystal Flacon',
                        'volume_ml' => $product->volume_ml,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'sku' => $product->sku . '-' . $product->volume_ml . 'ML',
                        'stock' => $product->stock,
                        'is_default' => true,
                    ]);
                }
            }

            // Reviews
            Review::create([
                'product_id' => $product->id,
                'customer_name' => 'Hamza Sheikh',
                'customer_city' => 'Lahore, DHA',
                'rating' => 5,
                'title' => 'Beast mode performance in Pakistan!',
                'comment' => 'Easily lasts 16+ hours on my sherwani and clothes. Packaging and heavy magnetic cap feel extraordinarily premium.',
                'verified_purchase' => true,
                'is_approved' => true,
            ]);

            Review::create([
                'product_id' => $product->id,
                'customer_name' => 'Dr. Ayesha Malik',
                'customer_city' => 'Islamabad, F-7',
                'rating' => 5,
                'title' => 'Regal, authentic, and unforgettable aura',
                'comment' => 'Received countless compliments at an embassy gala. Super fast 24h delivery in Islamabad via TCS.',
                'verified_purchase' => true,
                'is_approved' => true,
            ]);
        }

        // 10. Curated Bundles (Multi-Product Bundles inspired by Rawaha reference)
        $bundle1 = Bundle::create([
            'name' => 'The Royal Mughal Duo (Oud Royale + Noor-e-Gulab)',
            'slug' => 'royal-mughal-duo-bundle',
            'sku' => 'BNDL-MUGHAL-DUO',
            'tagline' => 'Imperial Agarwood meets Velvet Taif Rose (2x 100ml Extraits)',
            'description' => 'Pair our two most iconic creations: Oud Royale 1947 and Noor-e-Gulab Rose Absolute. Includes luxury velvet double-presentation coffret.',
            'original_price' => 33000.00,
            'bundle_price' => 26999.00,
            'savings_amount' => 6001.00,
            'image' => 'assets/images/perfumes/mughal_duo_bundle.svg',
            'badge_text' => 'SAVE RS. 6,000',
            'is_active' => true,
        ]);

        if (isset($createdProducts['oud-royale-1947-extrait'])) {
            BundleItem::create(['bundle_id' => $bundle1->id, 'product_id' => $createdProducts['oud-royale-1947-extrait']->id, 'quantity' => 1, 'custom_size_label' => '100ml Flacon']);
        }
        if (isset($createdProducts['noor-e-gulab-rose-absolute'])) {
            BundleItem::create(['bundle_id' => $bundle1->id, 'product_id' => $createdProducts['noor-e-gulab-rose-absolute']->id, 'quantity' => 1, 'custom_size_label' => '100ml Flacon']);
        }

        $bundle2 = Bundle::create([
            'name' => 'The Executive Sillage Duo (Sultan\'s Cuir + Lahore Nights)',
            'slug' => 'executive-sillage-duo-bundle',
            'sku' => 'BNDL-EXEC-DUO',
            'tagline' => 'Tuscan Leather & Smoked Resinous Amber for Power Presence',
            'description' => 'The ultimate masculine power combo. Sultan\'s Cuir & Tuscan Tobacco paired with Lahore Nights Smoked Amber in full 100ml collector flacons.',
            'original_price' => 33500.00,
            'bundle_price' => 27999.00,
            'savings_amount' => 5501.00,
            'image' => 'assets/images/perfumes/executive_bundle.svg',
            'badge_text' => 'SAVE RS. 5,500',
            'is_active' => true,
        ]);

        if (isset($createdProducts['sultans-cuir-tuscan-tobacco'])) {
            BundleItem::create(['bundle_id' => $bundle2->id, 'product_id' => $createdProducts['sultans-cuir-tuscan-tobacco']->id, 'quantity' => 1, 'custom_size_label' => '100ml Flacon']);
        }
        if (isset($createdProducts['lahore-nights-smoked-amber'])) {
            BundleItem::create(['bundle_id' => $bundle2->id, 'product_id' => $createdProducts['lahore-nights-smoked-amber']->id, 'quantity' => 1, 'custom_size_label' => '100ml Flacon']);
        }

        $bundle3 = Bundle::create([
            'name' => 'The Pure Attar Connoisseur Trio',
            'slug' => 'pure-attar-connoisseur-trio',
            'sku' => 'BNDL-ATTAR-TRIO',
            'tagline' => '3x 12ml Hand-Cut Crystal Flacons (Dehn al Oud + Motia + Sandalwood)',
            'description' => '100% pure alcohol-free concentrated perfume oils in crystal flacons with glass applicator rods.',
            'original_price' => 45000.00,
            'bundle_price' => 37999.00,
            'savings_amount' => 7001.00,
            'image' => 'assets/images/perfumes/attar_trio_bundle.svg',
            'badge_text' => 'SAVE RS. 7,000',
            'is_active' => true,
        ]);

        // 11. Blogs / Fragrance Chronicles
        Blog::create([
            'title' => 'Why Commercial Perfumes Disappear in Pakistan (And Why Extrait Lasts 18+ Hours)',
            'slug' => 'why-commercial-perfumes-disappear-in-pakistan',
            'excerpt' => 'An insider look into perfume concentration physics, alcohol volatility in 40°C heat, and the power of aged natural fixatives.',
            'content' => "In Pakistan's climate, conventional designer fragrances bottled at 12-15% concentration evaporate within 3 to 4 hours. The high atmospheric temperature accelerates alcohol vaporization, leaving little trail behind.\n\nAt Perfumes Collection, all spray compositions are formulated at 35% to 40% Extrait de Parfum strength. By using dense, natural base notes such as 15-year aged Cambodian agarwood and natural ambergris, we anchor volatile floral and citrus notes to skin lipids and cloth fibers for over 18 hours.",
            'image' => 'assets/images/perfumes/oud_royale_box.svg',
            'author_name' => 'Master Parfumeur M. Al-Farabi',
            'category' => 'Olfactory Science',
            'read_time' => '5 min read',
            'is_published' => true,
            'published_at' => now()->subDays(3),
        ]);

        Blog::create([
            'title' => 'The Sovereign History of Royal Mughal Attar Traditions in Lahore',
            'slug' => 'sovereign-history-royal-mughal-attar-lahore',
            'excerpt' => 'Exploring four centuries of imperial distillation in the courtyards of the Shalimar Gardens.',
            'content' => "During the Mughal dynasty in 17th century Lahore, Empress Nur Jahan is credited with discovering the essence of distilled rose petals (Itr-e-Gulab). The imperial ateliers perfected copper hydro-distillation over slow wood fire.\n\nToday, Perfumes Collection preserves these exact time-honored artisanal methods, sourcing rare botanicals from Kashmir, Taif, and Southeast Asia.",
            'image' => 'assets/images/perfumes/noor_gulab_box.svg',
            'author_name' => 'Tariq Al-Hashmi, Perfume Historian',
            'category' => 'Heritage',
            'read_time' => '7 min read',
            'is_published' => true,
            'published_at' => now()->subDays(8),
        ]);

        Blog::create([
            'title' => 'Bridal & Groom Scent Wardrobe: How to Choose Your Wedding Fragrance',
            'slug' => 'bridal-groom-scent-wardrobe-guide',
            'excerpt' => 'How to curate an intoxicating, regal scent cloud that lingers throughout Mehndi, Barat, and Walima ceremonies.',
            'content' => "A Pakistani wedding is a multi-day olfactory festival. For Mehndi, choose sparkling fresh or floral accords like Imperial Motia. For Barat, command the royal stage with Oud Royale 1947 or Sultan's Cuir.\n\nLayering an Extrait de Parfum over pure Dehn al Oud ensures you are enveloped in a magnetic scent trail that will be captured in your wedding memories forever.",
            'image' => 'assets/images/perfumes/discovery_set.svg',
            'author_name' => 'Zahra Karim, Fragrance Stylist',
            'category' => 'Wedding Guide',
            'read_time' => '6 min read',
            'is_published' => true,
            'published_at' => now()->subDays(14),
        ]);

        // 12. Coupons
        Coupon::create([
            'code' => 'ROYAL10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_spend' => 5000.00,
            'max_discount' => 3000.00,
            'expires_at' => now()->addMonths(6),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FIRSTORDER',
            'type' => 'fixed',
            'value' => 1000.00,
            'min_spend' => 8000.00,
            'expires_at' => now()->addMonths(12),
            'is_active' => true,
        ]);

        // 13. Realistic Customer Orders (Fulfillment & Payment Lifecycle)
        $oudRoyale = $createdProducts['oud-royale-1947-extrait'] ?? Product::first();
        $sultanCuir = $createdProducts['sultans-cuir-tuscan-tobacco'] ?? Product::skip(1)->first();
        $noorGulab = $createdProducts['noor-e-gulab-rose-absolute'] ?? Product::skip(2)->first();
        $lahoreNights = $createdProducts['lahore-nights-smoked-amber'] ?? Product::skip(3)->first();
        $murreeMist = $createdProducts['murree-mist-silver-bergamot'] ?? Product::skip(4)->first();

        // Order 1: Delivered COD in Lahore
        $order1 = Order::create([
            'order_number' => 'RAV-2026-1001',
            'user_id' => $customer->id,
            'customer_name' => 'Kamran Akram',
            'customer_email' => 'kamran.akram@gmail.com',
            'customer_phone' => '0300-8451234',
            'shipping_address' => 'House 42, Street 8, Sector C, Phase 6 DHA',
            'area' => 'DHA Phase 6',
            'city' => 'Lahore',
            'province' => 'Punjab',
            'postal_code' => '54792',
            'order_notes' => 'Please deliver before 5 PM. Call upon arrival.',
            'subtotal' => 27498.00,
            'discount_amount' => 0.00,
            'shipping_cost' => 0.00,
            'total_amount' => 27498.00,
            'payment_method' => 'cod',
            'payment_status' => 'paid',
            'order_status' => 'delivered',
            'courier_name' => 'TCS',
            'tracking_number' => 'TCS-92817462',
            'tracking_link' => 'https://www.tcsexpress.com/tracking?track=TCS-92817462',
            'is_whatsapp_order' => false,
            'created_at' => now()->subDays(5),
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $oudRoyale->id,
            'product_name' => $oudRoyale->name,
            'variant_label' => '100ml Collector Flacon',
            'price' => $oudRoyale->sale_price ?? $oudRoyale->price,
            'quantity' => 1,
            'total' => $oudRoyale->sale_price ?? $oudRoyale->price,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $murreeMist->id,
            'product_name' => $murreeMist->name,
            'variant_label' => '100ml Collector Flacon',
            'price' => $murreeMist->sale_price ?? $murreeMist->price,
            'quantity' => 1,
            'total' => $murreeMist->sale_price ?? $murreeMist->price,
        ]);

        // Order 2: Pending Bank Transfer Verification (Receipt Attached!)
        $order2 = Order::create([
            'order_number' => 'RAV-2026-1002',
            'user_id' => null,
            'customer_name' => 'Ayesha Siddiqui',
            'customer_email' => 'ayesha.s@outlook.com',
            'customer_phone' => '0321-9876543',
            'shipping_address' => 'Apartment 5B, Creek Vistas, Phase 8 DHA',
            'area' => 'Creek Vistas',
            'city' => 'Karachi',
            'province' => 'Sindh',
            'postal_code' => '75500',
            'order_notes' => 'Transferred via Bank Alfalah online banking. Receipt attached.',
            'subtotal' => 12499.00,
            'discount_amount' => 0.00,
            'shipping_cost' => 0.00,
            'total_amount' => 12499.00,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending_verification',
            'payment_receipt' => 'assets/images/perfumes/oud_royale.svg',
            'bank_transaction_id' => 'ALFH-9837190',
            'order_status' => 'pending',
            'courier_name' => null,
            'tracking_number' => null,
            'tracking_link' => null,
            'is_whatsapp_order' => false,
            'created_at' => now()->subHours(4),
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $noorGulab->id,
            'product_name' => $noorGulab->name,
            'variant_label' => '100ml Collector Flacon',
            'price' => 12499.00,
            'quantity' => 1,
            'total' => 12499.00,
        ]);
        Payment::create([
            'order_id' => $order2->id,
            'payment_method' => 'bank_transfer',
            'amount' => 12499.00,
            'transaction_id' => 'ALFH-9837190',
            'receipt_image' => 'assets/images/perfumes/oud_royale.svg',
            'status' => 'pending_verification',
            'notes' => 'Customer uploaded Bank Alfalah internet banking receipt.',
        ]);

        // Order 3: Shipped via Leopards to Islamabad
        $order3 = Order::create([
            'order_number' => 'RAV-2026-1003',
            'user_id' => null,
            'customer_name' => 'Dr. Omar Farooq',
            'customer_email' => 'omar.farooq@shifa.pk',
            'customer_phone' => '0333-5128901',
            'shipping_address' => 'House 17, Street 24, Sector F-7/2',
            'area' => 'F-7/2',
            'city' => 'Islamabad',
            'province' => 'Federal',
            'postal_code' => '44000',
            'order_notes' => 'Leave with security guard if not available.',
            'subtotal' => 14999.00,
            'discount_amount' => 0.00,
            'shipping_cost' => 0.00,
            'total_amount' => 14999.00,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'paid',
            'bank_transaction_id' => 'RAAST-8829103',
            'order_status' => 'shipped',
            'courier_name' => 'Leopards Courier',
            'tracking_number' => 'LEO-74628192',
            'tracking_link' => 'https://www.leopardscourier.com/tracking?track_numbers=LEO-74628192',
            'is_whatsapp_order' => false,
            'created_at' => now()->subDays(2),
        ]);
        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $sultanCuir->id,
            'product_name' => $sultanCuir->name,
            'variant_label' => '100ml Collector Flacon',
            'price' => 14999.00,
            'quantity' => 1,
            'total' => 14999.00,
        ]);

        // Order 4: Shipped via PostEx to Peshawar
        $order4 = Order::create([
            'order_number' => 'RAV-2026-1004',
            'user_id' => null,
            'customer_name' => 'Zainab Tariq',
            'customer_email' => 'zainab.tariq@gmail.com',
            'customer_phone' => '0345-2233445',
            'shipping_address' => 'Bungalow 12, Officers Colony, Mall Road Cantt',
            'city' => 'Peshawar',
            'province' => 'KPK',
            'postal_code' => '25000',
            'subtotal' => 13999.00,
            'discount_amount' => 1000.00,
            'coupon_code' => 'FIRSTORDER',
            'shipping_cost' => 0.00,
            'total_amount' => 12999.00,
            'payment_method' => 'easypaisa',
            'payment_status' => 'paid',
            'order_status' => 'shipped',
            'courier_name' => 'PostEx',
            'tracking_number' => 'PTX-662910',
            'tracking_link' => 'https://postex.pk/tracking?order_id=PTX-662910',
            'is_whatsapp_order' => true,
            'created_at' => now()->subDay(),
        ]);
        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $lahoreNights->id,
            'product_name' => $lahoreNights->name,
            'variant_label' => '100ml Collector Flacon',
            'price' => 13999.00,
            'quantity' => 1,
            'total' => 13999.00,
        ]);

        // Order 5: Processing COD in Faisalabad
        $order5 = Order::create([
            'order_number' => 'RAV-2026-1005',
            'user_id' => null,
            'customer_name' => 'Bilal Hassan',
            'customer_email' => 'bilal.hassan@yahoo.com',
            'customer_phone' => '0312-3456789',
            'shipping_address' => 'Street 4, Madina Town',
            'city' => 'Faisalabad',
            'province' => 'Punjab',
            'postal_code' => '38000',
            'subtotal' => 7999.00,
            'discount_amount' => 0.00,
            'shipping_cost' => 0.00,
            'total_amount' => 7999.00,
            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
            'order_status' => 'processing',
            'courier_name' => 'Trax Logistics',
            'tracking_number' => 'TRX-83719201',
            'tracking_link' => 'https://trax.pk/tracking?tracking_number=TRX-83719201',
            'is_whatsapp_order' => false,
            'created_at' => now()->subHours(12),
        ]);
        if (isset($createdProducts['the-imperial-discovery-coffret-set-of-5'])) {
            $disc = $createdProducts['the-imperial-discovery-coffret-set-of-5'];
            OrderItem::create([
                'order_id' => $order5->id,
                'product_id' => $disc->id,
                'product_name' => $disc->name,
                'variant_label' => 'Set of 5 (10ml Extraits)',
                'price' => 7999.00,
                'quantity' => 1,
                'total' => 7999.00,
            ]);
        }

        // Order 6: Pending Verification with Bank Receipt
        $order6 = Order::create([
            'order_number' => 'RAV-2026-1006',
            'user_id' => null,
            'customer_name' => 'Usman Ghani',
            'customer_email' => 'usman.ghani@gmail.com',
            'customer_phone' => '0322-4455667',
            'shipping_address' => 'Sector B-17, Multi Gardens, Block C',
            'city' => 'Islamabad',
            'province' => 'Federal',
            'postal_code' => '44000',
            'subtotal' => 21500.00,
            'discount_amount' => 0.00,
            'shipping_cost' => 0.00,
            'total_amount' => 21500.00,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending_verification',
            'payment_receipt' => 'assets/images/perfumes/dehn_oud_attar.svg',
            'bank_transaction_id' => 'HBL-7821903',
            'order_status' => 'pending',
            'is_whatsapp_order' => false,
            'created_at' => now()->subHours(2),
        ]);
        if (isset($createdProducts['dehn-al-oud-cambodi-pure-attar'])) {
            $attar = $createdProducts['dehn-al-oud-cambodi-pure-attar'];
            OrderItem::create([
                'order_id' => $order6->id,
                'product_id' => $attar->id,
                'product_name' => $attar->name,
                'variant_label' => '12ml Crystal Flacon',
                'price' => 21500.00,
                'quantity' => 1,
                'total' => 21500.00,
            ]);
        }

        // Order 7: Confirmed COD in Rawalpindi
        $order7 = Order::create([
            'order_number' => 'RAV-2026-1007',
            'user_id' => null,
            'customer_name' => 'Murtaza Shah',
            'customer_email' => 'murtaza.shah@gmail.com',
            'customer_phone' => '0334-9988112',
            'shipping_address' => 'House 19, Saddar Road, Cantt',
            'city' => 'Rawalpindi',
            'province' => 'Punjab',
            'postal_code' => '46000',
            'subtotal' => 14999.00,
            'discount_amount' => 1499.90,
            'coupon_code' => 'ROYAL10',
            'shipping_cost' => 0.00,
            'total_amount' => 13499.10,
            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
            'order_status' => 'confirmed',
            'is_whatsapp_order' => false,
            'created_at' => now()->subHours(8),
        ]);
        OrderItem::create([
            'order_id' => $order7->id,
            'product_id' => $sultanCuir->id,
            'product_name' => $sultanCuir->name,
            'variant_label' => '100ml Collector Flacon',
            'price' => 14999.00,
            'quantity' => 1,
            'total' => 14999.00,
        ]);

        // 14. Activity Logs for Admin Dashboard Stream
        ActivityLog::create([
            'user_id' => $superAdmin->id,
            'action' => 'system_bootstrapped',
            'description' => 'RAVAHA Parfums master vault initialized with 26 luxury impressions & administrative security policies.',
            'created_at' => now()->subDays(6),
        ]);
        ActivityLog::create([
            'user_id' => $orderSpecialist->id,
            'action' => 'order_verified',
            'description' => 'Verified Raast transaction RAAST-8829103 for order #RAV-2026-1003.',
            'created_at' => now()->subDays(2),
        ]);
        ActivityLog::create([
            'user_id' => $catalogLead->id,
            'action' => 'product_created',
            'description' => 'Updated olfactory composition notes for Sovereign Aventus and Roman Leather.',
            'created_at' => now()->subHours(5),
        ]);
    }
}
