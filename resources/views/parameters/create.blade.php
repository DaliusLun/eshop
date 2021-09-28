@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pridėti parametrą</div>
                <div class="card-body">
                    <form method="POST" action="{{route('parameter.store')}}">
                    <div class="form-group">
                        <label>Parametras</label>
                        <input type="text" name="title"  class="form-control">
                        <br>
                        <label>Matavimo vienetas</label>
                        <input type="text" name="data_type"  class="form-control">
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