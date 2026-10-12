<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $blogImages = [
            'why-commercial-perfumes-disappear-in-pakistan' => 'assets/images/blogs/blog_extrait_science.jpg',
            'sovereign-history-royal-mughal-attar-lahore' => 'assets/images/blogs/blog_mughal_attar.jpg',
            'bridal-groom-scent-wardrobe-guide' => 'assets/images/blogs/blog_wedding_wardrobe.jpg',
        ];

        foreach ($blogImages as $slug => $image) {
            DB::table('blogs')->where('slug', $slug)->update(['image' => $image]);
        }

        // Also update any blogs that still have .svg or null images
        $allBlogs = DB::table('blogs')->orderBy('id')->get();
        $defaults = [
            'assets/images/blogs/blog_extrait_science.jpg',
            'assets/images/blogs/blog_mughal_attar.jpg',
            'assets/images/blogs/blog_wedding_wardrobe.jpg',
        ];
        foreach ($allBlogs as $index => $blog) {
            if (empty($blog->image) || str_ends_with(strtolower($blog->image), '.svg')) {
                DB::table('blogs')->where('id', $blog->id)->update([
                    'image' => $defaults[$index % 3] ?? 'assets/images/blogs/blog_extrait_science.jpg'
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
