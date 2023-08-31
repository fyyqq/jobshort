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
    // Get Freelancer Name to see their profile page
    Route::get('/{name}', [HomeController::class, 'user'])->name('users');
    // Get Freelancer Name and filter by category
    Route::get('/{name}/filter-category/{service}', [HomeController::class, 'sortCategory']);
    // Get Freelancer Name and filter by their services
    Route::get('/{name}/sort-by/{type}', [HomeController::class, 'sortFilter']);
});

// Category Page
Route::prefix('categories')->group(function() {
    // Get all categories name
    Route::get('/', [CategoryController::class, 'index'])->name('categories');
    // Get each categories by name Selected
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('category');
    // Get each categories & filter 
    Route::get('/{slug}/sort-by/{type}', [CategoryController::class, 'filter']);
});

// Notifications
Route::prefix('notifications')->middleware('auth')->group(function() {
    // Get All Notifications
    Route::get('/', [NotificationController::class, 'index'])->name('notification');
    // Get All Notifications In Single Page Application
    Route::get('/inbox', [NotificationController::class, 'inbox'])->name('notification.inbox');
    // Get All Read Notifications In Single Page Application
    Route::get('/read', [NotificationController::class, 'read'])->name('notification.read');
    // Get All Unread Notifications In Single Page Application
    Route::get('/unread', [NotificationController::class, 'unread'])->name('notification.unread');
    // Action Read Notification
    Route::post('/read/{id}', [NotificationController::class, 'readMessage']);
    // Action Unread Notification
    Route::post('/unread/{id}', [NotificationController::class, 'unreadMessage']);
    // Action Delete Notification
    Route::delete('/delete/{id}', [NotificationController::class, 'destroy']);
});

// Wishlist
Route::prefix('wishlist')->group(function() {
    // Action Wishlist On Service
    Route::post('/{id}', [WishlistController::class, 'store'])->middleware('auth')->name('wishlist-service');
    // Action Unwishlist On Service
    Route::delete('/{id}', [WishlistController::class, 'unstore'])->middleware('auth')->name('unwishlist-service');
});

// Notification Post
Route::prefix('notify')->group(function() {
    // Action Notify On Freelancer
    Route::post('/{user}/{freelancer}', [NotificationController::class, 'store'])->middleware('auth');
    // Action Disnotify On Freelancer
    Route::delete('/{user}/{freelancer}', [NotificationController::class, 'unstore'])->middleware('auth');
});


// Services
Route::prefix('services')->group(function() {
    // Searching Section
    Route::prefix('search')->group(function() {
        // Searching By Keyword
        Route::get('/', [SearchController::class, 'index'])->name('search');
        // Showing Autocomplete Searching
        Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
        // Sort By Searching Result
        Route::get('/{value}/sort-by/{type}', [SearchController::class, 'filterSearch']);
        // Reset Sort By Searching Result To Normal
        Route::get('/reset/{value}', [SearchController::class, 'reset']);
    });
    // Show Service Detail
    Route::get('/{slug}', [HomeController::class, 'show'])->name('services');
    // Make Service Payment
    Route::post('/session/{slug}', [PaymentController::class, 'session'])->middleware('auth')->name('session');
    // Success Payment 
    Route::get('/success/{slug}', [PaymentController::class, 'success'])->middleware('auth')->name('success');
    // Order Service
    Route::get('/orders/success/{slug}', [PaymentController::class, 'pages'])->middleware('auth')->name('order.success');
    // Cancel Payment Action 
    Route::get('/cancel/{slug}', [PaymentController::class, 'cancel'])->middleware('auth')->name('cancel');
    // Show Service Review
    Route::get('/reviews/{slug}', [RatingController::class, 'index'])->name('reviews');
});

Route::prefix('account')->middleware(['auth'])->group(function() {
    Route::prefix('profile')->group(function() {
        // Profile Page
        Route::get('/', [ProfileController::class, 'index'])->name('profile.main');
        // Registration Profile
        Route::post('/registration', [ProfileController::class, 'store'])->name('profile.registration');
        // Update Information Profile
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        // Wishlist Page
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('profile.saved-services');
        Route::prefix('orders')->group(function() {
            // Order Page
            Route::get('/', [ProfileController::class, 'order'])->name('profile.order');
            // Pending Order Page
            Route::get('/pending', [ProfileController::class, 'pending'])->name('profile.order-pending');
            // Approved Order Page
            Route::get('/approved', [ProfileController::class, 'approved'])->name('profile.order-approved');
            // Rejected Order Page
            Route::get('/rejected', [ProfileController::class, 'rejected'])->name('profile.order-rejected');
            // Completed Order Page
            Route::get('/completed', [ProfileController::class, 'completed'])->name('profile.order-completed');
            // Action As Reject Order
            Route::post('/reject/{id}', [OrdersController::class, 'reject']);
            // Action As Complete Order
            Route::post('/complete/{id}', [OrdersController::class, 'complete']);
            // Rating For Completed Order
            Route::post('/completed/rating', [RatingController::class, 'store'])->name('profile.rating');
        });
    });
    Route::prefix('freelancer')->middleware(['freelancer'])->group(function() {
        // Freelancer Page
        Route::get('/', [FreelancerController::class, 'index'])->name('freelancer.main');
        Route::prefix('services')->group(function() {
            // Service Active Page
            Route::get('/', [ServicesController::class, 'index'])->name('freelancer.services');
            // Service Active Page
            Route::get('/all', [ServicesController::class, 'all'])->name('freelancer.services-all');
            // Service Archive Page
            Route::get('/archive', [ServicesController::class, 'archive'])->name('freelancer.services-archive');
            // Service Edit Page
            Route::get('/edit/{slug}', [ServicesController::class, 'edit'])->name('freelancer.edit-services');
            // Service Update
            Route::put('/update/{slug}', [ServicesController::class, 'update'])->name('freelancer.update-services');
            // Action As Active For Each Service
            Route::put('/active/{slug}', [ServicesController::class, 'updateActive'])->name('freelancer.update-active-services');
            // Action As Active For Selected Service
            Route::post('/active-items', [ServicesController::class, 'activeItems'])->name('freelancer.active-item-services');
            // Action As Archive For Each Service
            Route::put('/archive/{slug}', [ServicesController::class, 'updateArchive'])->name('freelancer.update-archive-services');
            // Action As Archive For Selected Service
            Route::post('/archive-items', [ServicesController::class, 'archiveItems'])->name('freelancer.archive-item-services');
            // Action As Delete For Each Service
            Route::delete('/delete/{slug}', [ServicesController::class, 'destroy'])->name('freelancer.delete-services');
            // Action As Delete For Selected Service
            Route::post('/delete-items', [ServicesController::class, 'deletedItems'])->name('freelancer.delete-item-services');
            // Sort Service by Normal Price
            Route::get('/sort-by-normal-price', [ServicesController::class, 'sortByNormal'])->name('freelancer.normal');
            // Sort Service by Higher Price
            Route::get('/sort-by-high-price', [ServicesController::class, 'sortByHighPrice'])->name('freelancer.filter-high-price');
            // Sort Service by Lower Price
            Route::get('/sort-by-low-price', [ServicesController::class, 'sortByLowPrice'])->name('freelancer.filter-low-price');
            // Sort Service by Oldest
            Route::get('/sort-by-oldest', [ServicesController::class, 'sortByOldest'])->name('freelancer.filter-oldest');
            // Sort Service by Top Order
            Route::get('/sort-by-top-order', [ServicesController::class, 'sortByTopOrder'])->name('freelancer.filter-order');
            // Sort Service by Top Rating
            Route::get('/sort-by-top-rating', [ServicesController::class, 'sortByTopRating'])->name('freelancer.filter-rating');
            // Service Searching
            Route::get('/search', [ServicesController::class, 'searchServices'])->name('freelancer.search-services');
        });
        Route::prefix('notifications')->group(function() {
            // All Notification Page
            Route::get('/', [FreelancerController::class, 'notification'])->name('freelancer.notification');
            Route::get('/inbox', [FreelancerController::class, 'inboxNotification'])->name('freelancer.notification-inbox');
            // Orders Notification Page
            Route::get('/orders', [FreelancerController::class, 'orderNotification'])->name('freelancer.notification-order');
            // Ratings Notification Page
            Route::get('/ratings', [FreelancerController::class, 'reviewNotification'])->name('freelancer.notification-rating');
        });
        Route::prefix('profile')->group(function() {
            // Freelancer Profile Page
            Route::get('/', [FreelancerController::class, 'profile'])->name('freelancer.profile');
            // Update Freelancer Information
            Route::put('/{id}', [FreelancerController::class, 'update'])->name('freelancer.profile-update');
        });
        Route::prefix('add-service')->group(function() {
            // Add Service
            Route::get('/', [ServicesController::class, 'create'])->name('freelancer.create-service');
            // Store Service
            Route::post('/', [ServicesController::class, 'store'])->name('freelancer.post-service');
        });

        Route::prefix('orders')->group(function() {
            // Pending Order Page
            Route::get('/', [OrdersController::class, 'index'])->name('freelancer.order');
            Route::get('/pending', [OrdersController::class, 'pending'])->name('freelancer.order-pending');
            // Approved Order Page
            Route::get('/approved', [OrdersController::class, 'approved'])->name('freelancer.order-approved');
            // Rejected Order Page
            Route::get('/rejected', [OrdersController::class, 'rejected'])->name('freelancer.order-rejected');
            // Completed Order Page
            Route::get('/completed', [OrdersController::class, 'completed'])->name('freelancer.order-completed');
            // Action As Approved Single Order
            Route::post('/approve/{id}', [OrdersController::class, 'approve']);
        });
    });
});

Route::prefix('freelancer_registration')->middleware('auth')->group(function() {
    // Freelancer Registration Page
    Route::get('/', [FreelancerRegistrationController::class, 'index'])->name('freelancer.registration');
    // Store Freelancer Information
    Route::post('/', [FreelancerRegistrationController::class, 'store'])->name('freelancer.post-registration');
});

