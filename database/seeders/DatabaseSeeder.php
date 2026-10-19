<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

require_once __DIR__ . '/BundleSeeder.php';

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LuxuryPerfumeSeeder::class,
            ProductionCatalogSeeder::class,
            BundleSeeder::class,
            RealisticReviewsSeeder::class,
        ]);
    }
}
