!DOCTYPE html>
<head>
    <title>insert</title>
</head>
<body>
    <form method="POST" action="{{route('store')}}">
        @csrf
    name<input type='text' name='username'>
    password<input type='password' name='password'>
    <input type='submit' name='submit'>
    

  </body>
</html>

