<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Session;

class SectionController extends Controller
{
    public function sections()
    {
        Session::put('page','sections');
        $sections = Section::get();
        return view('admin.sections.sections', compact('sections'));
    }

    public function updateSectionStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if ($data['status']=='Actif') {
                $status = 0;
            }else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 200, 'section_id'=>$data['section_id']]);
        }
    }
}
