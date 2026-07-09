<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Authentification | DP Mines Haut-Lomami</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .auth-bg {
                background: linear-gradient(rgba(30, 58, 138, 0.8), rgba(30, 58, 138, 0.9)), 
                            url('{{ asset("image/agent.jpeg") }}');
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center auth-bg px-4">
            
            <!-- Double Logo en haut du formulaire -->
            <div class="flex justify-between items-center w-full max-w-md mb-6 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20">
                <img src="{{ asset('image/logo_droite.png') }}" class="h-16 w-auto" alt="Logo DP Mines">
                <div class="text-center">
                    <span class="block text-white font-black text-sm uppercase tracking-tighter">Portail Numérique</span>
                    <span class="block text-amber-400 font-bold text-[10px] uppercase">Haut-Lomami</span>
                </div>
                <img src="{{ asset('image/logo_gauche.jpg') }}" class="h-16 w-auto" alt="Logo RDC">
            </div>

            <!-- Le Formulaire (Card) -->
            <div class="w-full sm:max-w-md bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden border-t-8 border-amber-500">
                <div class="px-8 py-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-white/60 text-[10px] font-bold uppercase tracking-widest text-center">
                &copy; {{ date('Y') }} - Division Provinciale des Mines <br> 
                République Démocratique du Congo
            </div>
        </div>
    </body>
</html>