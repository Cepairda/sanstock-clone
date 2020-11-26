<?php

use Illuminate\Support\Facades\Route;


Route::group([

    'namespace' => 'Site',
    'prefix' => LaravelLocalization::setLocale(),
    #'middleware' => 'trailingSlash'

], function () {

  $currentLocale = LaravelLocalization::getCurrentLocale();
  $pathInfo = preg_replace('/page=[0-9]+/', '', request()->getPathInfo());

//    dd(config('old_url')[trim($pathInfo, '/')]);
//    if (isset(config('old_url')[trim($pathInfo, '/')])) {
//        Route::redirect(config('old_url')[trim($pathInfo, '/')], 301);
//        redirect(config('old_url')[trim($pathInfo, '/')], 301);
//    }

//    dd($pathInfo);
  $url = trim(Str::replaceFirst(('/' . $currentLocale . '/'), '', $pathInfo), '/');
//    $index = 1;
//
//    if ($currentLocale != config('app.fallback_locale')) {
//        $url = str_replace('/' . $currentLocale, '', $pathInfo);
//        $index = 2;
//    }
 // $alias = App\Alias::where('url', $url)->first();
//    if (!isset($alias)) {
//        $alias = App\Alias::where('url', request()->segment($index))->first();
//    }

//    dd($url);

//  if (isset($alias)) {
//    if ($alias->type == 'brand') {
//      Route::get('{brandUrl}/{page?}', 'BrandController@show');
//    }
//    if ($alias->type == 'category') {
//      Route::get('{categoryUrl}/{page?}', 'CategoryController@show');
//    }
//    if ($alias->type == 'product_group') {
//      Route::get('{groupUrl}', 'ProductGroupController@show');
//    }
//    if ($alias->type == 'product') {
//      Route::get('{categoryUrl}/{productUrl}/', 'ProductController@show');
//    }
//    if ($alias->type == 'page') {
//      Route::get('/{pageAlias}', 'PageController@index');
//    }
//  }

  #Route::get('blog/{aliasOrPage?}/', 'BlogController@index');

  Route::get('/', 'HomeController@index')->name('/');
  Route::get('/blog', function () {return view('site.blog.index');})->name('blog');
  #Route::get('sale-points', 'SalePointController@index')->name('sale-points');
  #Route::post('products/update-prices', 'ProductController@updatePrices');
  #Route::post('back-call', 'PageController@backСall');
  #Route::post('order-project', 'PageController@orderProject');
  #Route::post('order-product', 'PageController@orderProduct');

  #Route::get('calculators', 'CalcController@index');

  #Route::post('calculator', 'PageController@calc');
  #Route::get('search/{value?}/{page?}', 'SearchController@show');
  #Route::post('search', 'SearchController@filtering');

  #Route::get('promotions', 'PromotionsController@index');
  #Route::get('promotions/{value?}', 'PromotionsController@show');

});

Route::prefix(LaravelLocalization::setLocale())->group(function () {

    Auth::routes();
    //Route::get('/home', 'HomeController@index')->middleware(['auth:web', 'checkAccess'])->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    #Route::get('/', function () {return view('site.home.index');})->name('/');
    #Route::get('/category', function () {return view('site.categories.show');})->name('category');
    #Route::get('/product', function () {return view('site.products.show');})->name('product');
    #Route::get('/contacts', function () {return view('site.pages.contacts');})->name('contacts');
    #Route::get('/documents', function () {return view('site.pages.documents');})->name('documents');
    #Route::get('/documents/certificates', function () {return view('site.pages.certificates');})->name('certificates');
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

    Route::namespace('Site')->group(function () {
        Route::get('/{slug}', 'ResourceController@getResource')->where('slug', '.*');
    });
});
