<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Brand;
use App\Models\FragranceFamily;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ActivityLog;

class ImagePerfumesInventorySeeder extends Seeder
{
    public function run()
    {
        // Delegate to ProductionCatalogSeeder for consistent catalog seeding
        $seeder = new ProductionCatalogSeeder();
        $seeder->setCommand($this->command);
        $seeder->run();
    }
}
