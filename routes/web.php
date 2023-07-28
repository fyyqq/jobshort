<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FreelancerRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Users Page
Route::prefix('user')->group(function() {
    Route::get('/{name:freelancer}', [HomeController::class, 'user'])->name('users');
    Route::get('/{name:freelancer}/filter-category/{service:category}', [HomeController::class, 'sortCategory']);
    Route::get('/{name:freelancer}/sort-by/{type}', [HomeController::class, 'sortFilter']);
});

// Category Page
Route::prefix('categories')->group(function() {
    Route::get('/', [CategoryController::class, 'index'])->name('categories');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('category');
    Route::get('/{slug}/sort-by/{type}', [CategoryController::class, 'filter']);
});

// Notifications
Route::prefix('notifications')->middleware('auth')->group(function() {
    Route::get('/', [NotificationController::class, 'index'])->name('notification');
    Route::get('/inbox', [NotificationController::class, 'inbox'])->name('notification.inbox');
    Route::get('/read', [NotificationController::class, 'read'])->name('notification.read');
    Route::get('/unread', [NotificationController::class, 'unread'])->name('notification.unread');
    Route::post('/read/{id}', [NotificationController::class, 'readMessage']);
    Route::post('/unread/{id}', [NotificationController::class, 'unreadMessage']);
    Route::delete('/delete/{id}', [NotificationController::class, 'destroy']);
});

// Wishlist
Route::post('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist-service');
Route::delete('/unwishlist/{id}', [WishlistController::class, 'unstore'])->name('unwishlist-service');

// Notification Post
Route::post('/notify/{user:id}/{freelancer:id}', [NotificationController::class, 'store']);
Route::delete('/disnotify/{user:id}/{freelancer:id}', [NotificationController::class, 'unstore']);

Route::prefix('orders')->middleware('auth')->group(function() {
    Route::get('/success/{slug}', [PaymentController::class, 'pages'])->name('order.success');
});

Route::prefix('services')->group(function() {
    Route::prefix('search')->group(function() {
        Route::get('/', [SearchController::class, 'index'])->name('search');
        Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
        Route::get('/{value}/sort-by/{type}', [SearchController::class, 'filterSearch']);
        Route::get('/reset/{value}', [SearchController::class, 'reset']);
    });
    // Show Service Detail
    Route::get('/{slug}', [HomeController::class, 'show'])->name('services');
    // Make Service Payment
    Route::post('/session/{slug}', [PaymentController::class, 'session'])->middleware('auth')->name('session');
    Route::get('/success/{slug}', [PaymentController::class, 'success'])->middleware('auth')->name('success');
    Route::get('/cancel/{slug}', [PaymentController::class, 'cancel'])->middleware('auth')->name('cancel');
    // Show Service Review
    Route::get('/reviews/{slug}', [RatingController::class, 'index'])->name('reviews');
});

Route::prefix('account')->middleware(['auth'])->group(function() {
    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.main');
        Route::post('/registration', [ProfileController::class, 'store'])->name('profile.registration');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('profile.saved-services');
        Route::prefix('orders')->group(function() {
            Route::get('/', [ProfileController::class, 'order'])->name('profile.order');
            Route::get('/pending', [ProfileController::class, 'pending'])->name('profile.order-pending');
            Route::get('/approved', [ProfileController::class, 'approved'])->name('profile.order-approved');
            Route::get('/rejected', [ProfileController::class, 'rejected'])->name('profile.order-rejected');
            Route::get('/completed', [ProfileController::class, 'completed'])->name('profile.order-completed');
            Route::post('/reject/{id}', [OrdersController::class, 'reject']);
            Route::post('/complete/{id}', [OrdersController::class, 'complete']);
            Route::post('/rating', [RatingController::class, 'store'])->name('profile.rating');
        });
    });
    Route::prefix('freelancer')->middleware(['freelancer'])->group(function() {
        Route::get('/', [FreelancerController::class, 'index'])->name('freelancer.main');
        Route::prefix('services')->group(function() {
            Route::get('/', [ServicesController::class, 'index'])->name('freelancer.services');
            Route::get('/all', [ServicesController::class, 'all'])->name('freelancer.services-all');
            Route::get('/archive', [ServicesController::class, 'archive'])->name('freelancer.services-archive');
            Route::get('/edit/{slug}', [ServicesController::class, 'edit'])->name('freelancer.edit-services');
            Route::put('/update/{slug}', [ServicesController::class, 'update'])->name('freelancer.update-services');
            Route::put('/active/{slug}', [ServicesController::class, 'updateActive'])->name('freelancer.update-active-services');
            Route::post('/active-items', [ServicesController::class, 'activeItems'])->name('freelancer.active-item-services');
            Route::put('/archive/{slug}', [ServicesController::class, 'updateArchive'])->name('freelancer.update-archive-services');
            Route::post('/archive-items', [ServicesController::class, 'archiveItems'])->name('freelancer.archive-item-services');
            Route::delete('/delete/{slug}', [ServicesController::class, 'destroy'])->name('freelancer.delete-services');
            Route::post('/delete-items', [ServicesController::class, 'deletedItems'])->name('freelancer.delete-item-services');
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
        Route::prefix('notifications')->group(function() {
            Route::get('/', [FreelancerController::class, 'notification'])->name('freelancer.notification');
            Route::get('/inbox', [FreelancerController::class, 'inboxNotification'])->name('freelancer.notification-inbox');
            Route::get('/orders', [FreelancerController::class, 'orderNotification'])->name('freelancer.notification-order');
            Route::get('/rating', [FreelancerController::class, 'reviewNotification'])->name('freelancer.notification-rating');
        });
        Route::prefix('profile')->group(function() {
            Route::get('/', [FreelancerController::class, 'profile'])->name('freelancer.profile');
            Route::put('/{id}', [FreelancerController::class, 'update'])->name('freelancer.profile-update');
            Route::prefix('address')->group(function() {
                Route::get('/', [FreelancerController::class, 'address'])->name('freelancer.profile-address');
                Route::put('/{id}', [FreelancerController::class, 'updateAddress'])->name('freelancer.address-update');
            });
        });
        Route::get('/add-service', [ServicesController::class, 'create'])->name('freelancer.create-service');
        Route::post('/add-service', [ServicesController::class, 'store'])->name('freelancer.post-service');

        Route::prefix('orders')->group(function() {
            Route::get('/', [OrdersController::class, 'index'])->name('freelancer.order');
            Route::get('/pending', [OrdersController::class, 'pending'])->name('freelancer.order-pending');
            Route::get('/approved', [OrdersController::class, 'approved'])->name('freelancer.order-approved');
            Route::get('/rejected', [OrdersController::class, 'rejected'])->name('freelancer.order-rejected');
            Route::get('/completed', [OrdersController::class, 'completed'])->name('freelancer.order-completed');
            Route::post('/approve/{id}', [OrdersController::class, 'approve']);
        });
    });
});

Route::prefix('freelancer_registration')->middleware('auth')->group(function() {
    Route::get('/', [FreelancerRegistrationController::class, 'index'])->name('freelancer.registration');
    Route::post('/', [FreelancerRegistrationController::class, 'store'])->name('freelancer.post-registration');
});

