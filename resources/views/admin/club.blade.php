@extends('admin.components.app')

@section('content')
    <h1>Clubs</h1>

    <label>Name</label>
    <input type="text">
{{-- <a href="{{route('admin.login')}}"></a> --}}
    <label>State</label>
    <input type="text">
    
    <input type="submit" name="submit">
@endsection
