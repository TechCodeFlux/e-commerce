<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Details</title>
</head>
<body>
    <h2>Club Details</h2>

    @if(!empty($data))
        <p><strong>Club Name:</strong> {{ $data['name'] }}</p>
        <p><strong>Address:</strong> {{ $data['address'] }}</p>
        <p><strong>Contact Number:</strong> {{ $data['contact'] }}</p>
        <p><strong>Username:</strong> {{ $data['username'] }}</p>
        <p><strong>Password:</strong> {{ $data['password'] }}</p>
    @else
        <p>No data available.</p>
    @endif

    <a href="{{ url()->previous() }}">Back</a>
</body>
</html>
