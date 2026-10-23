<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Category;
use App\Models\Bundle;
use App\Models\Blog;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $data = Cache::remember('homepage_curated_data_v3', 1800, function () {
            $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();

            // If no hero slides exist at all, populate initial default banners
            if ($heroSlides->isEmpty()) {
                $heroSlides = self::syncHeroBanners();
            }

            $featuredCategories = Category::where('is_active', true)->orderBy('sort_order', 'asc')->take(4)->get();
            $collections = Collection::where('is_active', true)->orderBy('sort_order', 'asc')->get();

            // Featured Collection: All newly added products / latest impressions
            $featuredProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->where('is_featured', true)
                ->orderBy('id', 'desc')
                ->get();

            if ($featuredProducts->isEmpty()) {
                $featuredProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                    ->active()
                    ->orderBy('id', 'desc')
                    ->get();
            }

            $bestsellers = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->bestsellers()
                ->take(8)
                ->get();

            if ($bestsellers->isEmpty()) {
                $bestsellers = $featuredProducts->take(8);
            }

            // New Release Impressions (swapped): Classic formulations from previous featured collection
            $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->newArrivals()
                ->orderBy('id', 'asc')
                ->get();

            if ($newArrivals->isEmpty()) {
                $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                    ->active()
                    ->orderBy('id', 'asc')
                    ->take(8)
                    ->get();
            }

            $restockedProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->latest()
                ->take(8)
                ->get();

            $bundles = Bundle::where('is_active', true)->with('items.product')->take(3)->get();

            // Exclusive Video Showcase Compositions (91 Gold Edition, Marjaan, 91 Sports)
            $exclusiveVideoConfigs = [
                [
                    'slug' => '91-gold-edition-all-exclusive',
                    'video' => 'assets/videos/91_gold_banner.mp4',
                    'badge' => 'TOP SELLER • 2026 RESERVE',
                    'default_name' => '91° Gold Edition',
                    'default_tagline' => '24K Saffron, Rare Aged Agarwood, Bourbon Vanilla & Royal Ambergris',
                    'default_desc' => 'The pinnacle of private reserve luxury. Macerated for 90 days with genuine Kashmiri saffron strands, vintage agarwood, and royal ambergris for a commanding all-day sillage.',
                    'default_price' => 3500,
                    'default_original_price' => 4500,
                    'default_rating' => 4.9,
                    'default_reviews' => 48,
                    'volume' => '50ml Extrait de Parfum',
                    'longevity' => '8-10 Hours Longevity',
                ],
                [
                    'slug' => 'marjaan',
                    'video' => 'assets/videos/marjaan_perfume_banner.mp4',
                    'badge' => 'ARABIAN SEA JEWEL • LIMITED EDITION',
                    'default_name' => 'Marjaan',
                    'default_tagline' => 'Red Coral Amber, Aged Sandalwood & Sweet Velvet Spices',
                    'default_desc' => 'Inspired by the precious gemstones of the Arabian Sea. Marjaan unfolds with radiant spices, aged Mysore sandalwood, and a warm, glowing amber base crafted for grand evenings.',
                    'default_price' => 2800,
                    'default_original_price' => 3400,
                    'default_rating' => 5.0,
                    'default_reviews' => 62,
                    'volume' => '50ml Extrait de Parfum',
                    'longevity' => '8-10 Hours Longevity',
                ],
                [
                    'slug' => '91-sports',
                    'video' => 'assets/videos/91_perfume_banner.mp4',
                    'badge' => 'HAUTE PERFORMANCE • FRESH EXTRAIT',
                    'default_name' => '91 Sports',
                    'default_tagline' => 'Crisp Grapefruit, Cooling Mint, Aquatic Accord & Clean Cedarwood',
                    'default_desc' => 'An exhilarating athletic performance extrait formulated to withstand intense heat and humidity with an ultra-crisp, magnetic citrus-marine trail that never fades.',
                    'default_price' => 2700,
                    'default_original_price' => 3300,
                    'default_rating' => 4.9,
                    'default_reviews' => 46,
                    'volume' => '60ml Extrait de Parfum',
                    'longevity' => '8-10 Hours Longevity',
                ],
            ];

            $exclusiveFragrances = collect($exclusiveVideoConfigs)->map(function ($cfg) {
                $product = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                    ->where('slug', $cfg['slug'])
                    ->first();

                if (!$product) {
                    $searchName = explode(' ', $cfg['default_name'])[0];
                    $product = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                        ->where('name', 'LIKE', '%' . $searchName . '%')
                        ->first();
                }

                $price = $product ? $product->effective_price : $cfg['default_price'];
                $originalPrice = $product ? ($product->compare_at_price ?: ($product->price > $price ? $product->price : $cfg['default_original_price'])) : $cfg['default_original_price'];
                $savings = max(0, $originalPrice - $price);
                $discountPercent = $originalPrice > 0 ? round(($savings / $originalPrice) * 100) : 0;

                $rawLongevity = $product && !empty($product->longevity) ? $product->longevity : $cfg['longevity'];
                $cleanLongevity = trim(preg_replace('/\s*\(Long Lasting\)/i', '', $rawLongevity));
                if (!str_contains(strtolower($cleanLongevity), 'longevity')) {
                    $cleanLongevity .= ' Longevity';
                }

                return (object)[
                    'id' => $product ? $product->id : null,
                    'product' => $product,
                    'slug' => $product ? $product->slug : $cfg['slug'],
                    'name' => $product ? $product->name : $cfg['default_name'],
                    'tagline' => $product && !empty($product->tagline) ? $product->tagline : $cfg['default_tagline'],
                    'description' => $product && !empty($product->description) ? $product->description : $cfg['default_desc'],
                    'price' => $price,
                    'original_price' => $originalPrice,
                    'savings' => $savings,
                    'discount_percent' => $discountPercent,
                    'rating' => $product && $product->rating_avg ? $product->rating_avg : $cfg['default_rating'],
                    'reviews_count' => $product && $product->reviews_count ? $product->reviews_count : $cfg['default_reviews'],
                    'video' => $cfg['video'],
                    'badge' => $cfg['badge'],
                    'volume' => $product && $product->volume_ml ? ($product->volume_ml . 'ml Extrait de Parfum') : $cfg['volume'],
                    'longevity' => $cleanLongevity,
                    'image' => $product ? $product->primary_image_url : null,
                ];
            });

            $collaborationProduct = Product::where('is_collaboration', true)->first();

            $recentReviews = Review::with('product')
                ->where('is_approved', true)
                ->latest()
                ->take(20)
                ->get();

            $recentBlogs = Blog::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();

            return compact(
                'heroSlides',
                'featuredCategories',
                'collections',
                'featuredProducts',
                'bestsellers',
                'newArrivals',
                'restockedProducts',
                'bundles',
                'exclusiveFragrances',
                'collaborationProduct',
                'recentReviews',
                'recentBlogs'
            );
        });

        return view('pages.home', $data);
    }

    /**
     * Cleanly sync and guarantee exact 3 video banners in sequence
     */
    public static function syncHeroBanners()
    {
        $slidesData = [
            1 => [
                'title' => "91° GOLD EDITION",
                'subtitle' => "A magnetic fusion of sun-drenched Italian bergamot, fresh sea salt, and rich cedarwood. Formulated with Grasse French oils for an all-day commanding masculine trail.",
                'badge_text' => "TOP SELLER 2026",
                'image' => 'assets/videos/91_gold_banner.mp4',
                'cta_text' => "EXPLORE COUTURE",
                'cta_url' => "/collections/men",
                'secondary_cta_text' => "WHATSAPP ADVISOR",
                'secondary_cta_url' => "https://wa.me/923363685732",
                'sort_order' => 1,
                'is_active' => true,
            ],
            2 => [
                'title' => "MARJAAN",
                'subtitle' => "An aristocratic private reserve macerated for 90 days with rare Kashmiri saffron and golden ambergris. Experience timeless luxury crafted specifically for evening galas.",
                'badge_text' => "PRIVATE RESERVE COLLECTION",
                'image' => 'assets/videos/marjaan_perfume_banner.mp4',
                'cta_text' => "EXPLORE SETS",
                'cta_url' => "/collections/bundles",
                'secondary_cta_text' => "VIEW DISCOVERY SET",
                'secondary_cta_url' => "/perfume/the-imperial-discovery-coffret-set-of-5",
                'sort_order' => 2,
                'is_active' => true,
            ],
            3 => [
                'title' => "REVIVAL 50",
                'subtitle' => "Hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration for 8-10 hours longevity across Pakistan.",
                'badge_text' => "HAUTE PARFUMERIE • EXTRAIT DE PARFUM",
                'image' => 'assets/videos/91_perfume_banner.mp4',
                'cta_text' => "DISCOVER COLLECTION",
                'cta_url' => "/collections/all",
                'secondary_cta_text' => "EXPLORE VAULT",
                'secondary_cta_url' => "/collections/all",
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        if (HeroSlide::count() === 0) {
            foreach ($slidesData as $data) {
                HeroSlide::create($data);
            }
        }

        return HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    }
}
