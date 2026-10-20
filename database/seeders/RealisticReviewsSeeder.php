<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Database\Seeder;

class RealisticReviewsSeeder extends Seeder
{
    public function run()
    {
        try {
            Review::query()->delete();
        } catch (\Throwable $e) {
            Review::truncate();
        }

        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $allReviews = [
            // Karachi Connoisseurs (Majority)
            ['name' => 'Bilal Farooqui', 'city' => 'Karachi, Clifton', 'comment' => 'Incredible longevity in Karachi humidity. Projects effortlessly for 14+ hours without turning cloying.'],
            ['name' => 'Hina Rizvi', 'city' => 'Karachi, DHA Phase 6', 'comment' => 'Exquisite unboxing and heavy magnetic cap. Smells distinctly luxurious with zero synthetic alcohol blast.'],
            ['name' => 'Syed Tariq Mehmood', 'city' => 'Karachi, PECHS', 'comment' => 'True extrait de parfum concentration with visible oil sheen. Easily rivals 300 USD niche bottles.'],
            ['name' => 'Zainab Murtaza', 'city' => 'Karachi, Gulshan-e-Iqbal', 'comment' => 'Warm, soothing, and incredibly addictive. Received compliments throughout an evening family wedding.'],
            ['name' => 'Mustafa Kamal', 'city' => 'Karachi, North Nazimabad', 'comment' => 'Delivered to Karachi in under 24 hours. The ambergris dry-down on cotton kurta is magnificent.'],
            ['name' => 'Mariam Alvi', 'city' => 'Karachi, KDA Scheme 1', 'comment' => 'Velvety floral and woody accords that stay smooth all day. My sister ordered her own bottle immediately.'],
            ['name' => 'Hamza Qureshi', 'city' => 'Karachi, DHA Phase 8', 'comment' => 'Unbeatable sillage and beast-mode performance. Stays fresh even after a long workday in the city.'],
            ['name' => 'Daniyal Akhter', 'city' => 'Karachi, Bahadurabad', 'comment' => 'Masterfully blended notes. Perfect for evening formal wear and high-profile business meetings.'],
            ['name' => 'Sumbul Jawaid', 'city' => 'Karachi, Clifton Block 4', 'comment' => 'Soft, elegant, and comforting projection that leaves an unforgettable luxury scent trail.'],
            ['name' => 'Fahad Merchant', 'city' => 'Karachi, DHA Phase 5', 'comment' => 'Top notch presentation with rich oils. Easily my best blind buy of 2026.'],
            ['name' => 'Adnan Siddiqui', 'city' => 'Karachi, Gulshan', 'comment' => 'Outstanding projection in the evening breeze. A signature fragrance that garners constant praise.'],
            ['name' => 'Naveen Pirzada', 'city' => 'Karachi, DHA Phase 2', 'comment' => 'Sensational fragrance oil balance. Elegant, understated, and unmistakably haute parfumerie.'],
            ['name' => 'Shahmeer Bukhari', 'city' => 'Karachi, PECHS Block 2', 'comment' => 'Solid glass bottle, tight magnetic seal, and divine sillage. Will definitely reorder soon.'],
            ['name' => 'Rameen Farrukh', 'city' => 'Karachi, Clifton', 'comment' => 'Luxurious, long-lasting, and universally adored by everyone around me. 10/10 purchase.'],
            ['name' => 'Kamran Baig', 'city' => 'Karachi, Malir Cantt', 'comment' => 'Extraordinary maceration. One spray on wrist lasted right into the next morning.'],
            ['name' => 'Dr. Asadullah Memon', 'city' => 'Karachi, SMCHS', 'comment' => 'The drydown is pure poetry. Very sophisticated and refined for everyday clinic wear.'],
            ['name' => 'Zeeshan Merchant', 'city' => 'Karachi, DHA Phase 4', 'comment' => 'Rich, resinous amber with great clarity. Received 4 compliments on the very first day.'],
            ['name' => 'Sarah Farhan', 'city' => 'Karachi, Bath Island', 'comment' => 'Pure sophistication in a bottle. Beautifully presented in a royal gift box.'],

            // Lahore Connoisseurs
            ['name' => 'Usman Tariq', 'city' => 'Lahore, Gulberg III', 'comment' => 'Received next day in Lahore via COD. Rich projection that lingers on clothes for days.'],
            ['name' => 'Dr. Omer Siddiqui', 'city' => 'Lahore, DHA Phase 5', 'comment' => 'I collect Roja and Clive Christian. This formulation has phenomenal depth and natural maceration.'],
            ['name' => 'Mahnoor Shah', 'city' => 'Lahore, Model Town', 'comment' => 'Addictive dark vanille and woody notes that don’t feel cloying in cool evenings.'],
            ['name' => 'Ali Raza Chatha', 'city' => 'Lahore, Cantt', 'comment' => 'Stout magnetic bottle and stellar atomiser mist. 3 sprays easily last past 12 hours.'],
            ['name' => 'Waqas Mansoor', 'city' => 'Lahore, Johar Town', 'comment' => 'Magnificent oriental accords. Perfect longevity for Lahore wedding season.'],

            // Islamabad & Rawalpindi Connoisseurs
            ['name' => 'Dr. Sarah Qureshi', 'city' => 'Islamabad, F-7/2', 'comment' => 'Super fast courier delivery to Islamabad. The balance of floral and woody notes is pure artistry.'],
            ['name' => 'Zeeshan Abbasi', 'city' => 'Islamabad, Bahria Town', 'comment' => 'Sophisticated and aristocratic aura. Wore it to an embassy dinner and everyone inquired about it.'],
            ['name' => 'Anum Naveed', 'city' => 'Islamabad, Blue Area', 'comment' => 'Concierge WhatsApp assistance was prompt and accurate. A truly majestic perfume experience.'],
            ['name' => 'Farooq Chaudhry', 'city' => 'Islamabad, E-7', 'comment' => 'Subtle, regal, and deeply comforting scent. Exceptional craftsmanship.'],

            // Peshawar Connoisseurs
            ['name' => 'Saadullah Khan', 'city' => 'Peshawar, University Town', 'comment' => 'Bold masculine projection with pure oriental woods. Ideal for traditional and formal occasions.'],
            ['name' => 'Engr. Farooq Afridi', 'city' => 'Peshawar, Hayatabad', 'comment' => 'Authentic agarwood and rich cashmere accord. Zero barnyard notes—exceptionally refined.'],
            ['name' => 'Taimur Khattak', 'city' => 'Peshawar, Cantt', 'comment' => 'Delivered securely bubble-wrapped to Peshawar. The fragrance profile is commanding yet silky smooth.'],
        ];

        // Seed reviews so EVERY product gets authentic reviews
        $productCount = $products->count();
        $reviewCount = count($allReviews);

        // 1. Give Aqua Ambergris (slug: aqua-ambergris-oceanic-extrait) 4 dedicated reviews
        $aquaAmbergris = $products->firstWhere('slug', 'aqua-ambergris-oceanic-extrait');
        if ($aquaAmbergris) {
            $aquaReviews = [
                ['name' => 'Bilal Farooqui', 'city' => 'Karachi, Clifton', 'comment' => 'Unbelievable ocean-breeze and ambergris sillage in Karachi humidity. Projects for 14+ hours.'],
                ['name' => 'Syed Tariq Mehmood', 'city' => 'Karachi, PECHS', 'comment' => 'Crisp bergamot and salted amber depth. My absolute signature scent for summers.'],
                ['name' => 'Usman Tariq', 'city' => 'Lahore, Gulberg III', 'comment' => 'Refreshing yet powerful projection. Received multiple compliments at office.'],
                ['name' => 'Saadullah Khan', 'city' => 'Peshawar, University Town', 'comment' => 'Extraordinary oceanic accords that hold up in dry and warm climate effortlessly.'],
            ];
            foreach ($aquaReviews as $idx => $ar) {
                Review::create([
                    'product_id' => $aquaAmbergris->id,
                    'customer_name' => $ar['name'],
                    'customer_city' => $ar['city'],
                    'rating' => 5,
                    'title' => 'Masterpiece Oceanic Extrait',
                    'comment' => $ar['comment'],
                    'verified_purchase' => true,
                    'is_approved' => true,
                    'created_at' => now()->subDays(10 - $idx)->subHours(rand(1, 8)),
                ]);
            }
        }

        // 2. Assign across all products
        foreach ($products as $pIndex => $prod) {
            // Pick 1-2 reviews per product
            $rev1 = $allReviews[$pIndex % $reviewCount];
            Review::create([
                'product_id' => $prod->id,
                'customer_name' => $rev1['name'],
                'customer_city' => $rev1['city'],
                'rating' => 5,
                'title' => 'Exceptional Haute Parfumerie',
                'comment' => $rev1['comment'],
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(30 - ($pIndex % 20))->subHours(rand(1, 10)),
            ]);

            // Add second review for featured and best-selling products
            if ($prod->is_featured || $prod->is_bestseller || in_array($prod->id, [1, 4, 5, 6, 8, 19, 25, 26, 28, 33])) {
                $rev2 = $allReviews[($pIndex + 7) % $reviewCount];
                Review::create([
                    'product_id' => $prod->id,
                    'customer_name' => $rev2['name'],
                    'customer_city' => $rev2['city'],
                    'rating' => 5,
                    'title' => 'Unrivaled Sillage & Value',
                    'comment' => $rev2['comment'],
                    'verified_purchase' => true,
                    'is_approved' => true,
                    'created_at' => now()->subDays(20 - ($pIndex % 15))->subHours(rand(1, 10)),
                ]);
            }
        }
    }
}
