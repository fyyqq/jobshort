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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('user/{name:freelancer}', [ProfileController::class, 'user'])->name('users');
// Route::get('/{slug}', [HomeController::class, 'jobs']);
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
Route::post('/saved/{id}', [WishlistController::class, 'store'])->name('saved-job');
Route::delete('/unsaved/{id}', [WishlistController::class, 'unstore'])->name('unsaved-job');

// Freelancer Notification
Route::post('/notify/{user:id}/{freelancer:id}', [NotificationController::class, 'store']);
Route::delete('/disnotify/{user:id}/{freelancer:id}', [NotificationController::class, 'unstore']);

Route::prefix('orders')->middleware(['auth'])->group(function() {
    // Route::get('/{slug}', [OrdersController::class, 'show'])->name('apply-jobs');
    Route::post('/{service:id}/{freelancer:id}', [OrdersController::class, 'store'])->name('applied-jobs');
});

Route::prefix('services')->group(function() {
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/{slug}', [HomeController::class, 'showService'])->name('jobs');
    Route::get('/reviews/{slug}', [RatingController::class, 'index'])->name('reviews');
    Route::get('/payment/{slug}', [PaymentController::class, 'index'])->name('payment');
});

Route::prefix('account')->middleware(['auth'])->group(function() {
    Route::get('/', [ProfileController::class, 'account'])->name('my-account');
    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.main');
        Route::post('/freelancer-registration', [ProfileController::class, 'store'])->name('profile.employee-registration');
        Route::put('/freelancer-update', [ProfileController::class, 'update'])->name('profile.employee-update');
        Route::put('/freelancer-edit', [ProfileController::class, 'update'])->name('profile.employee-edit');
        Route::get('/address', [AddressController::class, 'index'])->name('profile.address');
        Route::post('/freelancer-address', [AddressController::class, 'store'])->name('profile.store-address');
        Route::put('/freelancer-address', [AddressController::class, 'update'])->name('profile.update-address');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('profile.saved-jobs');
        Route::prefix('orders')->group(function() {
            Route::get('/', [ProfileController::class, 'applied'])->name('profile.applied');
            Route::get('/approved', [ProfileController::class, 'approved'])->name('profile.applied-approved');
            Route::get('/rejected', [ProfileController::class, 'rejected'])->name('profile.applied-rejected');
            Route::get('/completed', [ProfileController::class, 'completed'])->name('profile.applied-completed');
            Route::get('/status/{slug}', [ProfileController::class, 'status'])->name('profile.applied-status');
            Route::post('/reject/{id}', [OrdersController::class, 'reject']);
            Route::post('/complete/{id}', [OrdersController::class, 'complete'])->name('employer.applicant-complete');
            Route::post('/rating', [RatingController::class, 'store'])->name('employer.rating');
        });
    });
    Route::prefix('freelancer')->middleware(['auth'])->group(function() {
        Route::get('/', [FreelancerController::class, 'index'])->name('employer.main');
        Route::prefix('services')->group(function() {
            Route::get('/', [ServicesController::class, 'index'])->name('employer.jobs');
            Route::get('/edit/{slug}', [ServicesController::class, 'edit'])->name('employer.edit-jobs');
            Route::put('/update/{slug}', [ServicesController::class, 'update'])->name('employer.update-jobs');
            Route::put('/archive/{slug}', [ServicesController::class, 'updateArchive'])->name('employer.update-archive-jobs');
            Route::delete('/delete/{slug}', [ServicesController::class, 'destroy'])->name('employer.delete-jobs');
            Route::post('/delete-items', [FreelancerController::class, 'deletedItems'])->name('employer.delete-item-jobs');
            Route::get('/live', [FreelancerController::class, 'live'])->name('employer.live-jobs');
            Route::get('/ongoing', [FreelancerController::class, 'ongoing'])->name('employer.on-jobs');
            Route::get('/complete', [FreelancerController::class, 'complete'])->name('employer.complete-jobs');
            Route::get('/archive', [FreelancerController::class, 'archive'])->name('employer.archive-jobs');
            // Filter
            Route::get('/sort-by-normal-price', [ServicesController::class, 'sortByNormal'])->name('employer.normal');
            Route::get('/sort-by-high-price', [ServicesController::class, 'sortByHighPrice'])->name('employer.filter-high-price');
            Route::get('/sort-by-low-price', [ServicesController::class, 'sortByLowPrice'])->name('employer.filter-low-price');
            // Filter OrderBy
            Route::get('/sort-by-oldest', [ServicesController::class, 'sortByOldest'])->name('employer.filter-oldest');
            Route::get('/sort-by-top-order', [ServicesController::class, 'sortByTopOrder'])->name('employer.filter-order');
            Route::get('/sort-by-top-rating', [ServicesController::class, 'sortByTopRating'])->name('employer.filter-rating');
            // Filter Search
            Route::get('/search', [ServicesController::class, 'searchServices'])->name('employer.search-services');
        });
        Route::get('/notification', [FreelancerController::class, 'notification'])->name('employer.notification');
        Route::prefix('profile')->group(function() {
            Route::get('/', [FreelancerController::class, 'profile'])->name('employer.profile');
            Route::put('/{id}', [FreelancerController::class, 'updateProfile'])->name('freelancer.profile-update');
            Route::prefix('address')->group(function() {
                Route::get('/', [FreelancerController::class, 'address'])->name('employer.profile-address');
                Route::put('/{id}', [FreelancerController::class, 'updateAddress'])->name('employer.address-update');
            });
        });
        Route::get('/add-service', [ServicesController::class, 'create'])->name('employer.create-service');
        Route::post('/add-service', [ServicesController::class, 'store'])->name('employer.post-service');

        Route::prefix('orders')->group(function() {
            Route::get('/', [OrdersController::class, 'index'])->name('employer.applicant');
            Route::get('/approved', [OrdersController::class, 'approved'])->name('employer.applicant-approved');
            Route::get('/rejected', [OrdersController::class, 'rejected'])->name('employer.applicant-rejected');
            Route::get('/completed', [OrdersController::class, 'completed'])->name('employer.applicant-completed');
            Route::post('/approve/{id}', [OrdersController::class, 'approve'])->name('employer.applicant-approve');
        });
    });
});

Route::prefix('freelancer_registration')->group(function() {
    Route::get('/', [FreelancerRegistrationController::class, 'index'])->name('employer.registration-personal');
    Route::post('/', [FreelancerRegistrationController::class, 'storePersonal'])->name('employer.post-registration');
    Route::put('/', [FreelancerRegistrationController::class, 'updatePersonal'])->name('employer.update-registration');
    Route::prefix('/address')->group(function() {
        Route::get('/', [FreelancerRegistrationController::class, 'address'])->name('employer.registration-address');
        Route::post('/', [FreelancerRegistrationController::class, 'storeAddress'])->name('employer.post-address');
    });
});

