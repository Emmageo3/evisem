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
use App\Models\Coupon;
use App\Models\ProductsAttribute;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrdersProduct;
use Session;
use Auth;
use DB;


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

                    $categoryProducts = $categoryProducts->paginate(9);
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

    public function applyCoupon(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $userCartItems = Cart::userCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if($couponCount==0){
                $userCartItems = Cart::userCartItems();
                $totalCartItems = totalCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Ce coupon est invalide',
                    'totalCartItems' => $totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))]);
            }else{

                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                if($couponDetails->status==0){
                    $message = "Ce coupon n'est pas actif";
                }

                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date<$current_date){
                    $message = "Ce coupon a expiré";
                }

                $catArr = explode(",", $couponDetails->categories);
                $userCartItems = Cart::userCartItems();

                if(!empty($couponDetails->users)){

                    $userArr = explode(",", $couponDetails->users);
                    foreach ($userArr as $key => $user) {
                        $getUserId = User::select('id')->where('email',$user)->first()->toArray();
                        $userId[] = $getUserId['id'];
                    }

                }

                $total_amount = 0;

                foreach ($userCartItems as $key => $item) {

                    if(!in_array($item['product']['category_id'], $catArr)){
                        $message = "Ce coupon ne correspond à aucune catégorie de produit de votre panier";
                    }

                    if(!empty($couponDetails->users)){
                        if(!in_array($item['user_id'], $userId)){
                            $message = "Ce coupon ne vous appartient pas";
                        }
                    }


                    $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                if(isset($message)){
                    $userCartItems = Cart::userCartItems();
                    $totalCartItems = totalCartItems();
                    $couponAmount = 0;
                    return response()->json([
                    'status'=>false,
                    'message'=>$message,
                    'couponAmount'=>$couponAmount,
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))
                    ]);
                } else{
                    if($couponDetails->amount_type=="fixe"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }

                    $grand_total = $total_amount - $couponAmount;

                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']);

                    $message = "Votre coupon a été appliqué";
                    $totalCartItems = totalCartItems();
                    $userCartItems = Cart::userCartItems();

                    return response()->json([
                        'status'=>true,
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'view'=>(String)View::make('front.products.cart_items', compact('userCartItems'))
                    ]);

                }

            }
        }
    }

    public function checkout(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['address_id'])){
                $message ="Veuillez choisir une adresse de livraison";
                Session::flash('error_message1', $message);
                return redirect()->back();
            }
            if(empty($data['payment_gateway'])){
                $message = "Veuillez sélectionner une méthode de paiement";
                Session::flash('error_message2', $message);
                return redirect()->back();
            }

            if($data['payment_gateway']=="COD"){
                $payment_method = "COD";

                $orderDetails = Order::with('order_products')->where('id', $order_id)->first()->toArray();

                $email = Auth::user()->email;
                $messageData = [
                    'email'=> $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' =>  $orderDetails
                ];

                Mail::send('emails.order', $messageData, function($message) use($email){
                    $message->to($email)->subject('Commande enregistrée - Evisem');
                });

            }else{
                $payment_method = "Prepaid";
            }

            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();

            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = 1000;
            $order->coupon_code = Session::get('coupon_code');
            $order->coupon_amount = Session::get('coupon_amount');
            $order->order_status = "new";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $cartItems = Cart::where('user_id', Auth::user()->id)->get()->toArray();
            foreach ($cartItems as $key => $item) {
                $cartItem  = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                $cartItem->product_price = $getDiscountedAttrPrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }

            Session::put('order_id', $order_id);

            DB::commit();

            if($data['payment_gateway']=="COD"){
                return redirect('/thanks');
            }else{
                echo "bientot disponible";
                $payment_method = "Paiement en ligne";
            }
        }
        $userCartItems = Cart::userCartItems();
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        return view('front.products.checkout', compact('userCartItems','deliveryAddresses'));
    }

    public function addEditDeliveryAddress(Request $request, $id=null)
    {
        if($id==""){
            $title = "Ajouter une adresse";
            $address = new DeliveryAddress;
            $message = "Votre adresse a été ajoutée avec succès";
        } else {
            $title = "Modifier l'adresse";
            $address = DeliveryAddress::find($id);
            $message = "Votre adresse a été modifiée avec succès";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'mobile' => 'required|numeric'
            ];

            $customMessages = [
                'name.required' => 'Veuillez saisir votre nom complet',
                'mobile.required' => 'Veuillez saisir un numéro de téléphone valide',
            ];

            $this->validate($request,$rules,$customMessages);

            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->mobile = $data['mobile'];
            $address->save();

            Session::flash('success_message',$message);
            return redirect('checkout');
        }

        $countries = Country::where('status',1)->get()->toArray();
        return view('front.products.add_edit_delivery_address', compact('title','countries','address'));
    }

    public function deleteDeliveryAddress($id)
    {
        DeliveryAddress::where('id',$id)->delete();
        $message = "L'adresse a été supprimée avec succés!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }


    public function thanks()
    {
        if(Session::has('order_id')){
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('/cart');
        }

    }
}
