<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;

use App\Product;

class SitemapController extends Controller
{

    public function __construct()
    {
        //if (LOCALE != 'ru') { return abort(404); }
    }

	public function index ()
    {
		$pref = 'sitemap.xml';

		return response()->view('sitemap.index', [
			'sitemaps' => [
	            $pref . '/categories',
	            $pref . '/products',
	            $pref . '/pages',
        	]
        ])->header('Content-Type', 'text/xml');
	}

	public function pages()
    {
        return response()->view('sitemap.pages', [
            'pages' => [
	            ['url' => '/', 'lm' => '2020-12-17T12:27:45+00:00', 'p' => '1'],
	            ['url' => 'contacts', 'lm' => '2020-12-17T12:27:45+00:00', 'p' => '0.5'],
	            ['url' => 'about-us', 'lm' => '2020-12-17T12:27:45+00:00', 'p' => '0.5'],
	            ['url' => 'blog', 'lm' => '2020-12-17T12:27:45+00:00', 'p' => '0.5'],
	            ['url' => 'documentation', 'lm' => '2020-12-17T12:27:45+00:00', 'p' => '0.5'],
            ],
        ])->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Category::all()->where('details->published', 1);

        return response()->view('sitemap.categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::
        select('*', 'ua.data->name as ua_name', 'ru.data->name as ru_name')
        ->join('resource_localizations as ua', function($q) {
            $q->on('ua.resource_id', '=', 'resources.id')
                ->where('ua.locale', 'uk');
        })
        ->join('resource_localizations as ru', function($q) {
            $q->on('ru.resource_id', '=', 'resources.id')
                ->where('ru.locale', 'ru');
        })->where('details->published', 1)->orderByDesc('updated_at')->get();

        return response()->view('sitemap.products', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }
}
