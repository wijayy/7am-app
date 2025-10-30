<?php

use App\Http\Controllers\ApiTestController;
use App\Http\Controllers\JurnalAuthController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Volt::route('/', 'home')->name('home');
Volt::route('outlets/{slug}', 'outlet-show')->name('outlet-show');
Volt::route('reservation', 'reservation-create')->name('reservation');
Volt::route('loyality-card', 'loyality-home')->name('loyality.home');


Route::middleware(['auth'])->group(function () {
    Volt::route('dashboard', 'dashboard')
        ->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Volt::route('reservation/', 'reservation-index')->name('reservation.index');
    Volt::route('reservation/make', 'reservation-create')->name('reservation.create');
    Volt::route('reservation/history', 'reservation.history')->name('reservation.history');

    Volt::route('set-categories', 'set-category-index')->name('setcategory.index');

    Volt::route('members', 'member-index')->name('member.index');
    Volt::route('members/{slug}', 'member-show')->name('member.show');

    Volt::route('types', 'type-index')->name('type.index');
    Volt::route('cards', 'card-index')->name('card.index');

    Volt::route('redeem-reward', 'redeem-index')->name('redeem.index');

    Volt::route('settings/profile', 'profile')->name('settings.profile');
    Volt::route('settings/bussiness-info', 'bussiness-info')->name('settings.bussiness-info');
    Volt::route('settings/address', 'address')->name('settings.address');
    Volt::route('settings/password', 'password')->name('settings.password');
    Volt::route('settings/appearance', 'appearence')->name('settings.appearance');
});

Route::prefix('b2b')->group(function () {
    Volt::route('/', 'b2b-home')->name('b2b-home');
    Volt::route('contact', 'contact')->name('contact');

    Volt::route('shop', 'shop-index')->name('shop.index');
    Volt::route('shop/{slug}', 'shop-show')->name('shop.show');

    Volt::route('wholesale', 'wholesale-index')->name('wholesale.index');
});

Route::prefix('b2b')->middleware(['auth'])->group(function () {
    Volt::route('products', 'product-index')->name('product.index');
    Volt::route('products/add', 'product-create')->name('product.create');
    Volt::route('products/{slug}/edit', 'product-create')->name('product.edit');

    Volt::route('coupons', 'coupon-index')->name('coupon.index');
    Volt::route('coupons/add', 'coupon-create')->name('coupon.create');
    Volt::route('coupons/{slug}/edit', 'coupon-create')->name('coupon.edit');

    Volt::route('transaction', 'transaction-index')->name('transaction.index');

    Volt::route('cart', 'cart')->name('cart');
    Volt::route('checkout', 'checkout')->name('checkout');
    Volt::route('payment', 'payment')->name('payment');
    Volt::route('history', 'history')->name('history');
    Volt::route('invoice/{slug}', 'invoice')->name('invoice');
    Volt::route('checkout/{slug}/pay', 'payment')->name('payment');

    Volt::route('categories', 'category-index')->name('category.index');
    Volt::route('categories/add', 'category-create')->name('category.create');
    Volt::route('categories/{slug}/edit', 'category-create')->name('category.edit');

    Volt::route('set-category', 'set-category-index')->name('set-category.index');

    Volt::route('newsletters', 'newsletter-index')->name('newsletter.index');
    Volt::route('newsletters/add', 'newsletter-create')->name('newsletter.create');
    Volt::route('newsletters/{slug}/edit', 'newsletter-create')->name('newsletter.edit');

    Volt::route('businesses', 'business-index')->name('business.index');

    Volt::route('tests/jurnal', 'test.jurnal')->name('test.jurnal');

    route::get('/jurnal/test', [ApiTestController::class, 'index'])->name('jurnal.tests');
});

require __DIR__ . '/auth.php';
