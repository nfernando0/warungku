<?php

use App\Http\Middleware\IsAdmin;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome')->name('homepage');

Route::middleware(['auth', 'verified', IsAdmin::class])->prefix('dashboard')->group(function () {
    Route::get('', function () {
        return view('dashboard', [
            'todayEarnings' => Transaction::whereDate('created_at', today())->where('status', 'completed')->sum('total'),
            'todayTransactionsCount' => Transaction::whereDate('created_at', today())->where('status', 'completed')->count(),
            'totalProductsCount' => Product::count(),
            'lowStockProductsCount' => Product::where('stock', '<=', 5)->count(),
            'recentTransactions' => Transaction::where('status', 'completed')->latest()->take(5)->get(),
        ]);
    })->name('dashboard');
    Route::get('category', App\Livewire\Category\Index::class)->name('category.index');
    Route::get('category/create', App\Livewire\Category\Create::class)->name('category.create');

    Route::get('product', App\Livewire\Product\Index::class)->name('product.index');
    Route::get('product/create', App\Livewire\Product\Create::class)->name('product.create');

    Route::get('transaction', App\Livewire\Transaction\Index::class)->name('transaction.index');
    Route::get('users', App\Livewire\User\Index::class)->name('user.index');
});

Route::get('', App\Livewire\Home\Index::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('profile', App\Livewire\Profile\Index::class)->name('profile.index');
    Route::get('pesanan', App\Livewire\Pesanan\Index::class)->name('pesanan.index');
});

Route::middleware(['auth'])->group(function () {
    // Route Halaman Kasir / POS
    Route::get('/kasir', App\Livewire\Kasir\Index::class)->name('kasir.index');
});

require __DIR__ . '/settings.php';
