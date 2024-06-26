<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LocationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth',
    ],
    function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    },
);
// CRUD for Brand
Route::group(['prefix' => 'brand'], function ($router) {
    Route::controller(BrandController::class)->group(function () {
        Route::get('/index', 'index');
        Route::get('/show_brand/{id}', 'show_Brand');
        Route::post('/store_brand', 'store_Brand');
        Route::put('/update_brand/{id}', 'update_Brand');
        Route::delete('/delete_brand/{id}', 'delete_Brand');
    });
});

// CRUD for Category
Route::group(['prefix' => 'category'], function ($router) {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/index', 'index');
        Route::get('/show_Category/{id}', 'show_Category');
        Route::post('/store_Category', 'store_Category');
        Route::put('/update_Category/{id}', 'update_Category');
        Route::delete('/delete_Category/{id}', 'delete_Category');
    });
});

// CRUD for Location
Route::group(['prefix' => 'location'], function ($router) {
    Route::controller(LocationController::class)->group(function () {
        Route::post('/store_Location', 'store_Location');
        Route::put('/update_Location/{id}', 'update_Location');
        Route::delete('/delete_Location/{id}', 'delete_Location');
    });
});

// CRUD for Product
Route::group(['prefix' => 'product'], function ($router) {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/index', 'index');
        Route::get('/show_Product/{id}', 'show_Product');
        Route::post('/store_Product', 'store_Product');
        Route::put('/update_Product/{id}', 'update_Product');
        Route::delete('/delete_Product/{id}', 'delete_Product');
    });
});
Route::group(['prefix' => 'order'], function ($router) {
    Route::controller(OrderController::class)->group(function () {
        Route::get('/index', 'index');
        Route::get('/show_Order/{id}', 'show__Order');
        Route::post('/store_Order', 'store_Order');
        Route::get('/get_order_items/{id}', 'get_order_items');
        Route::get('/get_user_orders/{id}', 'get_user_orders');
        Route::post('/change_order_status/{id}', 'change_order_status');
    });
});
