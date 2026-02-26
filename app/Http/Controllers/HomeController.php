<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CompanyInfo;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $targetSlugs = [
            'trailers', 'accessoires-remorques', 
            'mowers', 'accessoires-tondeuses',
            'combustibles', 'accessoires-combustibles',
            'containers',
            'neue-container', 'besondere-bungalows', 'mobilheime', 
            'bungalows-mit-sanitaranlagen', 'lagerbehalter', 'sanitaranlagen'
        ];
        
        // Fetch all target categories in one query
        $categories = Category::whereIn('slug', $targetSlugs)->get()->keyBy('slug');
        
        $grouped_products = [
            'trailers' => collect(),
            'trailers_acc' => collect(),
            'mowers' => collect(),
            'mowers_acc' => collect(),
            'wood' => collect(),
            'wood_acc' => collect(),
            'containers' => collect(),
        ];

        foreach ($targetSlugs as $slug) {
            $category = $categories->get($slug);
            
            if ($category) {
                // Get this category's ID and all its children's IDs
                $categoryIds = $category->children()->pluck('id')->push($category->id);

                $products = Product::whereHas('categories', function($query) use ($categoryIds) {
                        $query->whereIn('categories.id', $categoryIds);
                    })
                    ->where('is_active', true)
                    ->with(['brand', 'media'])
                    ->latest('id')
                    ->get();

                $key = match($slug) {
                    'combustibles' => 'wood',
                    'accessoires-remorques' => 'trailers_acc',
                    'accessoires-tondeuses' => 'mowers_acc',
                    'accessoires-combustibles' => 'wood_acc',
                    'neue-container', 'besondere-bungalows', 'mobilheime', 
                    'bungalows-mit-sanitaranlagen', 'lagerbehalter', 'sanitaranlagen' => 'containers',
                    default => $slug
                };
                
                if (isset($grouped_products[$key])) {
                    $grouped_products[$key] = $grouped_products[$key]->merge($products);
                } else {
                    $grouped_products[$key] = $products;
                }
            }
        }

        // Best Sellers (Now showing latest products)
        $best_sellers = Product::where('is_active', true)
            ->with(['brand', 'media'])
            ->latest('id')
            ->limit(4)
            ->get();

        // Deal of the Week (Now showing latest product)
        $deal_product = Product::where('is_active', true)
            ->with(['brand', 'media'])
            ->latest('id')
            ->first();

        // Reviews (Dummy data for now, can be replaced with database model later)
        $reviews = collect([
            [
                'name' => 'Jean Dupont',
                'rating' => 5,
                'comment' => __('Service impeccable, livraison rapide et remorque de qualité.'),
                'date' => __('Il y a 2 jours')
            ],
            [
                'name' => 'Marie Martin',
                'rating' => 5,
                'comment' => __('Très satisfaite de ma commande de bois de chauffage. Je recommande !'),
                'date' => __('Il y a 1 semaine')
            ],
            [
                'name' => 'Pierre Durand',
                'rating' => 4,
                'comment' => __('Bon conseil pour le choix de ma tondeuse. Merci à l\'équipe.'),
                'date' => __('Il y a 2 semaines')
            ],
             [
                'name' => 'Sophie Lefebvre',
                'rating' => 5,
                'comment' => __('Excellent rapport qualité-prix pour le conteneur. Livraison sans souci.'),
                'date' => __('Il y a 3 semaines')
            ],
            [
                'name' => 'Thomas Muller',
                'rating' => 5,
                'comment' => __('Super service après-vente. Réactif et professionnel.'),
                'date' => __('Il y a 1 mois')
            ],
            [
                'name' => 'Lucie Bernard',
                'rating' => 5,
                'comment' => __('Produit conforme à mes attentes. Livraison très soignée.'),
                'date' => __('Il y a 1 mois')
            ],
            [
                'name' => 'Marc Petit',
                'rating' => 4,
                'comment' => __('Large choix d\'accessoires. Très bon accueil téléphonique.'),
                'date' => __('Il y a 2 mois')
            ],
            [
                'name' => 'Hélène Dubois',
                'rating' => 5,
                'comment' => __('Ma nouvelle tondeuse est parfaite. Merci pour les conseils !'),
                'date' => __('Il y a 2 mois')
            ],
        ]);

        return view('welcome', [
            'grouped_products' => $grouped_products,
            'best_sellers' => $best_sellers,
            'deal_product' => $deal_product,
            'reviews' => $reviews,
        ]);
    }
}
