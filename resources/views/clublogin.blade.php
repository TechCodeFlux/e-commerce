<html>
    <head>
        <title>Club Login</title>
    </head>
    <body>
        <h1>Welcome to the Club Login Page</h1>
        <form method='POST' action="/check">
            @csrf
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="enter your password" required>
            <br>
            <input type="submit" name="login"><br>
        </form>
    </body>
</html>