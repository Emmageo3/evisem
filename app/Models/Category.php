<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subcategories()
    {
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id')->select('id', 'name');
    }

    public function parentcategory()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id')->select('id','category_name');
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id','category_name','url')->with(['subcategories'=>function($query){
            $query->select('id','parent_id')->where('status',1);
        }])->where('url',$url)->first()->toArray();
        $catIds = array();
        $catIds[] = $categoryDetails['id'];
        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }

        return array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails);
    }
}
