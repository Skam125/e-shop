<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_attr_value extends Model
{
    protected $table= 'products_attr_values';
    protected $fillable = ['product_id', 'attr_value_id'];
    public $timestamps = false;
}
