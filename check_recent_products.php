<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Product;

$products = Product::with('categories')->latest()->limit(5)->get();
$data = $products->map(function($p) {
    return [
        'title' => $p->title,
        'categories' => $p->categories->pluck('slug')->toArray(),
        'is_active' => $p->is_active
    ];
});
echo json_encode($data);
