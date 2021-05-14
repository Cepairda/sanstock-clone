<?php
namespace App\Http\Controllers\Site;

use App\Resource;
use App\Category;
use App\ProductSort;
use Illuminate\Support\Facades\Cache;

class HomeController
{
  public function index()
  {
    $productsBySort = [];

    for ($i = 0; $i < 4; $i++) {
        $productsGrade[] = ProductSort::joinLocalization()->where('details->grade', $i)->limit(8)->get();
    }

    foreach ($productsGrade as $key => $value) {
        if ($value->isNotEmpty()) {
            $productsBySort[$key] = $value;
        }
    }

    $productsGradeKey = array_keys($productsBySort);
    $gradeActiveDefault = min($productsGradeKey);

    return view('site.home.index', compact('productsBySort', 'productsGradeKey', 'gradeActiveDefault'));
  }
}
