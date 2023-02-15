<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AdminActivitiesController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminCottagesController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminEventsController;
use App\Http\Controllers\AdminFoodsController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AdministratorInventoryController;
use App\Http\Controllers\AdminReportsController;
use App\Http\Controllers\AdminRoomsController;
use App\Http\Controllers\AdminTransactionsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdministratorSessionChecker;
use App\Http\Middleware\CustomerSessionChecker;

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
Route::get('/clear', function(){
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/testing', [HomeController::class, 'test11']);


Route::get('/login1', [LoginController::class, 'index']);
Route::get('/register', [RegisterController::class, 'index']);
Route::get('/get-province/{id}', [RegisterController::class, 'get_province']);
Route::get('/get-city/{id}', [RegisterController::class, 'get_city']);
// Route::post('/get-provinces', [RegisterController::class, 'get_provinces']);
// Route::post('/get-cities', [RegisterController::class, 'get_cities']);
// Route::post('/get-barangay', [RegisterController::class, 'get_barangay']);

//booking of the whole resort
Route::prefix('santorenz-reservation')->group(function () {
    Route::get('/terms-agreement', [HomeController::class, 'terms_agreement']);
    Route::get('/inquiries', [HomeController::class, 'resort_inquiries']);
    Route::post('/book_submit', [HomeController::class, 'book_resort']);
});


Route::prefix('forgot-password')->group(function () {
    Route::get('/', [ForgotPasswordController::class, 'index']);
    Route::get('/processing', [ForgotPasswordController::class, 'processing']);
});


Route::prefix('accounts')->group(function () {
    Route::post('/authenticate', [LoginController::class, 'authenticate']);
    Route::post('/store', [RegisterController::class, 'store']);
    Route::get('/reset/{email}', [RegisterController::class, 'reset']);
    Route::post('/retrieve', [RegisterController::class, 'retrieve']);
});


Route::prefix('services')->group(function () {
    Route::get('/rooms', [ServicesController::class, 'rooms']);
    Route::get('/cottage', [ServicesController::class, 'cottage']);
    Route::get('/foods', [ServicesController::class, 'foods']);
    Route::get('/activities', [ServicesController::class, 'activities']);
    Route::get('/events', [ServicesController::class, 'events']);
    Route::post('/reservation', [ServicesController::class, 'reservation']);
    Route::post('/reservation/addons_set_a', [ServicesController::class, 'addons_set_a']);
    Route::post('/reservation/addons_set_b', [ServicesController::class, 'addons_set_b']);
    Route::post('/reservation/addons_set_c', [ServicesController::class, 'addons_set_c']);
    Route::post('/reservation/addons_set_d', [ServicesController::class, 'addons_set_d']);
    Route::post('/reservation/addons_set_e', [ServicesController::class, 'addons_set_e']);
    Route::post('/search/result', [ServicesController::class, 'result']);
    Route::post('/comments', [ServicesController::class, 'comments']);
});


Route::prefix('rooms')->group(function () {
    Route::get('/{id}/details', [ServicesController::class, 'room_details']);
    Route::get('/results/{id}/{days}/{dates}/details', [ServicesController::class, 'room_post_details']);
});

Route::prefix('cottages')->group(function () {
    Route::get('/{id}/details', [ServicesController::class, 'cottages_details']);
});


Route::prefix('foods')->group(function () {
    Route::get('/{id}/details', [ServicesController::class, 'foods_details']);
});

Route::prefix('activities')->group(function () {
    Route::get('/{id}/details', [ServicesController::class, 'activities_details']);
});

Route::prefix('events')->group(function () {
    Route::get('/{id}/details', [ServicesController::class, 'events_details']);
});

Route::get('/about-us', [AboutUsController::class, 'index']);
Route::get('/contact-us', [ContactUsController::class, 'index']);

Route::get('/accounts/activate/{email}', [AccountsController::class, 'activate']);
Route::middleware([CustomerSessionChecker::class])->group(function () {
    Route::prefix('accounts')->group(function () {
        Route::get('/profile', [AccountsController::class, 'profile']);
        Route::post('/profile/update', [AccountsController::class, 'update']);
        Route::get('/my-reservation', [AccountsController::class, 'my_reservations']);
        Route::get('/change-password', [AccountsController::class, 'change_password']);
        Route::get('/logout', [AccountsController::class, 'logout']);

        Route::get('/my-reservation/{id}/cancel', [AccountsController::class, 'cancel']);
        Route::get('/my-reservation/{id}/print', [AccountsController::class, 'print']);
        
    });
});


Route::prefix('admin')->group(function () {
    Route::get('/', [AdministratorController::class, 'login']);
    Route::get('/login', [AdministratorController::class, 'login']);
    Route::post('/authenticate', [AdministratorController::class, 'authenticate']);
});

Route::middleware([AdministratorSessionChecker::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdministratorController::class, 'dashboard']);
        Route::get('/booking', [AdministratorController::class, 'booking']);
        Route::post('/search', [AdministratorController::class, 'result']);
        Route::get('/customers', [AdminCustomerController::class, 'index']);
        Route::get('/logout', [AdministratorController::class, 'logout']);
    });


    Route::prefix('admin/inventory')->name('admin.inventory.')->group(function () {
        Route::get('/', [AdministratorInventoryController::class, 'index']);
        // products
        Route::get('/products', [AdministratorInventoryController::class, 'products'])->name('products');
        Route::post('/products', [AdministratorInventoryController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [AdministratorInventoryController::class, 'update'])->name('products.update');
        Route::get('/products/{id}/delete', [AdministratorInventoryController::class, 'destroy'])->name('products.delete');
        // categories
        Route::get('/category', [AdministratorInventoryController::class, 'category'])->name('category');
        Route::post('/category', [AdministratorInventoryController::class, 'category_store'])->name('category.store');
        Route::put('/category/{id}', [AdministratorInventoryController::class, 'category_update'])->name('category.update');
        Route::get('/category/{id}/delete', [AdministratorInventoryController::class, 'category_destroy'])->name('category.delete');
        // stocks
        Route::get('/stocks', [AdministratorInventoryController::class, 'stocks'])->name('stocks');
        Route::post('/stocks', [AdministratorInventoryController::class, 'stocks_store'])->name('stocks.store');
        // deployments
        Route::get('/deployments', [AdministratorInventoryController::class, 'deployments'])->name('deployments');
        // bundles add
        Route::post('/deployments/bundles', [AdministratorInventoryController::class, 'bundles_store'])->name('deployments.bundle.store');
        Route::put('/deployments/bundles/{id}', [AdministratorInventoryController::class, 'bundles_update'])->name('deployments.bundle.update');
        Route::get('/deployments/bundles/{id}/modal', [AdministratorInventoryController::class, 'bundles_update_modal'])->name('deployments.bundle.update.modal');
        Route::get('/deployments/bundles/{id}/modal/deploy', [AdministratorInventoryController::class, 'bundles_deploy_modal'])->name('deployments.bundle.deploy.modal');
        Route::post('/deployments/deploy', [AdministratorInventoryController::class, 'deploy'])->name('deployments.deploy');
        Route::post('/deployments/return', [AdministratorInventoryController::class, 'return'])->name('deployments.return');
        Route::post('/deployments/bundles/{id}/deploy', [AdministratorInventoryController::class, 'bundles_deploy'])->name('deployments.bundle.deploy');
        Route::get('/deployments/bundles/{id}/delete', [AdministratorInventoryController::class, 'bundles_destroy'])->name('deployments.bundle.delete');
        // returns
        Route::get('/returns', [AdministratorInventoryController::class, 'stocks'])->name('returns');
    });

    Route::prefix('admin/bookings')->group(function () {
        Route::get('/rooms', [AdminBookingController::class, 'rooms']);
        Route::get('/rooms/details/{id}', [AdminBookingController::class, 'room_details']);
        Route::get('/cottages', [AdminBookingController::class, 'cottages']);
        Route::get('/foods', [AdminBookingController::class, 'foods']);
        Route::get('/events', [AdminBookingController::class, 'events']);
        Route::get('/activities', [AdminBookingController::class, 'activities']);
        Route::post('/reservation', [AdminBookingController::class, 'reservation']);
        Route::get('/receipt/print/{OrderID}', [AdminBookingController::class, 'adminReceipt'])->name('adminReceipt');
    });

    Route::prefix('admin/reports')->group(function () {
        Route::get('/sales-report', [AdminReportsController::class, 'sales_report']);
        Route::post('/search', [AdminReportsController::class, 'search']);
    });

    Route::prefix('admin/transactions')->group(function () {
        Route::get('/rooms', [AdminTransactionsController::class, 'rooms']);
        Route::get('/rooms/status/{id}/{stats}', [AdminTransactionsController::class, 'rooms_status']);
        Route::get('/cottages', [AdminTransactionsController::class, 'cottages']);
        Route::get('/foods', [AdminTransactionsController::class, 'foods']);
        Route::get('/events', [AdminTransactionsController::class, 'events']);
        Route::get('/activities', [AdminTransactionsController::class, 'activities']);
        Route::get('/pos', [AdminTransactionsController::class, 'pos']);
        Route::post('/get_content', [AdminTransactionsController::class, 'get_content']);
        Route::post('/add_pos', [AdminTransactionsController::class, 'pos_add']);
        Route::post('/add_pos_test', [AdminTransactionsController::class, 'pos_add_test'])->name('add_pos_test');
        Route::get('/view/{id}', [AdminTransactionsController::class, 'viewTransaction'])->name('viewTransaction');
        Route::get('/clearbooking', [AdminTransactionsController::class, 'clear_booking']);
        Route::get('/test', [AdminTransactionsController::class, 'transaction_test']);
    });


    Route::prefix('admin/rooms')->group(function () {
        Route::get('/create', [AdminRoomsController::class, 'index']);
        Route::get('/create-rooms', [AdminRoomsController::class, 'create_rooms']);
        Route::get('/details/{id}', [AdminRoomsController::class, 'rooms_details']);
        Route::get('/images/{id}/delete', [AdminRoomsController::class, 'delete_room_gallery']);
        Route::post('/gallery/store', [AdminRoomsController::class, 'store_gallery']);
        Route::post('/store', [AdminRoomsController::class, 'store_rooms']);
        Route::post('/update/{id}/rooms', [AdminRoomsController::class, 'update_rooms']);
        Route::get('/delete/{id}/rooms', [AdminRoomsController::class, 'delete_rooms']);

        Route::get('/category', [AdminRoomsController::class, 'category']);
        Route::post('/store/category', [AdminRoomsController::class, 'store_category']);
        Route::post('/update/category', [AdminRoomsController::class, 'update_category']);
        Route::get('/delete/{id}/category', [AdminRoomsController::class, 'delete_category']);
    });

    Route::prefix('admin/cottages')->group(function () {
        Route::get('/create', [AdminCottagesController::class, 'index']);
        Route::get('/create-cottages', [AdminCottagesController::class, 'create_cottages']);
        Route::get('/details/{id}', [AdminCottagesController::class, 'cottages_details']);
        Route::get('/images/{id}/delete', [AdminCottagesController::class, 'delete_cottages_gallery']);
        Route::post('/gallery/store', [AdminCottagesController::class, 'store_gallery']);
        Route::post('/store', [AdminCottagesController::class, 'store_cottages']);
        Route::post('/update/{id}/cottages', [AdminCottagesController::class, 'update_cottages']);
        Route::get('/delete/{id}/cottages', [AdminCottagesController::class, 'delete_cottages']);

        Route::get('/category', [AdminCottagesController::class, 'category']);
        Route::post('/store/category', [AdminCottagesController::class, 'store_category']);
        Route::post('/update/category', [AdminCottagesController::class, 'update_category']);
        Route::get('/delete/{id}/category', [AdminCottagesController::class, 'delete_category']);
    });


    Route::prefix('admin/foods')->group(function () {
        Route::get('/create', [AdminFoodsController::class, 'index']);
        Route::get('/create-foods', [AdminFoodsController::class, 'create_foods']);
        Route::get('/details/{id}', [AdminFoodsController::class, 'foods_details']);
        Route::get('/images/{id}/delete', [AdminFoodsController::class, 'delete_foods_gallery']);
        Route::post('/gallery/store', [AdminFoodsController::class, 'store_gallery']);
        Route::post('/store', [AdminFoodsController::class, 'store_foods']);
        Route::post('/update/{id}/foods', [AdminFoodsController::class, 'update_foods']);
        Route::get('/delete/{id}/foods', [AdminFoodsController::class, 'delete_foods']);

        Route::get('/category', [AdminFoodsController::class, 'category']);
        Route::post('/store/category', [AdminFoodsController::class, 'store_category']);
        Route::post('/update/category', [AdminFoodsController::class, 'update_category']);
        Route::get('/delete/{id}/category', [AdminFoodsController::class, 'delete_category']);
    });


    Route::prefix('admin/events')->group(function () {
        Route::get('/create', [AdminEventsController::class, 'index']);
        Route::get('/create-events', [AdminEventsController::class, 'create_events']);
        Route::get('/details/{id}', [AdminEventsController::class, 'events_details']);
        Route::get('/images/{id}/delete', [AdminEventsController::class, 'delete_events_gallery']);
        Route::post('/gallery/store', [AdminEventsController::class, 'store_gallery']);
        Route::post('/store', [AdminEventsController::class, 'store_events']);
        Route::post('/update/{id}/events', [AdminEventsController::class, 'update_events']);
        Route::get('/delete/{id}/events', [AdminEventsController::class, 'delete_events']);

        Route::get('/category', [AdminEventsController::class, 'category']);
        Route::post('/store/category', [AdminEventsController::class, 'store_category']);
        Route::post('/update/category', [AdminEventsController::class, 'update_category']);
        Route::get('/delete/{id}/category', [AdminEventsController::class, 'delete_category']);
    });

    Route::prefix('admin/activities')->group(function () {
        Route::get('/create', [AdminActivitiesController::class, 'index']);
        Route::get('/create-activities', [AdminActivitiesController::class, 'create_activities']);
        Route::get('/details/{id}', [AdminActivitiesController::class, 'activities_details']);
        Route::get('/images/{id}/delete', [AdminActivitiesController::class, 'delete_activities_gallery']);
        Route::post('/gallery/store', [AdminActivitiesController::class, 'store_gallery']);
        Route::post('/store', [AdminActivitiesController::class, 'store_activities']);
        Route::post('/update/{id}/activities', [AdminActivitiesController::class, 'update_activities']);
        Route::get('/delete/{id}/activities', [AdminActivitiesController::class, 'delete_activities']);

        Route::get('/category', [AdminActivitiesController::class, 'category']);
        Route::post('/store/category', [AdminActivitiesController::class, 'store_category']);
        Route::post('/update/category', [AdminActivitiesController::class, 'update_category']);
        Route::get('/delete/{id}/category', [AdminActivitiesController::class, 'delete_category']);
    });
});

Route::get('test', [ServicesController::class, 'test']);
