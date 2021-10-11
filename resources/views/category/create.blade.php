@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-header">Pridėti kategoriją</div>
            <div class="card-body">
               <form method="POST" action="{{route('category.store',$categoryId)}}">
                  <div class="form-group">
                     <label>Pavadinimas</label>
                     <input type="text" name="name"  class="form-control" value="">
                     <input type="hidden" name="category_id" value="{{$categoryId}}">
                  </div>
                  <br>
                  <div class="form-group">
                     <label>Priskiriami parametrai</label>
                     <select class="form-control" name="parameters[]" multiple>
                        @foreach ($parameters as $parameter)
                           <option value="{{$parameter->id}}"> 
                              {{$parameter->title}} {{$parameter->data_type}}
                           </option>
                        @endforeach
                     </select>
                     <small class="form-text text-muted">Pasirinkite parametrus, kurie bus priskirti šiai kategorijai.</small>
                  </div>
                  @csrf
                  <br>
                  <button class="btn btn-primary" type="submit">Pridėti</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection