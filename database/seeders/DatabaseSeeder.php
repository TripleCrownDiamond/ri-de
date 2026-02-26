<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CompanyInfo;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CompanyInfo::query()->updateOrCreate(
            ['siren' => '123456789'],
            [
                'nom' => 'Remorques Industrie',
                'siret' => '12345678900010',
                'numero_tva' => 'FR12 123 456 789',
                'date_creation' => '2009-01-01',
                'activite_naf_ape' => '4520A',
                'forme_juridique' => 'SARL',
                'adresse_siege' => '12 Rue des Remorques, 87000 Limoges, France',
                'dirigeants' => [
                    ['nom' => 'Dupont', 'prenom' => 'Jean', 'fonction' => 'Gérant'],
                ],
                'telephone' => '+33 5 55 00 00 00',
                'email_contact' => 'contact@remorques-industrie.fr',
                'rcs_ville' => 'RCS Limoges',
                'capital_social' => 10000.00,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        $this->seedCatalog();
    }

    protected function seedCatalog(): void
    {
        $brands = [
            'Gourdon',
            'Lider',
            'Staub',
            'Husqvarna',
        ];

        $brandModels = [];

        foreach ($brands as $name) {
            $brandModels[$name] = Brand::firstOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name]
            );
        }

        $categories = [
            'trailers' => 'Remorques',
            'mowers' => 'Tondeuses & robots',
            'wood' => 'Bois & pellets',
            'containers' => 'Conteneurs aménagés',
        ];

        $categoryModels = [];

        $position = 1;

        foreach ($categories as $slug => $name) {
            $categoryModels[$slug] = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'position' => $position++]
            );
        }

        $products = [
            [
                'title' => 'Remorque benne 1,5T simple essieu',
                'slug' => 'remorque-benne-1-5t-simple-essieu',
                'description' => 'Remorque benne basculante idéale pour artisans, paysagistes et collectivités.',
                'brand' => 'Gourdon',
                'price_ht' => 1990.00,
                'price_ttc' => 2388.00,
                'ean' => '3456789012345',
                'poids_kg' => 480,
                'dimensions' => ['longueur_cm' => 260, 'largeur_cm' => 150],
                'sku' => 'REM-BENNE-1500-GOU',
                'categories' => ['trailers'],
            ],
            [
                'title' => 'Remorque fourgon fermée 1300 kg',
                'slug' => 'remorque-fourgon-fermee-1300',
                'description' => 'Fourgon fermé sécurisé pour matériel, outillage ou marchandises sensibles.',
                'brand' => 'Lider',
                'price_ht' => 2490.00,
                'price_ttc' => 2988.00,
                'ean' => '3567890123456',
                'poids_kg' => 520,
                'dimensions' => ['longueur_cm' => 300, 'largeur_cm' => 160],
                'sku' => 'REM-FOURGON-1300-LID',
                'categories' => ['trailers'],
            ],
            [
                'title' => 'Tondeuse thermique 53 cm traction',
                'slug' => 'tondeuse-thermique-53cm-traction',
                'description' => 'Tondeuse thermique tractée pour grandes surfaces résidentielles.',
                'brand' => 'Staub',
                'price_ht' => 649.00,
                'price_ttc' => 778.80,
                'ean' => '4000000000001',
                'poids_kg' => 45,
                'dimensions' => ['largeur_coupe_cm' => 53],
                'sku' => 'TOND-THERM-53-STA',
                'categories' => ['mowers'],
            ],
            [
                'title' => 'Robot de tonte résidentiel 1 000 m²',
                'slug' => 'robot-tonte-residentiel-1000',
                'description' => 'Robot de tonte connecté pour jardins jusqu’à 1 000 m².',
                'brand' => 'Husqvarna',
                'price_ht' => 1499.00,
                'price_ttc' => 1798.80,
                'ean' => null,
                'poids_kg' => 12.5,
                'dimensions' => ['surface_max_m2' => 1000],
                'sku' => 'ROBOT-1000-HUSQ',
                'categories' => ['mowers'],
            ],
            [
                'title' => 'Palette de granulés de bois premium',
                'slug' => 'palette-granules-bois-premium',
                'description' => 'Palette de granulés certifiés ENplus, fort pouvoir calorifique.',
                'brand' => 'Remorques Industrie',
                'price_ht' => 399.00,
                'price_ttc' => 478.80,
                'ean' => '5900000000002',
                'poids_kg' => 975,
                'dimensions' => ['nombre_sacs' => 65],
                'sku' => 'PELLET-PALETTE-RI',
                'categories' => ['wood'],
            ],
            [
                'title' => 'Conteneur stockage 20 pieds',
                'slug' => 'conteneur-stockage-20pieds',
                'description' => 'Conteneur maritime transformé pour le stockage sécurisé sur site.',
                'brand' => 'Remorques Industrie',
                'price_ht' => null,
                'price_ttc' => null,
                'ean' => null,
                'poids_kg' => 2200,
                'dimensions' => ['longueur_m' => 6.0, 'largeur_m' => 2.4],
                'sku' => 'CONT-20P-STOCK',
                'categories' => ['containers'],
            ],
        ];

        $mediaBySlug = [
            'remorque-benne-1-5t-simple-essieu' => [
                'img/slides/slide1-remorques/remorque-fermee.webp',
                'img/slides/slide1-remorques/remorque-fixe-derriere-vehicule.webp',
                'img/slides/slide1-remorques/remorque-fermee-fixe-derriere-vehicule.webp',
            ],
            'remorque-fourgon-fermee-1300' => [
                'img/slides/slide1-remorques/remorque-fermee-fixe-derriere-vehicule.webp',
                'img/remorque-gourdon-paysage.webp',
                'img/remorque-fermee.webp',
            ],
            'tondeuse-thermique-53cm-traction' => [
                'img/slides/slide2-tondeuses/image-tondeuse-3.webp',
                'img/slides/slide2-tondeuses/tondeuse-image-2.webp',
                'img/tondeuse-paysage.webp',
            ],
            'robot-tonte-residentiel-1000' => [
                'img/slides/slide2-tondeuses/tondeuse-robot.webp',
                'img/tondeuse-robot.webp',
                'img/slides/slide2-tondeuses/image-tondeuse-3.webp',
            ],
            'palette-granules-bois-premium' => [
                'img/slides/slide4-bois/granules-bois.webp',
                'img/slides/slide4-bois/granule-ou-pellet.webp',
                'img/slides/slide4-bois/quelles-sont-les-idees-recues-sur-les-granules-de-bois.webp',
            ],
            'conteneur-stockage-20pieds' => [
                'img/slides/slide3-conteneurs/conteneur-aménagé.webp',
                'img/slides/slide3-conteneurs/conteneur1.webp',
                'img/slides/slide3-conteneurs/conteneur2.webp',
            ],
        ];

        foreach ($products as $data) {
            $brandName = $data['brand'];

            $brand = $brandModels[$brandName] ?? Brand::firstOrCreate(
                ['slug' => str($brandName)->slug()],
                ['name' => $brandName]
            );

            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'brand_id' => $brand->id,
                    'price_ht' => $data['price_ht'],
                    'price_ttc' => $data['price_ttc'],
                    'ean' => $data['ean'],
                    'poids_kg' => $data['poids_kg'],
                    'dimensions' => $data['dimensions'],
                    'sku' => $data['sku'],
                    'extra_attributes' => [],
                    'is_active' => true,
                ]
            );

            if (! empty($data['categories'])) {
                $ids = [];

                foreach ($data['categories'] as $slug) {
                    if (isset($categoryModels[$slug])) {
                        $ids[] = $categoryModels[$slug]->id;
                    }
                }

                if ($ids) {
                    $product->categories()->sync($ids);
                }
            }

            if (isset($mediaBySlug[$data['slug']])) {
                ProductMedia::where('product_id', $product->id)->delete();

                foreach ($mediaBySlug[$data['slug']] as $index => $path) {
                    ProductMedia::create([
                        'product_id' => $product->id,
                        'type' => 'image',
                        'path' => $path,
                        'title' => $product->title,
                        'position' => $index + 1,
                        'is_primary' => $index === 0,
                    ]);
                }
            }
        }
    }
}
