<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

$categories = Category::all();
foreach ($categories as $category) {
    if (!$category->name_fr) {
        $category->name_fr = $category->name;
        $category->save();
        echo "Updated category: {$category->name}\n";
    }
}
echo "Done.\n";
