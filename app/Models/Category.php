<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['parent_id', 'title', 'alias'];
    public $timestamps = false;
}
