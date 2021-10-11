@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pridėti prekę į "{{$category->name}}" kategoriją</div>
                <div class="card-body">
                    <form method="POST" action="{{route('item.store')}}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Pavadinimas</label>
                            <input type="text" name="name"  class="form-control">
                            <br>
                            <label>Kaina</label>
                            <input type="text" name="price"  class="form-control">
                            <br>
                            <label>Aprašymas</label>
                            <input type="text" name="description"  class="form-control">
                            <br>
                            <label>Gamintojas</label>
                            <input type="text" name="manufacturer"  class="form-control">
                            <br>
                            <label>Kiekis</label>
                            <input type="text" name="quantity"  class="form-control">
                            <br>
                            <label>Nuolaida</label>
                            <input type="text" name="discount" value="0" class="form-control">
                            <input type="hidden" name="category_id" value="{{$category->id}}">
                            <br>
                            <label>Rodyti prekę</label>
                            <input type="checkbox" name="show">
                            <br>
                            @foreach ($params as $parameter)
                                <br>
                                <label>{{$parameter[0]->title}}</label>
                                <input type="text" name="{{$parameter[0]->id}}" class="form-control" placeholder="{{$parameter[0]->data_type}}">
                            @endforeach
                            <br>
                                <div>
                                <label>Nuotraukos</label>
                                <br>
                                <input type="file" name="photos[]" multiple>
                                <br>
                                <small class="form-text text-muted">Pasirinkite prekės nuotraukas</small>
                            </div>
                        </div>
                        @csrf
                        <br>
                        <button class="btn btn-success" type="submit">Pridėti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection