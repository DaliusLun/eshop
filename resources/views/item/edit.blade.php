@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Koreguoti prekę</div>
                <div class="card-body">
                    <form method="POST" action="{{route('item.update',[$item])}}">
                    <div class="form-group">
                        <label>Pavadinimas</label>
                        <input type="text" name="name" value="{{$item->name}}" class="form-control"><br>
                        <label>Kaina</label>
                        <input type="text" name="price" value="{{$item->price}}" class="form-control"><br>
                        <label>Aprašymas</label>
                        <input type="text" name="description" value="{{$item->description}}" class="form-control"><br>
                        <label>Kiekis</label>
                        <input type="text" name="quantity" value="{{$item->quantity}}" class="form-control"><br>
                        <label>Nuolaida</label>
                        <input type="text" name="discount" value="{{$item->discount}}" class="form-control"><br>
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <input type="hidden" name="category_id" value="{{$category->id}}">
                        @foreach ($item->parameters as $parameter)
                            <label>{{$parameter->title}} ({{$parameter->data_type}})</label>
                            <input type="text" name="{{$parameter->id}}" value="{{$parameter->pivot->data}}" class="form-control"><br>
                        @endforeach
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="show" {{$item->checkboxStatus()}}>
                            <label class="form-check-label">Rodyti prekę</label>
                        </div>
                    </div>
                        @csrf
                        <br>
                        <button class="btn btn-success" type="submit">Atnaujinti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection