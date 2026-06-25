<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 

    
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');


    Route::get('/savings', [SavingController::class, 'index'])->name('savings.index');
    Route::post('/savings', [SavingController::class, 'create'])->name('savings.create'); 
    Route::post('/savings', [SavingController::class, 'store'])->name('savings.store');
 
    Route::get('/credits', [CreditController::class, 'index'])->name('credits.index');
    Route::post('/credits', [CreditController::class, 'store'])->name('credits.store');
    Route::put('/credits/{credit}', [CreditController::class, 'update'])->name('credits.update');
    
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');

    
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
});

require __DIR__.'/auth.php';
