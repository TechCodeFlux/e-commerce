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
         <th>Edit/delete</th>
        {{-- <th>Password</th> --}}
    </tr>

    @foreach ($clubs as $club)
        <tr>
            <td>{{ $club->id }}</td>
            <td>{{ $club->name }}</td>
            <td>{{ $club->address }}</td>
            <td>{{ $club->contact }}</td>
            <td>{{ $club->username }}</td>
            <td><a href="{{ route('club.edit', $club->id) }}"><button type="submit">Edit</button></a> 
                
                | 
                
                <form action="{{ route('club.destroy', $club->id) }}"
                      method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Are you sure you want to delete this club?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>    
            </td>
            {{-- <td>{{ $club->password }}</td> --}}
        </tr>
    @endforeach

</table>
<br>
<a href="{{ route('club.create') }}">
    <button type="button">Add Clubs</button>

  
</body>
</html>
