@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <div class="container__column1"> -->
    @if(Auth::user() && Auth::user()->isAdmin()) 
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Admin dashboard</div>
                    <div class="card-body">
                        <a style="font-size:15px" href="{{route('category.create',[count($chain) !== 0?$chain[count($chain)-1]:'0'])}}">Nauja kategorija šiame gylyje</a><br>
                        @if(count($chain) > 0)
                            <a style="font-size:15px" href="{{route('item.create',[$chain[count($chain)-1]])}}">Įdėti prekę į "{{$chain[count($chain)-1]->name}}" kategoriją</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                @if(count($chain) > 0)
                    <div class="card-header">
                        <h1>{{(count($chain) > 0)?$chain[count($chain)-1]->name:""}}</h1>
                    </div>
                @endif
                <div class="card-header">
                    @if(isset($chain) && count($chain)>0)
                    <a class="fa fa-home" href="{{route('category.index')}}"></a> >
                        @foreach ($chain as $item)
                            @if(next($chain))
                                <a class="chain" href="{{route('category.map',$item)}}">{{$item->name}}</a> >
                            @else
                                <a class="chain chain-last" href="{{route('category.map',$item)}}">{{$item->name}}</a>
                            @endif
                        @endforeach
                    @else
                        <div>Prekių kategorijos</div>
                    @endif
                </div>
                @if(count($categories)>0)
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Pavadinimas</th>
                                    @if(Auth::user() && Auth::user()->isAdmin())
                                        <th scope="col" style="text-align:center">Veiksmai</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">
                                            <a href="{{route('category.map',$category)}}">{{$category->name}}</a>
                                        </th>
                                        @if(Auth::user() && Auth::user()->isAdmin()) 
                                            <td style="text-align:center">
                                                <a href="{{route('category.edit',[$category])}}">
                                                    <button class="btn btn-primary">Koreguoti</button>
                                                </a>
                                            @if(Auth::user())
                                                <form style="display:inline-block" method="POST" action="{{route('category.destroy', [$category])}}">
                                                    @csrf
                                                    <button class="btn btn-danger" type="submit">Pašalinti</button>
                                                </form>
                                            @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if(count($chain) > 0 && count($items) > 0) 
        <div class="item-container">
            @foreach ($items as $item)
                @if($item->status!=0 || (Auth::user() && Auth::user ()->isAdmin()))
                    <div class="item {{$item->ifDisabled()}}">
                        <a href="{{route('item.show',((($item->id*7)+7)*17))}}">
                            @if($item->discount>0)
                                <div class="item__sale">%</div>
                            @endif
                            <div class="item__photo">
                                @if (count($item->photos)>0)
                                    <img src="{{asset('/itemPhotos/small/'.$item->photos[0]->name)}}" alt="">
                                @else
                                    <img src="{{asset('/itemPhotos/small/default.png')}}" alt="">
                                @endif
                            </div>
                            <div class="item__name">{{$item->name}}</div>
                            @if($item->discount>0)
                                <div class="item__price discount">{{$item->price}} €</div>
                                <div class="item__price with-discount">{{$item->price - $item->discount}} €</div>
                            @else
                                <div class="item__price">{{$item->price - $item->discount}} €</div>
                            @endif
                            @if($item->quantity == 0)
                                <div class="sold">Prekė išparduota</div>
                            @elseif($item->status == 0)
                                <div class="notavailable">Prekė šiuo metu neparduodama</div>
                            @else
                                <a href="#">
                                    <button class="btn btn-primary">Į krepšelį</button>
                                </a>
                                <br>
                            @endif
                            <a href="javascript:void(0)/{{$item->id}}">
                                    <div class="heart fa {{$item->heart()}}"></div>
                                </a>
                            @if(Auth::user() && Auth::user()->isAdmin()) 
                                <a href="{{route('item.edit',[$item,$chain[count($chain)-1]])}}">
                                    <button class="btn btn-warning">Koreguoti</button>
                                </a>
                                <form style="display:inline-block" method="POST" action="{{route('item.destroy', [$item])}}">
                                    @csrf
                                    <button class="btn btn-danger" type="submit" >Pašalinti</button>
                                </form>
                            @endif
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    @if(count($categories)==0 && count($items)==0)
        <br>
        <h3>Atsiprašome, šioje kategorijoje prekių nėra</h3>
        <a href="javascript:history.back()">< Grįžti atgal</a>
    @endif
    </div>
<!-- 
    <div class="container__column2">
        <div class="slideshow-container">

            <div class="mySlides ">
            <div class="numbertext">1 / 3</div>
            <img class="slideshow__img" src="{{asset('/photos/cover/cover1.jpg')}}">
            <div class="text">Caption Text</div>
            </div>

            <div class="mySlides ">
            <div class="numbertext">2 / 3</div>
            <img class="slideshow__img" src="{{asset('/photos/cover/cover2.jpg')}}">
            <div class="text">Caption Two</div>
            </div>

            <div class="mySlides ">
            <div class="numbertext">3 / 3</div>
            <img class="slideshow__img" src="{{asset('/photos/cover/cover3.jpg')}}" >
            <div class="text">Caption Three</div>
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            </div>
            <br>

            <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
            <span class="dot" onclick="currentSlide(3)"></span> 
            </div>

        
    </div>
</div> -->
<!-- 
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script> -->

@endsection
<script>
 var heart = "{{route('item.heart')}}";
</script>