<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>InApp Inventory Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('admin/assets/images/favicon_io/site.webmanifest') }}">
</head>

<body>
    <div id="overlay" class="overlay"></div>

    @include('admin.layouts.admin_header')

    @include('admin.layouts.admin_sidebar')

    <!-- MAIN CONTENT -->
    <main id="content" class="content py-10">
        @yield('admin_content')
    </main>

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin/assets/js/main.js') }}" type="module"></script>

</body>

</html>
