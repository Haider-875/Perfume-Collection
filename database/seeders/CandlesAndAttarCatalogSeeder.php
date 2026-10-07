<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;

class CandlesAndAttarCatalogSeeder extends Seeder
{
    public function run()
    {
        // 1. Attar Category
        $attarCat = Category::where('slug', 'attar')->orWhere('slug', 'pure-attar-oils')->first();
        if (!$attarCat) {
            $attarCat = Category::create([
                'name' => 'Attar Collection',
                'slug' => 'attar',
                'description' => 'Pure concentrated luxury attars and artisanal perfume oils crafted alcohol-free for monumental sillage.',
                'image' => 'assets/images/categories/collection_attar.jpg',
                'badge_text' => 'Alcohol-Free',
                'sort_order' => 3,
                'is_active' => true,
            ]);
        } else {
            $attarCat->update([
                'name' => 'Attar Collection',
                'slug' => 'attar',
                'description' => 'Pure concentrated luxury attars and artisanal perfume oils crafted alcohol-free for monumental sillage.',
                'image' => 'assets/images/categories/collection_attar.jpg',
                'badge_text' => 'Alcohol-Free',
                'sort_order' => 3,
                'is_active' => true,
            ]);
        }

        // 2. Candles Category
        $candleCat = Category::where('slug', 'candles')->first();
        if (!$candleCat) {
            $candleCat = Category::create([
                'name' => 'Candles',
                'slug' => 'candles',
                'description' => 'Artisanal hand-poured luxury soy wax scented candles infused with rich extrait de parfum oils.',
                'image' => 'assets/images/categories/collection_candles.jpg',
                'badge_text' => 'Soy Wax',
                'sort_order' => 6,
                'is_active' => true,
            ]);
        } else {
            $candleCat->update([
                'name' => 'Candles',
                'slug' => 'candles',
                'description' => 'Artisanal hand-poured luxury soy wax scented candles infused with rich extrait de parfum oils.',
                'image' => 'assets/images/categories/collection_candles.jpg',
                'badge_text' => 'Soy Wax',
                'sort_order' => 6,
                'is_active' => true,
            ]);
        }

        // 3. Attar Collection in collections table
        $attarCol = Collection::firstOrCreate(
            ['slug' => 'attar'],
            [
                'name' => 'Attar Collection',
                'description' => 'Pure concentrated luxury attars and artisanal perfume oils crafted alcohol-free for monumental sillage.',
                'image' => 'assets/images/categories/collection_attar.jpg',
                'badge_text' => 'Alcohol-Free',
                'sort_order' => 7,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 4. Candles Collection in collections table
        $candleCol = Collection::firstOrCreate(
            ['slug' => 'candles'],
            [
                'name' => 'Candles Collection',
                'description' => 'Artisanal hand-poured luxury soy wax scented candles infused with rich extrait de parfum oils.',
                'image' => 'assets/images/categories/collection_candles.jpg',
                'badge_text' => 'Soy Wax',
                'sort_order' => 8,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 5. Link Product 2 (Dehn al Oud Cambodi) to Attar category and collection
        $prod2 = Product::find(2);
        if ($prod2) {
            $prod2->category_id = $attarCat->id;
            $prod2->save();
            if (!$prod2->collections()->where('collections.id', $attarCol->id)->exists()) {
                $prod2->collections()->attach($attarCol->id);
            }
        }

        // 6. Candle Product 1: Imperial Oud & Amber Luxury Candle
        $candle1 = Product::where('slug', 'imperial-oud-amber-luxury-candle')->first();
        if (!$candle1) {
            $candle1 = Product::create([
                'name' => 'Imperial Oud & Amber Luxury Candle',
                'impression_of' => 'Artisanal Smoked Amber & Royal Agarwood',
                'slug' => 'imperial-oud-amber-luxury-candle',
                'sku' => 'PC-CNDL-OUD',
                'category_id' => $candleCat->id,
                'price' => 4500,
                'sale_price' => 3800,
                'compare_at_price' => 5200,
                'stock' => 40,
                'in_stock' => true,
                'volume_ml' => 250,
                'gender' => 'Unisex',
                'concentration' => 'Artisanal Scented Candle (Soy Wax)',
                'longevity' => '60+ Hours Burn Time',
                'sillage' => 'Atmospheric Room Fill',
                'season' => 'All Seasons / Sanctuary',
                'top_notes_summary' => 'Smoked Amber, Calabrian Bergamot, Golden Saffron',
                'heart_notes_summary' => 'Taif Rose Petals, Cashmere Wood, Spiced Clove',
                'base_notes_summary' => 'Cambodian Agarwood, Bourbon Vanilla, Smoked Cedar',
                'tagline' => 'Slow-burning natural soy wax candle infused with bespoke royal oud and warm amber',
                'description' => 'Hand-poured using 100% natural soy wax, lead-free cotton wicks, and pure extrait de parfum oils. Provides a velvety, enveloping scent throw that fills your home with an aura of regal tranquility for over 60 hours.',
                'thumbnail_image' => 'assets/images/categories/collection_candles.jpg',
                'hover_image' => 'assets/images/categories/collection_candles.jpg',
                'meta_title' => 'Imperial Oud & Amber Luxury Candle | Perfumes Collection Pakistan',
                'meta_description' => 'Hand-poured luxury scented soy wax candle infused with Cambodian Oud and warm Amber. 60+ hours burn time.',
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => true,
                'rating_avg' => 4.9,
                'reviews_count' => 18,
            ]);
            $candle1->collections()->attach($candleCol->id);
        } else {
            $candle1->category_id = $candleCat->id;
            $candle1->save();
            if (!$candle1->collections()->where('collections.id', $candleCol->id)->exists()) {
                $candle1->collections()->attach($candleCol->id);
            }
        }

        // 7. Candle Product 2: Velvet Rose & Smoked Vanilla Luxury Candle
        $candle2 = Product::where('slug', 'velvet-rose-smoked-vanilla-candle')->first();
        if (!$candle2) {
            $candle2 = Product::create([
                'name' => 'Velvet Rose & Smoked Vanilla Candle',
                'impression_of' => 'Damascena Rose & Madagascar Bourbon Vanille',
                'slug' => 'velvet-rose-smoked-vanilla-candle',
                'sku' => 'PC-CNDL-ROSE',
                'category_id' => $candleCat->id,
                'price' => 4200,
                'sale_price' => 3500,
                'compare_at_price' => 4800,
                'stock' => 35,
                'in_stock' => true,
                'volume_ml' => 250,
                'gender' => 'Unisex',
                'concentration' => 'Artisanal Scented Candle (Soy Wax)',
                'longevity' => '60+ Hours Burn Time',
                'sillage' => 'Atmospheric Room Fill',
                'season' => 'Evening / Romantic',
                'top_notes_summary' => 'Pink Pepper, Velvet Damascena Rose',
                'heart_notes_summary' => 'Smoked Guaiacwood, Turkish Rose Absolute',
                'base_notes_summary' => 'Madagascar Vanilla Bean, White Musks, Amber',
                'tagline' => 'Hand-poured luxury candle with rich crimson roses and comforting smoked bourbon vanilla',
                'description' => 'An opulent harmony of blooming Damascena roses softened with velvety bourbon vanilla and warm amber. Poured in black frosted glass for an alluring romantic ambiance.',
                'thumbnail_image' => 'assets/images/categories/collection_candles.jpg',
                'hover_image' => 'assets/images/categories/collection_candles.jpg',
                'meta_title' => 'Velvet Rose & Smoked Vanilla Luxury Candle | Perfumes Collection Pakistan',
                'meta_description' => 'Handcrafted soy wax candle blending rich Turkish rose with warm bourbon vanilla.',
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
                'rating_avg' => 4.8,
                'reviews_count' => 12,
            ]);
            $candle2->collections()->attach($candleCol->id);
        } else {
            $candle2->category_id = $candleCat->id;
            $candle2->save();
            if (!$candle2->collections()->where('collections.id', $candleCol->id)->exists()) {
                $candle2->collections()->attach($candleCol->id);
            }
        }
    }
}
