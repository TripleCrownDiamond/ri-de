<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Category;

$categories = Category::all(['id', 'name', 'slug', 'parent_id']);
echo json_encode($categories);
