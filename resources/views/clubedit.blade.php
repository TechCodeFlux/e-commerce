<!DOCTYPE html>
<html>
<head>
    <title>Edit Club</title>
</head>
<body>

<h3>Edit Club</h3>

<form action="{{ route('club.update', $club->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Club Name:</label>
    <input type="text" name="club_name" value="{{ $club->name }}" required>
    <br><br>

    <label>Club Address:</label>
    <textarea name="club_address" required>{{ $club->address }}</textarea>
    <br><br>

    <label>Club Contact:</label>
    <input type="text" name="club_contact" value="{{ $club->contact }}" required>
    <br><br>

    <label>Username:</label>
    <input type="text" name="username" value="{{ $club->username }}" required>
    <br><br>

    <label>Password:</label>
    <input type="password" name="password" placeholder="(leave blank for no change)">
    <br><br>

    <button type="submit">Update</button>
    <a href="{{ route('club.index') }}">Cancel</a>
</form>

</body>
</html>
