<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Session;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page','produits');
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        return view('admin.products.products', compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if ($data['status']=='Actif') {
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 200, 'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();

        $message ="le produit a été supprimé avec succes!";
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id=null)
    {
        if($id==""){
            $title = "Ajouter un produit";
            $product = new Product;
            $productdata = array();
        } else {
            $title = "Modifier un produit";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata), true);
            $product = Product::find($id);
        }

        if($request->isMethod('post'))
        {
            $data = $request->all();

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' =>  'required|regex:/^[\pL\s\-]+$/u'
            ];

            $this->validate($request,$rules);

            if(empty($data['is_featured']))
            {
                $is_featured = "No";
            }else{
                $is_featured = "Yes";
            }

            if(empty($data['fabric'])){
                $data['fabric']="";
            }
            if(empty($data['wash_care'])){
                $data['wash_care']="";
            }
            if(empty($data['pattern'])){
                $data['pattern']="";
            }
            if(empty($data['sleeve'])){
                $data['sleeve']="";
            }
            if(empty($data['meta_description'])){
                $data['meta_description']="";
            }
            if(empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }
            if(empty($data['occasion'])){
                $data['occasion']="";
            }
            if(empty($data['fit'])){
                $data['fit']="";
            }
            if(empty($data['product_weight'])){
                $data['product_weight']="";
            }
            if(empty($data['product_discount'])){
                $data['product_discount']="";
            }

            if(empty($data['product_video'])){
                $data['product_video']="";
            }


            // Upload Category Image
            if ($request->hasFile('main_image')) {
                $fileName = $request->file('main_image')->getClientOriginalName();
                $path = $request->file('main_image')->storeAs('images/category_images/', $fileName, 'public');
                $product->main_image = '/storage/'.$path;
            }

            if ($request->hasFile('product_video')) {
                $fileName = $request->file('product_video')->getClientOriginalName();
                $path = $request->file('product_video')->storeAs('images/category_images/', $fileName, 'public');
                $data["product_video"] = '/storage/'.$path;
                $product->product_video = $fileName;

                if(empty($data['product_video'])){
                    $data['product_video']="";
                }
            }

            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            $product->product_video = $data['product_video'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            $product->save();

            return redirect('admin/produits');
        }

        $fabricArray = array('Coton','Polyester', 'laine', 'satin');
        $sleeveArray = array('Manche longue', 'Manche 3/4', 'Manche courte', 'Sans manche');
        $patternArray = array('vérifié', 'uni', 'imprimé', 'soi', 'solid');
        $fitArray = array('Régulier', 'Slim');
        $occasionArray = array('décontracté', 'formel');

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        return view('admin.products.add_edit_product', compact('title','fabricArray','sleeveArray','fitArray','occasionArray','patternArray','categories','productdata'));
    }

    public function deleteProductImage($id)
    {
        $productimage = Product::select('main_image')->where('id', $id)->first();
        $product_image_path = '/storage/images/product_images/';
        if(file_exists($product_image_path.$productimage->product_image))
        {
            unlink($product_image_path.$productimage->product_image);
        }

        product::where('id', $id)->update(['main_image'=>'']);

        $message ="la sous-catégorie a été mise a jour avec succes!";
        Session::flash('success_message',$message);
        return redirect()->back();
    }


}
