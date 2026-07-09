<aside class="w-72 bg-[#003B31] h-screen flex flex-col shadow-2xl sticky top-0 left-0 z-50">
    
    <!-- ========== 1. EN-TÊTE : LOGO INSTITUTIONNEL ========== -->
    <div class="p-6 text-center">
        <!-- Cadre blanc pour le logo pour qu'il soit bien visible -->
        <div class="bg-white rounded-2xl p-3 shadow-lg mb-4">
            <img src="{{ asset('image/logo_droite.png') }}" 
                 class="h-12 w-auto mx-auto object-contain" 
                 alt="Logo Division des Mines">
        </div>
        <h1 class="text-white font-black text-sm tracking-tighter uppercase leading-none">
            Division des <span class="text-amber-400">Mines</span>
        </h1>
        <p class="text-[8px] text-white/40 font-bold uppercase tracking-[0.2em] mt-2">Haut-Lomami • RDC</p>
    </div>

    <!-- ========== 2. MENU DE NAVIGATION ========== -->
    <nav class="flex-1 px-4 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border-l-4 border-amber-400 shadow-lg' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
            <i class="fas fa-th-large text-sm {{ request()->routeIs('dashboard') ? 'text-amber-400' : '' }}"></i>
            <span class="text-[11px] font-bold uppercase tracking-widest">Tableau de Bord</span>
        </a>
        
        <!-- Mes Activités -->
        <a href="{{ route('dossiers.index') }}" 
           class="flex items-center justify-between px-5 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dossiers.*') ? 'bg-white/10 text-white border-l-4 border-amber-400' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fas fa-folder-open text-sm"></i>
                <span class="text-[11px] font-bold uppercase tracking-widest">Mes Activités</span>
            </div>
            <span class="bg-amber-500 text-[#003B31] text-[9px] font-black px-2 py-0.5 rounded-full">
                {{ Auth::user()->dossiers()->count() }}
            </span>
        </a>
        
        <!-- Notifications -->
        <a href="#" class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-white/40 hover:bg-white/5 hover:text-white transition-all">
            <i class="fas fa-bell text-sm"></i>
            <span class="text-[11px] font-bold uppercase tracking-widest">Notifications</span>
        </a>

        <!-- Rapports -->
        <a href="#" class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-white/40 hover:bg-white/5 hover:text-white transition-all">
            <i class="fas fa-chart-pie text-sm"></i>
            <span class="text-[11px] font-bold uppercase tracking-widest">Rapports</span>
        </a>

        <!-- Paramètres -->
        <a href="#" class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-white/40 hover:bg-white/5 hover:text-white transition-all">
            <i class="fas fa-cog text-sm"></i>
            <span class="text-[11px] font-bold uppercase tracking-widest">Paramètres</span>
        </a>
    </nav>

    <!-- ========== 3. PIED DE PAGE : BADGE UTILISATEUR (Style PEPE) ========== -->
    <div class="p-4 border-t border-white/5">
        <div class="bg-white/5 rounded-2xl p-4 flex items-center justify-between border border-white/5 group hover:bg-white/10 transition-all">
            <div class="flex items-center gap-3 overflow-hidden">
                <!-- Avatar avec Initiale -->
                <div class="w-10 h-10 bg-amber-400 rounded-xl flex-shrink-0 flex items-center justify-center text-[#003B31] font-black text-lg shadow-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <!-- Nom et Rôle -->
                <div class="overflow-hidden">
                    <p class="text-white text-[11px] font-bold truncate capitalize">{{ Auth::user()->name }}</p>
                    <p class="text-white/30 text-[8px] font-black uppercase tracking-tighter">
                        {{ Auth::user()->role == 'public' ? 'Titulaire' : Auth::user()->role }}
                    </p>
                </div>
            </div>
            
            <!-- Petit bouton déconnexion icône -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white/20 hover:text-red-400 transition-colors p-1">
                    <i class="fas fa-power-off text-sm"></i>
                </button>
            </form>
        </div>
        <p class="text-center text-[7px] text-white/10 font-bold uppercase tracking-[0.3em] mt-4">Version 2.0.1</p>
    </div>
</aside>