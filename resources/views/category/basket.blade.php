@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               <div class="card-header">Prekių krepšelis</div>
               <div class="card-body">
                   @if(count($uniqueItems)>0)
               <form action="{{route('category.updateBasket')}}" method="post">
               <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Pavadinimas</th>
                            <th style="text-align:center;" scope="col">Vnt. kaina (EUR)</th>
                            <th style="text-align:center;" scope="col">Kiekis</th>
                            <th style="text-align:center;" scope="col">Suma (EUR)</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($uniqueItems as $item)
                        <tr>
                            <th>
                                @if(isset($item->photos[0]))
                                    <img class="photo__extrasmall" src="{{asset('/itemPhotos/small/'.$item->photos[0]->name)}}">
                                @endif
                            </th>
                            <th scope="row" ><a href="{{route('item.show',((($item->id*7)+7)*17))}}">{{$item->name}}</a></th>
                            <th style="text-align:center;" scope="row">{{$item->price-$item->discount}}</th>

                            <th>
                                <div class="input-group plus-minus-input">
                                <div class="input-group-button">
                                    <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity{{$item->id}}">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <input class="input-group-field" type="number" name="quantity{{$item->id}}" value="{{array_count_values($_SESSION['basket'])[$item->id]}}">
                                <div class="input-group-button">
                                    <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity{{$item->id}}">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                                </div>
                            </th>
                            <th style="text-align:center;" scope="row">{{($item->price-$item->discount)*array_count_values($_SESSION['basket'])[$item->id]}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    
                    @csrf
                    <button class="btn btn-primary" type="submit">Atnaujinti krepšelį</button>
                    </form>
                    @else
                        <h3>Prekių krepšelis tuščias</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>

var basket = "{{route('item.basket')}}";

</script>