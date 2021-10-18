@extends('layouts.app')

@section('content')
<div class="container">
    @if(count($items) > 0) 
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
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    @if(count($items) == 0)
        <h3>Jūs neturite įsimintų prekių. Siūlome pasižvalgyti po mūsų prekių katalogą, <a href="{{route('category.index')}}">paspaudę čia</a>.</h3>
    @endif
    </div>
@endsection
<script>
    var heart = "{{route('item.heart')}}";
</script>