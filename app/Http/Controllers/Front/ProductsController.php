<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    public function listing($url, Request $request)
    {

        if($request->ajax()){
            $data = $request->all();
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0)
            {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort']=="product_latest"){
                        $categoryProducts->orderBy('id','Desc');
                    }else if($data['sort']=="product_name_a_z"){
                        $categoryProducts->orderBy('product_name','Asc');
                    }else if($data['sort']=="product_name_z_a"){
                        $categoryProducts->orderBy('product_name','Desc');
                    }else if($data['sort']=="price_lowest"){
                        $categoryProducts->orderBy('product_price','Asc');
                    }else if($data['sort']=="price_highest"){
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                    else{
                        $categoryProducts->orderBy('id','Desc');
                    }

                    $categoryProducts = $categoryProducts->paginate(30);
                }

                return view('front.products.ajax_listing', compact('categoryDetails','categoryProducts','url'));
            }
            else{
                abort(404);
            }
        }else{
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0)
            {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->paginate(6);

                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $fitArray = $productFilters['fitArray'];
                $heightArray = $productFilters['heightArray'];
                $patternArray = $productFilters['patternArray'];

                $page_name = "listing";
                return view('front.products.listing', compact('categoryDetails','categoryProducts','url','fabricArray','sleeveArray','fitArray','heightArray','patternArray','page_name'));
            }
            else{
                abort(404);
            }
        }


    }

}
