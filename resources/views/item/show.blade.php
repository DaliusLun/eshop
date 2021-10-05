@extends('layouts.app')

@section('content')




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="javascript:history.back()">< Grįžti atgal</a></div>

                @if(count($item->photos)>0)
                <div class="container__photos">
                    <div class="photos__column">

                        @foreach ($item->photos as $photo)
                            <img class="photo__small" src="{{asset('/itemPhotos/big/'.$photo->name)}}" onclick="myFunction(this);">
                        @endforeach
                    </div>

                    <div class="container">
                    <!-- <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span> -->
                        <img class="photo__big" id="expandedImg" src="{{asset('/itemPhotos/big/'.$item->photos[0]->name)}}" >
                    <!-- <div id="imgtext"></div> -->
                    </div>

                </div>@endif




                <div class="card-body">
                <table class="table">
                    <thead>
                        <a style="font-size:30px;font-weight:500;">{{$item->name}}</a>
                        <tr>
                            <th scope="row">Kaina</th>
                            <th scope="row">{{$item->price}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Nuolaida</td>
                            <td scope="row">{{$item->discount}}</td>
                        </tr>
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
<script>
function myFunction(imgs) {
  var expandImg = document.getElementById("expandedImg");
  var imgText = document.getElementById("imgtext");
  expandImg.src = imgs.src;
  imgText.innerHTML = imgs.alt;
  expandImg.parentElement.style.display = "block";
}

document.addEventListener("DOMContentLoaded", function(){
    console.log("op");
});
</script>
@endsection