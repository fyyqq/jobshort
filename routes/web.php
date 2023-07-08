<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChatifyController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FreelancerRegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServicesController;
use App\Models\Notification;

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

Auth::routes();
// Chatify::routes();

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Users Page
Route::get('user/{name:freelancer}', [ProfileController::class, 'user'])->name('users');
// Route::get('/{slug}', [HomeController::class, 'services']);

// Category Page
Route::get('/category/{slug}', [CategoriesController::class, 'show'])->name('categories');

// Notifications
Route::prefix('notifications')->group(function() {
    Route::get('/', [NotificationController::class, 'index'])->name('notification');
    Route::post('/read/{id}', [NotificationController::class, 'read'])->name('notification.read');
    Route::post('/unread/{id}', [NotificationController::class, 'unread'])->name('notification.read');
    Route::delete('/delete/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
});

// Chatify
Route::get('/chatify/{id}', [ChatifyController::class, 'index'])->name('chatify.user');;

// Payment
Route::post('/pay', [PaymentController::class, 'pay'])->name('pay');
Route::get('/success', [PaymentController::class, 'success'])->name('payment_success');
Route::get('/error', [PaymentController::class, 'error'])->name('payment_error');

// Wishlist
Route::post('/saved/{id}', [WishlistController::class, 'store'])->name('saved-service');
Route::delete('/unsaved/{id}', [WishlistController::class, 'unstore'])->name('unsaved-service');

// Freelancer Notification
Route::post('/notify/{user:id}/{freelancer:id}', [NotificationController::class, 'store']);
Route::delete('/disnotify/{user:id}/{freelancer:id}', [NotificationController::class, 'unstore']);

Route::prefix('orders')->middleware(['auth'])->group(function() {
    // Route::get('/{slug}', [OrdersController::class, 'show'])->name('apply-services');
    Route::post('/{service:id}/{freelancer:id}', [OrdersController::class, 'store'])->name('applied-services');
});

Route::prefix('services')->group(function() {
    Route::prefix('search')->group(function() {
        Route::get('/', [SearchController::class, 'index'])->name('search');
        Route::get('/latest-service/{value}', [SearchController::class, 'latestService']);
        Route::get('/oldest-service/{value}', [SearchController::class, 'oldestService']);
        Route::get('/highest-order/{value}', [SearchController::class, 'highestOrder']);
        Route::get('/lowest-order/{value}', [SearchController::class, 'lowestOrder']);
        Route::get('/highest-rating/{value}', [SearchController::class, 'highestRating']);
        Route::get('/lowest-rating/{value}', [SearchController::class, 'lowestRating']);
    });

    Route::get('/{slug}', [HomeController::class, 'showService'])->name('services');
    Route::get('/reviews/{slug}', [RatingController::class, 'index'])->name('reviews');
    Route::get('/payment/{slug}', [PaymentController::class, 'index'])->name('payment');
});

Route::prefix('account')->middleware(['auth'])->group(function() {
    Route::get('/', [ProfileController::class, 'account'])->name('my-account');
    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.main');
        Route::post('/registration', [ProfileController::class, 'store'])->name('profile.registration');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('profile.saved-services');
        Route::prefix('orders')->group(function() {
            Route::get('/', [ProfileController::class, 'applied'])->name('profile.applied');
            Route::get('/approved', [ProfileController::class, 'approved'])->name('profile.applied-approved');
            Route::get('/rejected', [ProfileController::class, 'rejected'])->name('profile.applied-rejected');
            Route::get('/completed', [ProfileController::class, 'completed'])->name('profile.applied-completed');
            Route::get('/status/{slug}', [ProfileController::class, 'status'])->name('profile.applied-status');
            Route::post('/reject/{id}', [OrdersController::class, 'reject']);
            Route::post('/complete/{id}', [OrdersController::class, 'complete'])->name('freelancer.applicant-complete');
            Route::post('/rating', [RatingController::class, 'store'])->name('freelancer.rating');
        });
    });
    Route::prefix('freelancer')->middleware(['freelancer'])->group(function() {
        Route::get('/', [FreelancerController::class, 'index'])->name('freelancer.main');
        Route::prefix('services')->group(function() {
            Route::get('/', [ServicesController::class, 'index'])->name('freelancer.services');
            Route::get('/edit/{slug}', [ServicesController::class, 'edit'])->name('freelancer.edit-services');
            Route::put('/update/{slug}', [ServicesController::class, 'update'])->name('freelancer.update-services');
            Route::put('/archive/{slug}', [ServicesController::class, 'updateArchive'])->name('freelancer.update-archive-services');
            Route::post('/archive-items', [ServicesController::class, 'archiveItems'])->name('freelancer.archive-item-services');
            Route::delete('/delete/{slug}', [ServicesController::class, 'destroy'])->name('freelancer.delete-services');
            Route::post('/delete-items', [ServicesController::class, 'deletedItems'])->name('freelancer.delete-item-services');
            Route::get('/live', [FreelancerController::class, 'live'])->name('freelancer.live-services');
            Route::get('/ongoing', [FreelancerController::class, 'ongoing'])->name('freelancer.on-services');
            Route::get('/complete', [FreelancerController::class, 'complete'])->name('freelancer.complete-services');
            Route::get('/archive', [FreelancerController::class, 'archive'])->name('freelancer.archive-services');
            // Filter
            Route::get('/sort-by-normal-price', [ServicesController::class, 'sortByNormal'])->name('freelancer.normal');
            Route::get('/sort-by-high-price', [ServicesController::class, 'sortByHighPrice'])->name('freelancer.filter-high-price');
            Route::get('/sort-by-low-price', [ServicesController::class, 'sortByLowPrice'])->name('freelancer.filter-low-price');
            // Filter OrderBy
            Route::get('/sort-by-oldest', [ServicesController::class, 'sortByOldest'])->name('freelancer.filter-oldest');
            Route::get('/sort-by-top-order', [ServicesController::class, 'sortByTopOrder'])->name('freelancer.filter-order');
            Route::get('/sort-by-top-rating', [ServicesController::class, 'sortByTopRating'])->name('freelancer.filter-rating');
            // Filter Search
            Route::get('/search', [ServicesController::class, 'searchServices'])->name('freelancer.search-services');
        });
        Route::get('/notification', [FreelancerController::class, 'notification'])->name('freelancer.notification');
        Route::prefix('profile')->group(function() {
            Route::get('/', [FreelancerController::class, 'profile'])->name('freelancer.profile');
            Route::put('/{id}', [FreelancerController::class, 'updateProfile'])->name('freelancer.profile-update');
            Route::prefix('address')->group(function() {
                Route::get('/', [FreelancerController::class, 'address'])->name('freelancer.profile-address');
                Route::put('/{id}', [FreelancerController::class, 'updateAddress'])->name('freelancer.address-update');
            });
        });
        Route::get('/add-service', [ServicesController::class, 'create'])->name('freelancer.create-service');
        Route::post('/add-service', [ServicesController::class, 'store'])->name('freelancer.post-service');

        Route::prefix('orders')->group(function() {
            Route::get('/', [OrdersController::class, 'index'])->name('freelancer.applicant');
            Route::get('/approved', [OrdersController::class, 'approved'])->name('freelancer.applicant-approved');
            Route::get('/rejected', [OrdersController::class, 'rejected'])->name('freelancer.applicant-rejected');
            Route::get('/completed', [OrdersController::class, 'completed'])->name('freelancer.applicant-completed');
            Route::post('/approve/{id}', [OrdersController::class, 'approve'])->name('freelancer.applicant-approve');
        });
    });
});

Route::prefix('freelancer_registration')->group(function() {
    Route::get('/', [FreelancerRegistrationController::class, 'index'])->name('freelancer.registration');
    Route::post('/', [FreelancerRegistrationController::class, 'store'])->name('freelancer.post-registration');
});

