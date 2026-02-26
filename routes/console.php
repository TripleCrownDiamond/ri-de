<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('import:trailers-motoculturestjean', function () {
    $path = storage_path('app/trailers_motoculturestjean.json');

    if (! file_exists($path)) {
        $this->error('File not found: '.$path);

        return;
    }

    $data = json_decode(file_get_contents($path), true);

    if (! is_array($data) || ! isset($data['items']) || ! is_array($data['items'])) {
        $this->error('Invalid JSON structure.');

        return;
    }

    $items = $data['items'];

    $this->info('Found '.count($items).' scraped trailers. Resetting existing trailer products...');

    $trailersCategory = Category::firstOrCreate(
        ['slug' => 'trailers'],
        ['name' => 'Remorques', 'position' => 1]
    );

    $productIds = $trailersCategory->products()->pluck('products.id')->all();

    if ($productIds) {
        ProductMedia::whereIn('product_id', $productIds)->delete();

        $trailersCategory->products()->detach();

        Product::whereIn('id', $productIds)->delete();
    }

    foreach ($items as $item) {
        $title = $item['title'] ?? null;

        if (! $title) {
            continue;
        }

        $slug = str($title)->slug('-');

        $brandName = $item['brand'] ?? 'TRIGANO / TRELGO';

        $brand = Brand::firstOrCreate(
            ['slug' => str($brandName)->slug()],
            ['name' => $brandName]
        );

        $priceTtc = $item['promo_price_ttc'] ?? $item['catalogue_price_ttc'] ?? null;
        $priceHt = $priceTtc ? $priceTtc / 1.2 : null;

        $description = $item['description'] ?? null;
        $technicalSpecs = $item['technical_specs'] ?? [];
        $advantages = $item['advantages'] ?? [];

        $product = Product::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'description' => $description,
                'brand_id' => $brand->id,
                'price_ht' => $priceHt,
                'price_ttc' => $priceTtc,
                'ean' => $item['ean'] ?? null,
                'poids_kg' => null,
                'dimensions' => [],
                'sku' => $item['sku'] ?? 'TRIGANO-'.strtoupper(substr(sha1($slug), 0, 10)),
                'extra_attributes' => [
                    'product_url' => $item['product_url'] ?? null,
                    'catalogue_price_ttc' => $item['catalogue_price_ttc'] ?? null,
                    'promo_price_ttc' => $item['promo_price_ttc'] ?? null,
                    'technical_specs' => $technicalSpecs,
                    'advantages' => $advantages,
                ],
                'is_active' => true,
            ]
        );

        $product->categories()->syncWithoutDetaching([$trailersCategory->id]);

        $imageUrl = $item['image_featured'] ?? null;

        if ($imageUrl) {
            ProductMedia::where('product_id', $product->id)->delete();

            ProductMedia::create([
                'product_id' => $product->id,
                'type' => 'image',
                'path' => $imageUrl,
                'title' => $title,
                'position' => 1,
                'is_primary' => true,
            ]);
        }
    }

    $this->info('Imported '.count($items).' trailers into the database.');
})->purpose('Import scraped TRIGANO trailers into the database');

Artisan::command('import:mowers-scraped', function () {
    $path = storage_path('app/mowers_scraped.json');

    if (! file_exists($path)) {
        $this->error('File not found: '.$path);

        return;
    }

    $data = json_decode(file_get_contents($path), true);

    if (! is_array($data) || ! isset($data['items']) || ! is_array($data['items'])) {
        $this->error('Invalid JSON structure.');

        return;
    }

    $items = $data['items'];

    $this->info('Found '.count($items).' scraped mowers. Resetting existing mower products...');

    $mowersCategory = Category::firstOrCreate(
        ['slug' => 'mowers'],
        ['name' => 'Tondeuses et robots', 'position' => 2]
    );

    $productIds = $mowersCategory->products()->pluck('products.id')->all();

    if ($productIds) {
        ProductMedia::whereIn('product_id', $productIds)->delete();

        $mowersCategory->products()->detach();

        Product::whereIn('id', $productIds)->delete();
    }

    foreach ($items as $item) {
        $title = $item['title'] ?? null;

        if (! $title) {
            continue;
        }

        $slug = str($title)->slug('-');

        $brandName = $item['brand'] ?? 'Marques diverses';

        $brand = Brand::firstOrCreate(
            ['slug' => str($brandName)->slug()],
            ['name' => $brandName]
        );

        $priceTtc = $item['promo_price_ttc'] ?? $item['catalogue_price_ttc'] ?? null;
        $priceHt = $priceTtc ? $priceTtc / 1.2 : null;

        $description = $item['description'] ?? null;
        $technicalSpecs = $item['technical_specs'] ?? [];
        $advantages = $item['advantages'] ?? [];

        $product = Product::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'description' => $description,
                'brand_id' => $brand->id,
                'price_ht' => $priceHt,
                'price_ttc' => $priceTtc,
                'ean' => $item['ean'] ?? null,
                'poids_kg' => null,
                'dimensions' => [],
                'sku' => $item['sku'] ?? 'MOWER-'.strtoupper(substr(sha1($slug), 0, 10)),
                'extra_attributes' => [
                    'product_url' => $item['product_url'] ?? null,
                    'source' => $item['source'] ?? null,
                    'catalogue_price_ttc' => $item['catalogue_price_ttc'] ?? null,
                    'promo_price_ttc' => $item['promo_price_ttc'] ?? null,
                    'technical_specs' => $technicalSpecs,
                    'advantages' => $advantages,
                ],
                'is_active' => true,
            ]
        );

        $product->categories()->syncWithoutDetaching([$mowersCategory->id]);

        $imageUrl = $item['image_featured'] ?? null;

        if ($imageUrl) {
            ProductMedia::where('product_id', $product->id)->delete();

            ProductMedia::create([
                'product_id' => $product->id,
                'type' => 'image',
                'path' => $imageUrl,
                'title' => $title,
                'position' => 1,
                'is_primary' => true,
            ]);
        }
    }

    $this->info('Imported '.count($items).' mowers into the database.');
})->purpose('Import scraped mowers into the database');
