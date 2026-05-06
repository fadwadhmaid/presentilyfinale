<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='20' fill='%233B82F6'/%3E%3Ctext x='50' y='70' font-family='Arial' font-size='60' font-weight='bold' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E">
    <link rel="shortcut icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='20' fill='%233B82F6'/%3E%3Ctext x='50' y='70' font-family='Arial' font-size='60' font-weight='bold' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E">
        <title inertia>PRESENTILY</title>
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