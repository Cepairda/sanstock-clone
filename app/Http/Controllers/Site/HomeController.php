<?php
namespace App\Http\Controllers\Site;

use App\Resource;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Cache;

class HomeController
{
  public function index()
  {
//      return Cache::remember('heavy_view', 3600, function() {
//          return view('site.home.index')->render();
//      });

    return view('site.home.index');
  }
}
