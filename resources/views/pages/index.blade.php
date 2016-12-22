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
        <h3 class="text-center">Новинки</h3>
        @if(count($new_products))
            <div class="row">
                @foreach(array_chunk($new_products->all(), 3) as $row)
                    <div class="row">
                        @foreach($row as $item)
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail ">
                                    <img src="/public/images/{{$item->image}}">
                                    <div class="caption">
                                        <h4><a href="{{url('product', $item->alias)}}"> {{$item->title}}</a></h4>
                                        <p><b>Цена: {{number_format($item->price, 2)}} грн.</b></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

