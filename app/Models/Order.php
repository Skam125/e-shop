<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['status_id', 'phone', 'client_name', 'delivery_type', 'delivery_address', 'comment', 'sum_payed'];
}
