<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Brand;
use App\Models\FragranceFamily;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductPrice;
use App\Models\ActivityLog;

class ProductionCatalogSeeder extends Seeder
{
    /**
     * Run production safe catalog seeder for the exact 26 Excel perfumes.
     * Enforces the 26 products and cleans up any old non-Excel products.
     */
    public function run()
    {
        // 1. Ensure Brand
        $brand = Brand::firstOrCreate(
            ['slug' => 'perfumes-collection-ateliers'],
            [
                'name' => 'Perfumes Collection Ateliers',
                'origin_country' => 'Paris / Lahore Atelier',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 2. Ensure Categories
        $catPerfume = Category::firstOrCreate(
            ['slug' => 'perfume'],
            [
                'name' => 'Perfume',
                'description' => 'Master-crafted luxury impressions and haute parfumerie extraits.',
                'image' => 'assets/images/categories/collection_signature.jpg',
                'badge_text' => 'Signature Extrait',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // 3. Ensure Collections
        $colMen = Collection::firstOrCreate(
            ['slug' => 'men'],
            [
                'name' => "Men's Haute Parfumerie",
                'description' => 'Commanding, smoky leather, aromatic woods, and rich spices.',
                'badge_text' => 'Power & Sillage',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        $colWomen = Collection::firstOrCreate(
            ['slug' => 'women'],
            [
                'name' => "Women's Imperial Flora",
                'description' => 'Sensual florals, luscious gourmands, and luminous amber extraits.',
                'badge_text' => 'Sensual & Radiant',
                'sort_order' => 2,
                'is_featured' => true,
            ]
        );

        $colUnisex = Collection::firstOrCreate(
            ['slug' => 'unisex'],
            [
                'name' => "Unisex & Niche Extraits",
                'description' => 'Transcendent compositions balancing ambergris, warm woods, and precious resins.',
                'badge_text' => 'Transcendent',
                'sort_order' => 3,
                'is_featured' => true,
            ]
        );

        $colExclusive = Collection::firstOrCreate(
            ['slug' => 'exclusive'],
            [
                'name' => "Exclusive Reserve",
                'description' => 'Hand-macerated private reserve formulations for connoisseurs.',
                'badge_text' => 'Private Reserve',
                'sort_order' => 4,
                'is_featured' => true,
            ]
        );

        // 4. Fragrance Families
        $ffGourmand = FragranceFamily::firstOrCreate(
            ['slug' => 'gourmand-vanille'],
            ['name' => 'Warm Gourmand & Bourbon Vanilla', 'accent_color' => '#A0522D', 'description' => 'Caramel, dates, cinnamon, and dark bourbon vanilla.']
        );
        $ffLeather = FragranceFamily::firstOrCreate(
            ['slug' => 'leather-spice'],
            ['name' => 'Smoky Leather & Royal Spice', 'accent_color' => '#8C6D53', 'description' => 'Tuscan leather, black suede, and Kashmiri saffron.']
        );
        $ffFloral = FragranceFamily::firstOrCreate(
            ['slug' => 'floral-nectar'],
            ['name' => 'Imperial Floral & White Flowers', 'accent_color' => '#E0A96D', 'description' => 'Tuberose, jasmine sambac, and white musk.']
        );
        $ffFresh = FragranceFamily::firstOrCreate(
            ['slug' => 'fresh-aquatic-citrus'],
            ['name' => 'Fresh Aquatic & Oceanic Bergamot', 'accent_color' => '#5C9EAD', 'description' => 'Crisp bergamot, aquatic accords, and cedarwood.']
        );
        $ffWoody = FragranceFamily::firstOrCreate(
            ['slug' => 'woody-oud-amber'],
            ['name' => 'Woody Oriental & Royal Oud', 'accent_color' => '#C9A24B', 'description' => 'Rare agarwood, Mysore sandalwood, and golden amber.']
        );

        // 5. The exact 26 Excel perfumes list
        $productsData = [
            [
                'sku' => 'RVH-001',
                'name' => 'Lattafa Khumrah (Midnight Oud Exclusive)',
                'slug' => 'lattafa-khumrah-midnight-oud-exclusive',
                'impression_of' => 'Midnight Oud Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffGourmand->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2300,
                'sale_price' => 2300,
                'compare_at_price' => 2800,
                'prices' => [30 => 1350, 50 => 2300, 100 => 4000],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Warm Cinnamon, Sweet Praline, Nutmeg & Midnight Smoked Amber',
                'description' => 'A deeply opulent blend of warm cinnamon, sweet dates, and creamy praline infused with midnight amber. Engineered with 35% extrait concentration for rich 14+ hours sillage.',
                'thumbnail_image' => 'assets/Perfumes images/Lattafa Khamrah 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Lattafa Khamrah 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-002',
                'name' => 'Eclair (Caramel Fantasy Exclusive)',
                'slug' => 'eclair-caramel-fantasy-exclusive',
                'impression_of' => 'Caramel Fantasy Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffGourmand->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2800,
                'sale_price' => 2800,
                'compare_at_price' => 3400,
                'prices' => [30 => 1350, 50 => 2800, 100 => 4800],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Golden Salted Caramel, Fluffy Vanilla Marshmallow & Warm Milk',
                'description' => 'A mouthwatering gourmand dream featuring golden caramel drizzle, whipped vanilla cream, and soft tonka bean. Leaves an irresistible comforting luxury scent trail.',
                'thumbnail_image' => 'assets/Perfumes images/Eclair 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Eclair 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-003',
                'name' => 'Marjaan',
                'slug' => 'marjaan',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffWoody->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2800,
                'sale_price' => 2800,
                'compare_at_price' => 3400,
                'prices' => [30 => 1350, 50 => 2800, 100 => 4800],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Red Coral Amber, Aged Sandalwood & Sweet Velvet Spices',
                'description' => 'Inspired by the precious gemstones of the Arabian Sea. Marjaan unfolds with radiant spices, aged Mysore sandalwood, and a warm, glowing amber base.',
                'thumbnail_image' => 'assets/Perfumes images/Marjaan 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Marjaan 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'sku' => 'RVH-004',
                'name' => 'My Way (Paris Ladies)',
                'slug' => 'my-way-paris-ladies',
                'impression_of' => 'Paris Ladies',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFloral->id,
                'gender' => 'Women',
                'stock' => 100,
                'base_price' => 2900,
                'sale_price' => 2900,
                'compare_at_price' => 3500,
                'prices' => [30 => 1350, 50 => 2900, 100 => 4400],
                'collections' => [$colWomen->id],
                'tagline' => 'Egyptian Orange Blossom, Radiant Tuberose & White Cedar',
                'description' => 'A luminous bouquet of bright white flowers from Egypt and India, underpinned by sensual bourbon vanilla and clean white musk. Elegant and timeless.',
                'thumbnail_image' => 'assets/Perfumes images/My Way 1.jpeg',
                'hover_image' => 'assets/Perfumes images/My Way 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-005',
                'name' => 'Afnan Supremacy',
                'slug' => 'afnan-supremacy',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffWoody->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 3000,
                'sale_price' => 3000,
                'compare_at_price' => 3700,
                'prices' => [30 => 1500, 50 => 3000, 100 => 5000],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Smoky Birch, Blackcurrant, Bergamot & Royal Ambergris',
                'description' => 'A powerhouse composition delivering an assertive smoky birch and crisp blackcurrant opening that settles into magnetic patchouli, oakmoss, and royal ambergris.',
                'thumbnail_image' => 'assets/Perfumes images/Afnan Supremacy 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Afnan Supremacy 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-006',
                'name' => 'Gucci Bloom',
                'slug' => 'gucci-bloom',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFloral->id,
                'gender' => 'Women',
                'stock' => 100,
                'base_price' => 2000,
                'sale_price' => 2000,
                'compare_at_price' => 2500,
                'prices' => [30 => 1300, 50 => 2000, 100 => 3500],
                'collections' => [$colWomen->id],
                'tagline' => 'Natural Tuberose, Jasmine Sambac & Rangoon Creeper Petals',
                'description' => 'Captures the rich scent of a thriving English garden filled with an abundance of flowers. Pure white tuberose absolute, powdery jasmine bud, and velvety floral accords.',
                'thumbnail_image' => 'assets/Perfumes images/Gucci Bloom 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Gucci Bloom 1.jpeg',
                'is_featured' => false,
                'is_bestseller' => false,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-007',
                'name' => '9PM Night Out (Night Out Exclusive)',
                'slug' => '9pm-night-out-exclusive',
                'impression_of' => 'Night Out Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffGourmand->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2500,
                'sale_price' => 2500,
                'compare_at_price' => 3100,
                'prices' => [30 => 1500, 50 => 2500, 100 => 3750],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Crisp Wild Apple, Spicy Cinnamon, Lavender & Deep Vanilla Amber',
                'description' => 'The ultimate clubbing and evening signature. Electric apple and cinnamon upfront that evolves into smooth lavender, orange blossom, and an addictive vanilla amber aura.',
                'thumbnail_image' => 'assets/Perfumes images/9PM Night Out 1.jpeg',
                'hover_image' => 'assets/Perfumes images/9PM Night Out 2.jpeg',
                'lifestyle_image' => 'assets/images/perfumes/9pm_night_out_3.jpg',
                'gallery_images' => ['assets/images/perfumes/9pm_night_out_3.jpg'],
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-008',
                'name' => 'Rebel',
                'slug' => 'rebel',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFresh->id,
                'gender' => 'Men',
                'stock' => 100,
                'base_price' => 2250,
                'sale_price' => 2250,
                'compare_at_price' => 2800,
                'prices' => [30 => 1350, 50 => 2250, 100 => 3500],
                'collections' => [$colMen->id],
                'tagline' => 'Calabrian Bergamot, Sichuan Pepper, Lavender & Raw Ambroxan',
                'description' => 'Raw, noble, and radically fresh. Bursting with sun-drenched bergamot, sharp Sichuan pepper, and a powerful trail of woody ambroxan.',
                'thumbnail_image' => 'assets/Perfumes images/Rebel 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Rebel 2.jpeg',
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-009',
                'name' => '9PM After 9',
                'slug' => '9pm-after-9',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffGourmand->id,
                'gender' => 'Men',
                'stock' => 100,
                'base_price' => 2300,
                'sale_price' => 2300,
                'compare_at_price' => 2900,
                'prices' => [30 => 1300, 50 => 2300, 100 => 3400],
                'collections' => [$colMen->id],
                'tagline' => 'Sensual Cardamom, Roasted Tonka, Rich Amber & Dark Woods',
                'description' => 'A darker, deeper after-hours variation crafted with warm crushed cardamom, toasted tonka bean, and seductive dark woods.',
                'thumbnail_image' => 'assets/Perfumes images/9PM After 9 1.jpeg',
                'hover_image' => 'assets/Perfumes images/9PM After 9 2.jpeg',
                'lifestyle_image' => 'assets/images/perfumes/9pm_after_9_2.jpg',
                'is_featured' => false,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'sku' => 'RVH-010',
                'name' => 'Ombre Leather (The Leather)',
                'slug' => 'ombre-leather-the-leather',
                'impression_of' => 'The Leather',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffLeather->id,
                'gender' => 'Men',
                'stock' => 100,
                'base_price' => 2600,
                'sale_price' => 2600,
                'compare_at_price' => 3200,
                'prices' => [30 => 1500, 50 => 2600, 100 => 3900],
                'collections' => [$colMen->id],
                'tagline' => 'Black Leather, Rich Cardamom, Jasmine Sambac & Earthy Moss',
                'description' => 'Vast, untethered, and tactile. Rich floral leather and spices evoke the still air and open spaces of the American Southwest.',
                'thumbnail_image' => 'assets/Perfumes images/Ombre Leather 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Ombre Leather 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-011',
                'name' => 'Tuscan Leather (Leather Temptation)',
                'slug' => 'tuscan-leather-leather-temptation',
                'impression_of' => 'Leather Temptation',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffLeather->id,
                'gender' => 'Men',
                'stock' => 100,
                'base_price' => 2400,
                'sale_price' => 2400,
                'compare_at_price' => 3000,
                'prices' => [30 => 1200, 50 => 2400, 100 => 4000],
                'collections' => [$colMen->id],
                'tagline' => 'Tuscan Leather, Bittersweet Raspberry, Saffron & Night Thyme',
                'description' => 'A legendary chypre blend fusing raw, supple Tuscan leather with sweet tart raspberry, golden saffron, and smoky olibanum resin.',
                'thumbnail_image' => 'assets/Perfumes images/Tuscan Leather 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Tuscan Leather 2.jpeg',
                'is_featured' => false,
                'is_bestseller' => false,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-012',
                'name' => 'Sentinal (Exclusive)',
                'slug' => 'sentinal-exclusive',
                'impression_of' => 'Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffWoody->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 3500,
                'sale_price' => 3500,
                'compare_at_price' => 4200,
                'prices' => [30 => 2000, 50 => 3500, 100 => 5500],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Rare Royal Woods, Golden Frankincense & Midnight Amber Extrait',
                'description' => 'A towering presence of royal frankincense, smoked cedar, and liquid ambergris. Built for collectors who command immediate reverence.',
                'thumbnail_image' => 'assets/Perfumes images/Sentinal 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Sentinal 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'sku' => 'RVH-013',
                'name' => 'Black Opium (Charm)',
                'slug' => 'black-opium-charm',
                'impression_of' => 'Charm',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffGourmand->id,
                'gender' => 'Women',
                'stock' => 100,
                'base_price' => 2500,
                'sale_price' => 2500,
                'compare_at_price' => 3000,
                'prices' => [30 => 1300, 50 => 2500, 100 => 3500],
                'collections' => [$colWomen->id],
                'tagline' => 'Adrenaline-Rich Black Coffee, White Florals & Sweet Vanilla',
                'description' => 'The addictive feminine scent that captivates instantly. Energizing dark roasted coffee beans softened by radiant white blossoms and warm cedar vanilla.',
                'thumbnail_image' => 'assets/Perfumes images/Black Opium 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Black Opium 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-014',
                'name' => 'Crush',
                'slug' => 'crush',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFloral->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2500,
                'sale_price' => 2500,
                'compare_at_price' => 3100,
                'prices' => [30 => 1200, 50 => 2500, 100 => 3700],
                'collections' => [$colUnisex->id],
                'tagline' => 'Pink Peppercorn, Peony Petals, Exotic Spices & Radiant Amber',
                'description' => 'An exhilarating burst of fresh pink peppercorn and blooming peony flowers resting on a clean, luminous amber base.',
                'thumbnail_image' => 'assets/Perfumes images/Crush 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Crush 2.jpeg',
                'is_featured' => false,
                'is_bestseller' => false,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-015',
                'name' => 'Republic (Stronger With You)',
                'slug' => 'republic-stronger-with-you',
                'impression_of' => 'Stronger With You',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffGourmand->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2500,
                'sale_price' => 2500,
                'compare_at_price' => 3100,
                'prices' => [30 => 1300, 50 => 2500, 100 => 4000],
                'collections' => [$colUnisex->id, $colMen->id],
                'tagline' => 'Glazed Chestnut, Sage, Cardamom & Smoky Vanilla Jungle Essence',
                'description' => 'Magnetic and confident. Infused with sweet glazed candied chestnut accord, aromatic wild sage, and creamy smoked vanilla.',
                'thumbnail_image' => 'assets/Perfumes images/Republic 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Republic 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-016',
                'name' => 'Bombshell',
                'slug' => 'bombshell',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFloral->id,
                'gender' => 'Women',
                'stock' => 100,
                'base_price' => 2100,
                'sale_price' => 2100,
                'compare_at_price' => 2700,
                'prices' => [30 => 1200, 50 => 2100, 100 => 3500],
                'collections' => [$colWomen->id],
                'tagline' => 'Purple Passion Fruit, Shangri-La Yellow Peony & Vanilla Orchid',
                'description' => 'Bright, glamorous, and sparkling. A joyful cocktail of freshly picked exotic passion fruit, Shangri-La peonies, and warm sun-drenched woods.',
                'thumbnail_image' => 'assets/Perfumes images/Bombshell 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Bombshell 2.jpeg',
                'is_featured' => false,
                'is_bestseller' => false,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-017',
                'name' => 'Xerjoff Naxos (Caribbean Exclusive)',
                'slug' => 'xerjoff-naxos-caribbean-exclusive',
                'impression_of' => 'Caribbean Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffWoody->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 4000,
                'sale_price' => 4000,
                'compare_at_price' => 5000,
                'prices' => [30 => 2000, 50 => 4000, 100 => 6000],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Raw Honey, Golden Tobacco Leaf, Sicilian Citrus & Cashmeran',
                'description' => 'A celebratory tribute to the Sicilian heritage. Sparkling bergamot and lemon blended harmoniously with rich organic honey, aromatic lavender, and dried blonde tobacco leaf.',
                'thumbnail_image' => 'assets/Perfumes images/Xerjoff Naxos 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Xerjoff Naxos 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-018',
                'name' => 'Azzaro Wanted (Mission)',
                'slug' => 'azzaro-wanted-mission',
                'impression_of' => 'Mission',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFresh->id,
                'gender' => 'Men',
                'stock' => 100,
                'base_price' => 2300,
                'sale_price' => 2300,
                'compare_at_price' => 2900,
                'prices' => [30 => 1300, 50 => 2300, 100 => 3700],
                'collections' => [$colMen->id],
                'tagline' => 'Calabrian Lemon, Spicy Ginger, Cade Wood & Haitian Vetiver',
                'description' => 'Designed for the bold and charismatic man. An intense fresh woody-spicy fragrance with fiery ginger, lemon zest, and smoky vetiver.',
                'thumbnail_image' => 'assets/Perfumes images/Azzaro Wanted 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Azzaro Wanted 2.jpeg',
                'is_featured' => false,
                'is_bestseller' => false,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-019',
                'name' => 'The White Oud',
                'slug' => 'the-white-oud',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffWoody->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2600,
                'sale_price' => 2600,
                'compare_at_price' => 3200,
                'prices' => [30 => 1500, 50 => 2600, 100 => 4200],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Velvety White Musk, Silky Agarwood & Clean Soft Amber',
                'description' => 'A pristine, ethereal take on royal oud. Blends clean crystalline white musk with a smooth, refined agarwood base and soft powdery floral accords.',
                'thumbnail_image' => 'assets/Perfumes images/The White Oud 1.jpeg',
                'hover_image' => 'assets/Perfumes images/The White Oud 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-020',
                'name' => 'Arabian Sea (Bleu de Chanel)',
                'slug' => 'arabian-sea-bleu-de-chanel',
                'impression_of' => 'Bleu de Chanel',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFresh->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2600,
                'sale_price' => 2600,
                'compare_at_price' => 3200,
                'prices' => [30 => 1400, 50 => 2600, 100 => 3800],
                'collections' => [$colUnisex->id, $colMen->id],
                'tagline' => 'Grapefruit Zest, Marine Ozone, Smoked Incense & New Caledonian Sandalwood',
                'description' => 'The quintessential blue signature. Zesty pink grapefruit and cool mint surge into deep aquatic notes and a refined cedar-incense base.',
                'thumbnail_image' => 'assets/Perfumes images/Arabian Sea 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Arabian Sea 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-021',
                'name' => 'Erba Pura (Roman Memory)',
                'slug' => 'erba-pura-roman-memory',
                'impression_of' => 'Roman Memory',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFloral->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2400,
                'sale_price' => 2400,
                'compare_at_price' => 3000,
                'prices' => [30 => 1200, 50 => 2400, 100 => 4000],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Sicilian Orange & Lemon, Mediterranean Fruit Basket & Fluffy White Musk',
                'description' => 'An intoxicating fruit basket explosion. Sweet Sicilian oranges and Calabrian bergamot drenched in liquid amber and enveloped by an enduring sensual white musk cloud.',
                'thumbnail_image' => 'assets/Perfumes images/Erba Pura 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Erba Pura 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-022',
                'name' => 'Hawas Ice (Ice Heaven)',
                'slug' => 'hawas-ice-ice-heaven',
                'impression_of' => 'Ice Heaven',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFresh->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2500,
                'sale_price' => 2500,
                'compare_at_price' => 3200,
                'prices' => [30 => 1500, 50 => 2500, 100 => 3750],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Frosted Italian Lemon, Star Anise, Mint & Oceanic Ambergris',
                'description' => 'Sub-zero aquatic power. Frosty citrus and crystalline mint energized by star anise and resting on a long-lasting oceanic ambergris foundation.',
                'thumbnail_image' => 'assets/Perfumes images/Hawas Ice 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Hawas Ice 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'sku' => 'RVH-023',
                'name' => 'Silk Musk (Exclusive)',
                'slug' => 'silk-musk-exclusive',
                'impression_of' => 'Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFloral->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2400,
                'sale_price' => 2400,
                'compare_at_price' => 3000,
                'prices' => [30 => 1200, 50 => 2400, 100 => 4400],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Royal White Musk, Lily of the Valley, Soft Powdery Violet & Amber',
                'description' => 'Pure silk draped across bare skin. Incredibly clean, soothing, and serene. Blended with powdery floral nectar and silky musk that lasts through the day.',
                'thumbnail_image' => 'assets/Perfumes images/Silk Musk 1.jpeg',
                'hover_image' => 'assets/Perfumes images/Silk Musk 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'sku' => 'RVH-024',
                'name' => '91 Sports',
                'slug' => '91-sports',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffFresh->id,
                'gender' => 'Men',
                'stock' => 100,
                'base_price' => 2700,
                'sale_price' => 2700,
                'compare_at_price' => 3300,
                'prices' => [60 => 2700],
                'collections' => [$colMen->id],
                'tagline' => 'Crisp Grapefruit, Cooling Mint, Aquatic Accord & Clean Cedarwood',
                'description' => 'Dynamic athletic performance extrait formulated to withstand intense heat and activity while maintaining an invigorating, ultra-crisp trail.',
                'thumbnail_image' => 'assets/Perfumes images/91 Sports 1.jpeg',
                'hover_image' => 'assets/Perfumes images/91 Sports 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'sku' => 'RVH-025',
                'name' => '91 Degree',
                'slug' => '91-degree',
                'impression_of' => null,
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffLeather->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 2500,
                'sale_price' => 2500,
                'compare_at_price' => 3100,
                'prices' => [30 => 1300, 50 => 2500],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => 'Fiery Spices, Nutmeg, Saddle Leather & Smoked Patchouli',
                'description' => 'A masterwork of thermodynamic contrast. Blends blazing red peppercorns with warm saddle leather and deep smoked patchouli resin.',
                'thumbnail_image' => 'assets/Perfumes images/91 Degree 1.jpeg',
                'hover_image' => 'assets/Perfumes images/91 Degree 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'sku' => 'RVH-026',
                'name' => '91 Gold Edition (All Exclusive)',
                'slug' => '91-gold-edition-all-exclusive',
                'impression_of' => 'All Exclusive',
                'category_id' => $catPerfume->id,
                'fragrance_family_id' => $ffWoody->id,
                'gender' => 'Unisex',
                'stock' => 100,
                'base_price' => 3500,
                'sale_price' => 3500,
                'compare_at_price' => 4500,
                'prices' => [30 => 1800, 50 => 3500, 100 => 5500],
                'collections' => [$colExclusive->id, $colUnisex->id],
                'tagline' => '24K Saffron, Rare Aged Agarwood, Bourbon Vanilla & Royal Ambergris',
                'description' => 'The pinnacle of private reserve luxury. Macerated with Kashmiri saffron strands, vintage agarwood, and ambergris for regal sillage.',
                'thumbnail_image' => 'assets/Perfumes images/91 Gold Edition 1.jpeg',
                'hover_image' => 'assets/Perfumes images/91 Gold Edition 2.jpeg',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => true,
            ],
        ];

        // 6. Delete any products not in this exact 26 list
        $allowedSkus = array_column($productsData, 'sku');
        $removed = Product::whereNotIn('sku', $allowedSkus)->get();
        foreach ($removed as $oldP) {
            $oldP->collections()->detach();
            $oldP->scentNotes()->detach();
            ProductVariant::where('product_id', $oldP->id)->delete();
            ProductPrice::where('product_id', $oldP->id)->delete();
            ProductImage::where('product_id', $oldP->id)->delete();
            $oldP->delete();
        }

        // 7. Upsert 26 Products
        foreach ($productsData as $data) {
            $collections = $data['collections'] ?? [];
            $prices = $data['prices'] ?? [];
            $basePrice = $data['base_price'] ?? 2500;
            $galleryImages = $data['gallery_images'] ?? [];
            unset($data['collections'], $data['prices'], $data['base_price'], $data['gallery_images']);

            $product = Product::where('sku', $data['sku'])->first();
            $payload = array_merge([
                'brand_id' => $brand->id,
                'price' => $basePrice,
                'concentration' => 'Extrait de Parfum (35% Oil Concentration)',
                'longevity' => '12-16 Hours (Long Lasting)',
                'sillage' => 'Strong / Noticeable Sillage',
                'season' => 'All Seasons',
                'time_of_day' => 'Day & Evening',
                'in_stock' => true,
                'is_active' => true,
                'rating_avg' => 4.9,
                'reviews_count' => rand(25, 65),
                'meta_title' => $data['name'] . ' | Perfumes Collection Pakistan',
                'meta_description' => $data['tagline'] . '. High concentration luxury impression crafted in Pakistan.',
                'top_notes_summary' => 'Calabrian Bergamot, Pink Pepper, Golden Amber',
                'heart_notes_summary' => 'Damascus Rose, Spiced Cinnamon, White Jasmine',
                'base_notes_summary' => 'Bourbon Vanilla, Mysore Sandalwood, Royal Musk',
            ], $data);

            if (!$product) {
                $product = Product::create($payload);
            } else {
                $product->update($payload);
            }

            if (!empty($collections)) {
                $product->collections()->sync($collections);
            }

            // Sync ProductImage
            ProductImage::where('product_id', $product->id)->delete();
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $product->thumbnail_image,
                'alt_text' => $product->name,
                'sort_order' => 1,
                'is_primary' => true,
            ]);
            $imgSort = 2;
            if ($product->hover_image && $product->hover_image !== $product->thumbnail_image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $product->hover_image,
                    'alt_text' => $product->name . ' Alternate',
                    'sort_order' => $imgSort++,
                    'is_primary' => false,
                ]);
            }
            if (!empty($galleryImages)) {
                foreach ($galleryImages as $galleryImg) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryImg,
                        'alt_text' => $product->name . ' Gallery',
                        'sort_order' => $imgSort++,
                        'is_primary' => false,
                    ]);
                }
            }

            // Sync ProductPrice
            ProductPrice::where('product_id', $product->id)->delete();
            foreach ($prices as $size => $price) {
                ProductPrice::create([
                    'product_id' => $product->id,
                    'size' => $size . 'ml',
                    'price' => $price,
                ]);
            }

            // Sync ProductVariant
            ProductVariant::where('product_id', $product->id)->delete();
            $isFirst = true;
            foreach ($prices as $size => $price) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_label' => $size . 'ml Flacon',
                    'volume_ml' => $size,
                    'price' => $price,
                    'sale_price' => $price,
                    'sku' => $product->sku . '-' . $size . 'ML',
                    'stock' => 100,
                    'is_default' => $size === 50 || ($isFirst && !isset($prices[50])),
                ]);
                $isFirst = false;
            }
        }

        // 8. Sync Scent Notes for all 26 Products
        $allScentNotes = \App\Models\ScentNote::all();
        if ($allScentNotes->isNotEmpty()) {
            foreach (Product::whereIn('sku', $allowedSkus)->get() as $p) {
                $top = strtolower($p->top_notes_summary ?? '');
                $heart = strtolower($p->heart_notes_summary ?? '');
                $base = strtolower($p->base_notes_summary ?? '');
                $full = strtolower($p->name . ' ' . $p->tagline . ' ' . $p->description . ' ' . $top . ' ' . $heart . ' ' . $base);

                $syncData = [];
                foreach ($allScentNotes as $n) {
                    $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', ' ', $n->name));
                    $words = array_filter(explode(' ', $cleanName));
                    $matched = false;
                    $layer = 'heart';

                    foreach ($words as $w) {
                        if (strlen($w) >= 4 && !in_array($w, ['noir', 'white', 'royal', 'golden', 'bark', 'leaf', 'bean', 'dew'])) {
                            if (strpos($top, $w) !== false) {
                                $matched = true;
                                $layer = 'top';
                                break;
                            } elseif (strpos($heart, $w) !== false) {
                                $matched = true;
                                $layer = 'heart';
                                break;
                            } elseif (strpos($base, $w) !== false) {
                                $matched = true;
                                $layer = 'base';
                                break;
                            } elseif (strpos($full, $w) !== false) {
                                $matched = true;
                                $layer = 'heart';
                                break;
                            }
                        }
                    }

                    if ($matched) {
                        $syncData[$n->id] = [
                            'note_layer' => $layer,
                            'prominence_percentage' => 33,
                        ];
                    }
                }

                if (!empty($syncData)) {
                    $p->scentNotes()->sync($syncData);
                }
            }
        }

        ActivityLog::record(
            'production_catalog_seeded',
            "Production catalog seeded successfully with exact 26 Excel perfumes."
        );
    }
}
