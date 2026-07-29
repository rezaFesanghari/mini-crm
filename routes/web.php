<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Customers\Show as CustomersShow;
use App\Livewire\Companies\Index as CompaniesIndex;
use App\Livewire\Companies\Show as CompaniesShow;
use App\Livewire\Deals\Index as DealsIndex;
use App\Livewire\Tasks\Index as TasksIndex;
use App\Livewire\Dashboard;


Route::view('/', 'welcome');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/customers', CustomersIndex::class)->name('customers.index');
        Route::get('/customers/{customer}', CustomersShow::class)->name('customers.show');

        Route::get('/companies', CompaniesIndex::class)->name('companies.index');
        Route::get('/companies/{company}', CompaniesShow::class)->name('companies.show');

        Route::get('/deals', DealsIndex::class)->name('deals.index');

        Route::get('/tasks', TasksIndex::class)->name('tasks.index');

    });

require __DIR__.'/auth.php';
