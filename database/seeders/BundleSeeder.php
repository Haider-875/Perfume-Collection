<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;

class BundleSeeder extends Seeder
{
    /**
     * Seed curated bundles linked to the actual 26 perfumes in the store.
     */
    public function run()
    {
        // 1. Clean existing bundles and bundle items safely (foreign key safe across MySQL & SQLite)
        try {
            BundleItem::query()->delete();
            Bundle::query()->delete();
        } catch (\Throwable $e) {
            // fallback
        }

        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        try {
            BundleItem::truncate();
            Bundle::truncate();
        } catch (\Throwable $e) {
            BundleItem::query()->delete();
            Bundle::query()->delete();
        }

        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // 2. Fetch all perfumes keyed by SKU and slug for reliable mapping
        $productsBySku = Product::all()->keyBy(fn($p) => strtoupper(trim($p->sku ?? '')));
        $productsBySlug = Product::all()->keyBy(fn($p) => strtolower(trim($p->slug ?? '')));

        $skuToSlugMap = [
            'RVH-001' => 'lattafa-khamrah-sweet-spice',
            'RVH-002' => 'ysl-libre-french-freedom',
            'RVH-003' => 'bdk-gris-charnel-spiced-fig',
            'RVH-004' => 'my-way-my-path',
            'RVH-005' => 'afnan-supremacy-silver-aventus',
            'RVH-006' => 'gucci-bloom-floral-garden',
            'RVH-007' => '9pm-night-out',
            'RVH-008' => 'arabian-sea-bleu-de-chanel',
            'RVH-009' => 'azzaro-most-wanted-wanted-night',
            'RVH-010' => 'ombre-leather-the-leather',
            'RVH-011' => 'tuscan-leather-leather-temptation',
            'RVH-012' => 'baccarat-rouge-540-crystal-amber',
            'RVH-013' => 'black-opium-charm',
            'RVH-014' => 'lost-cherry-cherry-temptation',
            'RVH-015' => 'stronger-with-you-intensely-sweet-leather',
            'RVH-016' => 'bombshell-sensual-bloom',
            'RVH-017' => 'xerjoff-naxos-royal-honey',
            'RVH-018' => 'creed-silver-mountain-water-silver-stream',
            'RVH-019' => 'white-oud-white-agarwood',
            'RVH-020' => 'aqua-di-gio-marine-breeze',
            'RVH-021' => 'erba-pura-roman-memory',
            'RVH-022' => 'hawas-ice-ice-heaven',
            'RVH-023' => 'velvet-musk-royal-santal',
            'RVH-024' => 'sauvage-elixir-desert-phantom',
            'RVH-025' => 'sovereign-smoke-oud-wood',
            'RVH-026' => '91-gold-edition-all-exclusive',
        ];

        $bundlesData = [
            [
                'name' => 'The Imperial Leather & Tobacco Duo',
                'slug' => 'imperial-leather-tobacco-duo',
                'sku' => 'BNDL-LEATHER-DUO',
                'tagline' => 'Tuscan Leather & Ombre Leather Extrait (2x 50ml Flacons)',
                'description' => 'The definitive rich leather power duo. Raw Tuscan leather and dark velvety suede macerated at full extrait concentration.',
                'skus' => ['RVH-010', 'RVH-011'],
                'bundle_price' => 3999.00,
                'image' => 'assets/Perfumes images/Ombre Leather 1.jpeg',
                'badge_text' => 'EXTRAIT DUO',
            ],
            [
                'name' => 'The Parisian Floral & Sweet Fantasy Duo',
                'slug' => 'parisian-floral-sweet-fantasy-duo',
                'sku' => 'BNDL-PARIS-SWEET',
                'tagline' => 'Parisian White Florals paired with Warm Caramel Vanilla (2x 50ml)',
                'description' => 'An intoxicating feminine pairing of luminous orange blossom and tuberose paired with warm buttery caramel and bourbon vanilla.',
                'skus' => ['RVH-004', 'RVH-002'],
                'bundle_price' => 4499.00,
                'image' => 'assets/Perfumes images/My Way 1.jpeg',
                'badge_text' => 'FEMME DUO',
            ],
            [
                'name' => 'The Nightlife Seduction Duo (9PM Double Feature)',
                'slug' => 'nightlife-seduction-9pm-duo',
                'sku' => 'BNDL-9PM-DUO',
                'tagline' => 'Crisp Apple Amber & Spicy Vanilla for Evening Events (2x 50ml)',
                'description' => 'The ultimate evening clubbing and occasion combo. Magnetic projection with sweet spicy vanilla, amber, and cinnamon sillage.',
                'skus' => ['RVH-007', 'RVH-009'],
                'bundle_price' => 3799.00,
                'image' => 'assets/Perfumes images/9PM Night Out 1.jpeg',
                'badge_text' => 'PARTY DUO',
            ],
            [
                'name' => 'The Sovereign Niche & Oud Coffret',
                'slug' => 'sovereign-niche-oud-coffret',
                'sku' => 'BNDL-NICHE-OUD',
                'tagline' => 'Honeyed Tobacco, Spiced Dates & Royal White Agarwood Trio (3x 50ml)',
                'description' => 'Our highest echelon of luxury. Italian honey-tobacco Naxos paired with rich spiced dates Lattafa Khumrah and silky White Oud.',
                'skus' => ['RVH-017', 'RVH-001', 'RVH-019'],
                'bundle_price' => 6999.00,
                'image' => 'assets/Perfumes images/Xerjoff Naxos 1.jpeg',
                'badge_text' => 'NICHE TRIO',
            ],
            [
                'name' => 'The Fresh Aquatic & Sillage Power Duo',
                'slug' => 'fresh-aquatic-sillage-power-duo',
                'sku' => 'BNDL-AQUATIC-DUO',
                'tagline' => 'Crisp Marine Bergamot & Frozen Mint for Intense Summer Projection (2x 50ml)',
                'description' => 'Beast-mode fresh aquatic versatility. Crisp oceanic mint, Italian bergamot, cedarwood, and magnetic ambroxan.',
                'skus' => ['RVH-022', 'RVH-020'],
                'bundle_price' => 3999.00,
                'image' => 'assets/Perfumes images/Hawas Ice 1.jpeg',
                'badge_text' => 'FRESH DUO',
            ],
            [
                'name' => 'The Sensual Gourmand & Alluring Florals Duo',
                'slug' => 'sensual-gourmand-alluring-florals-duo',
                'sku' => 'BNDL-SENSUAL-FLORAL',
                'tagline' => 'Dark Vanilla Coffee & Sparkling Passionfruit Florals (2x 50ml)',
                'description' => 'Two iconic feminine signatures. Black Opium\'s addictive black coffee and vanilla contrasted with Bombshell\'s radiant purple passion fruit.',
                'skus' => ['RVH-013', 'RVH-016'],
                'bundle_price' => 3599.00,
                'image' => 'assets/Perfumes images/Black Opium 1.jpeg',
                'badge_text' => 'FEMME DUO',
            ],
            [
                'name' => 'The 91 Signature Masterpiece Coffret',
                'slug' => '91-signature-masterpiece-coffret',
                'sku' => 'BNDL-91-MASTERPIECE',
                'tagline' => 'The Private Atelier Reserve Trio (3x 50ml Extraits)',
                'description' => 'Exclusive master formulations crafted in limited seasonal batches. Pure luxury amber, spicy woods, and noble musk.',
                'skus' => ['RVH-026', 'RVH-012', 'RVH-025'],
                'bundle_price' => 7499.00,
                'image' => 'assets/Perfumes images/91 Gold Edition 1.jpeg',
                'badge_text' => 'ATELIER TRIO',
            ],
            [
                'name' => 'The Alpha Connoisseur Masculine Duo',
                'slug' => 'alpha-connoisseur-masculine-duo',
                'sku' => 'BNDL-ALPHA-DUO',
                'tagline' => 'Smoky Pineapple Birch & Cardamom Glazed Chestnut (2x 50ml)',
                'description' => 'Supreme masculine compliments. Crisp smoky aventus-style birch paired with warm gourmand chestnut and spicy pink pepper.',
                'skus' => ['RVH-005', 'RVH-015'],
                'bundle_price' => 4299.00,
                'image' => 'assets/Perfumes images/Afnan Supremacy 1.jpeg',
                'badge_text' => 'POWER DUO',
            ],
            [
                'name' => 'The Velvet Musk & Mediterranean Fruits Trio',
                'slug' => 'velvet-musk-mediterranean-fruits-trio',
                'sku' => 'BNDL-VELVET-FRUITS',
                'tagline' => 'Sicilian Citrus, Mediterranean Fruits & Royal White Musk (3x 50ml Extraits)',
                'description' => 'Sun-drenched citrus and sweet Mediterranean fruits anchored by clean velvety musk and soft amber.',
                'skus' => ['RVH-021', 'RVH-003', 'RVH-023'],
                'bundle_price' => 5999.00,
                'image' => 'assets/Perfumes images/Erba Pura 1.jpeg',
                'badge_text' => 'UNISEX TRIO',
            ],
            [
                'name' => 'The Bloom & Romance Duo',
                'slug' => 'bloom-romance-duo',
                'sku' => 'BNDL-BLOOM-ROMANCE',
                'tagline' => 'Rangoon Creeper Jasmine & Lush Berry Romance (2x 50ml)',
                'description' => 'A romantic blend of opulent white blossoms and flirty red berries for everyday elegance.',
                'skus' => ['RVH-006', 'RVH-014'],
                'bundle_price' => 3499.00,
                'image' => 'assets/Perfumes images/Gucci Bloom 1.jpeg',
                'badge_text' => 'ROMANCE DUO',
            ],
        ];

        foreach ($bundlesData as $data) {
            $totalOrigPrice = 0;
            $matchedProducts = [];

            foreach ($data['skus'] as $sku) {
                $cleanSku = strtoupper(trim($sku));
                $prod = $productsBySku[$cleanSku] ?? null;

                if (!$prod && isset($skuToSlugMap[$cleanSku])) {
                    $expectedSlug = $skuToSlugMap[$cleanSku];
                    $prod = $productsBySlug[$expectedSlug] ?? null;
                }

                if ($prod) {
                    $matchedProducts[] = $prod;
                    $totalOrigPrice += (float) ($prod->price ?: 2500);
                }
            }

            if (empty($matchedProducts)) {
                continue;
            }

            $bundlePrice = min($data['bundle_price'], $totalOrigPrice - 500);
            $savings = max(0, $totalOrigPrice - $bundlePrice);

            $bundle = Bundle::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'sku' => $data['sku'],
                'tagline' => $data['tagline'],
                'description' => $data['description'],
                'original_price' => $totalOrigPrice,
                'bundle_price' => $bundlePrice,
                'savings_amount' => $savings,
                'image' => $data['image'],
                'badge_text' => $data['badge_text'],
                'is_active' => true,
            ]);

            foreach ($matchedProducts as $prod) {
                BundleItem::create([
                    'bundle_id' => $bundle->id,
                    'product_id' => $prod->id,
                    'quantity' => 1,
                    'custom_size_label' => ($prod->volume_ml ?? 50) . 'ml Flacon',
                ]);
            }
        }
    }
}
