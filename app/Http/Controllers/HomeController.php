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

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        // Self-heal / sync video slides if database has legacy static image slides, is empty, or needs new banner order
        $needsSync = $heroSlides->isEmpty() || 
            ($heroSlides->isNotEmpty() && (
                !\Illuminate\Support\Str::endsWith(strtolower($heroSlides->first()->image ?? ''), ['.mp4', '.webm']) ||
                !str_contains(strtolower($heroSlides->first()->image ?? ''), '91_gold_banner')
            ));

        if ($needsSync) {
            $videoMap = [
                1 => 'assets/videos/91_gold_banner.mp4',
                2 => 'assets/videos/marjaan_perfume_banner.mp4',
                3 => 'assets/videos/91_perfume_banner.mp4',
            ];
            if ($heroSlides->isEmpty()) {
                HeroSlide::create([
                    'title' => "BLEU IMPERIAL",
                    'subtitle' => "A magnetic fusion of sun-drenched Italian bergamot, fresh sea salt, and rich cedarwood. Formulated with Grasse French oils for an all-day commanding masculine trail.",
                    'badge_text' => "TOP SELLER 2026",
                    'image' => $videoMap[1],
                    'cta_text' => "EXPLORE COUTURE",
                    'cta_url' => "/collections/men",
                    'secondary_cta_text' => "WHATSAPP ADVISOR",
                    'secondary_cta_url' => "https://wa.me/923363685732",
                    'sort_order' => 1,
                    'is_active' => true,
                ]);
                HeroSlide::create([
                    'title' => "ROYAL OUD & AMBER",
                    'subtitle' => "An aristocratic private reserve macerated for 90 days with rare Kashmiri saffron and golden ambergris. Experience timeless luxury crafted specifically for evening galas.",
                    'badge_text' => "PRIVATE RESERVE COLLECTION",
                    'image' => $videoMap[2],
                    'cta_text' => "EXPLORE SETS",
                    'cta_url' => "/collections/bundles",
                    'secondary_cta_text' => "VIEW DISCOVERY SET",
                    'secondary_cta_url' => "/perfume/the-imperial-discovery-coffret-set-of-5",
                    'sort_order' => 2,
                    'is_active' => true,
                ]);
                HeroSlide::create([
                    'title' => "REVIVAL 50",
                    'subtitle' => "Hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration for 14+ hours longevity across Pakistan.",
                    'badge_text' => "HAUTE PARFUMERIE • EXTRAIT DE PARFUM",
                    'image' => $videoMap[3],
                    'cta_text' => "DISCOVER COLLECTION",
                    'cta_url' => "/collections/all",
                    'secondary_cta_text' => "EXPLORE VAULT",
                    'secondary_cta_url' => "/collections/all",
                    'sort_order' => 3,
                    'is_active' => true,
                ]);
                $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();
            } else {
                foreach ($heroSlides as $slide) {
                    $img = strtolower($slide->image ?? '');
                    if (str_contains($img, '91_gold_banner') || $slide->title === 'BLEU IMPERIAL') {
                        $slide->sort_order = 1;
                        $slide->image = $videoMap[1];
                        $slide->save();
                    } elseif (str_contains($img, 'marjaan_perfume_banner') || $slide->title === 'ROYAL OUD & AMBER') {
                        $slide->sort_order = 2;
                        $slide->image = $videoMap[2];
                        $slide->save();
                    } elseif (str_contains($img, '91_perfume_banner') || $slide->title === 'REVIVAL 50') {
                        $slide->sort_order = 3;
                        $slide->image = $videoMap[3];
                        $slide->save();
                    }
                }
                $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();
            }
        }
        
        $featuredCategories = Category::where('is_active', true)->orderBy('sort_order', 'asc')->take(4)->get();
        $collections = Collection::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        // Self-heal / sync catalog if database has legacy .svg placeholders or missing items
        try {
            if (Product::where('thumbnail_image', 'like', '%.svg')->exists() || Product::where('sku', 'like', 'RVH-%')->count() < 26) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', [
                    '--class' => 'Database\\Seeders\\ProductionCatalogSeeder',
                    '--force' => true,
                ]);
            }
        } catch (\Throwable $e) {
            // Non-blocking fallback
        }

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

        return view('pages.home', compact(
            'heroSlides',
            'featuredCategories',
            'collections',
            'featuredProducts',
            'bestsellers',
            'newArrivals',
            'restockedProducts',
            'bundles',
            'collaborationProduct',
            'recentReviews',
            'recentBlogs'
        ));
    }
}
