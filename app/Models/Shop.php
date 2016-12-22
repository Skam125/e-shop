<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Shop extends Model
{


public static function getAttributesByGroupId($id)
{
    return DB::select("SELECT c.title as attr_title, av.id as attr_val_id, av.value FROM attr_groups a
        JOIN attributes_attr_groups b on a.id = b.attr_group_id
        JOIN attributes c on b.attribute_id=c.id
        JOIN attr_values av on av.attribute_id=c.id
        where a.id=?", [$id]);
}

public static function filter(array $grouped_selected_attrs = array(), $selected_filters)
{


    $in_statement_for_selects = array();

    foreach ($grouped_selected_attrs as $group_key => $group) {
        $data_for_select = array();
        foreach ($group as $attr_id => $attr_value) {
            $data_for_select[] = $attr_id;
        }
        $in_statement = implode(',', $data_for_select);
        if ($in_statement) {
            $in_statement_for_selects[] = $in_statement;
        }
    }
    $i = 0;
    $result_sql = "SELECT DISTINCT tbl_1.product_id FROM ";

    $where = " WHERE 1";
    if ($selected_filters) {


        foreach ($in_statement_for_selects as $in) {
            $i++;
            $sql = '';

            if ($i > 1) {
                $sql .= " JOIN ";
            }

            $sql .= "(SELECT product_id FROM products_attr_values WHERE attr_value_id IN ({$in})) tbl_{$i}";

            if ($i > 1) {
                $sql .= " ON tbl_1.product_id = tbl_{$i}.product_id";
            }

            $where .= " AND tbl_{$i}.product_id is not null";

            $result_sql .= $sql;
        }

    } else {

        $result_sql = "SELECT id as product_id FROM products";
    }

    $result_sql .= $where;

    $items = DB::select($result_sql);

    $product_ids = array();

    if ($items) {
        foreach ($items as $item) {

            $product_ids[] = $item->product_id;
        }
    }

    return $product_ids;
}
    
}
