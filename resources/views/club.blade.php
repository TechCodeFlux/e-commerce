<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Club Adding Form</title>
</head>
<body>
    <h2>Club Registration</h2>

    <form method="POST" action="{{ route('club.store') }}">
        @csrf
        
        <label>Club Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Address:</label><br>
        <textarea name="address" rows="3" required></textarea><br><br>

        <label>Contact Number:</label><br>
        <input type="tel" name="contact" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Submit</button>

    </form>
</body>
</html>