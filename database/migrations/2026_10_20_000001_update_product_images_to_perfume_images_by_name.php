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
        $mapping = [
            'RVH-025' => ['thumb' => 'assets/Perfume_Images_By_Name/91° Oud.jpeg', 'hover' => 'assets/Perfumes images/91 Degree 1.jpeg'],
            'RVH-009' => ['thumb' => 'assets/Perfume_Images_By_Name/After 9.jpeg', 'hover' => 'assets/Perfumes images/9PM After 9 1.jpeg'],
            'RVH-020' => ['thumb' => 'assets/Perfume_Images_By_Name/Arabian Sea.jpeg', 'hover' => 'assets/Perfumes images/Arabian Sea 1.jpeg'],
            'RVH-006' => ['thumb' => 'assets/Perfume_Images_By_Name/Bloom.jpeg', 'hover' => 'assets/Perfumes images/Gucci Bloom 1.jpeg'],
            'RVH-017' => ['thumb' => 'assets/Perfume_Images_By_Name/Carribean.jpeg', 'hover' => 'assets/Perfumes images/Xerjoff Naxos 1.jpeg'],
            'RVH-013' => ['thumb' => 'assets/Perfume_Images_By_Name/Charm.jpeg', 'hover' => 'assets/Perfumes images/Black Opium 1.jpeg'],
            'RVH-014' => ['thumb' => 'assets/Perfume_Images_By_Name/Crush.jpeg', 'hover' => 'assets/Perfumes images/Crush 1.jpeg'],
            'RVH-022' => ['thumb' => 'assets/Perfume_Images_By_Name/Ice Heaven.jpeg', 'hover' => 'assets/Perfumes images/Hawas Ice 1.jpeg'],
            'RVH-011' => ['thumb' => 'assets/Perfume_Images_By_Name/Leather Temptation.jpeg', 'hover' => 'assets/Perfumes images/Tuscan Leather 1.jpeg'],
            'RVH-003' => ['thumb' => 'assets/Perfume_Images_By_Name/Marjaan.jpeg', 'hover' => 'assets/Perfumes images/Marjaan 1.jpeg'],
            'RVH-001' => ['thumb' => 'assets/Perfume_Images_By_Name/Midnight Oud.jpeg', 'hover' => 'assets/Perfumes images/Lattafa Khamrah 1.jpeg'],
            'RVH-018' => ['thumb' => 'assets/Perfume_Images_By_Name/Mission.jpeg', 'hover' => 'assets/Perfumes images/Azzaro Wanted 1.jpeg'],
            'RVH-007' => ['thumb' => 'assets/Perfume_Images_By_Name/Night Out.jpeg', 'hover' => 'assets/Perfumes images/9PM Night Out 1.jpeg'],
            'RVH-004' => ['thumb' => 'assets/Perfume_Images_By_Name/Paris.jpeg', 'hover' => 'assets/Perfumes images/My Way 1.jpeg'],
            'RVH-015' => ['thumb' => 'assets/Perfume_Images_By_Name/Republic.jpeg', 'hover' => 'assets/Perfumes images/Republic 1.jpeg'],
            'RVH-021' => ['thumb' => 'assets/Perfume_Images_By_Name/Roman Memory.jpeg', 'hover' => 'assets/Perfumes images/Erba Pura 1.jpeg'],
            'RVH-012' => ['thumb' => 'assets/Perfume_Images_By_Name/Sentinal.jpeg', 'hover' => 'assets/Perfumes images/Sentinal 1.jpeg'],
            'RVH-023' => ['thumb' => 'assets/Perfume_Images_By_Name/Silk Musk.jpeg', 'hover' => 'assets/Perfumes images/Silk Musk 1.jpeg'],
            'RVH-005' => ['thumb' => 'assets/Perfume_Images_By_Name/Supremacy.jpeg', 'hover' => 'assets/Perfume_Images_By_Name/Supremacy (2).jpeg'],
            'RVH-010' => ['thumb' => 'assets/Perfume_Images_By_Name/The Leather.jpeg', 'hover' => 'assets/Perfumes images/Ombre Leather 1.jpeg'],
        ];

        foreach ($mapping as $sku => $data) {
            $product = DB::table('products')->where('sku', $sku)->first();
            if (!$product) continue;

            $oldThumb = $product->thumbnail_image;
            $oldHover = $product->hover_image;

            DB::table('products')->where('id', $product->id)->update([
                'thumbnail_image' => $data['thumb'],
                'hover_image' => $data['hover'],
            ]);

            // Existing images list
            $existing = DB::table('product_images')->where('product_id', $product->id)->pluck('image_path')->toArray();

            $galleryList = [$data['thumb']];
            if ($data['hover'] && !in_array($data['hover'], $galleryList)) {
                $galleryList[] = $data['hover'];
            }
            if ($oldThumb && !in_array($oldThumb, $galleryList)) {
                $galleryList[] = $oldThumb;
            }
            if ($oldHover && !in_array($oldHover, $galleryList)) {
                $galleryList[] = $oldHover;
            }
            foreach ($existing as $img) {
                if (!in_array($img, $galleryList)) {
                    $galleryList[] = $img;
                }
            }

            // Sync product_images table
            DB::table('product_images')->where('product_id', $product->id)->delete();
            $now = now();
            foreach ($galleryList as $index => $imgPath) {
                $isPrimary = ($index === 0);
                $sort = $index + 1;
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_path' => $imgPath,
                    'alt_text' => $product->name . ($isPrimary ? ' - Primary Flacon' : ' - Gallery ' . $sort),
                    'sort_order' => $sort,
                    'is_primary' => $isPrimary,
                    'created_at' => $now,
                    'updated_at' => $now,
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
