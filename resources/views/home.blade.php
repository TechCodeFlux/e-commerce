<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            background: #f4f6f9;
            margin-top: 100px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        a {
            display: inline-block;
            margin: 15px;
            padding: 12px 25px;
            text-decoration: none;
            color: white;
            background: #3490dc;
            border-radius: 5px;
        }
        a.admin {
            background: #e3342f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to the System</h1>
    <p>Please choose your login type</p>

    <a href="/club">Club Login</a>
    <a href="/admin" class="admin">Admin Login</a>
    <a href="/clubmember" >Club Member Login</a>
</div>

</body>
</html>