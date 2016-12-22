<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_category extends Model
{
    protected $table='products_categories';
    protected $fillable=['category_id', 'product_id'];
    public $timestamps = false;
}
