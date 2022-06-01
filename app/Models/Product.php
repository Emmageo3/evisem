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
}
