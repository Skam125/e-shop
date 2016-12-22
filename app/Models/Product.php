<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Product extends Model
{
    protected $table='products';
    protected $fillable=['title', 'alias', 'image', 'description', 'price', 'is_new', 'is_popular'];

    public static function getProductsByCountsIds($idsArray){
        $products = DB::table('products')
            ->select('products.alias', 'counts.id as c_id', 'products.id', 'products.title', 'products.price', 'counts.count', 'counts.attr_value')
            ->join('counts', 'products.id', '=', 'counts.product_id')
            ->whereIn('counts.id', $idsArray)
            ->get();
        return $products;
    }

    public static function searchByTitle($searchText){
        $result = self::where('title', 'like', "%{$searchText}%")
            ->paginate(9);
        return $result;
    }

    public static function categoryByProduct($productId){
        $category = DB::table('products')
            ->join('products_categories', 'products.id', '=', 'products_categories.product_id')
            ->select('category_id')
            ->where('products.id', '=', "{$productId}")
            ->first();
        return $category->category_id;
    }
}
