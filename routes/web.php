<?php

use Illuminate\Support\Facades\Route;

Route::prefix(LaravelLocalization::setLocale())->group(function () {

    Auth::routes();
    //Route::get('/home', 'HomeController@index')->middleware(['auth:web', 'checkAccess'])->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/filter', 'HomeController@filter')->name('filter');

    Route::get('/', function () {return view('site.home.index');})->name('/');
    Route::get('/category', function () {return view('site.categories.show');})->name('category');
    Route::get('/product', function () {return view('site.products.show');})->name('product');
    Route::get('/contacts', function () {return view('site.pages.contacts');})->name('contacts');
    Route::get('/documents', function () {return view('site.pages.documents');})->name('documents');
    Route::get('/documents/certificates', function () {return view('site.pages.certificates');})->name('certificates');
    Route::get('/blog', function () {return view('site.blog.index');})->name('blog');
    Route::get('/blog/article', function () {return view('site.blog.article');})->name('article');



    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::prefix('admin')->as('admin.')->middleware('checkAccess')->namespace('Admin')->group(function () {

        Route::get('/', 'DashboardController@index')->name('dashboard.index');

        Route::get('/import', 'ImportController@updateOrCreate')->name('import');
        Route::get('/import-export', 'ImportExportController@index')->name('import-export');

        Route::prefix('brands')->as('brands.')->group(function () {
            Route::resource('/', 'BrandController')->parameters(['' => 'brand']);
        });

        Route::prefix('categories')->as('categories.')->group(function () {
            Route::resource('/', 'CategoryController')->parameters(['' => 'category'])->except(['show']);

            Route::get('/export', 'CategoryController@export')->name('export');
            Route::post('/import', 'CategoryController@import')->name('import');
        });

        Route::prefix('products')->as('products.')->group(function () {
            Route::resource('/', 'ProductController')->parameters(['' => 'product'])->except(['show']);

            Route::post('/import-price', 'ProductController@importPrice')->name('import-price');
            Route::get('/export', 'ProductController@export')->name('export');
            Route::post('/import', 'ProductController@import')->name('import');
        });

        Route::prefix('characteristics')->as('characteristics.')->group(function () {
            Route::resource('/', 'CharacteristicController')->parameters(['' => 'characteristic'])->except(['show']);
        });

        Route::prefix('characteristic-groups')->as('characteristic-groups.')->group(function () {
            Route::resource('/', 'CharacteristicGroupController')->parameters(['' => 'characteristic-group'])->except(['show']);
        });

        Route::prefix('sale-points')->as('sale-points.')->group(function () {
            Route::resource('/', 'SalePointController')->parameters(['' => 'sale-point'])->except(['show']);
        });

        Route::prefix('users')->as('users.')->group(function () {
            Route::resource('/', 'UserController')->parameters(['' => 'user'])->except(['show']);

            Route::get('/{id}/accesses', 'UserController@accesses')->name('accesses');
            Route::post('/{id}/accesses/update', 'UserController@updateAccesses')->name('accesses.update');
        });

        Route::prefix('roles')->as('roles.')->group(function () {
            Route::resource('/', 'RoleController')->parameters(['' => 'role']);
            Route::get('/{id}/accesses', 'RoleController@accesses')->name('accesses');
            Route::post('/{id}/accesses/update', 'RoleController@updateAccesses')->name('accesses.update');
        });

        Route::prefix('import-image')->as('import-image.')->group(function () {
            Route::resource('/', 'ImageController');//->parameters(['' => 'product']);
        });

        Route::prefix('mysql-backup')->as('mysql-backup.')->group(function () {
            Route::resource('/', 'MysqlBackupController')->parameters(['' => 'mysql-backup']);
            Route::get('/download/{name}', 'MysqlBackupController@download')->name('download');
        });

        Route::prefix('blog-categories')->as('blog-categories.')->group(function () {
            Route::resource('/', 'BlogCategoryController')->parameters(['' => 'blog-category']);
        });

        Route::prefix('blog-posts')->as('blog-posts.')->group(function () {
            Route::resource('/', 'BlogPostController')->parameters(['' => 'blog-post']);
        });

        Route::prefix('pages')->as('pages.')->group(function () {
            Route::resource('/', 'PageController')->parameters(['' => 'page']);
        });

        Route::prefix('smart-filters')->as('smart-filters.')->group(function () {
            Route::resource('/', 'SmartFilterController')->parameters(['' => 'category']);
        });
    });

    Route::as('site.')->namespace('Site')->group(function () {
        //Route::get('/', 'HomeController@index')->name('home');
        Route::get('/{slug}', 'ResourceController@getResource')->where('slug', '.*')->name('slug');
    });
});
