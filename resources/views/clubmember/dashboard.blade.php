<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
</head>
<body>

@include('clubmember.components.app')

<div class="content @yield('contentClassName')">
    @yield('content')
</div>

</body>
</html>