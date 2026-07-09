<x-app-layout>
    <style>
        /* On bloque le scroll global pour garder l'effet application */
        body { background-color: #f0f2f5 !important; height: 100vh; overflow: hidden; }
        
        .workspace-container {
            background-color: white;
            border-radius: 50px;
            margin: 20px;
            height: calc(100vh - 40px);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .form-scroll-area {
            flex: 1;
            overflow-y: auto;
            padding: 50px 80px;
            background-color: #fbfcfd;
        }

        /* Style des inputs comme sur ton image */
        .input-premium {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            padding: 15px 25px;
            width: 100%;
            font-weight: 600;
            color: #1e293b;
            transition: all 0.3s;
        }
        .input-premium:focus {
            border-color: #003B31;
            box-shadow: 0 0 0 4px rgba(0, 59, 49, 0.05);
            outline: none;
        }

        .section-card {
            background: white;
            padding: 35px;
            border-radius: 35px;
            border: 1px solid #f1f5f9;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .upload-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 25px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            background: white;
        }
        .upload-zone:hover { border-color: #003B31; background-color: #f0fdf4; }

        .label-premium {
            font-size: 10px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            margin-left: 10px;
            display: block;
        }

        /* BOUTON VERT IDENTIQUE À TA SIDEBAR */
        .btn-submit-premium {
            background-color: #003B31;
            color: white;
            font-weight: 800;
            padding: 18px 60px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(0, 59, 49, 0.2);
            border: none;
            cursor: pointer;
        }
        .btn-submit-premium:hover {
            background-color: #000000;
            transform: translateY(-2px);
        }
    </style>

    <div class="workspace-container">
        <!-- HEADER DU FORMULAIRE -->
        <div class="p-10 flex justify-between items-center border-b border-gray-50 bg-white">
            <div class="flex items-center gap-6">
                <div class="w-1.5 h-12 bg-amber-500 rounded-full"></div>
                <div>
                    <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">Nouvelle <span class="text-blue-900">Instruction</span></h2>
                    <p class="text-slate-400 text-sm mt-2 font-medium italic italic">Saisie assistée des paramètres géologiques et administratifs</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-red-500 font-bold text-xs uppercase tracking-widest transition">
                <i class="fas fa-times mr-2"></i> Annuler
            </a>
        </div>

        <!-- ZONE DE SAISIE -->
        <main class="form-scroll-area">
            <form action="{{ route('dossiers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- SECTION 1 : ADMINISTRATIF -->
                <div class="section-card">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="label-premium">N° Référence du Dossier</label>
                            <input type="text" name="numero_demande" placeholder="Ex: DM/HL/2026/001" class="input-premium uppercase" required>
                        </div>
                        <div>
                            <label class="label-premium">Type de Titre sollicité</label>
                            <select name="type_permis" class="input-premium">
                                <option value="PR">Permis de Recherche (PR)</option>
                                <option value="PE">Permis d'Exploitation (PE)</option>
                                <option value="PEPM">Petite Mine (PEPM)</option>
                                <option value="ZEA">Zone Artisanale (ZEA)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 : TECHNIQUE -->
                <div class="section-card">
                    <h3 class="text-xs font-black text-blue-900 uppercase mb-6 italic border-b pb-2">Localisation & Paramètres</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="label-premium">Territoire</label>
                                <select id="territoire_select" name="territoire" class="input-premium" onchange="updateSites()">
                                    <option value="">Choisir un territoire...</option>
                                    <option value="Malemba-Nkulu">Malemba-Nkulu</option>
                                    <option value="Bukama">Bukama</option>
                                    <option value="Kamina">Kamina</option>
                                    <option value="Kabongo">Kabongo</option>
                                    <option value="Kaniama">Kaniama</option>
                                </select>
                            </div>
                            <div>
                                <label class="label-premium">Site Géologique Référencé</label>
                                <select id="site_select" name="nom_site" class="input-premium">
                                    <option value="">En attente du territoire...</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="label-premium">Substance Minérale</label>
                                <select name="substance" class="input-premium">
                                    <option value="Lithium">Lithium</option>
                                    <option value="Or">Or (Aurifère)</option>
                                    <option value="Cassiterite">Cassitérite</option>
                                    <option value="Coltan">Coltan / Tantalite</option>
                                    <option value="Cuivre">Cuivre / Cobalt</option>
                                </select>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="label-premium">Nombre de Carrés</label>
                                    <input type="number" name="nombre_carres" class="input-premium" placeholder="Max 200" required>
                                </div>
                                <div class="flex-1">
                                    <label class="label-premium">Point Pivot (GPS)</label>
                                    <input type="text" name="pivot" class="input-premium" placeholder="X, Y">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3 : DOCUMENTS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div class="upload-zone" onclick="document.getElementById('document_pdf').click()">
                        <i class="fas fa-file-pdf text-3xl text-slate-300"></i>
                        <p class="text-[10px] font-black text-slate-400 uppercase mt-3" id="pdf_label">Dossier PDF (Scan complet)</p>
                        <input type="file" name="document_pdf" id="document_pdf" class="hidden" onchange="document.getElementById('pdf_label').innerText = this.files[0].name">
                    </div>
                    <div class="upload-zone" onclick="document.getElementById('photo_site').click()">
                        <i class="fas fa-camera text-3xl text-slate-300"></i>
                        <p class="text-[10px] font-black text-slate-400 uppercase mt-3" id="photo_label">Cliché Photographique du Site</p>
                        <input type="file" name="photo_site" id="photo_site" class="hidden" onchange="document.getElementById('photo_label').innerText = this.files[0].name">
                    </div>
                </div>

                <!-- BOUTON FINAL -->
                <div class="flex justify-center pb-10">
                    <button type="submit" class="btn-submit-premium">
                        Soumettre à la Division des Mines ➔
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        const sitesParTerritoire = {
            "Malemba-Nkulu": ["Ngoya", "Kanuka", "Museka", "Gisements SEGMAL"],
            "Kamina": ["Zone Industrielle", "Concession Zibo Mining", "Périmètre Ville"],
            "Bukama": ["Zone Nord Bukama", "Gisements COMINIERE", "Luena"],
            "Kabongo": ["Zone Artisanale Kabongo", "Secteur Or"],
            "Kaniama": ["Plaine de Kaniama", "Zone de Recherche"]
        };

        function updateSites() {
            const territoire = document.getElementById('territoire_select').value;
            const siteSelect = document.getElementById('site_select');
            siteSelect.innerHTML = '<option value="">Choisir un site...</option>';
            if (sitesParTerritoire[territoire]) {
                sitesParTerritoire[territoire].forEach(site => {
                    const option = document.createElement('option');
                    option.value = site;
                    option.text = site;
                    siteSelect.appendChild(option);
                });
            }
        }
    </script>
</x-app-layout>