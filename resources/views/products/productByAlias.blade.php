@extends('welcome')

@section('content')

    <style>
        .leftimg {
            height: auto;
            float: left; /* Выравнивание по левому краю */
            margin: 10px 10px 10px 0; /* Отступы вокруг картинки */
        }
    </style>


    <div class="col-md-3">
        <h3>Каталог</h3>
        <div class="list-group table-of-contents">
            @foreach($categories as $category)
                <a class="list-group-item {{ $category->id==$category_id ? 'active' : '' }}"
                   href="{{ url('category', $category->alias) }}">{{$category->title}}</a>
            @endforeach
        </div>
    </div>

    <div class="col-md-9">
        <div class="row">

            <h4 class="text-center">{{$product->title}}</h4>
            <img src="/public/images/{{$product->image}}" width="400px" alt="..." class="leftimg">
            <p><b>Цена: {{number_format($product->price, 2)}} грн.</b></p>
            @if($products_attrs)
                <div class="row">
                    <div class="col-lg-6">
                        {!! Form::open(['url'=>"cart/add", "class"=>'form-inline']) !!}
                        <label for="select-cart">{{$attrs_title}}</label>
                        <select id="select-cart" class="form-control">
                            @foreach($products_attrs as $item)
                                <option value="{{$item->id}}">{{$item->attr_value}}</option>
                            @endforeach
                        </select>
                        <label for="count">Количество</label>
                        <input type="number" name="count" value="1" id="count" min="1" max="99"
                               class="form-control form-inline">
                        <button type="submit" class="btn btn-default add-to-cart"
                                style='display:inline;'>В корзину
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            @else
                <p>Нету в наличии</p>
        </div>
        @endif

        <p> {{$product->description}}</p>



    </div>


    {{--коменты--}}
    <div class="row">
        @if (!Auth::guest())
            {!! Form::open(['url'=>'storeComment']) !!}
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <input type="hidden" name="user" value="{{Auth::user()->name}}">
            <div class="form-group">
                <label for="comment">Комментарии</label>
                    <textarea name="message" class="form-control" placeholder="Добавить коментарий"
                              id="comment"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default">Отправить</button>
            </div>
            {!! Form::close() !!}

        @endif

        <div>
            @foreach($comments as $comment)
                <h4>{{$comment->user}}</h4>
                <p>{{$comment->message}}</p>
                <p>Рейтинг комментария: {{$comment->rating}}</p>
                @if (!Auth::guest())
                    {!! Form::open(array('url'=>'plus')) !!}
                    <input type="hidden" name="id" value="{{$comment->id}}">
                    <div class="form-group">
                        <button class="btn btn-default">+</button>
                    </div>
                    {!! Form::close() !!}
                    {!! Form::open(['url'=>'minus']) !!}
                    <input type="hidden" name="id" value="{{$comment->id}}">
                    <div class="form-group">
                        <button class="btn btn-default">-</button>
                    </div>
                    {!! Form::close() !!}
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
    </div>



@endsection