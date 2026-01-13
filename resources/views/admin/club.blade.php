@extends('admin.components.app')

@section('content')
<h3>Club Entry</h3>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('club.store') }}" method="POST">
    @csrf

    <label>Club Name:</label>
    <input type="text" name="club_name" required>
    <br><br>

    <label>Club Address:</label>
    <textarea name="club_address" required></textarea>
    <br><br>

    <label>Club Contact:</label>
    <input type="text" name="club_contact" required>
    <br><br>

    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Country:</label>
    <input type="text" name="country_id" required>
    <br><br>

    <label>State:</label>
    <input type="text" name="state_id" required>
    <br><br>

    <label>City:</label>
    <input type="text" name="city" required>
    <br><br>

    <label>ZIP Code:</label>
    <input type="text" name="zip_code" required>
    <br><br>

    <label>Status:</label>
    <select name="status" required>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <br><br>

    <input type="submit" value="Submit">
    
</form>

@endsection
