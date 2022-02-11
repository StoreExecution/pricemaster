<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'api'], function () {
    Route::get('/product', 'ProductController@index')->name('product.index');
    Route::get('/product/all', 'ProductController@all')->name('product.all');
    Route::post('/product/upload', 'ProductController@parse')->name('product.parse');
    Route::post('/product/edit/upload', 'ProductController@parseEdit')->name('product.parseEdit');
    Route::get('/product/count', 'ProductController@count')->name('product.count');
    Route::get('/product/{product}', 'ProductController@show')->name('product.show');
    Route::patch('/product/{product}', 'ProductController@update')->name('product.update');
    Route::post('/product', 'ProductController@store')->name('product.store');

    Route::get('/brand', 'BrandController@index')->name('brand.index');
    Route::get('/brand/all', 'BrandController@all')->name('brand.all');
    Route::get('/brand/{brand}', 'BrandController@show')->name('brand.show');
    Route::patch('/brand/{brand}', 'BrandController@update')->name('brand.update');
    Route::post('/brand', 'BrandController@store')->name('brand.store');


    Route::get('/category', 'CategoryController@index')->name('category.index');
    Route::get('/category/all', 'CategoryController@all')->name('category.all');
    Route::get('/category/{category}', 'CategoryController@show')->name('category.show');
    Route::patch('/category/{category}', 'CategoryController@update')->name('category.update');
    Route::post('/category', 'CategoryController@store')->name('category.store');

    Route::get('/sub-category', 'SubCategoryController@index')->name('subcategory.index');
    Route::get('/sub-category/all', 'SubCategoryController@all')->name('subcategory.all');
    Route::get('/sub-category/{subCategory}', 'SubCategoryController@show')->name('subcategory.show');
    Route::patch('/sub-category/{subCategory}', 'SubCategoryController@update')->name('subcategory.update');
    Route::post('/sub-category', 'SubCategoryController@store')->name('category.store');


    Route::get('/role', 'RoleController@index')->name('role.index');

    Route::get('/user', 'UserController@index')->name('user.index');
    Route::get('/user/count', 'UserController@count')->name('user.count');
    Route::get('/user/{user}', 'UserController@show')->name('user.show');
    Route::patch('/user/{user}', 'UserController@update')->name('user.update');
    Route::post('/user', 'UserController@store')->name('user.store');

    Route::get('/supplier', 'SupplierController@index')->name('supplier.index');
    Route::get('/supplier/all', 'SupplierController@all')->name('supplier.all');
    Route::get('/supplier/count', 'SupplierController@count')->name('supplier.count');
    Route::get('/supplier/{supplier}', 'SupplierController@show')->name('supplier.show');
    Route::post('/supplier', 'SupplierController@store')->name('supplier.store');
    Route::patch('/supplier/{supplier}', 'SupplierController@update')->name('supplier.update');



    Route::get('/salepoint', 'SalepointController@index')->name('salepoint.index');
    Route::get('/salepoint/all', 'SalepointController@all')->name('salepoint.all');
    Route::get('/salepoint/count', 'SalepointController@count')->name('salepoint.count');
    Route::get('/salepoint/{salepoint}', 'SalepointController@show')->name('salepoint.show');
    Route::post('/salepoint', 'SalepointController@store')->name('salepoint.store');
    Route::patch('/salepoint/{salepoint}', 'SalepointController@update')->name('salepoint.update');

    Route::get('/suppliersurvey', 'SupplierPriceSurveyController@index')->name('suppliersurvey.index');
    Route::get('/suppliersurvey/count', 'SupplierPriceSurveyController@count')->name('suppliersurvey.count');
    Route::get('/suppliersurvey/{priceSurvey}', 'SupplierPriceSurveyController@show')->name('suppliersurvey.show');
    Route::post('/suppliersurvey', 'SupplierPriceSurveyController@store')->name('suppliersurvey.store');
    Route::patch('/suppliersurvey/{priceSurvey}', 'SupplierPriceSurveyController@update')->name('suppliersurvey.update');

    Route::get('/purchasesurvey', 'PurchaseController@index')->name('purchasesurvey.index');
    Route::get('/purchasesurvey/count', 'PurchaseController@count')->name('purchasesurvey.count');
    Route::get('/purchasesurvey/{priceSurvey}', 'PurchaseController@show')->name('purchasesurvey.show');
    Route::post('/purchasesurvey', 'PurchaseController@store')->name('purchasesurvey.store');
    Route::patch('/purchasesurvey/{priceSurvey}', 'PurchaseController@update')->name('purchasesurvey.update');


    Route::get('/salepointsurvey', 'SalepointPriceSurveyController@index')->name('salepointsurvey.index');
    Route::get('/salepointsurvey/count', 'SalepointPriceSurveyController@count')->name('salepointsurvey.count');
    Route::get('/salepointsurvey/{priceSurvey}', 'SalepointPriceSurveyController@show')->name('salepointsurvey.show');
    Route::post('/salepointsurvey', 'SalepointPriceSurveyController@store')->name('salepointsurvey.store');
    Route::patch('/salepointsurvey/{priceSurvey}', 'SalepointPriceSurveyController@update')->name('salepointsurvey.update');


    Route::get('/mobileapi/bestprice/{product}', 'MobileController@getBestPrice')->name('MobileController.getBestPrice');
    Route::get('/mobileapi/salepointhistory/{salepoint}', 'MobileController@salepointHistory')->name('MobileController.salepointrHistory');
    Route::get('/mobileapi/supplierhistory/{supplier}', 'MobileController@supplierHistory')->name('MobileController.supplierHistory');


    Route::post('/stock', 'StockController@store')->name('StockController.store');
    Route::get('/stock/csv', 'StockController@export')->name('StockController.export');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');


    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'AuthController@user');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');
    });

});
