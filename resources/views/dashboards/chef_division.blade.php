<x-app-layout>
    <!-- Bibliothèques UI : FontAwesome et Chart.js pour le pilotage -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <!-- 1. HEADER : DIRECTION PROVINCIALE (Style Institutionnel) -->
            <div class="p-8 md:p-10 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-[#001f3f] rounded-3xl flex items-center justify-center shadow-xl border-4 border-amber-500/20">
                        <i class="fas fa-crown text-amber-500 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-slate-800 tracking-tighter uppercase leading-none italic">
                            Direction <span class="text-blue-900">Provinciale</span>
                        </h2>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-2">
                            Pilotage Stratégique • Gestion du Patrimoine Minier du Haut-Lomami
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-300 uppercase leading-none">Console de Direction</p>
                        <p class="text-sm font-bold text-blue-900 uppercase">Connecté : {{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-blue-950 font-black">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10 flex-1 overflow-y-auto">
                
                <!-- 2. SECTION ALERTES ET RÉSUMÉ (TOP BAR) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                    <!-- Alerte Stagnation (Plus de 48h) -->
                    <div class="bg-white p-6 rounded-[2.5rem] border-l-8 border-l-red-500 shadow-xl shadow-red-900/5 relative overflow-hidden group">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black text-red-500 uppercase mb-1 italic">Radar de Lenteur</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['stagnation_count'] ?? 0 }}</h4>
                            <p class="text-[8px] text-slate-400 font-bold uppercase mt-2 italic underline decoration-red-200">Dossiers bloqués > 48h</p>
                        </div>
                        <i class="fas fa-hourglass-half absolute -right-2 -bottom-2 text-6xl text-red-50 opacity-10 group-hover:rotate-12 transition-transform"></i>
                    </div>

                    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Dossiers en file</p>
                        <h4 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $stats['total_province'] }}</h4>
                    </div>

                    <div class="bg-white p-6 rounded-[2.5rem] border-l-8 border-l-amber-500 shadow-md flex flex-col justify-center">
                        <p class="text-[10px] font-black text-amber-600 uppercase mb-1 italic">Attente Signature Avis</p>
                        <h4 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $stats['attente_avis'] }}</h4>
                    </div>

                    <div class="bg-blue-900 p-6 rounded-[2.5rem] shadow-2xl text-white flex flex-col justify-center">
                        <p class="text-[10px] font-black text-blue-300 uppercase mb-1">Validation Finale</p>
                        <h4 class="text-4xl font-black text-amber-400 tracking-tighter">{{ $stats['titres_finis'] }}</h4>
                        <p class="text-[8px] text-blue-200 font-bold uppercase mt-1 italic">Titres Octroyés</p>
                    </div>
                </div>

                <!-- 3. ZONE ANALYTIQUE (GRAPHES ET TERRITOIRES) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-12">
                    
                    <!-- Graphique : Répartition des Types de Permis -->
                    <div class="lg:col-span-1 bg-white rounded-[3rem] p-8 border border-gray-100 shadow-sm flex flex-col items-center">
                        <h3 class="text-sm font-black text-slate-800 uppercase italic mb-6 border-b border-slate-50 w-full pb-4 text-center">Répartition du Patrimoine</h3>
                        <div class="w-full h-64">
                            <canvas id="permitChart"></canvas>
                        </div>
                        <div class="mt-4 flex gap-4 text-[9px] font-black uppercase text-slate-400">
                            <span><i class="fas fa-circle text-blue-900"></i> PR</span>
                            <span><i class="fas fa-circle text-amber-500"></i> PE</span>
                            <span><i class="fas fa-circle text-blue-400"></i> PEPM</span>
                        </div>
                    </div>

                    <!-- Monitoring Territorial (Style PEPE ADMIN) -->
                    <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm">
                        <h3 class="text-sm font-black text-slate-800 uppercase italic mb-8 underline decoration-amber-500 decoration-4 underline-offset-8">Monitoring des Territoires</h3>
                        <div class="space-y-6">
                            @php
                                $territories = [
                                    ['n' => 'Malemba-Nkulu', 'v' => $stats['malemba'], 'c' => 'bg-blue-900'],
                                    ['n' => 'Bukama / Luena', 'v' => $stats['bukama'], 'c' => 'bg-amber-500'],
                                    ['n' => 'Kamina (Ville & Terr)', 'v' => $stats['kamina'], 'c' => 'bg-blue-400'],
                                    ['n' => 'Kabongo / Kaniama', 'v' => ($stats['kabongo'] + $stats['kaniama']), 'c' => 'bg-slate-300'],
                                ];
                                $max = $stats['total_province'] > 0 ? $stats['total_province'] : 1;
                            @endphp

                            @foreach($territories as $t)
                            <div class="group">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-black text-slate-700 uppercase tracking-tighter">{{ $t['n'] }}</span>
                                    <span class="text-xs font-black text-slate-800">{{ $t['v'] }} <span class="text-[9px] text-slate-400 font-normal">Dossiers</span></span>
                                </div>
                                <div class="w-full bg-slate-50 h-3 rounded-full overflow-hidden border border-slate-100">
                                    <div class="{{ $t['c'] }} h-full transition-all duration-1000 group-hover:brightness-110" style="width: {{ ($t['v'] / $max) * 100 }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 4. REGISTRES DÉCISIONNELS -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <!-- File d'entrée : Expertises SIG à signer -->
                    <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                        <div class="px-8 py-5 border-b border-slate-50 bg-[#001f3f] flex justify-between items-center">
                            <h3 class="font-black text-white text-xs uppercase italic tracking-widest">
                                <i class="fas fa-file-contract mr-2 text-amber-500"></i>Expertises SIG à valider
                            </h3>
                            <span class="text-[8px] font-black bg-white/10 text-white px-2 py-1 rounded-full uppercase tracking-tighter">Avis Technique</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($dossiersPrioritaires as $d)
                                    <tr class="hover:bg-amber-50/30 transition-all">
                                        <td class="px-8 py-6">
                                            <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">{{ $d->user->name }}</span>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 italic italic">{{ $d->numero_demande }} • {{ $d->nom_site }}</p>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center justify-center w-11 h-11 bg-blue-900 text-white rounded-2xl hover:bg-amber-500 hover:text-blue-900 transition-all shadow-xl">
                                                <i class="fas fa-file-signature text-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="py-20 text-center text-slate-300 font-bold uppercase italic opacity-40 italic italic">Aucune expertise en attente de signature.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- File de sortie : Transmission Territoire -->
                    <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                        <div class="px-8 py-5 border-b border-slate-50 bg-[#006B52] flex justify-between items-center">
                            <h3 class="font-black text-white text-xs uppercase italic tracking-widest">
                                <i class="fas fa-paper-plane mr-2 text-emerald-400"></i>À Notifier aux Territoires
                            </h3>
                            <span class="animate-pulse text-[8px] font-black bg-white/10 text-white px-2 py-1 rounded-full uppercase">Retour Ministre</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-50">
                                    @php 
                                        $dossiersASignaler = \App\Models\Dossier::where('statut', 'signé_ministre')->get();
                                    @endphp
                                    @forelse($dossiersASignaler as $d)
                                    <tr class="hover:bg-emerald-50/50 transition-all">
                                        <td class="px-8 py-6">
                                            <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">{{ $d->user->name }}</span>
                                            <p class="text-[9px] text-emerald-600 font-bold uppercase mt-1 italic tracking-widest italic">
                                                <i class="fas fa-map-marker-alt"></i> Territoire de {{ $d->territoire }}
                                            </p>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <form action="{{ route('dossiers.notifier', $d) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#006B52] hover:bg-black text-white px-5 py-2.5 rounded-xl font-black text-[9px] uppercase shadow-lg transition-all transform hover:scale-105">
                                                    Notifier Territoire
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="py-20 text-center text-slate-300 font-bold uppercase italic opacity-40 italic italic">Aucune transmission en attente.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 5. FOOTER BAS DE PAGE -->
            <div class="py-6 text-center bg-gray-50/50 border-t border-slate-50">
                <p class="text-[9px] text-gray-300 font-black uppercase tracking-[0.6em]">Division Provinciale des Mines • Haut-Lomami Management • Version 2.2.0</p>
            </div>
        </div>
    </div>

    <!-- SCRIPT DE GÉNÉRATION DU GRAPHIQUE (CHART.JS) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('permitChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['PR (Recherche)', 'PE (Exploitation)', 'PEPM (Petite Mine)'],
                    datasets: [{
                        data: [{{ $stats['count_pr'] }}, {{ $stats['count_pe'] }}, {{ $stats['count_pepm'] }}],
                        backgroundColor: ['#001f3f', '#f59e0b', '#3b82f6'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>