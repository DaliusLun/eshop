@extends('layouts.app')

@section('content')


<div id="itemblade"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:history.back()">< Grįžti atgal</a>
                </div>
                @if(count($item->photos)>0)
                <div class="container__photos">
                    <div class="photos__column">
                    <form name="form" action="" method="get">
                        @foreach ($item->photos as $photo)
                            <img class="photo__small" src="{{asset('/itemPhotos/big/'.$photo->name)}}" >
                        @endforeach
                    </form>
                    </div>

                    <div class="container">
                        <img class="photo__big" id="expandedImg" src="{{asset('/itemPhotos/big/'.$item->photos[0]->name)}}" >
                    </div>
                </div>@endif

                <div class="card-body">
                <table class="table">
                    <thead>
                        <a style="font-size:30px;font-weight:500;">{{$item->name}}</a>
                        <tr>
                            <th scope="row">Kaina</th>
                            <th scope="row">{{$item->price}} EUR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($item->discount!=="0.00") 
                            <tr>
                                <td scope="row">Nuolaida</td>
                                <td scope="row">{{$item->discount}} EUR</td>
                            </tr>
                        @endif
                        <tr>
                            <td scope="row">Gamintojas</td>
                            <td scope="row">{{$item->manufacturer}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Aprašymas</td>
                            <td scope="row">{{$item->description}}</td>
                        </tr>
                        @foreach ($item->parameters as $parameter)
                            <tr>
                                <td scope="row">{{$parameter->title}}</td>
                                <td scope="row">{{$parameter->pivot->data}} {{$parameter->data_type}}</td>
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
