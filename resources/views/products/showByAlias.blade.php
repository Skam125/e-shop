@extends('welcome')



@section('content')
    <div class="col-md-3">
        <h3>{{$category->title}}</h3>
        <style>
            label {
                font-weight: normal;
            }
        </style>
        @if($attr_result)
            {!! Form::open(array('url' => URL::full(), 'method' => 'get')) !!}
            <div class="form-group">
                @foreach($attr_result as $key => $attrs)

                    <b>{{$key}}</b><br>
                    <div id="attrs">
                    @foreach($attrs as $attr_val_id => $attr_val)

                        {!! Form::checkbox('filter[]', $attr_val_id, (is_array($selected_filters) ? (in_array($attr_val_id, $selected_filters) ? 'checked': null) : ''), ['id' => "attr_$attr_val_id"]) !!}
                        {!! Form::label("attr_$attr_val_id", "$attr_val") !!}<br>

                    @endforeach
                    </div>
                @endforeach
            </div>
            {!! Form::submit('Фильтровать', array('class' => 'btn btn-default')) !!}
            {!! Form::reset('Сбросить', array('class' => 'btn btn-default')) !!}

            {!! Form::close() !!}
        @else
            В данной категории еще нету товаров
        @endif
    </div>
    {{--<script>--}}
                {{--$(document).ready(function(){--}}
                    {{--$("form .form-group b").click(function(){--}}
                        {{--$("#attrs").slideToggle();--}}
                    {{--});--}}
                {{--});--}}
    {{--</script>--}}

    <div class="col-md-9">

        @if(count($products))
            <div class="row">
                @foreach(array_chunk($products->all(), 3) as $row)
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
                    <h3>Товары не найдены</h3>
                @endif
            </div>
@endsection