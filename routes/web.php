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
    });

});
