<x-app-layout>
    <!-- FontAwesome pour les icônes métier -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <!-- GRANDE CARTE BLANCHE (BUREAU DE RÉCEPTION) -->
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <!-- 1. EN-TÊTE : TITRE & BOUTON D'ENREGISTREMENT AU GUICHET -->
            <div class="p-8 md:p-12 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex items-center gap-6">
                    <!-- Barre d'accentuation Bleu Institutionnel -->
                    <div class="w-2 h-12 bg-blue-900 rounded-full shadow-[0_0_15px_rgba(30,58,138,0.3)]"></div>
                    <div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                            Réception & <span class="text-blue-900">Vérification</span>
                        </h2>
                        <p class="text-slate-400 text-sm mt-3 font-semibold italic flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                            Bureau du Secrétariat • Division Provinciale des Mines
                        </p>
                    </div>
                </div>

                <!-- BOUTON AJOUTÉ : POUR LES DOSSIERS PHYSIQUES (GUICHET) -->
                <a href="{{ route('dossiers.create') }}" class="bg-[#003B31] hover:bg-black text-white px-8 py-4 rounded-[1.5rem] font-black text-xs uppercase tracking-widest flex items-center gap-3 shadow-2xl transition-all transform hover:scale-105 border-b-4 border-black/20">
                    <span class="w-7 h-7 bg-white/10 rounded-full flex items-center justify-center text-lg">+</span>
                    Nouvel Enregistrement (Guichet)
                </a>
            </div>

            <!-- 2. ZONE DE PILOTAGE (STATS GLOBALES) -->
            <div class="p-8 md:p-12 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    
                    <!-- Stat 1 : Charge de travail totale -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center group hover:shadow-xl transition-all duration-300">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Total Province</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['total'] ?? 0 }}</h4>
                        </div>
                        <div class="w-16 h-16 bg-slate-50 rounded-[1.5rem] flex items-center justify-center text-slate-400 text-2xl group-hover:scale-110 transition-transform">
                            <i class="fas fa-database"></i>
                        </div>
                    </div>

                    <!-- Stat 2 : Urgent à réceptionner -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center border-l-8 border-l-red-500 group hover:shadow-xl transition-all">
                        <div>
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1 italic">À Réceptionner</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['nouveaux'] ?? 0 }}</h4>
                            <p class="text-[8px] text-red-400 font-bold mt-2 uppercase animate-bounce">⚠️ Action Requise</p>
                        </div>
                        <div class="w-16 h-16 bg-red-50 rounded-[1.5rem] flex items-center justify-center text-red-500 text-2xl">
                            <i class="fas fa-inbox"></i>
                        </div>
                    </div>

                    <!-- Stat 3 : Dossiers dans les bureaux techniques -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center border-l-8 border-l-blue-500 group hover:shadow-xl transition-all">
                        <div>
                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 italic">En Instruction</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['en_instruction'] ?? 0 }}</h4>
                            <p class="text-[8px] text-slate-300 font-bold mt-2 uppercase tracking-tighter">Services SIG / Direction</p>
                        </div>
                        <div class="w-16 h-16 bg-blue-50 rounded-[1.5rem] flex items-center justify-center text-blue-500 text-2xl">
                            <i class="fas fa-microchip"></i>
                        </div>
                    </div>

                    <!-- Stat 4 : Dossiers terminés (Octroyés) -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center border-l-8 border-l-emerald-500 group hover:shadow-xl transition-all">
                        <div>
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 italic">Terminés</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['termines'] ?? 0 }}</h4>
                            <p class="text-[8px] text-emerald-500 font-bold mt-2 uppercase">Octroyés</p>
                        </div>
                        <div class="w-16 h-16 bg-emerald-50 rounded-[1.5rem] flex items-center justify-center text-emerald-500 text-2xl">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                </div>

                <!-- 3. TABLEAU DES DOSSIERS EN ATTENTE (WORKFLOW) -->
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="font-black text-slate-800 text-sm uppercase italic underline decoration-amber-500 decoration-4">Dossiers à valider (Soumissions)</h3>
                        <span class="bg-white border border-slate-200 text-slate-400 text-[9px] font-black px-4 py-1 rounded-full uppercase tracking-tighter">Mise à jour en direct</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6 italic">Opérateur Minier</th>
                                    <th class="px-10 py-6 italic">N° Référence</th>
                                    <th class="px-10 py-6 text-center italic">Statut Circuit</th>
                                    <th class="px-10 py-6 text-right italic">Traitement</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($dossiersAttente as $d)
                                <tr class="hover:bg-blue-50/20 transition-all duration-300 group">
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">{{ $d->user->name ?? 'Dépôt Guichet' }}</span>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest italic italic">{{ $d->nom_site }}</p>
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="bg-blue-50 text-blue-800 text-[10px] font-black px-3 py-1 rounded-lg border border-blue-100 uppercase italic">{{ $d->numero_demande }}</span>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-md bg-amber-500 text-white shadow-amber-500/20">
                                            ● {{ $d->statut }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                        <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center justify-center w-12 h-12 bg-blue-900 text-white rounded-[1.2rem] transition-all shadow-lg hover:bg-black hover:scale-110">
                                            <i class="fas fa-clipboard-check text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="flex flex-col items-center opacity-30">
                                            <i class="fas fa-check-circle text-6xl mb-4 text-green-200"></i>
                                            <p class="text-lg font-black text-slate-400 uppercase tracking-tighter italic">Tous les dossiers ont été réceptionnés</p>
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
                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.5em]">Division Provinciale des Mines • Haut-Lomami Management • Guichet de Réception</p>
            </div>
        </div>
    </div>
</x-app-layout>