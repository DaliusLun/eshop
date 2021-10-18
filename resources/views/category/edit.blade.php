@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-header">Koreguoti kategoriją</div>
            <div class="card-body">
               <form method="POST" action="{{route('category.update',[$category])}}">
                  <div class="form-group">
                     <label>Pavadinimas</label>
                     <input type="text" name="name"  class="form-control" value="{{$category->name}}">
                  </div>
                  
                  <div class="form-group">
                     <label>Tėvinė kategorija</label>
                     <select class="form-control" name="category_id">
                        <option value="">Be kategorijos</option>
                        @foreach ($categories as $categoriesOne)
                           <option <?php echo $categoriesOne->id === $category->category_id ? 'selected':''?> value="{{$categoriesOne->id}}"> 
                              {{$categoriesOne->name}}
                           </option>
                        @endforeach
                     </select>
                     <small class="form-text text-muted">Pasirinkite tėvinę kategoriją.</small>
                  </div>
                  <div class="form-group">
                     <label>Priskiriami parametrai</label>
                     <select class="form-control" name="parameters[]" multiple>
                        @foreach ($parameters as $parameter)
                           <option <?php echo in_array($parameter->id, $ctParams) == $category->parameters ? 'selected':''?> value="{{$parameter->id}}"> 
                              {{$parameter->title}} {{$parameter->data_type}}
                           </option>
                        @endforeach
                     </select>
                     <small class="form-text text-muted">Pasirinkite parametrus, kurie bus priskirti šiai kategorijai.</small>
                  </div>
                  @csrf
                  <br>
                  <button class="btn btn-primary" type="submit">Koreguoti</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection