<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Database\Seeder;

class RealisticReviewsSeeder extends Seeder
{
    public function run()
    {
        Review::truncate();

        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $reviewsData = [
            [
                'customer_name' => 'Bilal Farooqui',
                'customer_city' => 'Karachi, Clifton',
                'rating' => 5,
                'title' => 'Incredible dry-down and projection',
                'comment' => 'Wore this to an outdoor dinner in Karachi humidity. Scent trail stayed prominent for over 14 hours without turning cloying. The 35% oil concentration makes a massive difference.',
            ],
            [
                'customer_name' => 'Dr. Sarah Qureshi',
                'customer_city' => 'Islamabad, F-8/2',
                'rating' => 5,
                'title' => 'Remarkable fidelity & smooth accords',
                'comment' => 'The balance of notes is pure artistry. No harsh synthetic alcohol blast on the opening. The heavy magnetic gold flacon feels like a 50,000 PKR luxury bottle.',
            ],
            [
                'customer_name' => 'Usman Tariq',
                'customer_city' => 'Lahore, Gulberg III',
                'rating' => 5,
                'title' => 'Fast TCS delivery and beast-mode sillage',
                'comment' => 'Received next day in Lahore via COD. Sprayed on my cotton kurta in the morning and could still distinctly catch the amber-oud whiffs the next day.',
            ],
            [
                'customer_name' => 'Mariam Jahangir',
                'customer_city' => 'Rawalpindi, Bahria Town',
                'rating' => 5,
                'title' => 'Compliments all evening at wedding',
                'comment' => 'Wore it for my cousin’s Barat function. At least 6 people asked me what I was wearing. The velvet-lined presentation box makes it feel royal.',
            ],
            [
                'customer_name' => 'Zeeshan Ali',
                'customer_city' => 'Multan, Cantt',
                'rating' => 5,
                'title' => 'Stands up to 42°C heat effortlessly',
                'comment' => 'In South Punjab heat, typical designer EDTs disappear in 90 minutes. This extrait de parfum genuinely held its woody base for over 12 hours. Pure quality.',
            ],
            [
                'customer_name' => 'Hina Rizvi',
                'customer_city' => 'Karachi, DHA Phase 6',
                'rating' => 5,
                'title' => 'Exquisite unboxing & rich sillage',
                'comment' => 'The solid cap, heavy glass base, and atomiser mist are top tier. The fragrance smells warm, sophisticated, and distinctly niche.',
            ],
            [
                'customer_name' => 'Saad Murtaza',
                'customer_city' => 'Peshawar, University Town',
                'rating' => 5,
                'title' => 'Rich masculine aura for formal wear',
                'comment' => 'Very confident, bold opening that smoothly transitions into smoky woods and leather. Perfect for evening business dinners and weddings.',
            ],
            [
                'customer_name' => 'Fatima Zahra',
                'customer_city' => 'Faisalabad, Canal Road',
                'rating' => 5,
                'title' => 'Velvety floral accords & royal sillage',
                'comment' => 'Authentic natural oils rather than synthetic lab smells. Soft, regal, and comforting. My sister ordered the exact same bottle right after trying mine.',
            ],
            [
                'customer_name' => 'Omer Siddiqui',
                'customer_city' => 'Lahore, DHA Phase 5',
                'rating' => 5,
                'title' => 'Easily rivals 250+ USD niche bottles',
                'comment' => 'I collect Roja and Tom Ford perfumes. This blend is 95% spot-on with even better projection tailored for Pakistani climate. Instant staple.',
            ],
            [
                'customer_name' => 'Anum Naveed',
                'customer_city' => 'Islamabad, E-11',
                'rating' => 5,
                'title' => 'Sophisticated and soothing daily scent',
                'comment' => 'WhatsApp concierge helped me choose the right notes for corporate office wear. Subtle yet lingers warmly all afternoon.',
            ],
            [
                'customer_name' => 'Hamza Abbasi',
                'customer_city' => 'Sialkot, Cantt',
                'rating' => 5,
                'title' => 'Long lasting 16+ hours performance',
                'comment' => 'Just 3-4 sprays on pulse points in the morning. Strong sillage for 4 hours then settles into a magnetic aura that lasts all day and night.',
            ],
            [
                'customer_name' => 'Zainab Khan',
                'customer_city' => 'Karachi, PECHS',
                'rating' => 5,
                'title' => 'Ultimate festive & wedding fragrance',
                'comment' => 'Wore this across three consecutive wedding days. The sweet vanilla and woody spices blended exceptionally well with formal attire.',
            ],
            [
                'customer_name' => 'Ahmed Raza',
                'customer_city' => 'Gujranwala, Model Town',
                'rating' => 5,
                'title' => 'Visible oil sheen on skin (True Extrait)',
                'comment' => 'You can see the rich concentration of organic perfume oils right after spraying. No sticky residue, just sheer longevity and richness.',
            ],
            [
                'customer_name' => 'Mahnoor Shah',
                'customer_city' => 'Lahore, Model Town',
                'rating' => 5,
                'title' => 'Addictive gourmand vanille profile',
                'comment' => 'Warm, cozy caramel and dark bourbon notes that don’t feel cloying. Has become my go-to signature scent for cool evenings.',
            ],
            [
                'customer_name' => 'Shahmeer Bukhari',
                'customer_city' => 'Hyderabad, Qasimabad',
                'rating' => 5,
                'title' => 'Authentic Assam agarwood depth',
                'comment' => 'The agarwood and amber accord is smooth and deeply aged. Absolutely zero barnyard or harsh pungent notes—pure luxury.',
            ],
            [
                'customer_name' => 'Rabia Aslam',
                'customer_city' => 'Wah Cantt',
                'rating' => 5,
                'title' => 'Pristine packaging and secure parcel',
                'comment' => 'Ordered on COD. Box arrived bubble wrapped and undamaged. The bottle looks stunning on my dressing vanity.',
            ],
            [
                'customer_name' => 'Daniyal Sheikh',
                'customer_city' => 'Quetta, Jinnah Town',
                'rating' => 5,
                'title' => 'Crisp opening and deep woody trail',
                'comment' => 'Delivered to Quetta within 3 days. Impressive formulation with a sparkling citrus opening and deep sandalwood sillage.',
            ],
            [
                'customer_name' => 'Ayesha Noor',
                'customer_city' => 'Lahore, Johar Town',
                'rating' => 5,
                'title' => 'Elegant sillage and endless compliments',
                'comment' => 'Soft rose, saffron, and creamy amber. Leaves a memorable scent trail wherever you walk.',
            ],
            [
                'customer_name' => 'Farhan Qureshi',
                'customer_city' => 'Abbottabad',
                'rating' => 5,
                'title' => 'Crisp mountain air & pine notes',
                'comment' => 'In cooler weather this projects like a dream. Rich fresh spicy aromatic notes that feel invigorating.',
            ],
            [
                'customer_name' => 'Khadija Mir',
                'customer_city' => 'Sargodha',
                'rating' => 5,
                'title' => 'Flawless gifting experience',
                'comment' => 'Ordered as an anniversary gift for my husband. He was blown away by the magnetic cap and rich oriental scent.',
            ]
        ];

        $productIndex = 0;
        $productCount = $products->count();

        foreach ($reviewsData as $i => $data) {
            $product = $products[$productIndex % $productCount];
            Review::create([
                'product_id' => $product->id,
                'customer_name' => $data['customer_name'],
                'customer_city' => $data['customer_city'],
                'rating' => $data['rating'],
                'title' => $data['title'],
                'comment' => $data['comment'],
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(20 - $i)->subHours(rand(1, 12)),
            ]);
            $productIndex++;
        }
    }
}
