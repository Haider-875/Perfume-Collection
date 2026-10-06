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
                'comment' => 'Wore this to an evening outdoor dinner in Karachi humidity. The scent trail stayed noticeable for over 12 hours without suffocating. Highly recommend.',
            ],
            [
                'customer_name' => 'Dr. Sarah Qureshi',
                'customer_city' => 'Islamabad, F-8',
                'rating' => 5,
                'title' => 'Remarkable fidelity & smooth notes',
                'comment' => 'The balance of the notes is pure artistry. No harsh synthetic opening at all. The heavy magnetic flacon feels worth twice the price.',
            ],
            [
                'customer_name' => 'Usman Tariq',
                'customer_city' => 'Lahore, Gulberg',
                'rating' => 5,
                'title' => 'Fast delivery and beast mode sillage',
                'comment' => 'Received via TCS the very next day on Cash on Delivery. Sprayed on my kurta in the morning and could still catch whiffs late at night.',
            ],
            [
                'customer_name' => 'Mariam Jahangir',
                'customer_city' => 'Rawalpindi',
                'rating' => 5,
                'title' => 'Received compliments all evening',
                'comment' => 'Such a luxurious and classy profile. Sprayed on my abaya and it literally lasted for 2 days. The presentation box makes it a great gift.',
            ],
            [
                'customer_name' => 'Zeeshan Ali',
                'customer_city' => 'Multan',
                'rating' => 5,
                'title' => 'Stands up to heat effortlessly',
                'comment' => 'In Multan summer heat most designer EDTs disappear within 2 hours. This extrait de parfum genuinely pushed 14 hours. 10/10 quality.',
            ],
            [
                'customer_name' => 'Hina Rizvi',
                'customer_city' => 'Karachi, DHA Phase 6',
                'rating' => 5,
                'title' => 'Premium presentation & unboxing',
                'comment' => 'The velvet interior and heavy gold cap are gorgeous. Smells sophisticated, warm, and distinctly high-end.',
            ],
            [
                'customer_name' => 'Saad Murtaza',
                'customer_city' => 'Peshawar',
                'rating' => 4,
                'title' => 'Rich masculine aura',
                'comment' => 'Very confident, bold opening. Dries down into an addictive amber-woody base. Excellent performance for formal wear.',
            ],
            [
                'customer_name' => 'Fatima Zahra',
                'customer_city' => 'Faisalabad',
                'rating' => 5,
                'title' => 'Velvety floral accords',
                'comment' => 'Authentic natural oil quality. Not overpowering, very regal and soft. My sister immediately placed an order after testing mine.',
            ],
            [
                'customer_name' => 'Omer Siddiqui',
                'customer_city' => 'Lahore Cantt',
                'rating' => 5,
                'title' => 'Easily competes with international bottles',
                'comment' => 'I own several original niche bottles and this impression is about 95% spot-on with even better longevity in local weather.',
            ],
            [
                'customer_name' => 'Anum Naveed',
                'customer_city' => 'Islamabad, E-11',
                'rating' => 5,
                'title' => 'Sophisticated and soothing',
                'comment' => 'Customer concierge on WhatsApp was very helpful in helping me select notes suited for daytime office wear. Beautiful blend.',
            ],
            [
                'customer_name' => 'Hamza Abbasi',
                'customer_city' => 'Sialkot',
                'rating' => 5,
                'title' => 'Long lasting for 14+ hours',
                'comment' => 'Just 4 sprays in the morning were enough. Strong sillage for the first 4 hours then settles into a magnetic skin scent.',
            ],
            [
                'customer_name' => 'Zainab Khan',
                'customer_city' => 'Karachi, PECHS',
                'rating' => 5,
                'title' => 'Perfect wedding season fragrance',
                'comment' => 'Wore it for Mehndi and Barat functions and received non-stop inquiries about what perfume I had on.',
            ],
            [
                'customer_name' => 'Ahmed Raza',
                'customer_city' => 'Gujranwala',
                'rating' => 4,
                'title' => 'Great value for Extrait concentration',
                'comment' => 'Heavy oil sheen on skin when sprayed, which confirms the high oil concentration. Great packaging and fast dispatch.',
            ],
            [
                'customer_name' => 'Mahnoor Shah',
                'customer_city' => 'Lahore, Model Town',
                'rating' => 5,
                'title' => 'Sensational gourmand notes',
                'comment' => 'Warm, cozy, and delicious without being overly sweet. It has become my everyday signature scent.',
            ],
            [
                'customer_name' => 'Shahmeer Bukhari',
                'customer_city' => 'Hyderabad',
                'rating' => 5,
                'title' => 'Authentic agarwood base',
                'comment' => 'Rich oriental oud profile done with elegance. Zero pungency, perfectly macerated.',
            ],
            [
                'customer_name' => 'Rabia Aslam',
                'customer_city' => 'Wah Cantt',
                'rating' => 5,
                'title' => 'Pleasantly surprised by the quality',
                'comment' => 'First time ordering from Perfumes Collection and definitely not the last. Arrived pristine in heavy carton packaging.',
            ],
            [
                'customer_name' => 'Daniyal Sheikh',
                'customer_city' => 'Quetta',
                'rating' => 5,
                'title' => 'Crisp opening and deep woody trail',
                'comment' => 'Delivered to Quetta in 3 days. Impressive formulation that lingers in the room long after you leave.',
            ],
            [
                'customer_name' => 'Ayesha Noor',
                'customer_city' => 'Lahore, Johar Town',
                'rating' => 5,
                'title' => 'Subtle elegance and great longevity',
                'comment' => 'A delicate yet lingering trail. Leaves a lovely impression on everyone around.',
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
                'created_at' => now()->subDays(18 - $i)->subHours(rand(1, 12)),
            ]);
            $productIndex++;
        }
    }
}
