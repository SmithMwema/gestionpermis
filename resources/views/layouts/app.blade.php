<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Portail DP Mines | Haut-Lomami</title>

        <!-- Fonts : Plus Jakarta Sans (utilisée dans les designs premium) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Icons : FontAwesome (Indispensable pour tes icônes) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body { 
                font-family: 'Plus Jakarta Sans', sans-serif; 
                background-color: #F4F7FE; /* Le gris bleuté très clair de ton image */
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Structure principale en FLEX -->
        <div class="flex h-screen overflow-hidden">
            
            <!-- 1. SIDEBAR GAUCHE (Appelée via navigation.blade.php) -->
            @include('layouts.navigation')

            <!-- 2. ZONE DE CONTENU DROITE (Défilante) -->
            <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none">
                
                <!-- On n'affiche le header Laravel que sur les pages hors Dashboard si nécessaire -->
                @if (isset($header) && !request()->routeIs('dashboard*'))
                    <header class="bg-white shadow-sm border-b border-gray-100 py-4 px-8">
                        <div class="max-w-7xl mx-auto uppercase font-bold text-xs tracking-widest text-slate-400">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Injection du contenu (Slot) -->
                <div class="h-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>