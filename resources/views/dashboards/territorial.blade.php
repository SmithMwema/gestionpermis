<x-app-layout>
    <!-- FontAwesome pour les icônes de terrain -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <!-- GRANDE CARTE BLANCHE (ANTENNE TERRITORIALE) -->
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <!-- 1. EN-TÊTE : IDENTITÉ DU RESSORT -->
            <div class="p-8 md:p-12 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex items-center gap-6">
                    <!-- Icône Terrain (Émeraude) -->
                    <div class="w-16 h-16 bg-[#003B31] rounded-3xl flex items-center justify-center shadow-xl border-4 border-emerald-500/20">
                        <i class="fas fa-map-location-dot text-emerald-400 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                            Antenne <span class="text-[#003B31]">Territoriale</span>
                        </h2>
                        <p class="text-slate-400 text-sm mt-3 font-semibold italic flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            Ressort : <span class="text-[#003B31] font-black uppercase">{{ Auth::user()->territoire ?? 'Non assigné' }}</span> • Suivi de proximité
                        </p>
                    </div>
                </div>

                <!-- Badge Statut Agent -->
                <div class="hidden lg:flex items-center gap-4 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
                    <div class="text-right px-2">
                        <p class="text-[10px] font-black text-slate-300 uppercase leading-none">Agent de Terrain</p>
                        <p class="text-sm font-bold text-emerald-700 uppercase italic">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-12 overflow-y-auto flex-1">
                
                <!-- 2. STATISTIQUES DU RESSORT (3 COLONNES) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <!-- Titres Actifs -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 border-l-8 border-l-emerald-500 group hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-1 italic">Titres en Exploitation</p>
                                <h4 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['titres_actifs'] ?? 0 }}</h4>
                                <p class="text-[8px] text-emerald-600 font-bold mt-2 uppercase">● Périmètres installés</p>
                            </div>
                            <i class="fas fa-hammer text-3xl text-emerald-50 group-hover:text-emerald-100 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Nouveaux Arrivants -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 border-l-8 border-l-blue-500 group hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-blue-500 uppercase mb-1 italic">Nouveaux arrivants</p>
                                <h4 class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['nouveaux_arrivants'] ?? 0 }}</h4>
                                <p class="text-[8px] text-slate-300 font-bold mt-2 uppercase tracking-tighter italic">En attente d'installation</p>
                            </div>
                            <i class="fas fa-truck-moving text-3xl text-blue-50 group-hover:text-blue-100 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Alertes d'inactivité -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 border-l-8 border-l-red-500 group hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-red-500 uppercase mb-1 italic">Alertes Inactivité</p>
                                <h4 class="text-5xl font-black text-slate-800 tracking-tighter">0</h4>
                                <p class="text-[8px] text-red-400 font-bold mt-2 uppercase animate-pulse italic">⚠️ Action Requise</p>
                            </div>
                            <i class="fas fa-stopwatch text-3xl text-red-50 group-hover:text-red-100 transition-colors"></i>
                        </div>
                    </div>
                </div>

                <!-- 3. REGISTRE DES ACTIVITÉS LOCALES -->
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden mb-6">
                    <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-[#003B31]">
                        <h3 class="font-black text-white text-sm uppercase italic tracking-widest">
                            <i class="fas fa-list-check mr-3 text-emerald-400"></i>Registre des permis — Ressort de {{ Auth::user()->territoire }}
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6 italic">Société / Opérateur</th>
                                    <th class="px-10 py-6 italic">Site / Carrés</th>
                                    <th class="px-10 py-6 text-center italic">État Terrain</th>
                                    <th class="px-10 py-6 text-right italic">Action de terrain</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($dossiersLocaux as $d)
                                <tr class="hover:bg-emerald-50/20 transition-all duration-300 group">
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">{{ $d->user->name }}</span>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 italic italic">{{ $d->numero_demande }}</p>
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-bold text-slate-600 capitalize italic">{{ $d->nom_site }}</span>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-tighter">{{ $d->nombre_carres }} Carrés • {{ $d->substance }}</p>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <!-- Utilisation de l'Accessor pour la couleur -->
                                        <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-md {{ $d->statut_color }}">
                                            ● {{ $d->statut_label }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                        @if(!$d->date_installation)
                                            <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-black text-white px-5 py-2.5 rounded-xl font-black text-[9px] uppercase transition-all shadow-lg hover:scale-105">
                                                <span>Installer sur site</span>
                                                <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center gap-3 bg-blue-900 hover:bg-black text-white px-5 py-2.5 rounded-xl font-black text-[9px] uppercase transition-all shadow-lg hover:scale-105">
                                                <span>Rapport de Constat</span>
                                                <i class="fas fa-file-signature text-amber-500"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="flex flex-col items-center opacity-30">
                                            <i class="fas fa-map-pin text-6xl mb-4 text-emerald-200"></i>
                                            <p class="text-lg font-black text-slate-400 uppercase tracking-tighter italic italic">Aucun permis répertorié dans ce territoire</p>
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
                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.5em]">Surveillance Territoriale • Division des Mines • Province du Haut-Lomami</p>
            </div>
        </div>
    </div>
</x-app-layout>