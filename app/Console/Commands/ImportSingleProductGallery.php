<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductMedia;

class ImportSingleProductGallery extends Command
{
    protected $signature = 'import:single-gallery';
    protected $description = 'Import gallery for the single product from single-product.txt';

    public function handle()
    {
        $filePath = 'c:\Users\takac\OneDrive\Desktop\Bureau\projet-remorques-industrie\single-product.txt';
        
        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1;
        }

        $content = file_get_contents($filePath);
        $this->info("File read successfully.");

        // Target Product
        $title = "Bewohnbares Containerhaus Luxusmodul 20 Fuß";
        $product = Product::where('title', $title)->first();

        if (!$product) {
            $this->error("Product not found: $title");
            // Try to find by slug or similar if exact match fails
             $product = Product::where('title', 'like', '%Bewohnbares Containerhaus%')->first();
             if (!$product) {
                 $this->error("Product really not found.");
                 return 1;
             }
             $this->info("Found product by partial match: " . $product->title);
        } else {
            $this->info("Found product: " . $product->title);
        }

        // Extract Gallery Images
        // Look for data-large_image="..."
        preg_match_all('/data-large_image="([^"]+)"/', $content, $matches);
        $images = array_unique($matches[1]);

        $this->info("Found " . count($images) . " gallery images.");

        foreach ($images as $imgUrl) {
            $this->info("Processing image: $imgUrl");

            // Upload to Cloudinary
            $cloudinaryUrl = $this->uploadToCloudinary($imgUrl);

            if ($cloudinaryUrl) {
                $this->info("Uploaded to: $cloudinaryUrl");

                // Check if already exists
                $exists = ProductMedia::where('product_id', $product->id)
                    ->where('path', $cloudinaryUrl)
                    ->exists();

                if (!$exists) {
                    ProductMedia::create([
                        'product_id' => $product->id,
                        'type' => 'image',
                        'path' => $cloudinaryUrl,
                        'is_primary' => false, // Gallery images are not primary (usually)
                        'title' => $product->title,
                    ]);
                    $this->info("Attached to product.");
                } else {
                    $this->info("Already attached.");
                }
            } else {
                $this->error("Failed to upload.");
            }
        }

        return 0;
    }

    private function uploadToCloudinary($url)
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $uploadPreset = env('CLOUDINARY_UPLOAD_PRESET');

        if (!$cloudName || !$apiKey || !$apiSecret) {
            $this->error("Missing Cloudinary credentials");
            return null;
        }

        $timestamp = time();
        $params = [
            'timestamp' => $timestamp,
            'upload_preset' => $uploadPreset,
        ];
        
        ksort($params);
        $stringToSign = '';
        foreach ($params as $key => $value) {
            $stringToSign .= "$key=$value&";
        }
        $stringToSign = rtrim($stringToSign, '&');
        $signature = sha1($stringToSign . $apiSecret);

        $response = Http::post("https://api.cloudinary.com/v1_1/$cloudName/image/upload", [
            'file' => $url,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'upload_preset' => $uploadPreset,
            'signature' => $signature,
        ]);

        if ($response->successful()) {
            return $response->json()['secure_url'] ?? null;
        }
        
        // Retry unsigned
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
