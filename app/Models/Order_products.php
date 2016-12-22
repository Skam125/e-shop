<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_products extends Model
{
    protected $table = 'order_products';
    protected $fillable = ['order_id', 'product_id', 'price', 'attr_values', 'count'];
    public $timestamps = false;
}
