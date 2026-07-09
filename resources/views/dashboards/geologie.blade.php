<x-app-layout>
    <!-- Bibliothèques UI Spécifiques -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <!-- GRANDE CARTE BLANCHE (CONTRÔLE TECHNIQUE SIG) -->
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <!-- 1. EN-TÊTE TECHNIQUE (Focus Expertise) -->
            <div class="p-8 md:p-12 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex items-center gap-6">
                    <!-- Icône Boussole/SIG -->
                    <div class="w-16 h-16 bg-[#1e293b] rounded-3xl flex items-center justify-center shadow-xl border-4 border-blue-500/20">
                        <i class="fas fa-drafting-compass text-amber-500 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                            Bureau <span class="text-blue-700">Géologie & SIG</span>
                        </h2>
                        <p class="text-slate-400 text-sm mt-3 font-semibold italic flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                            Expertise technique des périmètres • Division des Mines
                        </p>
                    </div>
                </div>

                <!-- Statut du Système -->
                <div class="hidden lg:flex items-center gap-4 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
                    <div class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-300 uppercase leading-none">Serveur SIG</p>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-widest">Opérationnel</p>
                    </div>
                </div>
            </div>

            <!-- 2. ZONE DE TRAVAIL GÉOLOGIQUE -->
            <div class="p-8 md:p-12 overflow-y-auto flex-1">
                
                <!-- CARTE DE MONITORING DES CONCESSIONS -->
                <div class="mb-12 relative group">
                    <div id="map-sig" class="h-96 w-full rounded-[3rem] shadow-inner border-8 border-slate-50 z-0 transition-all group-hover:border-blue-50"></div>
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-2xl border border-white/50 z-10">
                        <p class="text-[10px] font-black text-blue-900 uppercase mb-3 tracking-widest italic border-b pb-2">Légende Cartographique</p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 bg-blue-600 rounded-full shadow-lg shadow-blue-600/50"></span> 
                                <span class="text-[11px] font-bold text-slate-600 uppercase">Dossier en file</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse shadow-lg shadow-red-500/50"></span> 
                                <span class="text-[11px] font-bold text-slate-600 uppercase">Conflit de voisinage</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATISTIQUES MÉTIER (3 COLONNES) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <!-- À Vérifier -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 border-l-8 border-l-blue-600 group hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 italic">Dossiers à localiser</p>
                                <h4 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['a_verifier'] ?? 0 }}</h4>
                            </div>
                            <i class="fas fa-map-location-dot text-3xl text-blue-100 group-hover:text-blue-500 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Expertises validées -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 border-l-8 border-l-emerald-500 group hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 italic">Validés ce mois</p>
                                <h4 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['expertises_du_mois'] ?? 0 }}</h4>
                            </div>
                            <i class="fas fa-check-double text-3xl text-emerald-100 group-hover:text-emerald-500 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Alertes Empiètements -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 border-l-8 border-l-red-500 group hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1 italic">Conflits / Empiètements</p>
                                <h4 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['conflits'] ?? 0 }}</h4>
                            </div>
                            <i class="fas fa-draw-polygon text-3xl text-red-100 group-hover:text-red-500 transition-colors"></i>
                        </div>
                    </div>
                </div>

                <!-- REGISTRE D'INSTRUCTION TECHNIQUE -->
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden mb-6">
                    <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-[#1e293b] text-white">
                        <h3 class="font-black text-white text-sm uppercase italic underline decoration-amber-500 decoration-4 underline-offset-8">File d'attente Expertise SIG</h3>
                        <span class="bg-blue-600 text-white text-[9px] font-black px-4 py-1.5 rounded-full uppercase tracking-tighter shadow-lg italic">Priorité Technique</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6 italic">Requérant</th>
                                    <th class="px-10 py-6 italic italic">Référence / Territoire</th>
                                    <th class="px-10 py-6 text-center italic italic">Carrés</th>
                                    <th class="px-10 py-6 text-right italic">Action SIG</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($fileAttente as $d)
                                <tr class="hover:bg-blue-50/20 transition-all duration-300 group">
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">{{ $d->user->name }}</span>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 italic italic">Dossier numérique</p>
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="bg-blue-50 text-blue-800 text-[10px] font-black px-3 py-1 rounded-lg border border-blue-100 uppercase italic">{{ $d->numero_demande }}</span>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase mt-1 italic tracking-widest">{{ $d->territoire }}</p>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <span class="text-lg font-black text-slate-800">{{ $d->nombre_carres }}</span>
                                        <p class="text-[8px] text-slate-300 font-bold uppercase">Unités</p>
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                        <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center justify-center w-12 h-12 bg-blue-900 text-white rounded-2xl hover:bg-amber-500 hover:text-blue-900 transition-all shadow-xl hover:rotate-12">
                                            <i class="fas fa-map-location-dot text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="flex flex-col items-center opacity-30">
                                            <i class="fas fa-satellite-dish text-6xl mb-4 text-blue-200"></i>
                                            <p class="text-xl font-black text-slate-400 uppercase tracking-tighter italic">Aucun levé cartographique en attente</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Baseline -->
            <div class="py-8 px-12 bg-gray-50/50 border-t border-gray-100 text-center">
                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.5em]">Division Provinciale des Mines • Haut-Lomami Management • Bureau SIG v2.1</p>
            </div>
        </div>
    </div>

    <!-- Script Leaflet (Simulation SIG) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map-sig', {
                scrollWheelZoom: false,
                zoomControl: false
            }).setView([-8.7410, 25.9960], 7); 
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; DP Mines'
            }).addTo(map);

            // Simulation des dossiers sur la carte du Haut-Lomami
            @foreach($fileAttente as $d)
                L.circle([-8.7410 + (Math.random() * 0.8 - 0.4), 25.9960 + (Math.random() * 1.5 - 0.75)], {
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.5,
                    radius: 5000
                }).addTo(map).bindPopup('<div class="p-2 font-sans"><p class="font-black uppercase text-xs text-blue-900">{{ $d->numero_demande }}</p><p class="text-[10px] text-slate-500 font-bold uppercase">{{ $d->nom_site }}</p></div>');
            @endforeach
        });
    </script>
</x-app-layout>