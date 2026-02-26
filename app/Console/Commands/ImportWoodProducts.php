<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportWoodProducts extends Command
{
    protected $signature = 'import:wood';

    protected $description = 'Import wood products from scraped JSON';

    public function handle(): int
    {
        $path = base_path('../extracted_wood.json');

        if (! file_exists($path)) {
            $this->error('extracted_wood.json not found in root directory.');
            return self::FAILURE;
        }

        $raw = file_get_contents($path);
        if ($raw === false) {
            $this->error('Unable to read extracted_wood.json.');
            return self::FAILURE;
        }

        $data = json_decode($raw, true);
        if (! is_array($data)) {
            $this->error('Invalid JSON format for extracted_wood.json.');
            return self::FAILURE;
        }

        $this->info("Found " . count($data) . " wood products to import.");

        // Ensure categories exist
        $catWood = Category::firstOrCreate(
            ['slug' => 'combustibles'],
            ['name' => 'Combustibles', 'position' => 10]
        );
        $catAcc = Category::firstOrCreate(
            ['slug' => 'accessoires-combustibles'],
            ['name' => 'Acc. Combustibles', 'position' => 11]
        );

        // Update name if they already exist
        $catWood->update(['name' => 'Combustibles']);
        $catAcc->update(['name' => 'Acc. Combustibles']);

        // Delete products in these categories that have no price or no images
        $this->info("Cleaning up products without price or images...");
        Product::whereHas('categories', function($q) {
            $q->whereIn('slug', ['combustibles', 'accessoires-combustibles']);
        })->get()->each(function($p) {
            if ($p->price_ttc <= 0 || $p->media()->count() == 0) {
                $this->info("Deleting incomplete product: {$p->title}");
                $p->delete();
            }
        });

        foreach ($data as $item) {
            $title = $item['title'] ?? null;
            if (! $title) {
                continue;
            }

            $sku = $item['sku'] ?? 'WOOD-' . strtoupper(substr(sha1(Str::slug($title)), 0, 8));
            $slug = Str::slug($title);
            
            $description = $item['description'] ?? null;
            $priceTtc = $item['price'] ?? 0;
            $categorySlug = $item['category'] ?? 'combustibles';
            
            $targetCategory = ($categorySlug === 'accessoires-combustibles' || $categorySlug === 'accessoires-bois-pellets') ? $catAcc : $catWood;

            $productData = [
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'ean' => null,
                'poids_kg' => null,
                'dimensions' => [],
                'extra_attributes' => [
                    'source' => 'simplyfeu_extraction',
                ],
                'is_active' => true,
            ];

            if ($priceTtc > 0) {
                $productData['price_ttc'] = $priceTtc;
                $productData['price_ht'] = $priceTtc / 1.2; // Assuming 20% VAT
            }

            $product = Product::updateOrCreate(
                ['sku' => $sku], // Match by SKU
                $productData
            );

            // Attach to the correct category and remove from others if necessary
            $product->categories()->sync([$targetCategory->id]);

            // Handle images
            if (!empty($item['images'])) {
                // Clear existing media if we want to refresh, but user said "enrichi" 
                // so let's just add new ones or update
                foreach ($item['images'] as $index => $imageUrl) {
                    ProductMedia::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'path' => $imageUrl
                        ],
                        [
                            'type' => 'image',
                            'position' => $index,
                            'is_primary' => ($index === 0)
                        ]
                    );
                }
            }

            $this->info("Imported/Updated: {$title} ({$sku})");
        }

        $this->info('Import completed successfully.');
        return self::SUCCESS;
    }
}
