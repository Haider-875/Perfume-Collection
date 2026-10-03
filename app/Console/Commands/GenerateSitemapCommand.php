<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate luxury XML sitemap for search engines';

    public function handle()
    {
        $this->info('Generating SEO Sitemap for Perfumes Collection...');

        $baseUrl = config('app.url', 'https://perfumecollectionpk.com');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Static Pages
        $staticPages = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => '/collections', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => '/vault', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => '/blogs', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => '/about', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/faq', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/collaborations', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/shipping-policy', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => '/refund-policy', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => '/terms-of-service', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => '/privacy-policy', 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}{$page['loc']}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // Fragrances (Products)
        $products = Product::where('is_active', true)->get();
        foreach ($products as $product) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/perfume/{$product->slug}</loc>\n";
            $xml .= "    <lastmod>" . $product->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        // Collections
        $categories = Category::where('is_active', true)->get();
        foreach ($categories as $category) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/collections/{$category->slug}</loc>\n";
            $xml .= "    <lastmod>" . $category->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        // Blogs
        $blogs = Blog::where('is_published', true)->get();
        foreach ($blogs as $blog) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/blogs/{$blog->slug}</loc>\n";
            $xml .= "    <lastmod>" . $blog->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);
        $this->info('Sitemap successfully written to public/sitemap.xml');

        return Command::SUCCESS;
    }
}
