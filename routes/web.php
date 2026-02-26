<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Redirect root to default locale
Route::get('/', function () {
    return redirect('/de');
});

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'de|fr']], function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/boutique', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/categorie/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/produits/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/devis', [QuoteController::class, 'index'])->name('quote.index');
    Route::post('/devis', [QuoteController::class, 'store'])->name('quote.store');
    Route::get('/commander', [OrderController::class, 'index'])->name('order.index');
    Route::post('/commander', [OrderController::class, 'store'])->name('order.store');
    Route::get('/merci/{order}', [OrderController::class, 'thanks'])->name('order.thanks');

    Route::get('/page/{legalPage:slug}', [App\Http\Controllers\LegalPageController::class, 'show'])->name('legal.show');

    // User Orders
    Route::middleware('auth')->group(function () {
        Route::get('/mes-commandes', [OrderController::class, 'userOrders'])->name('orders.user');
    });

    // Test Email Route (Remove in production)
    Route::get('/test-email', function() {
        $adminEmail = \App\Models\CompanyInfo::first()?->email_contact ?? config('mail.from.address');
        try {
            \Illuminate\Support\Facades\Mail::raw('Ceci est un test de configuration email pour Remorques Industrie.', function($message) use ($adminEmail) {
                $message->to($adminEmail)->subject('Test Email - Remorques Industrie');
            });
            return "Email envoyé avec succès à " . $adminEmail;
        } catch (\Exception $e) {
            return "Erreur lors de l'envoi de l'email : " . $e->getMessage();
        }
    });

    // Admin Panel
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Products Management
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::post('products/{product}/media', [App\Http\Controllers\Admin\ProductController::class, 'addMedia'])->name('products.media.add');
        Route::delete('media/{media}', [App\Http\Controllers\Admin\ProductController::class, 'removeMedia'])->name('media.remove');
        
        // Categories & Brands
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);
        
        // Site Info & Legal
        Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::resource('legal-pages', App\Http\Controllers\Admin\LegalPageController::class);
    });
});

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard', ['locale' => app()->getLocale()]);
    }
    return redirect()->route('orders.user', ['locale' => app()->getLocale()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/test-email', function () {
    $adminEmail = \App\Models\CompanyInfo::first()?->email_contact ?? config('mail.from.address');
    $data = [
        'product' => 'Produit de Test',
        'qty' => 1,
        'name' => 'Testeur',
        'email' => 'test@example.com'
    ];
    
    try {
        \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\OrderNotification($data));
        return "Email envoyé avec succès à : " . $adminEmail;
    } catch (\Exception $e) {
        return "Erreur lors de l'envoi de l'email : " . $e->getMessage();
    }
})->middleware(['auth', 'admin']);
