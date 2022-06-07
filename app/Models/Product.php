<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductsImage');
    }

    public static function productFilters()
    {
        $productFilters['fabricArray']= array('Coton','Polyester', 'laine', 'satin');
        $productFilters['sleeveArray'] = array('Manches extra longues', 'Trois-quart', 'Sans manches', 'Manches courtes', 'Manches longues', 'Manches mi-longues', 'Mancherons');
        $productFilters['patternArray'] = array('Crocodile', 'Galaxie', 'Léopard', 'Patchwork', 'Unicolore', 'Pois', 'Python', 'Tie dye', 'Tropical', 'Militaire', 'Rayures', 'Papillon', 'Imprimés aléatoires');
        $productFilters['fitArray'] = array('Basique', 'Simple', 'Vintage', 'Bohème', 'Sport', 'Sexy', 'BCBG', 'Glamour', 'Elegant', 'Casual');
        $productFilters['heightArray'] = array('Court', 'Mini','Mi-long', 'Maxi', 'Long', 'Aux genoux');
        return $productFilters;
    }

    public static function getDiscountedPrice($product_id)
    {
        $proDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount'] > 0)
        {
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
        }else if($catDetails['category_discount'])
        {
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$catDetails['category_discount']/100);
        }else
        {
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getDiscountedAttrPrice($product_id,$size)
    {
        $proAttrPrice =ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount'] > 0)
        {
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
        }else if($catDetails['category_discount'])
        {
            $discounted_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$catDetails['category_discount']/100);
        }else
        {
            $discounted_price = 0;
        }
        return array('product_price'=>$proAttrPrice['price'],'discounted_price'=>$discounted_price);
    }
}
