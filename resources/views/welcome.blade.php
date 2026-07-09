<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGPM | Administration des Mines</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts : Bricolage Grotesque & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --mining-gold: #fbbf24;
            --mining-slate: #020617;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--mining-slate); color: #f8fafc; }
        h1, h2, h3 { font-family: 'Bricolage Grotesque', sans-serif; }
        
        /* Texture de fond "Ingénierie" */
        .bg-grid {
            background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 40px 40px;
        }

        .bento-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bento-card:hover {
            border-color: var(--mining-gold);
            transform: translateY(-5px);
            background: rgba(15, 23, 42, 0.8);
        }

        .btn-primary {
            background-color: var(--mining-gold);
            color: black;
            transition: transform 0.2s;
        }
        .btn-primary:hover { transform: scale(1.02); }
    </style>
</head>
<body class="bg-grid antialiased">

    <!-- Header / Navbar -->
    <nav class="sticky top-0 z-50 border-b border-white/5 bg-slate-950/80 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-2 bg-amber-500 rounded-md">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <span class="block text-xl font-extrabold tracking-tighter leading-none">SIGPM</span>
                    <span class="block text-[10px] text-amber-500 font-bold uppercase tracking-widest">Division des Mines</span>
                </div>
            </div>

            <!-- Boutons de Connexion -->
            <div class="flex items-center gap-8">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-xs font-bold uppercase tracking-widest hover:text-amber-500 transition">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition">Connexion</a>
                        <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest shadow-lg">Ouvrir un compte</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-24 pb-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full mb-8">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-bold uppercase tracking-widest">République Démocratique du Congo</span>
            </div>
            
            <h1 class="text-6xl md:text-8xl font-black leading-[0.9] tracking-tighter mb-8 max-w-4xl">
                DIGITALISER <br> <span class="text-amber-500 italic">L'INDUSTRIE</span> MINIÈRE.
            </h1>
            
            <p class="text-slate-400 text-lg md:text-xl max-w-2xl mb-12 font-medium leading-relaxed">
                Système Intégré de Gestion des Permis Miniers. Une solution de pointe pour la traçabilité des ressources et la modernisation du Haut-Lomami.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('login') }}" class="btn-primary px-10 py-5 rounded-2xl text-sm font-black uppercase tracking-widest">Accéder au Cadastre</a>
                <a href="#explore" class="px-10 py-5 border border-white/10 rounded-2xl text-sm font-bold uppercase tracking-widest hover:bg-white/5 transition">Explorer le Projet</a>
            </div>
        </div>
    </header>

    <!-- Bento Grid (Design Moderne) -->
    <section id="explore" class="py-24 max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 h-auto">
            
            <!-- Carte 1 : Image contextuelle (Excavatrice/Mines) -->
            <div class="md:col-span-8 rounded-[2rem] overflow-hidden relative group min-h-[400px]">
                <img src="https://images.unsplash.com/photo-1578319439584-104c94d37305?q=80&w=2070&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale hover:grayscale-0" alt="Mines Haut-Lomami">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                <div class="absolute bottom-10 left-10">
                    <h3 class="text-4xl font-black mb-2 uppercase tracking-tighter italic">Province du Haut-Lomami</h3>
                    <p class="text-slate-300 font-bold uppercase tracking-widest text-xs">Extraction & Souveraineté</p>
                </div>
            </div>

            <!-- Carte 2 : Stats Finance -->
            <div class="md:col-span-4 bento-card rounded-[2rem] p-10 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center justify-center text-amber-500 mb-6 font-bold">$$</div>
                    <h4 class="text-2xl font-bold mb-4 tracking-tight">Redevances Provinciales</h4>
                    <p class="text-slate-400 text-sm">Contrôle en temps réel des flux financiers et maximisation des revenus de la province.</p>
                </div>
                <div class="text-4xl font-black text-amber-500">+100%</div>
            </div>

            <!-- Carte 3 : SIG / Map -->
            <div class="md:col-span-4 bento-card rounded-[2rem] p-10">
                <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center justify-center text-blue-500 mb-6 font-bold">MAP</div>
                <h4 class="text-2xl font-bold mb-4 tracking-tight">Cartographie SIG</h4>
                <p class="text-slate-400 text-sm">Superposition numérique des carrés miniers pour éradiquer les chevauchements de titres.</p>
            </div>

            <!-- Carte 4 : Dossiers / Workflow -->
            <div class="md:col-span-8 bento-card rounded-[2rem] p-10 relative overflow-hidden group">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center h-full">
                    <div class="max-w-md">
                        <h4 class="text-3xl font-black mb-4 uppercase tracking-tighter italic">Instruction Numérique</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Dématérialisation totale des procédures administratives de la Division des Mines. De la demande à l'octroi, tout est tracé.</p>
                    </div>
                    <!-- Élément visuel abstrait -->
                    <div class="mt-8 md:mt-0 flex gap-2">
                        <div class="w-2 h-12 bg-slate-800 rounded-full group-hover:bg-amber-500 transition-all duration-300"></div>
                        <div class="w-2 h-20 bg-slate-800 rounded-full group-hover:bg-amber-500 transition-all duration-500"></div>
                        <div class="w-2 h-16 bg-slate-800 rounded-full group-hover:bg-amber-500 transition-all duration-700"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Industriel -->
    <footer class="py-20 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center opacity-40">
            <div class="mb-6 md:mb-0">
                <p class="text-xs font-black uppercase tracking-[0.5em]">SIGPM System © 2026</p>
                <p class="text-[10px] uppercase font-bold text-amber-500 mt-2 tracking-widest italic">Division Provinciale des Mines Haut-Lomami</p>
            </div>
            <div class="flex gap-10">
                <span class="text-[10px] font-bold uppercase tracking-widest">Transparence</span>
                <span class="text-[10px] font-bold uppercase tracking-widest">Traçabilité</span>
                <span class="text-[10px] font-bold uppercase tracking-widest">Modernité</span>
            </div>
        </div>
    </footer>

</body>
</html>