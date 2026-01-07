<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Club Details</title>
</head>
<body>

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

    <label>Username:</label>
    <input type="text" name="username" required>
    <br><br>

    <label>Password:</label>
    <input type="password" name="password" required>
    <br><br>

    <input type="submit" value="Submit">
    
</form>
<a href="{{ route('club.index') }}">
    <button type="button">View Clubs</button></body>
</html>
