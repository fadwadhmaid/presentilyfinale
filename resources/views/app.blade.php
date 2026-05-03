<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>PRESENTO</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
        @routes
        <!-- Ajouter Lottie Player -->
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>