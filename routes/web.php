<?php

use App\Helpers\Helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\RepackDataUpdate;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LogStatusController;
use App\Http\Controllers\RepackDeleteController;

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
Route::get('clear_cache', function () {
    Artisan::call('optimize:clear');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $title = 'Dashboard';
    return view('dashboard', compact('title'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


        Route::name('users.')->prefix('users')->controller(UserController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::post('/delete/{id}', 'destroy')->name('destroy');
            Route::get('data','getUserData')->name('getUserData');
        });

        Route::name('customers.')->prefix('customers')->controller(CustomersController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::post('/delete/{id}', 'destroy')->name('destroy');
            Route::get('data','getCustomersData')->name('getCustomersData');
        });


        Route::name('logStatus.')->prefix('logStatus')->controller(LogStatusController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::post('/delete/{id}', 'destroy')->name('destroy');
            Route::get('data','getLogStatusData')->name('getLogStatusData');
        });

        Route::get('log-status-hours', [LogStatusController::class, 'log_status_hours'])->name('log-status-hours');
        Route::post('update-log-hours/{id}', [LogStatusController::class, 'update_log_hours'])->name('update-log-hours');



        Route::controller(ProductController::class)->group(function(){

            Route::prefix('products')->name('products.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('getProductsData','getProductsData')->name('getProductsData');
            });

            Route::post('/product-image/{id}/{attribute}', [ProductController::class, 'updateProductImage']);
            Route::get('/CKW-C2T', 'CKW_C2T');
            Route::get('/bko-c2t', 'CKW_C2T')->name('CKW_C2T');
            Route::get('/bko-c2t/data', 'CKWC2TData')->name('CKW_C2T.data');


            Route::patch('/update-product-csdid/{id}', 'updateCSDID');
            Route::get('/products/{product}', 'edit')->name('products.edit');
            Route::put('/products/{product}', 'update')->name('products.update');
            Route::delete('/products/{product}', 'destroy')->name('products.destroy');
            Route::delete('/repack-products/{product}', 'deleteRepack');
            Route::patch('/update-remarks/{id}', 'updateRemarks');
            Route::patch('/update-w/{id}', 'updateW');
            Route::patch('/update-l/{id}', 'updateL');
            Route::patch('/update-h/{id}', 'updateH');
            Route::patch('/update-tpcs/{id}', 'updateTpcs');
            Route::patch('/update-weight/{id}', 'updateWeight');
            Route::patch('/update-product-id/{id}', 'updateProductId');
            Route::patch('/update-product-name/{id}', 'updateProductName');
            Route::post('/add-to-repack', 'addToRepack');

            Route::patch('/update-repack-remarks/{id}', 'updateRepackRemarks');
            Route::patch('/update-repack-w/{id}', 'updateRepackW');
            Route::patch('/update-repack-l/{id}', 'updateRepackL');
            Route::patch('/update-repack-h/{id}', 'updateRepackH');
            Route::patch('/update-repack-tpcs/{id}', 'updateRepackTpcs');
            Route::patch('/update-repack-weight/{id}', 'updateRepackWeight');
            Route::patch('/update-repack-product-id/{id}', 'updateRepackProductId');
            Route::patch('/update-repack-product-name/{id}', 'updateRepackProductName');

            Route::any('/product_search/{searchValue}', 'product_C2T');
            Route::get('/products/datatable', 'getProductData')->name('products.datatable');

            Route::get('/bkw-c2t', 'BKW_C2T')->name('bkwc2t');
            Route::get('bkw-c2t/data','bkwc2tData')->name('bkwc2tData');
            Route::get('/repack-products', 'repackProducts')->name('repackProducts');
            Route::get('repackProductsData','repackProductsData')->name('repackProductsData');

            Route::any('/custom_search/{searchValue}', 'BKW_C2T');
            Route::any('/custom_searchck/{searchValue}', 'BKW_C2T');
        });

    Route::get('/repacks/{id?}/{attribute}', function(){ die('ss'); });
    Route::post('/repacks/{id}/{attribute}', [RepackDataUpdate::class, 'update']);
    Route::post('/update-bulk-ctid', [RepackDeleteController::class, 'updateCtIdRepackProduct']);
    Route::get('/generate-invoices', [PrintController::class, 'generatePDF']);
    Route::post('/delete-from-repack', [RepackDeleteController::class, 'deleteRepackProduct']);

    Route::post('bill_id_status', [RepackDataUpdate::class, 'bill_id_status'])->name('bill_id_status');
    Route::post('ctid_lc_change', [RepackDataUpdate::class, 'ctid_lc_change'])->name('ctid_lc_change');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('theme/change/{theme}',[ThemeController::class,'changeTheme'])->name('theme.change');

});

require __DIR__.'/auth.php';
