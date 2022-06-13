<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Session;
use Auth;
use App\Models\ProductsAttribute;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        Paginator::useBootstrap();
        if($request->ajax()){
            $data = $request->all();
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0)
            {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                if(isset($data['fabric']) && !empty($data['fabric'])){
                    $categoryProducts->whereIn('products.fabric',$data['fabric']);
                }

                if(isset($data['sleeve']) && !empty($data['sleeve'])){
                    $categoryProducts->whereIn('products.sleeve',$data['sleeve']);
                }

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
            $url = Route::getFacadeRoot()->current()->uri();
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

    public function detail($id)
    {

        $productDetails = Product::with(['category','attributes'=>function($query){
            $query->where('status',1);
        },'images'])->find($id)->toArray();
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');
        $relatedProducts = Product::where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(3)->inRandomOrder()->get()->toArray();
        return view('front.products.detail', compact('productDetails','total_stock','relatedProducts'));
    }

    public function getProductPrice(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'],$data['size']);
            return $getDiscountedAttrPrice;
        }
    }

    public function addToCart(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            //echo $getProductStock['stock']; die;
            if($getProductStock['stock'] < $data['quantity'])
            {
                $message = "Désolé, nous ne disposons pas de la quantité que vous avez demandé";
                Session::flash('error_message',$message);
                return redirect()->back();
            }

            $session_id = Session::get('session_id');
            if(empty($session_id))
            {
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            if(Auth::check()){
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();
            }
            else{
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
            }


            if($countProducts>0)
            {
                Session::flash('error_message2');
                return redirect()->back();
            }

            if(Auth::check()){
                $user_id = Auth::user()->id;
            }else{
                $user_id = 0;
            }

            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            Session::flash('success_message');
            return redirect('cart');
        }
    }

    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        return view('front.products.cart', compact('userCartItems'));
    }

    public function updateCartItemQty(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            $cartDetails = Cart::find($data['cartid']);
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

            if($data['qty']>$availableStock['stock']){
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>"Le stock demandé n'est pas disponible",
                    'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))
                ]);
            }

            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize==0){
                return response()->json([
                    'status'=>false,
                    'message'=>"La taille demandée n'est pas disponible",
                    'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();
            return response()->json(
                [
                    'status'=>true,
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))
                ]);
        }
    }

    public function deleteCartItem(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            Cart::where('id',$data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))
            ]);
        }
    }


}
