<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;


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

// Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('/', 'home')->name('homepage');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

//Notifikasi Admin
Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin/notifications');


//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [UserController::class, 'userprofile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateprofile'])->name('profile/update');
    Route::get('/langganan', [HomeController::class, 'langganan'])->name('user.langganan');
    Route::get('/products/{id}', [ProductController::class, 'detail'])->name('cart.detail');

    //keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/detail/{id}', [ProductController::class, 'detail'])->name('cart.detail');
    Route::post('/cart/add-product', [CartController::class, 'addProduct'])->name('cart.addProduct');
    Route::post('/cart/add-koran', [CartController::class, 'addKoran'])->name('cart.addKoran');
    Route::delete('/cart/remove-product', [CartController::class, 'removeProduct'])->name('cart.removeProduct');
    Route::delete('/cart/remove-koran', [CartController::class, 'removeKoran'])->name('cart.removeKoran');

    Route::get('/cart/{step}', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/cart/save-shipping', [CartController::class, 'saveShipping'])->name('checkout.saveShipping');
    Route::post('/cart/process-payment', [CartController::class, 'processPayment'])->name('checkout.processPayment');
});

//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    //admin loan management
    Route::post('/borrow-book', [LoanController::class, 'borrowBook'])->name('admin.loans.borrow');
    Route::post('/return-book/{loanId}', [LoanController::class, 'returnBook'])->name('admin.loans.return');
    Route::get('/loans', [LoanController::class, 'index'])->name('admin.loans.index');
    Route::get('/payments', [LoanController::class, 'showPayments'])->name('admin.payments.index');

    Route::get('/admin/langganan', [DashboardController::class, 'index'])->name('langganan');

    //admin Home & profile
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');
    Route::post('/admin/profile/update', [AdminController::class, 'updateprofile'])->name('admin/profile/update');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin/dashboard');

    //admin products
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin/products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin/products/create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin/products/store');
    Route::get('/admin/products/show/{id}', [ProductController::class, 'show'])->name('admin/products/show');
    Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    Route::put('/admin/products/edit/{id}', [ProductController::class, 'update'])->name('admin/products/update');


    Route::delete('/admin/products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin/products/destroy');
});
