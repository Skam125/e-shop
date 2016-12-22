<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attributes_attr_group extends Model
{
    protected $table = 'attributes_attr_groups';
    protected $fillable = ['attribute_id', 'attr_group_id'];
    public $timestamps = false;
}
