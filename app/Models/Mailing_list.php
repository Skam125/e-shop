<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing_list extends Model
{
    protected $table= 'mailing_list';
    protected $fillable = ['name', 'email'];
    public $timestamps = false;
}
