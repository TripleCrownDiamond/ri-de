<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Product;
use App\Models\Category;

$counts = [];
foreach (['trailers', 'mowers', 'combustibles', 'containers'] as $slug) {
    $cat = Category::where('slug', $slug)->first();
    if ($cat) {
        $counts[$slug] = $cat->products()->where('is_active', true)->count();
    } else {
        $counts[$slug] = 'category not found';
    }
}
echo json_encode($counts);
