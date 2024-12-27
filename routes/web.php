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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;


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
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/newspaper/{id}', [ProductController::class, 'detail'])->name('koran.detail');
Route::get('/newspaper/{productId}/{koranId}', [ProductController::class, 'detailKoran'])->name('detailKoran');


Route::controller(AuthController::class)->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('register', 'register')->name('register');
        Route::post('register', 'registerSave')->name('register.save');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'loginAction')->name('login.action');
    });
    Route::get('/', 'home')->name('homepage');
    Route::get('/newspaper', 'home')->name('newspaper');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

//Notifikasi Admin
Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin/notifications');


//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [UserController::class, 'userprofile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateprofile'])->name('profile/update');
    Route::get('/langganan', [HomeController::class, 'langganan'])->name('user.langganan');
    //keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add-product', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/apply-promo', [CartController::class, 'applyPromo'])->name('cart.applyPromo');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/remove-promo', [CartController::class, 'removePromo'])->name('cart.removePromo');
    Route::get('/generate-invoice', [CartController::class, 'generateInvoice'])->name('invoice.generate');
    Route::post('/payment-handler', [PaymentController::class, 'payment_handler'])->name('payment.handler');
    Route::get('/payment', [PaymentController::class, 'payment']);
    Route::post('/payment', [PaymentController::class, 'payment_post']);
    Route::get('/payment/manual', [PaymentController::class, 'manualPayment'])->name('payment.manual');
    Route::post('/payment/manual/submit', [PaymentController::class, 'submitManualPayment'])->name('payment.manual.submit');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
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
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');
    Route::post('/admin/profile/update', [AdminController::class, 'updateprofile'])->name('admin/profile/update');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin/AdminHome');
    Route::get('/admin/koran', [AdminController::class, 'adminkoran'])->name('admin.koran');
    Route::prefix('admin')->group(function () {
        Route::get('korans/create', [AdminController::class, 'createKoran'])->name('admin.korans.create');
        Route::post('korans', [AdminController::class, 'storeKoran'])->name('admin.korans.store');
        Route::get('korans/{koran}', [AdminController::class, 'showKoran'])->name('admin.korans.show');
        Route::get('korans/{koran}/edit', [AdminController::class, 'editKoran'])->name('admin.korans.edit');
        Route::put('korans/{koran}', [AdminController::class, 'updateKoran'])->name('admin.korans.update');
        Route::delete('korans/{koran}', [AdminController::class, 'destroyKoran'])->name('admin.korans.destroy');
    });


    //admin products
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin/products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin/products/create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin/products/store');
    Route::get('/admin/products/show/{id}', [ProductController::class, 'show'])->name('admin/products/show');
    Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    Route::put('/admin/products/edit/{id}', [ProductController::class, 'update'])->name('admin/products/update');


    Route::delete('/admin/products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin/products/destroy');
});
