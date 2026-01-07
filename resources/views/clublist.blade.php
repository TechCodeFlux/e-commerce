<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Club List</title>
</head>
<body>

<h3>Registered Clubs</h3>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Contact</th>
        <th>Username</th>
        {{-- <th>Password</th> --}}
    </tr>

    @foreach ($clubs as $club)
        <tr>
            <td>{{ $club->id }}</td>
            <td>{{ $club->name }}</td>
            <td>{{ $club->address }}</td>
            <td>{{ $club->contact }}</td>
            <td>{{ $club->username }}</td>
            {{-- <td>{{ $club->password }}</td> --}}
        </tr>
    @endforeach

</table>
<a href="{{ route('club.create') }}">
    <button type="button">add Clubs</button></body>
</body>
</html>
