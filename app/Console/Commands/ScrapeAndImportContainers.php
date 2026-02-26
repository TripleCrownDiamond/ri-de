<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMedia;

class ScrapeAndImportContainers extends Command
{
    protected $signature = 'scrape:containers';
    protected $description = 'Scrape container products from products-grid.txt and import them with Cloudinary images';

    public function handle()
    {
        $filePath = 'c:\Users\takac\OneDrive\Desktop\Bureau\projet-remorques-industrie\products-grid.txt';
        
        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1;
        }

        $content = file_get_contents($filePath);
        $this->info("File read successfully. Length: " . strlen($content));

        // Regex to find product blocks
        preg_match_all('/<li class="[^"]*product[^"]*"(.*?)<\/li>/s', $content, $matches);

        $products = $matches[1];
        $this->info("Found " . count($products) . " products.");

        $count = 0;
        foreach ($products as $productHtml) {
            if ($count >= 40) break; // Limit to 40 products

            try {
                // Extract Title
                preg_match('/<h2 class="woocommerce-loop-product__title">([^<]+)<\/h2>/', $productHtml, $titleMatch);
                $title = $titleMatch[1] ?? null;

                // Extract Price
                preg_match('/<span class="woocommerce-Price-amount amount"><bdi>.*?([\d.,]+).*?<\/bdi>/s', $productHtml, $priceMatch);
                $priceStr = $priceMatch[1] ?? '0';
                $price = (float) str_replace(',', '.', str_replace('.', '', $priceStr));

                // Extract SKU
                preg_match('/data-product_sku="([^"]+)"/', $productHtml, $skuMatch);
                $sku = $skuMatch[1] ?? null;

                // Extract Image URL
                preg_match('/<img.*?src="([^"]+)".*?>/', $productHtml, $imgMatch);
                $imgUrl = $imgMatch[1] ?? null;

                // Extract Category
                preg_match('/product_cat-([^ "]+)/', $productHtml, $catMatch);
                $catSlug = $catMatch[1] ?? 'general';
                $categoryName = ucwords(str_replace('-', ' ', $catSlug));

                if (!$title || !$sku) {
                    $this->warn("Skipping product due to missing title or SKU.");
                    continue;
                }

                $this->info("Processing: $title ($sku)");

                // Create/Update Category
                $category = Category::firstOrCreate(
                    ['slug' => $catSlug],
                    [
                        'name' => $categoryName,
                        'name_fr' => $categoryName,
                        'name_de' => $categoryName,
                    ]
                );

                // Upload Image to Cloudinary (Manual Implementation)
                $cloudinaryUrl = null;
                if ($imgUrl) {
                    try {
                        $this->info("Uploading image: $imgUrl");
                        $cloudinaryUrl = $this->uploadToCloudinary($imgUrl);
                        if ($cloudinaryUrl) {
                            $this->info("Uploaded to: $cloudinaryUrl");
                        } else {
                            $this->warn("Failed to upload (returned null), using original URL.");
                            $cloudinaryUrl = $imgUrl;
                        }
                    } catch (\Exception $e) {
                        $this->error("Failed to upload image: " . $e->getMessage());
                        $cloudinaryUrl = $imgUrl; 
                    }
                }

                // Create/Update Product
                // Ensure unique slug by appending SKU
                $slug = Str::slug($title . '-' . $sku);

                $product = Product::updateOrCreate(
                    ['sku' => $sku],
                    [
                        'title' => $title,
                        'slug' => $slug,
                        'price_ttc' => $price,
                        'price_ht' => $price / 1.2,
                        'is_active' => true,
                        'description' => "Container product extracted from source.",
                    ]
                );

                // Attach Category
                if (!$product->categories->contains($category->id)) {
                    $product->categories()->attach($category->id);
                }

                // Add Media
                if ($cloudinaryUrl) {
                    // Check if media already exists
                    $existingMedia = ProductMedia::where('product_id', $product->id)
                        ->where('path', $cloudinaryUrl)
                        ->first();

                    if (!$existingMedia) {
                        // If updating with Cloudinary URL, remove old non-Cloudinary media if exists
                        if (strpos($cloudinaryUrl, 'cloudinary') !== false) {
                            ProductMedia::where('product_id', $product->id)
                                ->where('path', 'not like', '%cloudinary%')
                                ->delete();
                        }

                        ProductMedia::create([
                            'product_id' => $product->id,
                            'type' => 'image',
                            'path' => $cloudinaryUrl,
                            'is_primary' => true,
                            'title' => $title,
                        ]);
                    }
                }

                $count++;

            } catch (\Exception $e) {
                $this->error("Error processing product: " . $e->getMessage());
            }
        }

        $this->info("Imported $count products successfully.");
        return 0;
    }

    private function uploadToCloudinary($url)
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $uploadPreset = env('CLOUDINARY_UPLOAD_PRESET');

        if (!$cloudName || !$apiKey || !$apiSecret) {
            $this->error("Missing Cloudinary credentials in .env");
            return null;
        }

        $timestamp = time();
        $params = [
            'timestamp' => $timestamp,
            'upload_preset' => $uploadPreset, // Use upload preset if available
        ];
        
        // If using signed upload (recommended if preset is not public/unsigned)
        // Sort params by key
        ksort($params);
        $stringToSign = '';
        foreach ($params as $key => $value) {
            $stringToSign .= "$key=$value&";
        }
        $stringToSign = rtrim($stringToSign, '&');
        $signature = sha1($stringToSign . $apiSecret);

        // Prepare multipart form data
        // Since Http client handles multipart, we can use it.
        // However, we are uploading from URL.
        // Cloudinary supports 'file' parameter as remote URL.

        $response = Http::post("https://api.cloudinary.com/v1_1/$cloudName/image/upload", [
            'file' => $url,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'upload_preset' => $uploadPreset,
            'signature' => $signature,
        ]);

        if ($response->successful()) {
            return $response->json()['secure_url'] ?? null;
        } else {
            $this->error("Cloudinary Error: " . $response->body());
            
            // Retry without signature (maybe preset is unsigned)
            if ($uploadPreset) {
                $response = Http::post("https://api.cloudinary.com/v1_1/$cloudName/image/upload", [
                    'file' => $url,
                    'upload_preset' => $uploadPreset,
                ]);
                if ($response->successful()) {
                    return $response->json()['secure_url'] ?? null;
                }
            }
            
            return null;
        }
    }
}
