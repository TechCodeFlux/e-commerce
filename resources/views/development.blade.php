<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
</head>
<body>
    <h3>ADMIN LOGIN</h3>
    <form action="{{route('admin.index')}}" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>