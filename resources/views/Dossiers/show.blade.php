<x-app-layout>
    <!-- Bibliothèques UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { background: #E2E8F0; height: 100vh; overflow: hidden; }
        
        .show-container {
            background: #FFFFFF;
            border-radius: 40px;
            margin: 15px;
            display: flex;
            height: calc(100vh - 30px);
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .pdf-section { flex: 1; background: #334155; display: flex; flex-direction: column; border-right: 1px solid #E2E8F0; }
        .pdf-header { background: #1E293B; padding: 15px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        
        .action-section {
            width: 480px; 
            background: white;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #F1F5F9;
        }

        .inst-logo { height: 45px; width: auto; object-fit: contain; }
        .info-label { text-transform: uppercase; font-size: 9px; font-weight: 800; color: #94A3B8; letter-spacing: 1px; margin-bottom: 4px; }
        .info-value { font-weight: 700; color: #1E293B; margin-bottom: 12px; font-size: 13px; }
        
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 12px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        
        .btn-decision { width: 100%; padding: 14px; border-radius: 18px; font-weight: 800; font-size: 10px; text-transform: uppercase; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; border: none; cursor: pointer; }
        .btn-validate { background: #003B31; color: white; margin-bottom: 10px; }
        .btn-chef { background: #f59e0b; color: #001f3f; margin-bottom: 10px; }
        .btn-sig { background: #1E3A8A; color: white; margin-bottom: 10px; }
        .btn-ministre { background: #001f3f; color: #f59e0b; margin-bottom: 10px; border: 2px solid #f59e0b; }
        .btn-invalidate { background: #EF4444; color: white; }
        
        .motif-textarea { border: 1.5px solid #E2E8F0; border-radius: 15px; padding: 12px; font-size: 12px; background: #F8FAFC; width: 100%; margin-top: 5px; margin-bottom: 15px; transition: 0.3s; }
        .motif-textarea:focus { border-color: #003B31; outline: none; background: white; }
        
        .user-circle { width: 35px; height: 35px; background-color: #003B31; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px; }
        
        .doc-tab { padding: 8px 15px; border-radius: 12px; font-size: 10px; font-weight: 800; text-transform: uppercase; cursor: pointer; color: rgba(255,255,255,0.4); border: 1px solid transparent; transition: 0.3s; }
        .doc-tab.active { background: #f59e0b; color: #001f3f; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    </style>

    <div class="show-container">
        
        <!-- ========== PANEL GAUCHE : VISIONNEUSE PDF ========== -->
        <section class="pdf-section">
            <div class="pdf-header">
                <div class="flex justify-between items-center">
                    <div class="flex gap-2 bg-black/30 p-1.5 rounded-2xl border border-white/5">
                        <div onclick="switchDoc('original', '{{ asset('storage/' . $dossier->document_pdf) }}')" id="tab-original" class="doc-tab active">
                            <i class="fas fa-file-alt mr-2"></i> Dossier
                        </div>
                        @if($dossier->avis_technique_pdf)
                            <div onclick="switchDoc('avis', '{{ asset('storage/' . $dossier->avis_technique_pdf) }}')" id="tab-avis" class="doc-tab">
                                <i class="fas fa-certificate mr-2 text-amber-400"></i> Avis Tech.
                            </div>
                        @endif
                        @if($dossier->titre_final_pdf)
                            <div onclick="switchDoc('titre', '{{ asset('storage/' . $dossier->titre_final_pdf) }}')" id="tab-titre" class="doc-tab">
                                <i class="fas fa-stamp mr-2 text-emerald-400"></i> Titre
                            </div>
                        @endif
                    </div>
                    <a id="btn-fullscreen" href="{{ asset('storage/' . $dossier->document_pdf) }}" target="_blank" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-xl text-[10px] font-black text-white transition-all">
                        <i class="fas fa-expand mr-2"></i> PLEIN ÉCRAN
                    </a>
                </div>
            </div>
            <div class="flex-1 bg-[#525659] relative">
                <iframe id="pdf-viewer" src="{{ asset('storage/' . $dossier->document_pdf) }}" class="w-full h-full border-none"></iframe>
            </div>
        </section>

        <!-- ========== PANEL DROIT : ACTIONS & INSTRUCTION ========== -->
        <section class="action-section">
            <!-- Header Logos -->
            <div class="flex justify-between items-center mb-6 bg-gray-50/50 p-4 rounded-[1.5rem] border border-gray-100">
                <img src="{{ asset('image/logo_droite.png') }}" class="inst-logo" alt="DP Mines">
                <div class="text-center px-2">
                    <p class="text-[8px] font-black text-blue-900 uppercase leading-none italic">République Démocratique du Congo</p>
                    <p class="text-[7px] font-bold text-amber-600 uppercase mt-1 tracking-widest">Division des Mines</p>
                </div>
                <img src="{{ asset('image/logo_gauche.jpg') }}" class="inst-logo" alt="RDC">
            </div>

            <!-- Titre et Badge de Statut -->
            <div class="mb-4 flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-black text-slate-800 uppercase tracking-tighter italic leading-none">Fiche d'instruction</h2>
                    <p class="text-[9px] text-gray-400 font-bold uppercase mt-1 tracking-widest italic">Agent : {{ Auth::user()->name }}</p>
                </div>
                <div class="user-circle shadow-lg">{{ substr(Auth::user()->name, 0, 1) }}</div>
            </div>

            <!-- Badge Statut Dynamique -->
            <div class="mb-6">
                <span class="status-badge bg-{{ $dossier->statut_color }}-100 text-{{ $dossier->statut_color }}-700 shadow-sm border border-black/5">
                    ● {{ $dossier->statut_label }}
                </span>
            </div>

            <!-- Informations Dossier -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-6">
                <p class="info-label">Requérant / Opérateur</p>
                <p class="info-value text-blue-900 uppercase mb-2">{{ $dossier->user->name }}</p>
                <div class="flex flex-wrap gap-x-4 gap-y-1">
                    <p class="text-[10px] text-slate-500 font-bold uppercase italic tracking-tighter">
                        <i class="fas fa-map-marker-alt text-amber-500 mr-1"></i> {{ $dossier->nom_site }}
                    </p>
                </div>
            </div>

            <!-- ========== HISTORIQUE DES RAPPORTS ========== -->
            <div class="space-y-3 mb-6">
                <h3 class="info-label text-blue-900 font-black italic border-b pb-1">📜 Rapports du circuit</h3>
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px]">
                    <p class="font-black text-gray-400 uppercase italic">1. Secrétariat :</p>
                    <p class="italic">"{{ $dossier->message_administration ?? 'En attente...' }}"</p>
                </div>
                @if($dossier->avis_geologue)
                <div class="p-3 bg-blue-50/50 rounded-xl border border-blue-100 text-[10px]">
                    <p class="font-black text-blue-400 uppercase italic">2. Bureau SIG :</p>
                    <p class="italic text-blue-800 font-bold">{{ $dossier->avis_geologue }}</p>
                </div>
                @endif
            </div>

            <!-- ============================================================
                 ZONE DYNAMIQUE DE DÉCISION (CORRIGÉE)
            ============================================================= -->
            <div class="flex-1 mt-auto">
                @php $role = strtolower(Auth::user()->role); @endphp

                <!-- 1. CAS SECRÉTAIRE -->
                @if($role == 'secretaire' && $dossier->statut == 'soumis')
                    <form action="{{ route('dossiers.traiter', $dossier) }}" method="POST">
                        @csrf
                        <label class="info-label text-emerald-700">Avis de conformité administrative</label>
                        <textarea name="motif" rows="3" class="motif-textarea shadow-inner" placeholder="Vérifiez les pièces jointes et le paiement..." required></textarea>
                        <div class="space-y-3">
                            <button type="submit" name="action" value="valider" class="btn-decision btn-validate shadow-xl">
                                <i class="fas fa-check-circle"></i> VALIDER RÉCEPTION & TRANSMETTRE
                            </button>
                            <button type="submit" name="action" value="rejeter" class="btn-decision btn-invalidate shadow-xl">
                                <i class="fas fa-times-circle"></i> INVALIDER LE DOSSIER
                            </button>
                        </div>
                    </form>

                <!-- 2. CAS GÉOLOGUE -->
                @elseif(($role == 'geologue' || $role == 'geometre') && $dossier->statut == 'en_instruction')
                    <form action="{{ route('dossiers.traiter', $dossier) }}" method="POST">
                        @csrf
                        <label class="info-label text-blue-700">Expertise SIG (Vacance du terrain)</label>
                        <textarea name="motif" rows="3" class="motif-textarea shadow-inner" placeholder="Rapport sur le périmètre et les carrés..." required></textarea>
                        <button type="submit" name="action" value="valider" class="btn-decision btn-sig shadow-xl">
                            <i class="fas fa-map-location-dot"></i> VALIDER LE PÉRIMÈTRE
                        </button>
                        <button type="submit" name="action" value="rejeter" class="btn-decision btn-invalidate shadow-xl">
                            <i class="fas fa-draw-polygon"></i> SIGNALER UN CONFLIT
                        </button>
                    </form>

                <!-- 3. CAS CHEF DE DIVISION -->
                @elseif($role == 'chef_division' && $dossier->statut == 'avis_technique')
                    <form action="{{ route('dossiers.traiter', $dossier) }}" method="POST">
                        @csrf
                        <label class="info-label text-amber-600">Conclusion Technique Finale</label>
                        <textarea name="motif" rows="3" class="motif-textarea shadow-inner" placeholder="Émettez l'avis de conformité technique..." required></textarea>
                        <button type="submit" name="action" value="valider" class="btn-decision btn-chef shadow-xl">
                            <i class="fas fa-certificate"></i> SIGNER & GÉNÉRER L'AVIS PDF
                        </button>
                    </form>

                <!-- 4. CAS MINISTRE -->
                @elseif($role == 'ministre' && $dossier->statut == 'en_signature')
                    <form action="{{ route('dossiers.traiter', $dossier) }}" method="POST">
                        @csrf
                        <textarea name="motif" rows="2" class="motif-textarea" placeholder="Instructions finales..."></textarea>
                        <button type="submit" name="action" value="valider" class="btn-decision btn-ministre shadow-2xl">
                            <i class="fas fa-stamp"></i> ACCORDER LE TITRE MINIER
                        </button>
                    </form>

                <!-- 5. MODE CONSULTATION (REJETÉ OU DÉJÀ TRAITÉ) -->
                @else
                    <div class="bg-gray-50 p-6 rounded-3xl text-center border border-gray-100">
                        <i class="fas fa-info-circle text-slate-400 text-3xl mb-2"></i>
                        <p class="text-xs font-black text-slate-500 uppercase">Consultation uniquement</p>
                        <p class="text-[10px] text-slate-400 mt-1 italic italic">Le dossier est actuellement à l'étape : {{ $dossier->statut_label }}</p>
                    </div>
                @endif
                
                <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-[10px] font-black text-slate-300 uppercase hover:text-blue-900 transition-colors">
                    <i class="fas fa-chevron-left mr-2"></i> Retour au bureau
                </a>
            </div>
        </section>

    </div>

    <!-- Script de commutation des documents -->
    <script>
        function switchDoc(type, url) {
            document.getElementById('pdf-viewer').src = url;
            document.getElementById('btn-fullscreen').href = url;
            document.querySelectorAll('.doc-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-' + type).classList.add('active');
        }
    </script>
</x-app-layout>