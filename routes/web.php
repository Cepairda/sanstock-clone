<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::prefix(LaravelLocalization::setLocale())->group(function () {

    Auth::routes();
    //Route::get('/home', 'HomeController@index')->middleware(['auth:web', 'checkAccess'])->name('home');
    //Route::get('/home', 'HomeController@index')->name('home');
    // Route::get('/', 'HomeController@filter')->name('filter');

     //view page (test)
     //Route::get('/contacts', function () {return view('site.page.contacts');})->name('contacts');

     #Route::get('/blog', function () {return view('site.blog.index');})->name('blog');
     #Route::get('/blog/article', function () {return view('site.blog.article');})->name('article');


    // мои маршруты
    // Route::get('/test-api', 'Admin\PriceMonitoringController@getProductPriceMonitoringListByApi')->name('api.test');

    // New Post
    Route::prefix('new-post')->group(function () {

        Route::get('/areas', 'Admin\NewPost\NewPostController@getAreas')->name('get-areas');

        Route::get('/{regionRef}/settlements', 'Admin\NewPost\NewPostController@getSettlements')->name('get-settlements');

        Route::get('/{cityRef}/warehouses', 'Admin\NewPost\NewPostController@getWarehouses')->name('get-warehouses');

        Route::get('/{cityRef}/streets', 'Admin\NewPost\NewPostController@getStreets')->name('get-streets');


    });

    // конец моих маршрутов

    Route::get('/sitemap.xml', 'SitemapController@index');
    Route::get('/sitemap.xml/categories', 'SitemapController@categories');
    Route::get('/sitemap.xml/products', 'SitemapController@products');
    Route::get('/sitemap.xml/pages', 'SitemapController@pages');

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    $config = array_merge(config('translation-manager.route'), ['namespace' => '\Barryvdh\TranslationManager']);
    Route::group($config, function($router)
    {
        $router->get('view/{groupKey?}', 'Controller@getView')->where('groupKey', '.*')->name('view');
        $router->get('/{groupKey?}', 'Controller@getIndex')->where('groupKey', '.*')->name('index');
        $router->post('/add/{groupKey}', 'Controller@postAdd')->where('groupKey', '.*')->name('add');
        $router->post('/edit/{groupKey}', 'Controller@postEdit')->where('groupKey', '.*')->name('edit');
        $router->post('/groups/add', 'Controller@postAddGroup')->name('groups.add');
        $router->post('/delete/{groupKey}/{translationKey}', 'Controller@postDelete')->where('groupKey', '.*')->name('delete');
        $router->post('/import', 'Controller@postImport')->name('import');
        $router->post('/find', 'Controller@postFind')->name('find');
        $router->post('/locales/add', 'Controller@postAddLocale')->name('locales.add');
        $router->post('/locales/remove', 'Controller@postRemoveLocale')->name('locales.remove');
        $router->post('/publish/{groupKey}', 'Controller@postPublish')->where('groupKey', '.*')->name('publish');
        $router->post('/translate-missing', 'Controller@postTranslateMissing')->name('translate-missing');
    });

    Route::prefix('admin')->as('admin.')->middleware(['auth:web', 'checkAccess'])->namespace('Admin')->group(function () {

        Route::get('/', 'DashboardController@index')->name('dashboard.index');

        //StockImport
        Route::get('/stock-import', 'StockImportController@updateOrCreate')->name('stock-import');

        /**
         * Brands Import B2B
         */
        Route::get('/brand-import', 'BrandB2BImportController@import')->name('brand-import');

        /**
         * Category Import B2B
         */
        Route::get('/category-import', 'CategoryB2BImportController@import')->name('category-import');

        /**
         * Price and Balance Import B2B
         */
        Route::get('/price-import', 'StockImportController@importPrice')->name('price-import');

        Route::get('/import', 'ImportController@updateOrCreate')->name('import');
        Route::get('/import-queue', 'ImportController@updateOrCreateOnQueue')->name('import-queue');
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

        Route::prefix('partners')->as('partners.')->group(function () {
            Route::resource('/', 'PartnerController')->parameters(['' => 'partner'])->except(['show']);

            Route::post('/import', 'PartnerController@import')->name('import');
            Route::get('/create-search-string', 'PartnerController@createSearchString')->name('create-search-string');

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

        Route::prefix('blog-tags')->as('blog-tags.')->group(function () {
            Route::resource('/', 'BlogTagController')->parameters(['' => 'blog-tag']);

            Route::get('/create-search-string', 'BlogTagController@createSearchString')->name('create-search-string');
        });

        Route::prefix('pages')->as('pages.')->group(function () {
            Route::resource('/', 'PageController')->parameters(['' => 'page'])->except(['show']);

            Route::get('/create-search-string', 'PageController@createSearchString')->name('create-search-string');
        });

        Route::prefix('smart-filters')->as('smart-filters.')->group(function () {
            Route::resource('/', 'SmartFilterController')->parameters(['' => 'category']);
        });

        Route::prefix('comments')->as('comments.')->group(function () {
            Route::resource('/', 'CommentController')->parameters(['' => 'comment']);

            Route::get('/create-search-string', 'CommentController@createSearchString')->name('create-search-string');
        });

        Route::prefix('reviews')->as('reviews.')->group(function () {
            Route::resource('/', 'CommentController')->parameters(['' => 'comment']);

            Route::get('/create-search-string', 'CommentController@createSearchString')->name('create-search-string');
        });

        Route::prefix('icons')->as('icons.')->group(function () {
            Route::resource('/', 'IconController')->parameters(['' => 'icon']);

            Route::get('/create-search-string', 'IconController@createSearchString')->name('create-search-string');
        });

        Route::prefix('robots')->as('robots.')->group(function () {
            Route::resource('/', 'RobotsController')->parameters(['' => 'robot']);

            Route::get('/create-search-string', 'IconController@createSearchString')->name('create-search-string');
        });

        Route::prefix('html-blocks')->as('html-blocks.')->group(function () {
            Route::resource('/', 'HtmlBlockController')->parameters(['' => 'block']);

            Route::get('/create-search-string', 'HtmlBlockController@createSearchString')->name('create-search-string');
        });

        Route::prefix('setting')->as('setting.')->group(function () {
            Route::resource('/', 'SettingController')->parameters(['' => 'setting']);

            Route::get('/create-search-string', 'SettingController@createSearchString')->name('create-search-string');
        });

    });

    // New Post
    Route::get('admin/test-request', '\App\Http\Controllers\Admin\NewPost\NewPostController@sentRequest')->name('sent-request-new-post');

    //Site
    Route::as('site.')->namespace('Site')->group(function () {
        Route::get('/telegram-bot', 'TelegramBotController@index')->name('telegram-bot');
        Route::post('/telegram-bot', 'TelegramBotController@index')->name('telegram-bot');

        Route::get('live-search', 'ProductController@search')->name('products.live-search');

        Route::get('/', 'HomeController@index')->name('/');

        // корзина
        Route::get('/cart', 'CartController@loadCartView')->name('cart');
        Route::get('/order-products', 'CartController@getCartProducts')->name('order-products');
        Route::get('/order-products-table', 'CartController@getCartProductsTable')->name('order-products');
        Route::get('/cart/checkout', 'CartController@loadCheckout')->name('order-checkout');
        // оформить заказ
        Route::post('/checkout', 'CartController@checkout')->name('checkout');
        Route::get('/payment', 'CartController@payment')->name('payment');
        Route::get('/payment-platon', 'CartController@orderPayment')->name('payment-form');
        Route::get('/check-transaction-status', 'CartController@checkTransactionStatus')->name('check-transaction-status');
        Route::get('/checkout', 'CartController@successCheckout')->name('success-checkout');
        Route::get('/success-checkout/{order_id}/{payment_method}', 'CartController@moveToSuccessCheckoutPage')->name('move-to-success-checkout-page');
        Route::get('/start-frame', 'CartController@frame')->name('start-frame');

        // Google Pay
        Route::get('/google-pay', 'CartController@requestGooglePay')->name('google-pay-request-to-platon');
        Route::get('/google-pay-success', 'CartController@googlePayTransactionSuccess')->name('google-pay-success');

        // Apple Pay
        Route::get('/apple-pay-validation', 'CartController@applePayValidation')->name('apple-pay-validation');
        Route::get('/apple-pay', 'CartController@requestApplePayPlaton')->name('apple-pay-request-to-platon');
        Route::get('/apple-pay-success', 'CartController@applePayTransactionSuccess')->name('apple-pay-success');

        // export Prom.ua
        Route::get('/export-prom/{token}','ExportController@export')->name('export-prom');

        Route::get('search', 'SearchController@search')->name('products.search');
        Route::post('products/update-price', 'ProductController@updatePrice')->name('products.update-price');
        Route::post('products/get-first-additional', 'ProductController@getFirstAdditional')->name('products.get-first-additional');
        Route::get('/favorites', 'ResourceController@Favorites')->name('favorites');

        Route::get('/blog', 'BlogController@index')->name('blog');
        Route::get('/blog/tag/{tag}', 'BlogController@index')->where('tag', '[0-9]+')->name('blog-tag');
        Route::get('/blog/{slug}', 'BlogController@post')->name('blog-post');

        Route::get('/contacts', 'ContactController@index')->name('contacts');
        Route::post('/contacts', 'ContactController@contactForm')->name('contact-form');

        Route::get('/about-us', function(){
            return view('site.page.about-us');
        })->name('about-us');
        Route::get('/delivery', function(){
            return view('site.page.delivery');
        })->name('delivery');
        Route::get('/payments', function(){
            return view('site.page.payments');
        })->name('payments');
        Route::get('/guarantee', function(){
            return view('site.page.guarantee');
        })->name('guarantee');

//        test
        Route::get('/test', function () {
            return view('site.page.404');
        });

        Route::get('/documentation', function () {return view('site.page.documentation');})->name('documentations');
        Route::get('/documents/certificates', function () {return view('site.page.certificates');})->name('certificates');

        Route::post('/comments', 'CommentController@store')->name('comments.store');

        Route::get('/sitemap', function () {return view('site.page.sitemap');})->name('sitemap');

        Route::post('/show-more', 'ResourceController@showMore');

        Route::get('/{slug}', 'ResourceController@getResource')->where('slug', '.*')->name('resource');


    });
});
