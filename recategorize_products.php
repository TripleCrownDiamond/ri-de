<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;

echo "--- MISE À JOUR DES BRANDS ---\n";
$brands = ['Debon', 'Trigano'];
foreach ($brands as $bName) {
    $brand = Brand::firstOrCreate(['name' => $bName], ['slug' => Str::slug($bName)]);
    echo " Brand: " . $brand->name . " (ID: " . $brand->id . ")\n";
}

echo "\n--- CRÉATION DES CATÉGORIES ---\n";
$categories = [
    ['name' => 'Remorques Fourgons', 'slug' => 'fourgons'],
    ['name' => 'Remorques Bagagères', 'slug' => 'bagageres'],
    ['name' => 'Accessoires & Pièces', 'slug' => 'accessoires'],
    ['name' => 'Tondeuses & robots', 'slug' => 'mowers'],
    ['name' => 'Bois & pellets', 'slug' => 'wood'],
];

foreach ($categories as $catData) {
    $category = Category::firstOrCreate(['slug' => $catData['slug']], ['name' => $catData['name']]);
    echo " Category: " . $category->name . " (ID: " . $category->id . ")\n";
}

echo "\n--- RE-CATÉGORISATION DES PRODUITS ---\n";
$products = Product::all();
$catFourgon = Category::where('slug', 'fourgons')->first();
$catBagagere = Category::where('slug', 'bagageres')->first();
$catAccessoire = Category::where('slug', 'accessoires')->first();
$catRemorque = Category::where('slug', 'trailers')->first();
$catMowers = Category::where('slug', 'mowers')->first();
$catWood = Category::where('slug', 'wood')->first();

foreach ($products as $product) {
    $title = strtolower($product->title);
    $targetCats = [];
    
    // Logique de catégorisation
    if (stripos($title, 'fourgon') !== false) {
        $targetCats[] = $catFourgon->id;
        $targetCats[] = $catRemorque->id;
    } elseif (stripos($title, 'kit accessoires') !== false || stripos($title, 'suspensions') !== false || stripos($title, 'renforts') !== false) {
        $targetCats[] = $catAccessoire->id;
        $targetCats[] = $catRemorque->id;
    } elseif (stripos($title, 'tondeuse') !== false || stripos($title, 'robot') !== false || stripos($title, 'husqvarna') !== false || stripos($title, 'staub') !== false) {
        $targetCats[] = $catMowers->id;
    } elseif (stripos($title, 'bois') !== false || stripos($title, 'pellet') !== false || stripos($title, 'granulés') !== false) {
        $targetCats[] = $catWood->id;
    } elseif (stripos($title, 'remorque') !== false) {
        // Par défaut, si c'est une petite remorque sans mention spécifique, on met dans bagagère
        $targetCats[] = $catBagagere->id;
        $targetCats[] = $catRemorque->id;
    } else {
        // Si on ne sait pas, on garde les catégories actuelles pour ne pas tout casser
        $targetCats = $product->categories->pluck('id')->toArray();
        if (empty($targetCats)) {
             $targetCats[] = $catRemorque->id; // Fallback par défaut si vraiment vide
        }
    }
    
    $product->categories()->sync($targetCats);
    
    // Mise à jour de la marque si manquante
    if (!$product->brand_id || $product->brand_id == 5) { // 5 = Remorques Industrie (par défaut)
        if (stripos($title, 'debon') !== false) {
            $product->brand_id = Brand::where('name', 'Debon')->first()->id;
        } elseif (stripos($title, 'trigano') !== false) {
            $product->brand_id = Brand::where('name', 'Trigano')->first()->id;
        } elseif (stripos($title, 'brenderup') !== false) {
            $product->brand_id = Brand::where('name', 'Brenderup')->first()->id;
        } elseif (stripos($title, 'erde') !== false) {
            $product->brand_id = Brand::where('name', 'Erde')->first()->id;
        }
        $product->save();
    }
    
    echo " - Mis à jour: " . $product->title . " -> Cats: " . $product->categories->pluck('name')->implode(', ') . "\n";
}

echo "\n--- TERMINÉ ---\n";
