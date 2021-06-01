<?php
namespace App\Http\Controllers\Site;

use App\ProductSort;

class HomeController
{
  public function index()
  {
    $productsBySort = [];

    for ($i = 0; $i < 4; $i++) {
        $productsGrade[] = ProductSort::joinLocalization()
            ->withProductGroup()
            ->withNotShowProductsBalanceZero()
            ->where('details->grade', $i)->limit(8)->get();
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
