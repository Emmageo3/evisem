<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public static function sections()
    {
        $getSections = Section::with('categories')->where('status',1)->get();
        $getSections = json_decode(json_encode($getSections), true);
        return $getSections;
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'section_id')->where(['parent_id'=>'ROOT','status'=>1])->with('subcategories');
    }
}
