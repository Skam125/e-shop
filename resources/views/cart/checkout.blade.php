@extends('welcome')
@section('content')
    <div class="col-md-3">
        <h3>Каталог</h3>
        <div class="list-group table-of-contents">
            @foreach($categories as $category)
                <a class="list-group-item" href="{{ url('category', $category->alias) }}">{{$category->title}}</a>
            @endforeach

        </div>
    </div>
    <div class="col-md-9">
        <h3 class="text-center">Корзина</h3>
        @if($result)
        <p>Заказ оформлен. Мы Вам перезвоним!</p>
        @else
            <p>Выбрано товаров {{$totalCount}}, на сумму: {{$totalPrice}} грн.</p>
            {!! Form::open(['url'=>'cart/checkout']) !!}
            <input type="hidden" name="action" value="checkout">
            <div class="form-group">
                {!! Form::label('name', 'Имя')!!}
                {!! Form::text('name',  Auth::user()->name, ['required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', 'Номер телефона')!!}
                {!! Form::text('phone', null, ['required' => 'required']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('delivery_type', 'Тип доставки')!!}
                <select name="delivery_type" id="delivery_type">
                    @foreach($delivery_types as $delivery_type)
                        <option value="{{$delivery_type->id}}">{{$delivery_type->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('delivery_address', 'Адрес доставки')!!}
                {!! Form::text('delivery_address', null, ['required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('comment', 'Комментарий')!!}
                {!! Form::text('comment') !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Оформить', ['class' => 'btn btn-default']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    </div>

@endsection
