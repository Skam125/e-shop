@extends('welcome')


@section('content')
    <div class="col-md-3">
        <h3>Все товары:</h3>
        <style>
            label {
                font-weight: normal;
            }
        </style>
        {!! Form::open(array('url' => url('/products'), 'method' => 'get')) !!}
        <div class="form-group">
            @foreach($attr_result as $key => $attrs)
                <b>{{$key}}</b><br>
                @foreach($attrs as $attr_val_id => $attr_val)
                    {!! Form::checkbox('filter[]', $attr_val_id, (is_array($selected_filters) ? (in_array($attr_val_id, $selected_filters) ? 'checked': null) : ''), ['id' => "attr_$attr_val_id"]) !!}
                    {!! Form::label("attr_$attr_val_id", "$attr_val") !!}<br>

                @endforeach
            @endforeach
        </div>
        {!! Form::submit('Фильтровать', array('class' => 'btn btn-default')) !!}
        {!! Form::reset('Сбросить', array('class' => 'btn btn-default')) !!}

        {!! Form::close() !!}

    </div>

    <div class="col-md-9">

        @if($products)

            @foreach($products as $product)
                <div style="margin: 20px; padding-bottom: 20px;">
                    <h4><a href="{{url('product', $product->alias)}}">{{$product->title}}</a></h4>
                    <p>{{$product->description}}</p>
                    <p><b>Цена: {{number_format($product->price, 2)}} грн.</b></p>
                </div>
            @endforeach

        <!-- Pagination -->
            <?php
            $products->appends(Request::except('page'));
            ?>
            @if($products->lastPage() >= 2)
                <ul class="pagination">
                    <li {{ $products->currentPage()=='1' ? 'class=active' : '' }}><a
                                href="{!! $products ->url(1)!!}">Первая</a></li>
                </ul>
                @if($products->lastPage() > 2)
                    <ul class="pagination">
                        <li id="special-pagination" {{ $products->currentPage() >= 2 && $products->currentPage() < $products->lastPage() ? 'class=active' : '' }}>
                            <span>...</span></li>
                    </ul>
                    <ul class="pagination" id="hidden-pagination" style="display:none">
                        @for ($i = 2; $i < $products->lastPage(); $i++)
                            <li {{ $products->currentPage()==$i ? 'class=active' : '' }}><a
                                        href="{!! $products->url($i) !!}">{{$i}}</a></li>
                        @endfor
                    </ul>
                @endif
                <ul class="pagination">
                    <li {{ $products->currentPage()==$products->lastPage() ? 'class=active' : '' }}><a
                                href="{!! $products->url($products->lastPage())!!}">Последняя</a></li>
                </ul>
            @endif
        <!-- Pagination -->

        @else
            <h3>Нету продуктов!</h3>
        @endif
    </div>
@endsection