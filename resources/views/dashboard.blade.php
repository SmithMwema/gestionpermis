cat > /mnt/user-data/outputs/dashboard.blade.php << 'BLADE'
<x-app-layout>

@push('styles')
<style>
    body {
        background-color: #f0f2f5 !important;
        height: 100vh;
        overflow: hidden;
    }

    .jobi-container {
        background-color: white;
        border-radius: 40px;
        margin: 15px;
        display: flex;
        height: calc(100vh - 30px);
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .jobi-sidebar {
        width: 260px;
        background-color: #ffffff;
        border-right: 1px solid #f3f4f6;
        padding: 25px 20px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar-logo {
        width: 140px;
        height: auto;
        object-fit: contain;
    }

    .jobi-main-scroll {
        flex: 1;
        background-color: #fafbfc;
        padding: 30px;
        overflow-y: auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card-jobi {
        background: #ffffff;
        padding: 15px 20px;
        border-radius: 20px;
        border: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: box-shadow 0.2s;
    }

    .stat-card-jobi:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }

    .nav-link-jobi {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        border-radius: 12px;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 13px;
        transition: 0.2s;
        text-decoration: none;
    }

    .nav-link-jobi.active {
        background-color: #3d4c3a;
        color: white !important;
    }

    .nav-link-jobi:hover:not(.active) {
        background-color: #f3f4f6;
        color: #111827;
    }

    .bg-jobi-green { background-color: #3d4c3a; }

    .chart-container {
        height: 220px;
        position: relative;
    }

    /* Badge alerte avec point rouge animé */
    .notif-badge {
        background: #ef4444;
        color: white;
        font-size: 9px;
        font-weight: 700;
        padding: 1px 6px;
        border-radius: 20px;
        margin-left: auto;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    /* Timeline historique */
    .timeline-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 4px;
    }
</style>
@endpush

    <div class="jobi-container shadow-2xl">

        {{-- ============================================================ --}}
        {{-- SIDEBAR GAUCHE                                               --}}
        {{-- ============================================================ --}}
        <aside class="jobi-sidebar">

            {{-- Logo --}}
            <div class="mb-8 text-center">
                <img src="{{ asset('image/logo_droite.png') }}" class="sidebar-logo mx-auto" alt="DP Mines">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-2">Division des Mines</p>
            </div>

            {{-- Profil utilisateur --}}
            <div class="text-center mb-8 border-b pb-6">
                {{-- Avatar avec initiales (2 lettres si prénom + nom) --}}
                <div class="w-12 h-12 bg-{{ Auth::user()->role_color }}-50 rounded-full mx-auto flex items-center justify-center text-{{ Auth::user()->role_color }}-600 font-bold text-sm mb-2 border border-{{ Auth::user()->role_color }}-100">
                    {{ Auth::user()->initiales }}
                </div>
                <h4 class="font-bold text-gray-800 text-xs">{{ Auth::user()->name }}</h4>
                {{-- Rôle dynamique — plus codé en dur --}}
                <p class="text-[9px] text-{{ Auth::user()->role_color }}-600 font-black uppercase tracking-tighter italic">
                    {{ Auth::user()->role_label }}
                </p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="nav-link-jobi active">
                    <i class="fa-solid fa-house w-4"></i> Dashboard
                </a>
                <a href="{{ route('dossiers.index') }}" class="nav-link-jobi">
                    <i class="fa-solid fa-folder-open w-4"></i> Mes Activités
                </a>
                <a href="#" class="nav-link-jobi">
                    <i class="fa-solid fa-bell w-4"></i> Notifications
                    {{-- Badge dynamique : affiché seulement si alertes > 0 --}}
                    @if($stats['alertes'] > 0)
                        <span class="notif-badge">{{ $stats['alertes'] }}</span>
                    @endif
                </a>
                <a href="#" class="nav-link-jobi">
                    <i class="fa-solid fa-circle-question w-4"></i> Aide & Support
                </a>
            </nav>

            {{-- Déconnexion --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="nav-link-jobi w-full text-red-500 hover:bg-red-50">
                    <i class="fa-solid fa-right-from-bracket w-4"></i> Déconnexion
                </button>
            </form>
        </aside>

        {{-- ============================================================ --}}
        {{-- CONTENU PRINCIPAL                                            --}}
        {{-- ============================================================ --}}
        <main class="jobi-main-scroll">

            {{-- Message de succès --}}
            @if(session('status'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Erreurs de validation --}}
            @if($errors->any())
                <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-xs font-semibold">
                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- En-tête --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-xl font-black text-gray-800 uppercase tracking-tight italic">Vue d'ensemble</h1>
                    <p class="text-[10px] text-gray-400 mt-1">
                        Bonjour, <span class="font-bold text-gray-600">{{ Auth::user()->name }}</span> —
                        {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                    </p>
                </div>
                <a href="{{ route('dossiers.create') }}"
                   class="bg-jobi-green text-white px-6 py-2.5 rounded-xl font-bold text-[10px] uppercase shadow-lg hover:opacity-90 transition transform hover:scale-105">
                    <i class="fa-solid fa-plus mr-1"></i> Ajouter un dossier
                </a>
            </div>

            {{-- ======================================================== --}}
            {{-- CARTES DE STATISTIQUES                                   --}}
            {{-- ======================================================== --}}
            <div class="stats-grid">

                <div class="stat-card-jobi">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Soumis</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-folder text-blue-500"></i>
                    </div>
                </div>

                <div class="stat-card-jobi">
                    <div>
                        <p class="text-2xl font-bold text-amber-600">{{ $stats['en_cours'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">En cours</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-clock text-amber-500"></i>
                    </div>
                </div>

                <div class="stat-card-jobi">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['termines'] }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Octroyés</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-green-500"></i>
                    </div>
                </div>

                <div class="stat-card-jobi {{ $stats['alertes'] > 0 ? 'border-red-200 bg-red-50' : '' }}">
                    <div>
                        <p class="text-2xl font-bold {{ $stats['alertes'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $stats['alertes'] }}
                        </p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Alertes</p>
                    </div>
                    <div class="w-10 h-10 {{ $stats['alertes'] > 0 ? 'bg-red-100' : 'bg-gray-50' }} rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-bell {{ $stats['alertes'] > 0 ? 'text-red-500' : 'text-gray-400' }}"></i>
                    </div>
                </div>

            </div>

            {{-- ======================================================== --}}
            {{-- GRAPHIQUE + DOSSIERS RÉCENTS                             --}}
            {{-- ======================================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                {{-- Graphique des soumissions (données réelles) --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-800 text-xs mb-1 uppercase opacity-50 italic">
                        <i class="fa-solid fa-chart-line mr-1"></i> Évolution des soumissions
                    </h3>
                    <p class="text-[9px] text-gray-400 mb-4">7 derniers jours</p>
                    <div class="chart-container">
                        <canvas id="jobiChart"></canvas>
                    </div>
                </div>

                {{-- Dossiers récents --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <h3 class="font-bold text-gray-800 text-xs mb-4 uppercase opacity-50 italic">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Dossiers Récents
                    </h3>
                    <div class="space-y-3">
                        @forelse($recents as $d)
                        <div class="flex items-start justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 transition">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-gray-700 uppercase truncate">
                                    {{ $d->type_permis }} — {{ $d->nom_site }}
                                </p>
                                <p class="text-[9px] text-gray-400 mt-0.5">
                                    <i class="fa-solid fa-arrow-right mr-1"></i>{{ $d->prochain_responsable }}
                                </p>
                                {{-- Motif de rejet visible directement pour le titulaire --}}
                                @if($d->statut === 'rejeté' && $d->motif_rejet)
                                    <p class="text-[9px] text-red-500 mt-1 italic">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>{{ $d->motif_rejet }}
                                    </p>
                                @endif
                            </div>
                            <span class="ml-2 flex-shrink-0 text-[8px] font-black uppercase px-2 py-1 rounded-full
                                bg-{{ $d->statut_color }}-100 text-{{ $d->statut_color }}-700">
                                <i class="fa-solid {{ $d->statut_icon }} mr-1"></i>{{ $d->statut_label }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fa-solid fa-folder-open text-gray-300 text-3xl mb-2"></i>
                            <p class="text-gray-400 text-[10px] italic">Aucun mouvement récent.</p>
                            <a href="{{ route('dossiers.create') }}"
                               class="inline-block mt-3 text-[9px] font-bold text-green-700 underline">
                                Soumettre votre premier dossier
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ======================================================== --}}
            {{-- ALERTE DOSSIERS REJETÉS (si applicable)                  --}}
            {{-- ======================================================== --}}
            @if($stats['alertes'] > 0)
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5"></i>
                <div>
                    <p class="text-xs font-bold text-red-700">
                        {{ $stats['alertes'] }} dossier(s) rejeté(s) nécessite(nt) votre attention
                    </p>
                    <p class="text-[10px] text-red-500 mt-0.5">
                        Consultez le motif de rejet et corrigez votre dossier pour le resoumettre.
                    </p>
                    <a href="{{ route('dossiers.index') }}"
                       class="inline-block mt-2 text-[9px] font-bold text-red-700 underline">
                        Voir mes dossiers rejetés →
                    </a>
                </div>
            </div>
            @endif

        </main>
    </div>

{{-- ================================================================ --}}
{{-- SCRIPTS                                                          --}}
{{-- ================================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données réelles injectées depuis le controller via json_encode
    const chartLabels = {!! json_encode($chartLabels) !!};
    const chartValues = {!! json_encode($chartValues) !!};

    const ctx = document.getElementById('jobiChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartValues,
                borderColor: '#3d4c3a',
                borderWidth: 3,
                backgroundColor: 'rgba(61, 76, 58, 0.05)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#3d4c3a',
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.parsed.y + ' soumission(s)'
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    grid: { display: false },
                    ticks: { font: { size: 10 }, color: '#9ca3af' }
                },
                y: {
                    display: true,
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        font: { size: 10 },
                        color: '#9ca3af',
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</x-app-layout>




