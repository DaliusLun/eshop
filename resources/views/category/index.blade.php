@extends('layouts.app')

@section('content')
<div class="container">

    @if(Auth::user() && Auth::user()->isAdmin()) 
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Admin dashboard</div>
                    <div class="card-body">
                            <!-- <form style="display:inline-block" action="{{route('category.store')}}" method="post">
                                @csrf
                                <input type="text" name="name">
                                @php
                                    if(count($chain) == 0) {
                                        $categoryId = 0;
                                    } else {
                                        $categoryId = $chain[count($chain) -1]->id;
                                    }
                                @endphp
                                <input type="hidden" name="category_id" value="{{$categoryId}}">
                                <button type="submit">Pridėti</button>
                            </form> -->
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
                @if (count($chain) > 0)
                    <div class="card-header">
                        <h1>{{(count($chain) > 0)?$chain[count($chain)-1]->name:""}}</h1>
                    </div>
                @endif
                <div class="card-header">
                    <a href="{{route('category.index')}}">HOME</a><br>
                    @foreach ($chain as $item)
                        @if(next($chain))
                            <a class="chain" href="{{route('category.map',$item)}}">{{$item->name}}</a> >
                        @else
                            <a class="chain chain-last" href="{{route('category.map',$item)}}">{{$item->name}}</a>
                        @endif
                    @endforeach
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
                <div class="item">
                    <a href="{{route('item.show',[$item])}}">
                        @if($item->discount>0)
                            <div class="item__sale">%</div>
                        @endif
                        <div class="item__name">{{$item->name}}</div>
                        <div class="item__photo">
                            @if (count($item->photos)>0)
                                <img src="{{asset('/itemPhotos/small/'.$item->photos[0]->name)}}" alt="">
                            @else
                            <img src="{{asset('/itemPhotos/small/default.png')}}" alt="">
                            @endif
                        </div>
                        @if($item->discount>0)
                            <div class="item__price discount">{{$item->price}} €</div>
                            <div class="item__price with-discount">{{$item->price - $item->discount}} €</div>
                        @else
                            <div class="item__price">{{$item->price - $item->discount}} €</div>
                        @endif
                            <a href="#">
                                <button class="btn btn-primary">Į krepšelį</button>
                            </a>
                    </a>
                </div>
            @endforeach
        </div>
        
    @endif
<!-- 
    @if(count($chain) > 0 && count($items) > 0) 

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Prekės</div>
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
                                @foreach ($items as $item)
                                    <tr>
                                        <th scope="row">{{$item->name}}</th>
                                        @if(Auth::user() && Auth::user()->isAdmin()) 
                                            <td style="text-align:center">
                                                <a href="{{route('item.show',[$item])}}">
                                                    <button class="btn btn-primary">Show</button>
                                                </a>
                                                <a href="{{route('item.edit',[$item,$chain[count($chain)-1]])}}">
                                                    <button class="btn btn-primary">Koreguoti</button>
                                                </a>
                                                <form style="display:inline-block" method="POST" action="{{route('item.destroy', [$item])}}">
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
    @endif -->
    
    @if(count($categories)==0 && count($items)==0)
        <br>
        <h3>Atsiprašome, šioje kategorijoje prekių nėra</h3>
        <a href="javascript:history.back()">< Grįžti atgal</a>
    @endif


</div>
@endsection
