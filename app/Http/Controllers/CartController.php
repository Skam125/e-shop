<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Delivery_type;
use App\Models\Order;
use App\Models\Order_products;
use App\Models\Product;
use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsInCart = false;

        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            $countsIds = array_keys($productsInCart);
            $products = Product::getProductsByCountsIds($countsIds);
            $totalPrice = Cart::getTotalPrice($products);
        }

        return view('cart.index', compact('products', 'productsInCart', 'totalPrice'));
    }

    public function add($id)
    {
        Cart::addProduct($id);
        return back();
    }

    public function delete($id)
    {
        Cart::deleteProduct($id);
        return back();
    }

    public function addAjax()
    {
        if(abs((int) Input::get('count'))){
            $count =abs((int) Input::get('count'));
        } else $count = 1;
        $id = Input::get('id');
        $data = Cart::addProduct($id, $count);
        return \Response::json($data);

    }

    public function actionAjax()
    {
        $id = Input::get('id');
        $action = Input::get('action');
        $data = Cart::plusMinusProduct($id, $action);
        return \Response::json($data);

    }
    
    public function checkout()
    {
        $result = false;

        $categories = Category::all();
        $delivery_types = Delivery_type::all();
        $productsInCart = Cart::getProducts();
        $totalCount = Cart::countItems();

        $countIds = array_keys($productsInCart);
        $products = Product::getProductsByCountsIds($countIds);
        $totalPrice = Cart::getTotalPrice($products);


        if (Input::get('action') == 'checkout') {


            $order = Order::create([
                'status_id' => 2,
                'phone' => Input::get('phone'),
                'client_name' => Input::get('name'),
                'delivery_type' => Input::get('delivery_type'),
                'delivery_address' => Input::get('delivery_address'),
                'comment' => Input::get('comment')
            ]);

            foreach ($products as $product) {
                     Order_products::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                         'price' => $product->price,
                         'attr_value' => $product->attr_value,
                         'count' => $productsInCart[$product->c_id],
                    ]);
            }
            Cart::clear();
            $result = true;
        }


        return view('cart.checkout', compact('delivery_types', 'categories', 'totalCount', 'totalPrice', 'result'));

    }


}
