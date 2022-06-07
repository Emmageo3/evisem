<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;


class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page','categories');
        $categories = Category::with(['section', 'parentcategory'])->get();
        return view('admin.categories.categories', compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if ($data['status']=='Actif') {
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 200, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null){
        if($id==""){
            $title="Ajouter une sous-catégorie";
            $category = new Category;
            $categorydata = array();
            $getcategories = array();
            $message = "La sous catégorie a été ajoutée avec succes!";
        }else {
            $title="Modifier une sous-catégorie";
            $categorydata = Category::where('id', $id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            $getcategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getcategories = json_decode(json_encode($getcategories),true);
            $category = Category::find($id);
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required|numeric',
                'url' => 'required',
                'category_image' => 'required|image'
            ];

            $customMessages = [
                'category_image.required' => 'Veuillez insérer une image',
                'category_discount.required'=>'Veuillez mettre deux zéros si il n y a pas de remise'
            ];

            $this->validate($request,$rules,$customMessages);

            // Upload Category Image
            if ($request->hasFile('category_image')) {
                $fileName = $request->file('category_image')->getClientOriginalName();
                $path = $request->file('category_image')->storeAs('images/category_images/', $fileName, 'public');
                $data["category_image"] = '/storage/'.$path;
            }

            if(empty($data['category_discount'])){
                $data['category_discount']="";
            }

            if(empty($data['description'])){
                $data['description']="";
            }

            if(empty($data['meta_title'])){
                $data['meta_title']="";
            }

            if(empty($data['meta_description'])){
                $data['meta_description']="";
            }

            if(empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_image = $data['category_image'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            Session::flash('success_message', 'La sous catégorie a été modifiée avec succes!');
            return redirect('admin/categories');
        }

        $getSections = Section::get();

        return view('admin.categories.add_edit_category', compact('title','getSections','categorydata','getcategories'));
    }

    public function appendCategoriesLevel(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $getcategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            $getcategories = json_decode(json_encode($getcategories),true);
            return view('admin.categories.append_categories_level', compact('getcategories'));
        }
    }

    public function deleteCategoryImage(Request $request,$id)
    {
        $categoryimage = Category::select('category_image')->where('id', $id)->first();
        $category_image_path = '/storage/images/category_images/';
        if(file_exists($category_image_path.$categoryimage->category_image))
        {
            unlink($category_image_path.$categoryimage->category_image);
        }

        Category::where('id', $id)->update(['category_image'=>'']);

        $request->session()->flash('success_message', 'la sous-catégorie a été mise a jour avec succes!');
        return redirect()->back();
    }

    public function deleteCategory(Request $request,$id)
    {
        Category::where('id', $id)->delete();

        $request->session()->flash('success_message', 'la sous-catégorie a été supprimée avec succes!');
        return redirect()->back();
    }
}
