<html>
    <head></head>
    <body>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <h2>User Details</h2>

<p>Username: {{ $username }}</p>
<p>Password: {{ $password }}</p>
    </body>
</html>