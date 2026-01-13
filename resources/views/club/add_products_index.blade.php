@extends('club.components.app')

@section('content')
<h1>Add Products</h1>
<div class="" style="width:80vh; height:60vh; ">
  <form class="col-lg-3 ms-lg-5" action="{{route('club.add_products')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <span>
    <label> Product Name :</label>
    <input class="rounded-2 input-box" style="height: 5vh; width:40vh; " type="text" name="name" required minlength="2">
    </span>
<br><br>
      <span>
    <label> Stock :</label>
    <input class="rounded-2 input-box no-arrow" style="height: 5vh;  " type="number" name="stock" minlength="0" required>
    </span>
<br><br>
     <span>
    <label> Description :</label>
    <textarea class="rounded-2 input-box"  rows="5" cols="30" name="description" required minlength="5"></textarea>
    </span>
<br><br>
     <span>
    <label> Image :</label>
     <input class="rounded-2 input-box" type="file" name="image">
    </span>
<br><br>
      <span>
    <button type="submit" class="bd-orange-300 px-sm-5 rounded" name="submit">Add</textarea>
    </span>
  </form>
</div>
<style>

  /* Chrome, Edge, Safari */
.no-arrow::-webkit-outer-spin-button,
.no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
.no-arrow {
    -moz-appearance: textfield;
}

 .input-box {
    border: 2px solid #ccc;
    padding: 8px;
    outline: none; 
    /* removes default blue outline */
}

.input-box:focus {
    border-color: rgb(255, 98, 0);
}


.input-box {
    border: 2px solid #ccc;
    transition: border-color 0.3s ease;
}

input:focus,
textarea:focus {
    border-color: #ff6600;
    outline: none;
}

</style>
@endsection

