{{-- resources/views/layouts/fantasy.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Fantasy Questions' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        /* Asegurar que el contenido ocupe toda la altura */
        #app {
            min-height: 100vh;
        }
    </style>
</head>
<body class="antialiased">
    <div id="app">
        {{ $slot }}
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>