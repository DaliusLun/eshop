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
                    <form name="form" action="" method="get">
                        @foreach ($item->photos as $photo)
                            <img class="photo__small" src="{{asset('/itemPhotos/big/'.$photo->name)}}" onclick="imgExpand(this);">
                        @endforeach
                    </form>
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
function imgExpand(imgs) {

    let expandImg = document.getElementById("expandedImg");
    let imgText = document.getElementById("imgtext");
    expandImg.src = imgs.src;

    let a = document.getElementsByClassName('photo__small');
    for (i = 0; i < a.length; i++) {
        a[i].classList.remove('border')
    }
    imgs.classList.add('border');
    
}


    // border on first photo on page load



function borderOnFirstPhotoOnPageLoad() {
    let imgs = document.getElementsByClassName('photo__small');
    let firstImg = imgs[0];
    firstImg.className += ' border';
}


borderOnFirstPhotoOnPageLoad();


</script>
@endsection