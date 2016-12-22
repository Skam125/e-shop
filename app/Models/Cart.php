<?php

namespace App\Models;

use Session;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    public static function addProduct($id, $count)
    {
        $productsInCart = array();

        if (Session::has('products')) {
            $productsInCart = Session::get('products');
        }
        $productsInCart[$id] = $count;
        Session::put('products', $productsInCart);

        return self::countItems();
    }

    public static function plusMinusProduct($id, $action)
    {
        $productsInCart = array();
        $productsInCart = Session::get('products');

        if ($action == 'plus') {
                $productsInCart[$id]++;
        } else {
            if ($productsInCart[$id] > 1) {
                $productsInCart[$id]--;
            } else {$productsInCart[$id] = 1; }
        }

        Session::put('products', $productsInCart);


        $countsIds = array_keys($productsInCart);
        $products = Product::getProductsByCountsIds($countsIds);
        $totalPrice = number_format(self::getTotalPrice($products), 2);

        $result = ['countItems' => self::countItems(), 'value' => $productsInCart[$id], 'totalPrice' => $totalPrice];
        return $result;
    }

    public static function countItems()
    {
        if (Session::has('products')) {
            $count = 0;
            foreach (Session::get('products') as $id => $quantity) {
                $count += $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getProducts()
    {
        if (Session::has('products')) {
            return Session::get('products');
        } else {
            return false;
        }
    }

    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        $total = 0;

        if ($productsInCart) {
            foreach ($products as $product) {

                $total += $product->price * $productsInCart[$product->c_id];
            }
        }

        return number_format($total, 2);
    }

    /**
     * Удаляет товар с указанным id из корзины
     */
    public static function deleteProduct($id)
    {

        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        Session::put('products', $productsInCart);
    }

    /**
     * Очищает корзину
     */
    public static function clear()
    {
        if (Session::has('products')) {
            Session::forget('products');
        }
    }


}
