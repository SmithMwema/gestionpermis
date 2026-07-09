<x-app-layout>
    <!-- FontAwesome pour le prestige -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <!-- GRANDE CARTE BLANCHE (CABINET DU MINISTRE) -->
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <!-- 1. EN-TÊTE : EXCELLENCE MONSIEUR LE MINISTRE -->
            <div class="p-8 md:p-12 flex justify-between items-center border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex items-center gap-8">
                    <!-- Sceau de l'Autorité Provinciale -->
                    <div class="relative">
                        <div class="w-20 h-20 bg-[#001f3f] rounded-full flex items-center justify-center shadow-2xl border-4 border-amber-500">
                            <i class="fas fa-ribbon text-amber-500 text-3xl"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white shadow-md animate-pulse"></div>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none italic">
                            Cabinet du <span class="text-blue-900">Ministre</span>
                        </h2>
                        <p class="text-slate-400 text-sm mt-3 font-semibold italic flex items-center gap-3">
                            <img src="{{ asset('image/logo_gauche.jpg') }}" class="h-4 w-auto opacity-50">
                            Gouvernement Provincial • Mines & Géologie • Haut-Lomami
                        </p>
                    </div>
                </div>

                <!-- Horloge de l'Autorité -->
                <div class="hidden lg:flex items-center gap-4 bg-slate-900 text-white px-8 py-4 rounded-[2rem] shadow-xl border-b-4 border-amber-500">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] leading-none mb-1">Calendrier Officiel</p>
                        <p class="text-sm font-bold italic">{{ date('d F Y') }}</p>
                    </div>
                    <i class="fas fa-calendar-check text-amber-500 text-xl"></i>
                </div>
            </div>

            <!-- 2. ZONE DE DÉCISION ET STATISTIQUES D'AUTORITÉ -->
            <div class="p-8 md:p-12 overflow-y-auto flex-1">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-12">
                    <!-- Stat 1 : Urgence -->
                    <div class="bg-white p-8 rounded-[3rem] border-l-[12px] border-l-amber-500 shadow-xl shadow-amber-900/5 relative overflow-hidden group hover:scale-105 transition-transform duration-500">
                        <div class="relative z-10">
                            <p class="text-[11px] font-black text-amber-600 uppercase tracking-widest mb-2 italic">Titres en attente d'octroi</p>
                            <h4 class="text-7xl font-black text-slate-800 tracking-tighter">{{ $stats['a_signer'] ?? 0 }}</h4>
                            <p class="text-[9px] text-slate-400 font-bold mt-3 uppercase underline decoration-amber-200 decoration-2">Signature immédiate requise ➔</p>
                        </div>
                        <i class="fas fa-pen-fancy absolute -right-4 -bottom-4 text-8xl text-amber-500 opacity-5 group-hover:rotate-12 transition-transform"></i>
                    </div>

                    <!-- Stat 2 : Bilan -->
                    <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col justify-center">
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Total Titres Octroyés (2026)</p>
                        <div class="flex items-baseline gap-3">
                            <h4 class="text-6xl font-black text-blue-900 tracking-tighter">{{ $stats['octroyes_total'] ?? 0 }}</h4>
                            <span class="text-xs font-bold text-green-500 uppercase tracking-tighter">Actes Scellés</span>
                        </div>
                    </div>

                    <!-- Stat 3 : Note de Loi -->
                    <div class="bg-[#001f3f] p-8 rounded-[3rem] shadow-2xl text-white flex flex-col justify-center relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-3 italic italic border-b border-white/10 pb-2">Prérogative Ministérielle</p>
                            <p class="text-[11px] font-medium leading-relaxed opacity-70 italic">
                                "En vertu du Code Minier, le Ministre Provincial accorde le titre après avis favorable de la Division."
                            </p>
                        </div>
                        <i class="fas fa-gavel absolute -right-4 -bottom-4 text-7xl text-white opacity-5"></i>
                    </div>
                </div>

                <!-- 3. LE REGISTRE DES DÉCRETS (L'ACTION) -->
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-10 py-6 border-b border-slate-50 flex justify-between items-center bg-[#001f3f]">
                        <h3 class="font-black text-white text-sm uppercase italic tracking-widest">
                            <i class="fas fa-file-shield mr-3 text-amber-500"></i>Dossiers munis de l'Avis de Conformité
                        </h3>
                        <div class="flex items-center gap-3">
                            <span class="bg-green-500 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-lg">Vérifié Division</span>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6">Opérateur sollicitant</th>
                                    <th class="px-10 py-6">Référence / Territoire</th>
                                    <th class="px-10 py-6 text-center">Statut Technique</th>
                                    <th class="px-10 py-6 text-right">Apposer le Sceau</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($dossiersMinistre as $d)
                                <tr class="hover:bg-blue-50/20 transition-all duration-300 group">
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-black text-slate-800 uppercase tracking-tighter group-hover:text-blue-900 transition-colors">{{ $d->user->name }}</span>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 italic tracking-widest">{{ $d->nom_site }}</p>
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-3 py-1 rounded-lg border border-slate-200 uppercase">{{ $d->numero_demande }}</span>
                                        <p class="text-[9px] text-blue-900 font-bold mt-1 uppercase">{{ $d->territoire }}</p>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-green-600 font-black text-[10px] uppercase underline decoration-2 underline-offset-4 italic">Avis Favorable</span>
                                            <p class="text-[8px] text-slate-300 font-bold uppercase italic">(Chef de Division)</p>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                        <!-- Bouton Signature avec Icône Tampon (Stamp) -->
                                        <a href="{{ route('dossiers.show', $d) }}" class="inline-flex items-center justify-center w-14 h-14 bg-[#001f3f] text-white rounded-2xl hover:bg-amber-500 hover:text-blue-900 transition-all shadow-xl hover:rotate-6 active:scale-90">
                                            <i class="fas fa-stamp text-2xl"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="flex flex-col items-center opacity-30">
                                            <i class="fas fa-feather-pointed text-6xl mb-4 text-slate-200"></i>
                                            <p class="text-xl font-black text-slate-400 uppercase tracking-tighter italic">Aucun titre en attente de signature ministérielle</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. FOOTER CABINET -->
            <div class="py-8 px-12 bg-gray-50/50 border-t border-gray-100 text-center flex justify-between items-center italic">
                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.5em]">République Démocratique du Congo • Province du Haut-Lomami • Cabinet du Ministre</p>
                <div class="flex gap-4">
                    <span class="text-[8px] font-black text-slate-300 uppercase">Autorité de l'État</span>
                    <span class="text-[8px] font-black text-slate-300 uppercase italic">Version 2.3.1</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>