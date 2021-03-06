@extends('layouts.app')

@section('content')

<div id="itemblade"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header heart__anchor">
                    <a class="fa fa-home" href="{{route('category.index')}}"></a> >
                    @foreach ($categories as $category)
                        <a class="chain" href="{{route('category.map',$category)}}">{{$category->name}}</a> >
                    @endforeach
                    <a class="chain chain-last" href="{{route('item.show',((($item->id*7)+7)*17))}}">{{$item->name}}</a>
                    <a href="javascript:void(0)/{{$item->id}}">
                        <div class="heart fa heart__item {{$item->heart()}}"></div>
                    </a>
                </div>

                @if(count($item->photos)>0)
                <div class="container__photos">
                    <div class="photos__column">
                    <form name="form" action="" method="get">
                        @foreach ($item->photos as $photo)
                            <img class="photo__small" src="{{asset('/itemPhotos/big/'.$photo->name)}}">
                        @endforeach
                    </form>
                    </div>

                    <div class="container">
                        <img class="photo__big" id="expandedImg" src="{{asset('/itemPhotos/big/'.$item->photos[0]->name)}}" >
                    </div>

                </div>
                @endif

                <div class="card-body">

<!-- Change the `data-field` of buttons and `name` of input field's for multiple plus minus buttons-->
<div class="input-group plus-minus-input">
  <div class="input-group-button">
    <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
      <i class="fa fa-minus" aria-hidden="true"></i>
    </button>
  </div>
  <input class="input-group-field" type="number" name="quantity" value="1">
  <div class="input-group-button">
    <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
      <i class="fa fa-plus" aria-hidden="true"></i>
    </button>
  </div>
</div>
<br>




                    <a href="javascript:void(0)/{{$item->id}}">
                        <div class="btn btn-primary basket">?? krep??el??</div>
                    </a>
                    <br><br>
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
                            <td scope="row">Apra??ymas</td>
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
<script>
var heart = "{{route('item.heart')}}";
var basket = "{{route('item.basket')}}";

</script>