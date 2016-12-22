<?php

namespace App\Http\Controllers;


use App\Models\Attr_group;
use App\Models\Counts;
use App\Models\Attr_value;
use App\Models\Attribute;
use App\Models\Attributes_attr_group;
use App\Models\Order;
use App\Models\Product;
use App\Models\Products_attr_value;
use App\Models\Products_category;
use Illuminate\Http\Request;
use App\Models\Category;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;

class AdminController extends Controller
{

    public function index()
    {
        
        $attr_values = Attr_value::all()->sortBy("attribute_id");
        $categories = Category::all();
        $attributes = Attribute::all();
        $products = Product::all();
        $attr_groups = Attr_group::all();
        return view('admin.index', compact('categories', 'attributes', 'products', 'attr_groups', 'attr_values'));
    }

    public function showOrders(){

        $orders = DB::table('orders')->join('order_statuses', 'order_statuses.id', '=', 'orders.status_id')->orderBy('created_at', 'desc')->get();

        return view('admin_order.index', compact('orders'));
    }
    
    public function showProducts(){
        
        return view('admin_product.index');
    }
    
    public function showCategory(){
        
        return view('admin_category.index');
    }
    
    public function storeCategory()
    {

        $category = DB::select('select id from categories where title=?', [Input::get('categoryTitle')]);
        if ($category) {
            return redirect('/admin')->with(['flash_message' => 'Такая категория уже существует!']);
        } else {
            Category::create([
                'title' => Input::get('categoryTitle'),
                'alias' => Input::get('categoryAlias'),
            ]);
            Attr_group::create([
                'title' => Input::get('categoryTitle'),
            ]);
        }

        return back()->with(['flash_message' => 'Категория добавлена']);
    }

    public function storeAttributeAttrValuesGroup()
    {
        $arrayAttributeId = Input::get('attributeID');
        $attr_group_id = Input::get('attr_group_id');

        foreach ($arrayAttributeId as $id) {
            $query = DB::select("select * from attributes_attr_groups  where attribute_id=? AND attr_group_id=?", [$id, $attr_group_id]);
            if (!$query) {
                Attributes_attr_group::create([
                    'attribute_id' => $id,
                    'attr_group_id' => $attr_group_id,
                ]);
            }
        }

        return back()->with(['flash_message' => 'Аттрибуты добавлены в групу']);
    }

    public function storeAttribute()
    {
        $attribute = DB::select('select id from attributes where title=?', [Input::get('attributeTitle')]);

        if ($attribute) {
            return redirect('/admin')->with(['flash_message' => 'Такой атрибут уже существует!']);
        } else {
            Attribute::create([
                'title' => Input::get('attributeTitle'),
            ]);
        }
        return back()->with(['flash_message' => 'Атрибут добавлен']);
    }

    public function storeAttrValue()
    {
        $attr_value = DB::select('select id from attr_values where value=? and attribute_id=?', [Input::get('attributeValue'), Input::get('attributeID')]);

        if ($attr_value) {
            return redirect('/admin')->with(['flash_message' => 'Аттрибут с таким значением уже существует']);
        } else {
            Attr_value::create([
                'attribute_id' => Input::get('attributeID'),
                'value' => Input::get('attributeValue'),
            ]);
        }
        return back()->with(['flash_message' => 'Значение аттрибута добавлено']);
    }

    public function storeNewProduct()
    {
        $product_id = DB::select('select id from products where title=?', [Input::get('title')]);


        if ($product_id) {
            return redirect('/admin')->with(['flash_message' => 'Такой товар уже существует']);
        } else {

            $image = Input::file('image');
            $product = Product::create([
                'title' => Input::get('title'),
                'alias' => Input::get('alias'),
                'description' => Input::get('description'),
                'price' => Input::get('price'),
                'is_new' => Input::get('is_new'),
                'is_popular' => Input::get('is_popular'),
            ]);
            Products_category::create([
                'category_id' => Input::get('category'),
                'product_id' => $product->id,
            ]);
            $move = $image->move('public/images', $product->id . '.' . $image->getClientOriginalExtension());

            if ($move) {
                $product->image = $product->id . '.' . $image->getClientOriginalExtension();
                $product->save();
            }
            return back()->with(['flash_message' => 'Товар добавлен']);
        }
    }

    public function storeCount()
    {
        $check = Counts::where('attr_value', '=', Input::get('attr_value'))->where('product_id', '=', Input::get('productID'))->select('id')->first();

        if ($check) {
            return back()->with(['flash_message' => 'Уже есть в базе']);
        } else {
            Counts::create([
                'product_id' => Input::get('productID'),
                'count' => Input::get('count'),
                'attr_value' => Input::get('attr_value'),
            ]);
            return back()->with(['flash_message' => 'Добавлено']);
        }
    }

    public function storeProductAttributes()
    {
        $arrayAttributeId = Input::get('attributeID');
        $product_id = Input::get('productID');

        foreach ($arrayAttributeId as $id) {
            $query = DB::select("select * from products_attr_values  where attr_value_id=? AND product_id=?", [$id, $product_id]);
            if (!$query) {
                Products_attr_value::create([
                    'product_id' => $product_id,
                    'attr_value_id' => $id,
                ]);
            }
        }
        return back()->with(['flash_message' => 'Значение аттрибутов добавлены']);
    }
}