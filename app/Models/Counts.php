<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Counts extends Model
{
    protected $table = 'counts';
    protected $fillable = ['product_id', 'count', 'attr_value'];
    public $timestamps = false;

    public static function attrsByProduct($id){
        $attrs = DB::table('counts')->where('product_id', '=', $id)->get();
        return $attrs;
    }

    public static function attributeTitle($attr){
        $attibute_title = DB::table('attr_values')
            ->select('title')
            ->join('attributes', 'attr_values.attribute_id', '=', 'attributes.id')
            ->where('value', '=', $attr)->first();
        return $attibute_title;
    }

}
