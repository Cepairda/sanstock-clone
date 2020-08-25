<?php

use Illuminate\Support\Facades\Route;

Route::prefix(LaravelLocalization::setLocale())->group(function () {

    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::prefix('admin')->as('admin.')->namespace('Admin')->group(function () {

        Route::get('/', 'DashboardController@index')->name('dashboard.index');

        Route::get('/test', 'ImportController@updateOrCreate')->name('import');

        Route::prefix('products')->as('products.')->group(function () {
            Route::post('/import-price', 'ProductController@importPrice')->name('import-price');
            Route::resource('/', 'ProductController')->parameters(['' => 'product']);
        });

        Route::prefix('categories')->as('categories.')->group(function () {
            Route::resource('/', 'CategoryController')->parameters(['' => 'category']);
        });

        Route::prefix('brands')->as('brands.')->group(function () {
            Route::resource('/', 'BrandController')->parameters(['' => 'brand']);
        });

        Route::prefix('import-image')->as('import-image.')->group(function () {
            Route::resource('/', 'ImageController');//->parameters(['' => 'product']);
        });

        Route::prefix('mysql-backup')->as('mysql-backup.')->group(function () {
            Route::resource('/', 'MysqlBackupController')->parameters(['' => 'mysql-backup']);
            Route::get('/download/{name}', 'MysqlBackupController@download')->name('download');
        });

    });

});
