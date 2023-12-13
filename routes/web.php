<?php

use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ProfileController as AuthProfileController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\shippingController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class,'index']);
Route::get('product-category/{section}/{slug}',[HomeController::class,'category'])
->name('category');
Route::get('product/{category}/{slug}',[HomeController::class,'single'])->name('single');
Route::post('get-product-price',[HomeController::class,'getAttrDiscountPrice'])
->name('get-product');

Route::prefix('/cart')->group(function(){
   Route::post('/add',[CartController::class,'addCart'])->name('add-to-cart');
   Route::get('/checkout',[CartController::class,'checkout'])->name('checkout');
   Route::post('/remove',[CartController::class,'cartRemove'])->name('remove');
   Route::post('/update/qty',[CartController::class,'updateCartQty'])
   ->name('update.qty');

   Route::group(['middleware' => ['auth']],function () {
         Route::get('/shipping',[shippingController::class,'shipping']);
                // SSLCOMMERZ Start
            Route::get('/payment', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
            Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

            Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
            Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

            Route::post('/success', [SslCommerzPaymentController::class, 'success']);
            Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
            Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

            Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
            //SSLCOMMERZ END
   });

});

Route::prefix('/user')->group(function(){
    Route::get('/register',[UserController::class,'create']);
    Route::post('/register',[UserController::class,'store']);
    Route::get('/login',[UserController::class,'loginCreate'])->name('login');
    Route::post('/login',[UserController::class,'loginStore']);
    Route::get('/logout',[UserController::class,'logout'])->name('user.logout');
    Route::match(['get', 'post'], '/check-email', [UserController::class,'checkEmail']);
    Route::match(['get', 'post'], '/confirm/{code}', [UserController::class,'confirmAccount']);
   
    Route::group(['middleware' => ['auth']],function () {
        Route::get('/account', [UserController::class, 'account'])->name('account');
        Route::put('account/update',[UserController::class,'updateAccount'])
        ->name('account.update');
        Route::post('/check-current-pwd',[UserController::class,'checkCurrentPwd']);
        Route::put('/password/update',[UserController::class,'updatePassword'])
        ->name('password.update');
    });


   
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::prefix('admin')->name('admin.')->middleware(['guest:admin'])->group(function () {
    Route::get('/login',[AuthenticatedSessionController::class,'create'])->name('login');
    Route::post('/login',[AuthenticatedSessionController::class,'store']);
});

Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::post('/logout',[AuthenticatedSessionController::class,'destroy'])->name('logout');
    Route::get('/profile',[AuthProfileController::class,'edit'])->name('profile.edit');
    Route::put('profile/update',[AuthProfileController::class,'updateProfile'])
    ->name('profile.update');
    Route::post('/check-current-pwd',[AuthProfileController::class,'checkCurrentPwd']);
    Route::put('/password/update',[AuthProfileController::class,'updatePassword'])
    ->name('password.update');
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::get('/category/status', [CategoryController::class,'status'])->name('category.status');

    Route::resource('products', ProductController::class);
    Route::get('/product/status', [ProductController::class,'status'])->name('product.status');
    Route::get('/get/category', [ProductController::class,'getCategory'])->name('get.category');
    // product-attributes
    Route::get('/product-attributes/{id}',[ProductAttributeController::class,'addProductAttr'])->name('product-attributes');
    Route::post('/product-attributes/store',[ProductAttributeController::class,'StoreProductAttr'])->name('product-attributes.store');
    Route::post('/product-attributes/update',[ProductAttributeController::class,'UpdateProductAttr'])->name('product-attributes.update');
    Route::delete('/product-attributes/delete/{id}',[ProductAttributeController::class,'DeleteProductAttr']);
    // product-images
    Route::get('/product-images/{id}',[ProductImageController::class,'addProductImg'])->name('product-images');
    Route::post('/product-images/store',[ProductImageController::class,'storeProductImg'])->name('product-images.store');
    Route::delete('/product-images/delete/{id}',[ProductImageController::class,'DeleteProductImg']);

    Route::resource('banners', BannerController::class);

    Route::resource('/ads',AdsController::class);

});

;



// require __DIR__.'/auth.php';
