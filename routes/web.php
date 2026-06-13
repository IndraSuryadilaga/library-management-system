<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\FineController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog');
Route::get('/book/{book}', [PageController::class, 'showBook'])->name('show.book');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/loan/{book}', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan/{book}', [LoanController::class, 'store'])->name('loan.store');
});


// Admin Routes
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('authors', AuthorController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class);
    Route::resource('items', ItemController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('loans', AdminLoanController::class);
    Route::resource('fines', FineController::class);
});
