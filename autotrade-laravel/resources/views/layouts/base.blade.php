{{-- resources/views/layouts/base.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Autotrade' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- No global CSS here. Every page pushes its own styles. --}}
    @stack('styles')
</head>
<body>
    @yield('content')
</body>
</html>