@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               <div class="card-header">Parametrai</div>
               <div class="card-body">
               <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Pavadinimas</th>
                            <th scope="col">Matavimo vienetas</th>
                            @if(Auth::user() && Auth::user()->isAdmin()) 
                                <th scope="col" style="text-align:center">Veiksmai</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($parameters as $parameter)
                        <tr>
                            <th scope="row">{{$parameter->title}}</th>
                            <th scope="row">{{$parameter->data_type}}</th>
                            @if(Auth::user() && Auth::user()->isAdmin()) 
                            <td style="text-align:center">
                                <a href="{{route('parameter.edit',[$parameter])}}">
                                    <button class="btn btn-primary">Koreguoti</button>
                                </a>
                                <form style="display:inline-block" method="POST" action="{{route('parameter.destroy', [$parameter])}}">
                                    @csrf
                                    <button class="btn btn-danger" type="submit" >Pašalinti</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection