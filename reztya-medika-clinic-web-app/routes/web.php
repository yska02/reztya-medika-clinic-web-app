<?php

use App\Http\Controllers\BanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentReceiptController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirects
Route::permanentRedirect('/', '/home');
Route::permanentRedirect('/login', '/signin')->middleware('guest');
Route::permanentRedirect('/logout', '/home')->middleware(['auth', 'verified', 'clear']);

Route::group(['middleware' => 'prevent-back-history'], function() {
    // Start Group cannot back //
    // Home
    Route::get('/home', [HomeController::class, 'home']);

    // About Us
    Route::get('/about-us', [HomeController::class, 'aboutUs']);

    Route::get('/active-order', function () {
        return view('active-order');
    })->middleware(['auth', 'verified', 'clear']);

    Route::get('/payment-receipt-form', function () {
        return view('payment-receipt-form');
    })->middleware(['auth', 'verified', 'clear']);

    // Sign Up
    Route::get('/signup', [SignUpController::class, 'signUp'])->middleware('guest');
    Route::post('/signup', [SignUpController::class, 'userRegister']);

    Route::get('/email/verify', function () {
        return view('email.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link verifikasi telah dikirim!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // Sign In
    Route::get('/signin', function () {
        return view('users.signin');
    })->middleware('guest')->name('login');
    Route::post('/signin', [SignInController::class, 'userLogin']);

    // Sign Out
    Route::post('/signout', [SignInController::class, 'userLogout'])->middleware('auth');

    // View Profile
    Route::get('/view-profile/{username}', [ProfileController::class, 'viewProfile'])->middleware(['auth', 'verified', 'clear']);

    // Edit Profile
    Route::get('/edit-profile/{username}', [ProfileController::class, 'viewEditProfile'])->middleware(['auth', 'verified', 'clear']);
    Route::post('/edit-profile/{username}', [ProfileController::class, 'editProfile'])->middleware(['auth', 'verified', 'clear']);

    // Change Password
    Route::post('/change-password/{username}', [ProfileController::class, 'changePassword'])->middleware(['auth', 'verified', 'clear']);

    // Reset Password
    Route::get('/reset-password', function () {
        return view('users.reset_password');
    })->middleware('guest');
    Route::post('/reset-password', [ProfileController::class, 'resetPassword'])->middleware('guest');

    // Products
    Route::get('/view-products', [ProductController::class, 'view']);
    Route::get('/manage-products', [ProductController::class, 'index'])->middleware('admin');
    Route::get('/product-detail/{id}', [ProductController::class, 'show']);
    Route::post('/delete-product/{id}', [ProductController::class, 'destroy'])->middleware('admin');
    Route::get('/add-product', [ProductController::class, 'create'])->middleware('admin');
    Route::post('/store-product', [ProductController::class, 'store'])->middleware('admin');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->middleware('admin');
    Route::put('/update-product/{id}', [ProductController::class, 'update'])->middleware('admin');
    Route::get('/view-products/search-product', [ProductController::class, 'search']);
    Route::get('/view-products/filter/name/a-to-z', [ProductController::class, 'filterAtoZ']);
    Route::get('/view-products/filter/name/z-to-a', [ProductController::class, 'filterZtoA']);
    Route::get('/view-products/filter/price/high-to-low', [ProductController::class, 'filterPriceHightoLow']);
    Route::get('/view-products/filter/price/low-to-high', [ProductController::class, 'filterPriceLowtoHigh']);
    Route::get('/view-products/filter/category/{category_name}', [ProductController::class, 'filterCategory']);


    // Services
    Route::get('/view-services', [ServiceController::class, 'view']);
    Route::get('/manage-services', [ServiceController::class, 'index'])->middleware('admin');
    Route::get('/service-detail/{id}', [ServiceController::class, 'show']);
    Route::post('/delete-service/{id}', [ServiceController::class, 'destroy'])->middleware('admin');
    Route::get('/add-service', [ServiceController::class, 'create'])->middleware('admin');
    Route::post('/store-service', [ServiceController::class, 'store'])->middleware('admin');
    Route::get('/edit-service/{id}', [ServiceController::class, 'edit'])->middleware('admin');
    Route::put('/update-service/{id}', [ServiceController::class, 'update'])->middleware('admin');
    Route::get('/view-services/search-services', [ServiceController::class, 'search']);
    Route::get('/view-services/filter/name/a-to-z', [ServiceController::class, 'filterAtoZ']);
    Route::get('/view-services/filter/name/z-to-a', [ServiceController::class, 'filterZtoA']);
    Route::get('/view-services/filter/price/high-to-low', [ServiceController::class, 'filterPriceHightoLow']);
    Route::get('/view-services/filter/price/low-to-high', [ServiceController::class, 'filterPriceLowtoHigh']);
    Route::get('/view-services/filter/category/{category_name}', [ServiceController::class, 'filterCategory']);

    // Schedules
    Route::get('/manage-schedules', [ScheduleController::class, 'index'])->middleware('admin');
    Route::get('/add-schedule', [ScheduleController::class, 'add'])->middleware('admin');
    Route::post('/add-schedule', [ScheduleController::class, 'store'])->middleware('admin');
    Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit'])->middleware('admin');
    Route::post('/update-schedule/{id}', [ScheduleController::class, 'update'])->middleware('admin');
    Route::get('/delete-schedule/{id}', [ScheduleController::class, 'delete'])->middleware('admin');

    // Ban and Unban User
    Route::get('/view-users', [BanController::class, 'viewUsers'])->middleware('admin');
    Route::post('/ban-user/{username}', [BanController::class, 'banUser'])->middleware('admin');
    Route::post('/unban-user/{username}', [BanController::class, 'unbanUser'])->middleware('admin');

    // Category
    Route::get('/manage-categories', [CategoryController::class, 'index'])->middleware('admin');
    Route::post('/delete-category/{id}', [CategoryController::class, 'destroy'])->middleware('admin');
    Route::get('/add-category', [CategoryController::class, 'create'])->middleware('admin');
    Route::post('/store-category', [CategoryController::class, 'store'])->middleware('admin');
    Route::get('/edit-category/{id}', [CategoryController::class, 'edit'])->middleware('admin');
    Route::put('/update-category/{id}', [CategoryController::class, 'update'])->middleware('admin');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->middleware(['auth', 'verified', 'clear']);
    Route::post('/buy-product', [CartController::class, 'buyProduct'])->middleware(['auth', 'verified', 'clear']);
    Route::post('/book-service', [CartController::class, 'bookService'])->middleware(['auth', 'verified', 'clear']);
    Route::put('/update-schedule/{id}', [CartController::class, 'updateCartSchedule'])->middleware(['auth', 'verified', 'clear']);
    Route::put('/update-quantity/{id}', [CartController::class, 'updateCartQuantity'])->middleware(['auth', 'verified', 'clear']);
    Route::get('/remove-cart/{id}', [CartController::class, 'removeCart'])->middleware(['auth', 'verified', 'clear']);

    //Order
    Route::get('/order/{status}', [OrderController::class, 'statusFilter'])->middleware(['auth', 'verified', 'clear']);
    Route::get('/create-order', [OrderController::class, 'createOrderWithoutProduct'])->middleware(['auth', 'verified', 'clear']);
    Route::post('/create-order', [OrderController::class, 'create'])->middleware(['auth', 'verified', 'clear']);
    Route::get('/active-order', [OrderController::class, 'activeOrder'])->middleware(['auth', 'verified', 'clear']);
    Route::get('/cancel-order/{id}', [OrderController::class, 'cancelOrder'])->middleware(['auth', 'verified', 'clear']);
    Route::get('/history-order', [OrderController::class, 'historyOrder'])->middleware(['auth', 'verified', 'clear']);
    Route::get('/repeat-order/{id}', [OrderController::class, 'repeatOrder'])->middleware(['auth', 'verified', 'clear']);

    //Order Detail
    Route::get('/order-detail/{id}', [OrderDetailController::class, 'detailOrder'])->name('detail_order')->middleware(['auth', 'verified', 'clear']);
    Route::put('/reschedule/{id}', [OrderDetailController::class, 'reschedule'])->middleware(['auth', 'verified', 'clear']);

    //Payment Receipt
    Route::put('/upload-transfer-receipt/{id}', [PaymentReceiptController::class, 'uploadTransferReceipt'])->middleware(['auth', 'verified', 'clear']);
    Route::post('/add-payment-receipt/{id}', [PaymentReceiptController::class, 'addPaymentReceipt'])->middleware('admin');
    Route::get('/form-payment-receipt/{id}', [PaymentReceiptController::class, 'formPaymentReceipt'])->name('form_payment')->middleware('admin');
    Route::post('/upsert-payment-receipt/{id}', [PaymentReceiptController::class, 'upsertPaymentReceipt'])->middleware('admin');

    // Review
    Route::post('/order-detail/{order_id}/add-clinic-review', [FeedbackController::class, 'addClinicFeedback'])->middleware(['auth', 'verified', 'clear']);
});
