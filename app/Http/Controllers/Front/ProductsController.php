<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    public function listing($url)
    {
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount>0)
        {
            $categoryDetails = Category::categoryDetails($url);
            $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->get()->toArray();
            return view('front.products.listing', compact('categoryDetails','categoryProducts'));
        }else{
            abort(404);
        }
    }

}
