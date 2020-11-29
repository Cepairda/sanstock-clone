<?php
namespace App\Http\Controllers\Site;

use App\Resource;
use App\Category;
use App\Product;

class HomeController
{
  public function index()
  {
    #$data['home_category'] = Resource::withoutGlobalScopes()->where()->get()->keyBy('id');
    #$data['home_product'] = Product::joinData()->whereIn('id', [1, 2, 3, 4])->get();
    #$data['home_posts'] = BlogPost::joinData()->withAlias()->wherePublished(true)->orderByDesc('created_at')->limit(12)->get();
    return view('site.home.index');
  }
}