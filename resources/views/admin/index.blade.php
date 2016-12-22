@extends('welcome')


@section('content')
    <h3>Добрый день, администратор!</h3>
    <p>Вам доступны такие возможности:</p>
    <a href="{{ url('/admin/product') }}">Управление товарами</a><br>
    <a href="{{ url('/admin/category') }}">Управление категориями</a><br>
    <a href="{{ url('/admin/order') }}">Управление заказами</a><br>
    <a href="#">Управление фильтрами</a><br>
    <hr>
    <h3>Новая категория:</h3>
    {!! Form::open(array('url'=>'admin/storeCategory')) !!}
    <div class="form-group">
        {!! Form::label('categoryTitle', 'Название категории')!!}
        {!! Form::text('categoryTitle', null, ['required' => 'required']) !!}

        {!! Form::label('categoryAlias', 'Алиас для категории')!!}
        {!! Form::text('categoryAlias', null, ['required' => 'required']) !!}

        {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
    <hr>
    <h3>Аттрибуты для групы:</h3>
    {!! Form::open(array('url'=>'admin/storeAttributeAttrValuesGroup')) !!}
    <div class="form-group">
        {!! Form::label('attr_groups', 'Група для атрибутов')!!}
        <select name="attr_group_id" id="attr_groups">
            @foreach($attr_groups as $value)
                <option value="{{$value->id}}">{{$value->title}}</option>
            @endforeach
        </select>
        {!! Form::label('attributeID', 'Выбрать атрибуты')!!}
        <select name="attributeID[]" id="attributeID" class="form-control" multiple>
            @foreach($attributes as $attribute)
                <option value="{{$attribute->id}}">{{$attribute->title}}</option>
            @endforeach
        </select>
        {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
    <hr>
    <h3>Новый аттрибут:</h3>
    {!! Form::open(array('url'=>'admin/storeAttribute')) !!}
    <div class="form-group">
        {!! Form::label('attributeTitle', 'Название атрибута')!!}
        {!! Form::text('attributeTitle', null, ['required' => 'required']) !!}

        {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
    <hr>
    <h3>Значение для аттрибута:</h3>
    {!! Form::open(array('url'=>'admin/storeAttrValue')) !!}
    <div class="form-group">
        {!! Form::label('attributeID', 'Выбрать атрибут')!!}
        <select name="attributeID" id="attributeID">
            @foreach($attributes as $attribute)
                <option value="{{$attribute->id}}">{{$attribute->title}}</option>
            @endforeach
        </select>
        {!! Form::label('attributeValue', 'Значение атрибута')!!}
        {!! Form::text('attributeValue', null, ['required' => 'required']) !!}
        {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
    <hr>

    <h3>Добавить товар:</h3>
    {!! Form::open(array('url'=>'admin/storeProduct', 'files'=>true)) !!}
    <div class="form-group">
        <label for="category">Категория: </label>
        <select name="category" id="category">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="title">Название: </label>
        <input type="text" class="form-control input-sm" name="title" id="title" required>
    </div>
    <div class="form-group">
        <label for="alias">Алиас: </label>
        <input type="text" class="form-control input-sm" name="alias" id="alias" required>
    </div>
    <div class="form-group">
        <label for="">Картинка</label>
        <input type="file" class="form-control input-sm" name="image" required>
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <textarea name="description" class="form-control" id="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Цена: </label>
        <input type="number" class="form-control input-sm" name="price" id="price" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="is_new">Новинка: </label>
        <input type="checkbox" class="form-control input-sm" name="is_new" id="is_new" value="1">
    </div>
    <div class="form-group">
        <label for="is_popular">Популярное: </label>
        <input type="checkbox" class="form-control input-sm" name="is_popular" id="is_popular" value="1">
    </div>
    <div class="form-group">
        <button class="btn btn-default">Добавить</button>
    </div>
    {!! Form::close() !!}
    <hr>

    <h3>Количество товара:</h3>
    {!! Form::open(array('url'=>'admin/storeCount')) !!}
    <div class="form-group">
        {!! Form::label('productID', 'Выбрать товар')!!}
        <select name="productID" id="productID">
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->title}}</option>
            @endforeach
        </select>
        {!! Form::label('attr_value', 'Выбрать атрибут')!!}
        <select name="attr_value" id="attr_value" class="form-control">
            @foreach($attr_values as $attr_value)
                <option value="{{$attr_value->value }}">{{$attr_value->value}}</option>
            @endforeach
        </select>
        {!! Form::label('count', 'Количество')!!}
        {!! Form::number('count', null, ['required' => 'required']) !!}
        {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
<hr>
    <h3>Значение аттрибута для продукта</h3>
    {!! Form::open(array('url'=>'admin/storeProductAttributes')) !!}
    <div class="form-group">
        {!! Form::label('productID', 'Продукт')!!}
        <select name="productID" id="productID">
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->title}}</option>
            @endforeach
        </select>
        {!! Form::label('attributeID', 'Выбрать атрибуты')!!}
        <select name="attributeID[]" id="attributeID" class="form-control" multiple>
            @foreach($attr_values as $attr_value)
                <option value="{{$attr_value->id}}">{{$attr_value->value}}</option>
            @endforeach
        </select>
        {!! Form::submit('Добавить', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
    <hr>

@endsection