<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Customers\Show as CustomersShow;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware(['auth'])->group(function () {
    Route::get('/customers', CustomersIndex::class)->name('customers.index');
        Route::get('/customers/{customer}', CustomersShow::class)->name('customers.show');
    });

require __DIR__.'/auth.php';
