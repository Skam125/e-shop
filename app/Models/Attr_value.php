<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Attr_value extends Model
{
    protected $table = 'attr_values';
    protected $fillable = ['attribute_id', 'value'];
    public $timestamps = false;

    public static function attributesByIds($id)
    {

        $result = array();

        if (is_array($id)) {
            $in = implode(',', $id);
        } else {
            $in = $id;
        }

        $sql = "SELECT a.value, b.title FROM attr_values a
        join attributes b on a.attribute_id = b.id 
        where a.id IN ({$in})";

        $attrs_values = DB::select($sql);

        if ($attrs_values) {
            foreach ($attrs_values as $item) {
                $result[$item->title] = $item->value;
            }
            return $result;
        } else {
            return false;
        }
    }
}
