<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
</head>
<body>

@include('admin.components.app')

<!-- content -->
        <div class="content @yield('contentClassName')">
            @yield('content')
        </div>
        <!-- ./ content -->
</div>

</body>
</html>
