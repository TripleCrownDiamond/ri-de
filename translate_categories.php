<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

$mapping = [
    'Anhänger' => 'Remorques',
    'Rasenmäher' => 'Tondeuses',
    'Ausgebaute Container' => 'Conteneurs aménagés',
    'Kastenanhänger' => 'Remorques fourgons',
    'Gepäckanhänger' => 'Remorques bagagères',
    'Alle Teile & Zubehör' => 'Toutes pièces & accessoires',
    'Anhängerzubehör' => 'Accessoires remorques',
    'Rasenmäherzubehör' => 'Accessoires tondeuses',
    'Brennstoffzubehör' => 'Accessoires bois & pellets',
    'Brennstoffe' => 'Bois & pellets',
    'Sonstiges' => 'Divers',
];

foreach ($mapping as $de => $fr) {
    $categories = Category::where('name', $de)->get();
    foreach ($categories as $category) {
        $category->name_fr = $fr;
        $category->name_de = $de;
        $category->save();
        echo "Translated: {$de} -> {$fr}\n";
    }
}
echo "Done.\n";
