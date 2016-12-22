@extends('welcome')

@section('content')
    <h2>Корзина</h2>
    @if($productsInCart)
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Код товара</th>
                <th>Название</th>
                <th>Стоимость</th>
                <th>Количество</th>
                <th>Атрибуты</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>#{{$product->c_id}}</td>
                    <td><a href="{{url('product', $product->alias)}}">{{$product->title}}</a></td>
                    <td>{{$product->price}} грн.</td>
                    <td><button attr_id="{{$product->c_id}}" attr_count="{{$productsInCart[$product->c_id]}}" class="cart_plus">+</button>
                        <span id="{{$product->c_id}}">{{$productsInCart[$product->c_id]}}</span> шт.
                        <button attr_id="{{$product->c_id}}" attr_count="{{$productsInCart[$product->c_id]}}" class="cart_minus">-</button>

                    </td>
                    <td>{{$product->attr_value}}</td>
                    <td><a href="{{url('cart/delete', $product->c_id)}}">X</a></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">Общая стоимость:</td>
                <td><span id="totalPrice">{{$totalPrice}}</span> грн.</td>

            </tr>
            </tfoot>
        </table>
        <a href="{{url('cart/checkout')}}">Оформить заказ</a>
    @else
        <p>Корзина пуста</p>
    @endif
@endsection