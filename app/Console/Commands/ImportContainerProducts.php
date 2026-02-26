<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportContainerProducts extends Command
{
    protected $signature = 'import:containers';

    protected $description = 'Import container products from scraped JSON';

    public function handle(): int
    {
        $path = storage_path('app/containers_scraped.json');

        if (! file_exists($path)) {
            $this->error('containers_scraped.json not found in storage/app.');
            return self::FAILURE;
        }

        $raw = file_get_contents($path);
        if ($raw === false) {
            $this->error('Unable to read containers_scraped.json.');
            return self::FAILURE;
        }

        $data = json_decode($raw, true);
        if (! is_array($data) || !isset($data['items'])) {
            $this->error('Invalid JSON format for containers_scraped.json.');
            return self::FAILURE;
        }

        $this->info("Found " . count($data['items']) . " container products to import.");

        // Ensure categories exist
        $catContainer = Category::firstOrCreate(
            ['slug' => 'neue-container'],
            ['name' => 'Neue Container', 'name_de' => 'Neue Container', 'position' => 20]
        );
        
        $subCategories = [];
        foreach ($data['items'] as $item) {
            if (isset($item['subcategory'])) {
                $subSlug = Str::slug($item['subcategory']);
                if (!isset($subCategories[$subSlug])) {
                    $subCategories[$subSlug] = Category::firstOrCreate(
                        ['slug' => $subSlug],
                        [
                            'name' => ucwords(str_replace('_', ' ', $item['subcategory'])),
                            'name_de' => ucwords(str_replace('_', ' ', $item['subcategory'])),
                            'parent_id' => $catContainer->id,
                            'position' => 21
                        ]
                    );
                }
            }
        }

        foreach ($data['items'] as $item) {
            $title = $item['title'] ?? null;
            if (! $title) {
                continue;
            }

            $sku = $item['sku'] ?? 'CONT-' . strtoupper(substr(sha1(Str::slug($title)), 0, 8));
            $slug = Str::slug($title);
            
            $description = $item['description'] ?? null;
            $priceTtc = $item['catalogue_price_ttc'] ?? 0;
            
            $productData = [
                'title' => $title,
                'title_de' => $title,
                'slug' => $slug,
                'description' => $description,
                'description_de' => $description,
                'ean' => $item['ean'] ?? null,
                'dimensions' => $item['technical_specs'] ?? [],
                'extra_attributes' => [
                    'source' => $item['source'] ?? 'manual_extraction',
                    'advantages' => $item['advantages'] ?? [],
                    'product_url' => $item['product_url'] ?? null,
                ],
                'is_active' => true,
            ];

            if ($priceTtc > 0) {
                $productData['price_ttc'] = $priceTtc;
                $productData['price_ht'] = $priceTtc / 1.2; // Assuming 20% VAT
            }

            $product = Product::updateOrCreate(
                ['sku' => $sku],
                $productData
            );

            // Attach to the correct category
            $categoriesToSync = [$catContainer->id];
            if (isset($item['subcategory'])) {
                $subSlug = Str::slug($item['subcategory']);
                if (isset($subCategories[$subSlug])) {
                    $categoriesToSync[] = $subCategories[$subSlug]->id;
                }
            }
            $product->categories()->sync($categoriesToSync);

            // Handle images
            if (!empty($item['image_featured'])) {
                ProductMedia::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'path' => $item['image_featured']
                    ],
                    [
                        'type' => 'image',
                        'position' => 0,
                        'is_primary' => true
                    ]
                );
            }

            $this->info("Imported/Updated: {$title} ({$sku})");
        }

        $this->info('Import completed successfully.');
        return self::SUCCESS;
    }
}
