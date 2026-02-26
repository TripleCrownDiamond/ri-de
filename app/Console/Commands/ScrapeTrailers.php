<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ScrapeTrailers extends Command
{
    protected $signature = 'scrape:trailers';

    protected $description = 'Scrape trailers from external website into products table';

    public function handle(): int
    {
        $path = storage_path('app/trailers_motoculturestjean.json');

        if (! file_exists($path)) {
            $this->error('trailers_motoculturestjean.json introuvable dans storage/app.');

            return self::FAILURE;
        }

        $raw = file_get_contents($path);

        if ($raw === false) {
            $this->error('Impossible de lire le fichier JSON des remorques.');

            return self::FAILURE;
        }

        $data = json_decode($raw, true);

        if (! is_array($data) || ! isset($data['items']) || ! is_array($data['items'])) {
            $this->error('Format JSON invalide pour trailers_motoculturestjean.json.');

            return self::FAILURE;
        }

        $brand = Brand::firstOrCreate(
            ['slug' => 'scraped-trailers'],
            ['name' => 'Remorques importées']
        );

        $trailersCategory = Category::firstOrCreate(
            ['slug' => 'trailers'],
            ['name' => 'Remorques', 'position' => 1]
        );

        foreach ($data['items'] as $item) {
            $title = $item['title'] ?? null;

            if (! $title) {
                continue;
            }

            $slug = str($title)->slug('-');

            $description = $item['description'] ?? null;

            $cataloguePrice = $item['catalogue_price_ttc'] ?? null;
            $promoPrice = $item['promo_price_ttc'] ?? null;
            $priceTtc = $promoPrice ?? $cataloguePrice;

            $ean = $item['ean'] ?? null;
            $sku = $item['sku'] ?? null;

            $brandName = $item['brand'] ?? 'Remorques importées';

            $brand = Brand::firstOrCreate(
                ['slug' => str($brandName)->slug('-')],
                ['name' => $brandName]
            );

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'description' => $description,
                    'brand_id' => $brand->id,
                    'price_ht' => $priceTtc ? $priceTtc / 1.2 : null,
                    'price_ttc' => $priceTtc,
                    'ean' => $ean,
                    'poids_kg' => null,
                    'dimensions' => [],
                    'sku' => $sku ?: 'SCRAPE-'.strtoupper(substr(sha1($slug), 0, 10)),
                    'extra_attributes' => [],
                    'is_active' => true,
                ]
            );

            $product->categories()->syncWithoutDetaching([$trailersCategory->id]);

            $imageUrl = $item['image_featured'] ?? null;

            if ($imageUrl) {
                ProductMedia::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'path' => $imageUrl,
                    ],
                    [
                        'type' => 'image',
                        'title' => $title,
                        'position' => 1,
                        'is_primary' => true,
                    ]
                );
            }
        }

        $this->info('Scraping completed.');

        return self::SUCCESS;
    }
}
