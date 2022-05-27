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
        }else {
            $title="Modifier une sous-catégorie";
            $categorydata = Category::where('id', $id)->first();
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required|numeric',
                'url' => 'required',
                'category_image' => 'image'
            ];

            $this->validate($request,$rules);

            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
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

            Session::flash('success_message','La sous-catégorie a été insérée avec succes!');
            return redirect('admin/categories');
        }

        $getSections = Section::get();

        return view('admin.categories.add_edit_category', compact('title','getSections','categorydata'));
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
}
