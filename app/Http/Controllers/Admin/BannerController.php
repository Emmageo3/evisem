<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;

class BannerController extends Controller
{
    public function banners()
    {
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners', compact('banners'));
    }

    public function updateBannerStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if ($data['status']=='Actif') {
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 200, 'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner(Request $request,$id)
    {
        Banner::where('id', $id)->delete();

        $request->session()->flash('success_message', 'la bannière a été supprimée avec succes!');
        return redirect()->back();
    }

    public function addEditBanner(Request $request, $id=null)
    {
        if($id==""){
            $title = "Ajouter une bannière";
            $banner = new Banner;
            $bannerdata = array();
        } else {
            $title = "Modifier la bannière";
            $bannerdata = Banner::find($id);
            $bannerdata = json_decode(json_encode($bannerdata), true);
            $banner = Banner::find($id);
        }

        if($request->isMethod('post'))
        {
            $data = $request->all();

            $rules = [
                'title' => 'required'
            ];

            $this->validate($request,$rules);

            if(empty($data['alt'])){
                $data['alt']="";
            }

            if(empty($data['link'])){
                $data['link']="";
            }


            // Upload Category Image
            if ($request->hasFile('image')) {
                $fileName = $request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('images/', $fileName, 'public');
                $banner->image = '/storage/'.$path;
            }

            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->alt = $data['alt'];
            $banner->status = 1;
            $banner->save();

            $message = "La banniere a été insérée avec succes";
            Session::flash('success_message', $message);
            return redirect('admin/banners');
        }

        return view('admin.banners.add_edit_banner', compact('title','bannerdata'));
    }
}
