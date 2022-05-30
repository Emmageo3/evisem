<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $featuredItemsCount = Product::where('is_featured', 'Yes')->where('status',1)->count();
        $featuredItems = Product::where('is_featured', 'Yes')->where('status',1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);

        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();

        $page_name = "index";
        return view('front.index', compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
    }

}
