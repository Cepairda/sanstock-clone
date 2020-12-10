<?php

use Illuminate\Support\Facades\Route;

Route::prefix(LaravelLocalization::setLocale())->group(function () {

    Auth::routes();
    //Route::get('/home', 'HomeController@index')->middleware(['auth:web', 'checkAccess'])->name('home');
    //Route::get('/home', 'HomeController@index')->name('home');
    // Route::get('/', 'HomeController@filter')->name('filter');

     //view page (test)
     Route::get('/contacts', function () {return view('site.page.contacts');})->name('contacts');
     Route::get('/documentation', function () {return view('site.page.documentation');})->name('documentations');
     Route::get('/documents/certificates', function () {return view('site.page.certificates');})->name('certificates');
     #Route::get('/blog', function () {return view('site.blog.index');})->name('blog');
     #Route::get('/blog/article', function () {return view('site.blog.article');})->name('article');

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
            Route::get('/create-search-string', 'CategoryController@createSearchString')->name('create-search-string');

        });

        Route::prefix('products')->as('products.')->group(function () {
            Route::resource('/', 'ProductController')->parameters(['' => 'product'])->except(['show']);

            Route::post('/import-price', 'ProductController@importPrice')->name('import-price');
            Route::get('/export', 'ProductController@export')->name('export');
            Route::post('/import', 'ProductController@import')->name('import');
            Route::get('/create-search-string', 'ProductController@createSearchString')->name('create-search-string');

        });

        Route::prefix('characteristics')->as('characteristics.')->group(function () {
            Route::resource('/', 'CharacteristicController')->parameters(['' => 'characteristic'])->except(['show']);

            Route::get('/create-search-string', 'CharacteristicController@createSearchString')->name('create-search-string');
        });

        Route::prefix('characteristic-groups')->as('characteristic-groups.')->group(function () {
            Route::resource('/', 'CharacteristicGroupController')->parameters(['' => 'characteristic-group'])->except(['show']);
        });

        Route::prefix('sale-points')->as('sale-points.')->group(function () {
            Route::resource('/', 'SalePointController')->parameters(['' => 'sale-point'])->except(['show']);

            Route::get('/create-search-string', 'SalePointController@createSearchString')->name('create-search-string');
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
            Route::resource('/', 'BlogCategoryController')->parameters(['' => 'blog-category'])->except(['show']);

            Route::get('/create-search-string', 'BlogCategoryController@createSearchString')->name('create-search-string');
        });

        Route::prefix('blog-posts')->as('blog-posts.')->group(function () {
            Route::resource('/', 'BlogPostController')->parameters(['' => 'blog-post']);

            Route::get('/create-search-string', 'BlogPostController@createSearchString')->name('create-search-string');
        });

        Route::prefix('pages')->as('pages.')->group(function () {
            Route::resource('/', 'PageController')->parameters(['' => 'page'])->except(['show']);

            Route::get('/create-search-string', 'PageController@createSearchString')->name('create-search-string');
        });

        Route::prefix('smart-filters')->as('smart-filters.')->group(function () {
            Route::resource('/', 'SmartFilterController')->parameters(['' => 'category']);
        });
    });

    Route::as('site.')->namespace('Site')->group(function () {
        Route::get('/', 'HomeController@index')->name('/');
        Route::get('live-search', 'ProductController@search')->name('products.live-search');
        Route::get('search', 'SearchController@search')->name('products.search');
        Route::post('products/update-price', 'ProductController@updatePrice')->name('products.update-price');
        Route::get('/favorites', 'ResourceController@Favorites')->name('favorites');
        Route::get('/sitemap', function () {return view('site.page.sitemap');})->name('sitemap');
        Route::get('/{slug}', 'ResourceController@getResource')->where('slug', '.*')->name('resource');
    });
});
