<?php

use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages (no auth)
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/deneme', [PageController::class, 'trial'])->name('public.trial');
Route::get('/referanslar', [PageController::class, 'references'])->name('public.references');
Route::get('/iletisim', [PageController::class, 'contact'])->name('public.contact');

/*
|--------------------------------------------------------------------------
| Admin (auth)
|--------------------------------------------------------------------------
*/
// Breeze's post-login target: send everyone to the accounting page.
Route::redirect('/dashboard', '/accounting')->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('accounting/salary-multiplier', [AccountingController::class, 'saveSalaryMultiplier'])
        ->name('accounting.salary-multiplier');
    Route::resource('accounting', AccountingController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->parameters(['accounting' => 'entry']);

    Route::resource('materials', MaterialController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('companies', CompanyController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('projects', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('machines', MachineController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
