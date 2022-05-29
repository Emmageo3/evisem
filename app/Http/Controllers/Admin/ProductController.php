<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
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
        } else {
            $title = "Modifier un produit";
        }

        $fabricArray = array('Coton','Polyester', 'laine');
        $sleeveArray = array('Manche longue', 'Manche 3/4', 'Manche courte', 'Sans manche');
        $patternArray = array('vérifié', 'uni', 'imprimé', 'soi', 'solid');
        $fitArray = array('Régulier', 'Slim');
        $occasionArray = array('décontracté', 'formel');

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        return view('admin.products.add_edit_product', compact('title','fabricArray','sleeveArray','fitArray','occasionArray','patternArray','categories'));
    }
}
