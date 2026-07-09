<x-app-layout>
    <!-- FontAwesome pour les icônes de documents -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <!-- GRANDE CARTE BLANCHE -->
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <!-- 1. EN-TÊTE : ESPACE DE GESTION -->
            <div class="p-8 md:p-12 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex items-center gap-6">
                    <div class="w-2 h-12 bg-amber-500 rounded-full shadow-[0_0_15px_rgba(245,158,11,0.4)]"></div>
                    <div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                            Espace de <span class="text-blue-900">Gestion</span>
                        </h2>
                        <p class="text-slate-400 text-sm mt-3 font-semibold italic flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            Bienvenue sur votre console, {{ Auth::user()->name }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('dossiers.create') }}" class="bg-[#003B31] hover:bg-black text-white px-8 py-4 rounded-[1.5rem] font-black text-xs uppercase tracking-widest flex items-center gap-3 shadow-2xl transition-all transform hover:scale-105 border-b-4 border-black/20">
                    <span class="w-7 h-7 bg-white/10 rounded-full flex items-center justify-center text-lg">+</span>
                    Nouveau dépôt dossier
                </a>
            </div>

            <!-- 2. ZONE DES STATISTIQUES (GRID 4 COLONNES) -->
            <div class="p-8 md:p-12 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    
                    <!-- Total Transmis -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center group hover:shadow-xl transition-all duration-300">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Total Transmis</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['total'] ?? 0 }}</h4>
                        </div>
                        <div class="w-16 h-16 bg-blue-50 rounded-[1.5rem] flex items-center justify-center text-blue-900 text-2xl group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>

                    <!-- En Instruction -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center border-l-8 border-l-blue-500 group hover:shadow-xl transition-all">
                        <div>
                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 italic">Instruction</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['en_cours'] ?? 0 }}</h4>
                        </div>
                        <div class="w-16 h-16 bg-blue-500/10 rounded-[1.5rem] flex items-center justify-center text-blue-500 text-2xl animate-pulse">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>

                    <!-- Octroyés -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center border-l-8 border-l-emerald-500 group hover:shadow-xl transition-all">
                        <div>
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 italic">Octroyés</p>
                            <h4 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">{{ $stats['termines'] ?? 0 }}</h4>
                        </div>
                        <div class="w-16 h-16 bg-emerald-50 rounded-[1.5rem] flex items-center justify-center text-emerald-500 text-2xl">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <!-- Rejetés -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex justify-between items-center border-l-8 border-l-red-500 group hover:shadow-xl transition-all">
                        <div>
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1 italic">Rejetés</p>
                            <h4 class="text-5xl font-black text-red-600 tracking-tighter leading-none">{{ $stats['rejetes'] ?? 0 }}</h4>
                        </div>
                        <div class="w-16 h-16 bg-red-50 rounded-[1.5rem] flex items-center justify-center text-red-500 text-2xl">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>

                <!-- 3. TABLEAU : ICI NOUS AJOUTONS LES BOUTONS DE TÉLÉCHARGEMENT -->
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="font-black text-slate-800 text-sm uppercase italic underline decoration-amber-500 decoration-4">Historique de mes activités</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6 italic">RÉFÉRENCE</th>
                                    <th class="px-10 py-6 italic">SITE / CONCESSION</th>
                                    <th class="px-10 py-6 text-center italic">STATUT CIRCUIT</th>
                                    <th class="px-10 py-6 text-right italic">DOCUMENTS & ACTES</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($recents as $d)
                                <tr class="hover:bg-blue-50/20 transition-all duration-300 group">
                                    <td class="px-10 py-8 font-black text-blue-900 text-sm uppercase tracking-tighter">
                                        {{ $d->numero_demande }}
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-bold text-slate-600 capitalize italic">{{ $d->nom_site }}</span>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-tighter">{{ $d->type_permis }}</p>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-md
                                            {{ $d->statut == 'octroyé' ? 'bg-emerald-500 text-white shadow-emerald-500/20' : 
                                               ($d->statut == 'rejeté' ? 'bg-red-500 text-white shadow-red-500/20' : 'bg-amber-500 text-white shadow-amber-500/20') }}">
                                            ● {{ str_replace('_', ' ', $d->statut) }}
                                        </span>
                                    </td>

                                    <!-- COLONNE ACTIONS MISE À JOUR : TÉLÉCHARGEMENTS -->
                                    <td class="px-10 py-8 text-right space-x-3">
                                        <!-- 1. Bouton Visualiser (Oeil) -->
                                        <a href="{{ route('dossiers.show', $d) }}" title="Ouvrir la fiche" class="inline-flex items-center justify-center w-11 h-11 bg-slate-100 text-slate-400 hover:bg-blue-900 hover:text-white rounded-[1.2rem] transition-all shadow-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- 2. Bouton Avis Technique (Apparaît si généré) -->
                                        @if($d->avis_technique_pdf)
                                        <a href="{{ asset('storage/' . $d->avis_technique_pdf) }}" target="_blank" title="Télécharger l'Avis de Conformité" class="inline-flex items-center justify-center w-11 h-11 bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white rounded-[1.2rem] transition-all shadow-sm border border-blue-200">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        @endif

                                        <!-- 3. Bouton Titre Final (Apparaît si octroyé) -->
                                        @if($d->titre_final_pdf)
                                        <a href="{{ asset('storage/' . $d->titre_final_pdf) }}" target="_blank" title="Télécharger le Titre Minier" class="inline-flex items-center justify-center w-11 h-11 bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white rounded-[1.2rem] transition-all shadow-sm border-2 border-amber-300">
                                            <i class="fas fa-certificate"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center opacity-30 italic font-black uppercase text-slate-400">
                                        Aucun dossier enregistré
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="py-8 px-12 bg-gray-50/50 border-t border-gray-100 text-center">
                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.5em]">Division Provinciale des Mines • Haut-Lomami Management</p>
            </div>
        </div>
    </div>
</x-app-layout>