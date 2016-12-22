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
        <h3 class="text-center">Результаты по запросу "{{$searchText}}": </h3>

        @if(count($products))
            <div class="row">
                @foreach(array_chunk($products->all(), 3) as $row)
                    <div class="row">
                        @foreach($row as $item)
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail ">
                                    <img src="https://vlaber.com.ua/images/stories/virtuemart/product/20160722Img0635.jpg"
                                         alt="...">
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