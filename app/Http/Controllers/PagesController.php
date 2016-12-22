<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function index()
    {
        $new_products = Product::where('is_new', 1)->orderBy('created_at','desc')->take(6)->get();
        $categories = Category::all();
        return view('pages.index', compact('categories', 'new_products'));
    }

    public function contacts(){


        
        return view('pages.contacts', compact(''));
    }

    

}
