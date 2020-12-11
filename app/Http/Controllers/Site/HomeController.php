<?php
namespace App\Http\Controllers\Site;

use App\Resource;
use App\Category;
use App\Product;

class HomeController
{
  public function index()
  {
    return view('site.home.index');
  }
}
