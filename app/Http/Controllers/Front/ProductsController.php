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
            $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->paginate(6);

            if(isset($_GET['sort']) && !empty($_GET['sort'])){
                if($_GET['sort']=="product_latest"){
                    $categoryProducts = Product::orderBy('id','Desc');
                }else if($_GET['sort']=="product_name_a_z"){
                    $categoryProducts = Product::orderBy('product_name','Asc');
                }else if($_GET['sort']=="product_name_z_a"){
                    $categoryProducts = Product::orderBy('product_name','Desc');
                }else if($_GET['sort']=="price_lowest"){
                    $categoryProducts = Product::orderBy('product_price','Asc');
                }else if($_GET['sort']=="price_highest"){
                    $categoryProducts = Product::orderBy('product_price','Desc');
                }
                else{
                    $categoryProducts = Product::orderBy('id','Desc');
                }

                $categoryProducts = $categoryProducts->paginate(30);
            }

            return view('front.products.listing', compact('categoryDetails','categoryProducts','url'));
        }else{
            abort(404);
        }
    }

}
