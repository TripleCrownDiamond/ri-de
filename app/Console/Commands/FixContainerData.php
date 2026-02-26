<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMedia;

class FixContainerData extends Command
{
    protected $signature = 'fix:container-data';
    protected $description = 'Translate categories and delete products without images';

    public function handle()
    {
        // 1. Translate Categories
        $cats = [
            'neue-container' => 'Nouveaux Conteneurs',
            'besondere-bungalows' => 'Bungalows Spéciaux',
            'mobilheime' => 'Mobil-homes',
            'bungalows-mit-sanitaranlagen' => 'Bungalows avec Sanitaires',
            'lagerbehalter' => 'Conteneurs de Stockage',
            'sanitaranlagen' => 'Installations Sanitaires'
        ];

        foreach($cats as $slug => $fr) {
            $cat = Category::where('slug', $slug)->first();
            if ($cat) {
                $cat->update(['name_fr' => $fr]);
                $this->info("Updated category: $slug -> $fr");
            } else {
                $this->warn("Category not found: $slug");
            }
        }

        // 2. Delete Products without Images in Container Categories
        // Get all container related category IDs
        $containerSlugs = array_keys($cats);
        $containerSlugs[] = 'containers';
        
        $categories = Category::whereIn('slug', $containerSlugs)->get();
        $categoryIds = $categories->pluck('id');
        
        // Find products in these categories that don't have media
        $products = Product::whereHas('categories', function($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        })->doesntHave('media')->get();

        $count = $products->count();
        $this->info("Found $count container products without images.");

        if ($count > 0) {
            foreach ($products as $product) {
                $this->info("Deleting: " . $product->title . " (" . $product->sku . ")");
                $product->delete();
            }
            $this->info("Deleted $count products.");
        }

        return 0;
    }
}
