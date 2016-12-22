<?php

namespace App\Http\Controllers;


use App\Models\Counts;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Mailing_list;
use App\Models\Product;
use App\Models\Products_category;
use App\Models\Shop;
use DB;
use Input;
use App\Http\Requests;


class ProductsController extends Controller
{



    public function productByAlias($alias)
    {
        $product = Product::where('alias', $alias)->get()->first();
        $products_attrs = Counts::attrsByProduct($product->id);
        $attrs_title = Counts::attributeTitle($products_attrs[0]->attr_value)->title;
        $comments = Comment::where('product_id', $product->id)->get();
        $categories = Category::all();
        $category_id = Product::categoryByProduct($product->id);

        return view('products.productByAlias', compact('product', 'products_attrs', 'attrs_title', 'comments', 'alias', 'categories', 'category_id'));
    }
    

    public function showByAlias($alias)
    {

        $category_attr_group = collect(DB::select('select a.id, c.title from categories c
        join attr_groups a on c.title=a.title
        where c.alias = ?', [$alias]))->first();

        $category = Category::where('alias', $alias)->get()->first();

        if ($category_attr_group) {
            $attrs = Shop::getAttributesByGroupId($category_attr_group->id);
        }

        $selected_filters = is_array(Input::get('filter')) ? Input::get('filter') : null;

        $attr_result = array();
        if (!empty($attrs)) {
            foreach ($attrs as $attr) {
                $attr_result[$attr->attr_title][$attr->attr_val_id] = $attr->value;
            }
        }

        $selected_attrs = $attr_result;
        
        foreach ($selected_attrs as $group_key => $attr_group) {

            foreach ($attr_group as $key => $value)

                if (is_array($selected_filters)) {
                    if (in_array($key, $selected_filters)) {
                        foreach ($selected_attrs[$group_key] as $key_unset => $value) {
                            if (!in_array($key_unset, $selected_filters)) {

                                unset($selected_attrs[$group_key][$key_unset]);


                            }
                        }
                    }

                }
        }

        $filtered_products_ids = Shop::filter($selected_attrs, $selected_filters);

        $products = Products_category::whereIn('product_id', $filtered_products_ids)->where('products_categories.category_id', '=', $category->id)->join('products', 'products.id', '=', 'products_categories.product_id')->paginate(9);


        return view('products.showByAlias', compact('products', 'attr_result', 'selected_filters', 'category'));
    }

    public function storeComment()
    {
        Comment::create([
            'user' => Input::get('user'),
            'message' => Input::get('message'),
            'product_id' => Input::get('product_id')
        ]);

        return back()->with(['flash_message' => 'Коментарий добавлен']);
    }

    public function plus()
    {
        Comment::where("id", Input::get('id'))->increment("rating");
        return back()->with(['flash_message' => 'Рейтинг увеличен']);
    }
    public function minus()
    {
        Comment::where("id", Input::get('id'))->decrement("rating");;
        return back()->with(['flash_message' => 'Рейтинг уменьшен']);
    }
    
    public function storeMail(){
        Mailing_list::create([
            'name' => Input::get('name'),
            'email' => Input::get('email')
        ]);
        return back()->with(['flash_message' => 'Вы подписались на рассылку']);
    }
    
    public function search(){
        $categories = Category::all();
        $searchText = Input::get('searchText');
        $products = Product::searchByTitle($searchText);
        return view('pages.search', compact('products', 'searchText', 'categories'));
    }
}


