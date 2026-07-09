<x-app-layout>
    <!-- Bibliothèques UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { background: #E2E8F0; height: 100vh; overflow: hidden; }
        
        .main-card {
            background: #FFFFFF;
            border-radius: 50px;
            margin: 20px;
            display: flex;
            height: calc(100vh - 40px);
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .scroll-area { flex: 1; overflow-y: auto; padding: 40px 60px; }

        /* Badge de Statut Premium - Taille fixe pour la lisibilité */
        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 14px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 150px; /* Force la largeur pour éviter l'écrasement */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Bouton Nouveau Dépôt - Vert Sombre */
        .btn-new {
            background-color: #003B31;
            color: white !important;
            padding: 14px 30px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        .btn-new:hover { background-color: #000000; transform: translateY(-2px); }

        .doc-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            font-size: 16px;
        }
    </style>

    <div class="main-card">
        <!-- 1. HEADER : MES ACTIVITÉS -->
        <div class="p-10 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
            <div class="flex items-center gap-6">
                <div class="w-2 h-12 bg-amber-500 rounded-full"></div>
                <div>
                    <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        Mes <span class="text-[#003B31]">Activités</span>
                    </h2>
                    <p class="text-slate-400 text-sm mt-3 font-medium italic">
                        <i class="fas fa-folder-tree mr-2 text-amber-500"></i>
                        Suivi du circuit des dossiers à la Division des Mines
                    </p>
                </div>
            </div>

            <!-- BOUTON SÉCURISÉ : Uniquement pour ceux qui créent (Titulaire, Secrétaire, Admin) -->
            @php $role = strtolower(Auth::user()->role); @endphp
            @if(in_array($role, ['titulaire', 'secretaire', 'admin', 'public']))
            <a href="{{ route('dossiers.create') }}" class="btn-new shadow-xl transform hover:scale-105">
                <span class="w-6 h-6 bg-white/10 rounded-full flex items-center justify-center">+</span>
                Nouveau dépôt dossier
            </a>
            @endif
        </div>

        <!-- 2. ZONE DE LISTE -->
        <div class="scroll-area">
            <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                    <h3 class="font-black text-slate-800 text-sm uppercase italic underline decoration-amber-500 decoration-4 underline-offset-8">Registre Provincial des Permis</h3>
                    <span class="bg-white border border-slate-200 text-slate-400 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase italic">Total : {{ $dossiers->count() }} dossiers</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b">
                            <tr>
                                <th class="px-10 py-6 italic">Référence Dossier</th>
                                <th class="px-10 py-6 italic">Objet / Localisation</th>
                                <th class="px-10 py-6 text-center italic">Position Circuit</th>
                                <th class="px-10 py-6 text-center italic">Actes Officiels</th>
                                <th class="px-10 py-6 text-right italic">Détails</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($dossiers as $d)
                            <tr class="hover:bg-green-50/30 transition-all duration-300">
                                <!-- Référence -->
                                <td class="px-10 py-8 font-black text-[#003B31] text-sm uppercase tracking-tighter">
                                    {{ $d->numero_demande }}
                                </td>
                                
                                <!-- Détails Projet -->
                                <td class="px-10 py-8">
                                    <span class="text-sm font-bold text-slate-700 capitalize">{{ $d->nom_site }}</span>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest italic">
                                        {{ $d->substance ?? 'Gisement' }} • {{ $d->territoire }}
                                    </p>
                                </td>
                                
                                <!-- Statut Pill Corrigé -->
                                <td class="px-10 py-8 text-center">
                                    <div class="status-pill 
                                        {{ $d->statut == 'octroyé' ? 'bg-emerald-500 text-white shadow-emerald-500/20' : 
                                           ($d->statut == 'rejeté' ? 'bg-red-500 text-white shadow-red-500/20' : 'bg-amber-500 text-white shadow-amber-500/20') }}">
                                        {{ str_replace('_', ' ', $d->statut) }}
                                    </div>
                                    <p class="text-[8px] text-slate-300 font-bold mt-2 uppercase tracking-tighter">
                                        MàJ : {{ $d->updated_at->diffForHumans() }}
                                    </p>
                                </td>

                                <!-- Documents & Actes (Affichage dynamique) -->
                                <td class="px-10 py-8 text-center">
                                    <div class="flex justify-center gap-3">
                                        @if($d->avis_technique_pdf)
                                            <a href="{{ asset('storage/' . $d->avis_technique_pdf) }}" target="_blank" class="doc-btn bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white shadow-sm" title="Consulter l'Avis Technique">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        @endif
                                        @if($d->titre_final_pdf)
                                            <a href="{{ asset('storage/' . $d->titre_final_pdf) }}" target="_blank" class="doc-btn bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white shadow-sm border border-emerald-100" title="Consulter l'Acte d'Octroi">
                                                <i class="fas fa-stamp text-amber-500"></i>
                                            </a>
                                        @endif
                                        @if(!$d->avis_technique_pdf && !$d->titre_final_pdf)
                                            <span class="text-[8px] font-bold text-slate-200 uppercase italic">En instruction...</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Action Oeil -->
                                <td class="px-10 py-8 text-right">
                                    <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center justify-center w-12 h-12 bg-slate-100 text-slate-400 hover:bg-[#003B31] hover:text-white rounded-2xl transition-all shadow-sm">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-24 text-center opacity-30 italic font-black uppercase text-slate-400">
                                    <i class="fas fa-inbox text-6xl mb-4 block"></i>
                                    Aucun dossier répertorié
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="py-6 text-center bg-gray-50/50 border-t border-gray-100">
            <p class="text-[9px] text-gray-300 font-black uppercase tracking-[0.5em]">Division Provinciale des Mines • Haut-Lomami Management</p>
        </div>
    </div>
</x-app-layout>