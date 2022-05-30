<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function() {
    //toutes les routes de l'admin seront définies ici...
    Route::match(['get', 'post'],   '/',[App\Http\Controllers\Admin\AdminController::class, 'login']);
    Route::group(['middleware' => ['admin']],function() {
        Route::get('dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
        Route::get('logout', [App\Http\Controllers\Admin\AdminController::class, 'logout']);
        Route::get('settings', [App\Http\Controllers\Admin\AdminController::class, 'settings']);
        Route::post('check-current-pwd', [App\Http\Controllers\Admin\AdminController::class, 'checkCurrentPassword']);
        Route::post('update-current-pwd', [App\Http\Controllers\Admin\AdminController::class, 'updateCurrentPassword']);
        Route::match(['get', 'post'], 'update-admin-details',[App\Http\Controllers\Admin\AdminController::class, 'updateAdminDetails']);

        Route::get('sections',[App\Http\Controllers\Admin\SectionController::class, 'sections']);
        Route::post('update-section-status',[App\Http\Controllers\Admin\SectionController::class, 'updateSectionStatus']);

        Route::get('categories',[App\Http\Controllers\Admin\CategoryController::class, 'categories']);
        Route::post('update-category-status',[App\Http\Controllers\Admin\CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}',[App\Http\Controllers\Admin\CategoryController::class, 'addEditCategory']);
        Route::post('append-categories-level',[App\Http\Controllers\Admin\CategoryController::class, 'appendCategoriesLevel']);
        Route::get('delete-category-image/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'deleteCategoryImage']);
        Route::get('delete-category/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'deleteCategory']);

        Route::get('produits',[App\Http\Controllers\Admin\ProductController::class, 'products']);
        Route::post('update-product-status',[App\Http\Controllers\Admin\ProductController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteProduct']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}',[App\Http\Controllers\Admin\ProductController::class, 'addEditProduct']);
        Route::get('delete-product-image/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteProductImage']);

        Route::match(['get', 'post'], 'add-attributes/{id}',[App\Http\Controllers\Admin\ProductController::class, 'addAttributes']);
        Route::post('edit-attributes/{id}',[App\Http\Controllers\Admin\ProductController::class, 'editAttributes']);
    });

});
