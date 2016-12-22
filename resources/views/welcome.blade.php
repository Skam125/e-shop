<!DOCTYPE html>
<html>
<head>
    <title>Diploma work!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/cerulean/bootstrap.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://bootswatch.com/cerulean/bootstrap.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ url('/') }}" class="navbar-brand">Immortal</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/') }}">Главная страница</a>
                </li>
                <li>
                    <a href="{{ url('admin') }}">Админка</a>
                </li>
                <li>
                    <a href="{{ url('contacts') }}">Контакты</a>
                </li>
            </ul>
            <form class="navbar-form navbar-left" action="{{url('search')}}">
                <div class="form-group">
                    <input type="text" name="searchText" class="form-control" placeholder="Поиск">
                </div>
                <button type="submit" class="btn btn-default">Найти</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('cart') }}">Корзина
                        (<span id="cart-count">{{\App\Models\Cart::countItems()}}</span>)
                    </a></li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                    <li><a href="{{ url('/auth/register') }}">Register</a></li>
                @else

                    <li><a>{{ Auth::user()->name }}</a>
                    <li>
                        <a href="{{ url('/auth/logout') }}">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ url('/auth/logout') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="row page-header" id="header">
        <div class="col-md-12">
            <div>
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav navbar-nav navbar-right">

                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="pp">
    <div class="pp-content">
        <h3>Подпишись на рассылку</h3>
        {!! Form::open(array('url'=>'storeMail')) !!}
        <div class="form-group">
            <label for="">Ваше имя:</label>
            <input type="text" class="form-control input-sm" name="name">
        </div>

        <div class="form-group">
            <label for="">Email:</label>
            <input type="email" class="form-control input-sm" name="email">
        </div>
        <div class="form-group">
            <button class="btn btn-default">Подписаться</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div id="pp-bg"></div>

<!-- Latest compiled and minified JavaScript -->

<script src="/public/js/script.js"></script>
<script>

    $(document).ready(function () {
        $('.add-to-cart').click(function () {
            var id = $('#select-cart option:selected').val();
            console.log(id);
            var count = $('#count').val();
            console.log(count);
            $.post("/cart/addAjax", {id: id, count: count}, function (data) {
                $('#cart-count').html((data));
            });
            return false;
        });
    });


    $(document).ready(function () {
        $('.cart_plus').click(function () {
            var id = $(this).attr('attr_id');
            $.post("/cart/actionAjax", {id: id, action: 'plus'}, function (data) {
                $('#'+id).html((data['value']));
                $('#cart-count').html((data['countItems']));
                $('#totalPrice').html((data['totalPrice']));
            });
            return false;
        });
    });

    $(document).ready(function () {
        $('.cart_minus').click(function () {
            var id = $(this).attr('attr_id');
            $.post("/cart/actionAjax", {id: id, action: 'minus'}, function (data) {
                $('#'+id).html((data['value']));
                $('#cart-count').html((data['countItems']));
                $('#totalPrice').html((data['totalPrice']));
            });
            return false;
        });
    });
</script>

</body>
</html>





