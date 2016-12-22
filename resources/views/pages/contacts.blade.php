@extends('welcome')
@section('content')
    {!! Form::open(array('url'=>'contact')) !!}
    <div class="form-group">
        {!! Form::label('email', 'Ваша почта')!!}
        {!! Form::email('email', null, ['required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('message', 'Сообщение')!!}
        {!! Form::textarea('message', null, ['required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Отправить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
@endsection