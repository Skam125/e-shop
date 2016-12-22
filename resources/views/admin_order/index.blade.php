@extends('welcome')

@section('content')
    <h3>Заказы:</h3>
{{--    {{dd($orders)}}--}}

    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>#</th>
            <th>Имя клиента</th>
            <th>Телефон</th>
            <th>Тип доставки</th>
            <th>Адрес доставки</th>
            <th>Комментарий</th>
            <th>Стутаус заказа</th>
            <th>Дата заказа</th>
            <th>Посмотреть</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->client_name}}</td>
                <td>{{$order->phone}}</td>
                <td>{{$order->delivery_type}}</td>
                <td>{{$order->delivery_address}}</td>
                <td>{{$order->comment}}</td>
                <td>{{$order->title}}</td>
                <td>{{$order->created_at}}</td>
                <td>ССылка на посмотреть</td>
                <td>Удалить</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<script>
    document.getElementsByClassName('skillset');
</script>