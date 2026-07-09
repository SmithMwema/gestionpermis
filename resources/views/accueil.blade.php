<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DP Mines - Haut-Lomami | Site Officiel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Correction Diaporama avec les noms exacts de tes fichiers */
        .slider-container { position: relative; height: 550px; width: 100%; overflow: hidden; background-color: #1a202c; }
        .slide { 
            position: absolute; inset: 0; opacity: 0; transition: opacity 1.5s ease-in-out; 
            background-size: cover; background-position: center;
        }
        .slide.active { opacity: 1; }
        .slide-overlay { 
            position: absolute; inset: 0; 
            background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.3), rgba(0,0,0,0.8)); 
        }

        .slogan-modern {
            background: linear-gradient(90deg, #fbbf24, #ffffff, #fbbf24);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 3s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- EN-TÊTE OFFICIEL -->
    <header class="bg-white border-b-8 border-blue-900 py-6">
        <div class="w-full px-4 md:px-16 flex justify-between items-center">
            <div class="flex-shrink-0">
                <img src="{{ asset('image/logo_droite.png') }}" alt="Logo DP Mines" class="h-32 md:h-44 w-auto object-contain">
            </div>

            <div class="text-center flex-1 mx-4">
                <h1 class="text-blue-900 font-black text-2xl md:text-4xl uppercase tracking-tighter leading-none italic">
                    République Démocratique du Congo
                </h1>
                <p class="text-amber-600 font-extrabold text-xl md:text-2xl uppercase mt-2">
                    Province du Haut-Lomami
                </p>
                <div class="h-1.5 w-48 bg-blue-900 mx-auto my-4 rounded-full shadow-sm"></div>
                <p class="text-gray-400 font-bold text-sm md:text-base uppercase tracking-[0.3em]">
                    Division Provinciale des Mines et Géologie
                </p>
            </div>

            <div class="flex-shrink-0 text-right">
                <img src="{{ asset('image/logo_gauche.jpg') }}" alt="Armoiries RDC" class="h-32 md:h-44 w-auto object-contain">
            </div>
        </div>
    </header>

    <!-- NAVIGATION -->
    <nav class="bg-blue-900 shadow-xl sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center font-bold text-sm uppercase text-gray-100 tracking-widest">
            <div class="hidden md:flex space-x-10">
                <a href="#missions" class="hover:text-amber-400">Missions & Objectifs</a>
                <a href="#stats" class="hover:text-amber-400">Statistiques</a>
                <a href="#carte" class="hover:text-amber-400">Carte SIG</a>
            </div>
            <a href="{{ route('login') }}" class="bg-amber-500 text-blue-900 px-10 py-3 rounded-full font-black hover:bg-white transition duration-300 shadow-xl">
                CONNEXION
            </a>
        </div>
    </nav>

    <!-- DIAPORAMA (CORRIGÉ AVEC TES NOMS DE FICHIERS) -->
    <section class="slider-container flex items-center justify-center text-center text-white">
        <!-- Noms de fichiers basés sur ta capture d'écran -->
        <div class="slide active" style="background-image: url('{{ asset('image/Titualire.png') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('image/agent.jpeg') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('image/agent 2.jpg') }}')"></div>
        
        <div class="slide-overlay"></div>

        <div class="relative z-10 px-4">
            <h2 class="text-4xl md:text-7xl font-black mb-6 animate__animated animate__fadeInDown uppercase tracking-tighter shadow-2xl">
                Cadastre Minier <br> <span class="text-amber-500 font-black">Numérique</span>
            </h2>
            <p class="text-xl md:text-3xl font-black slogan-modern italic animate__animated animate__fadeInUp uppercase tracking-widest">
                "L'excellence minière au service du développement provincial."
            </p>
        </div>
    </section>

    <!-- MISSIONS & OBJECTIFS (RÉ-INTRODUITS ET EMBELLIS) -->
    <section id="missions" class="py-20 container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Missions -->
            <div class="bg-white p-10 rounded-3xl shadow-xl border-l-8 border-blue-900">
                <h2 class="text-3xl font-black text-blue-900 mb-6 uppercase italic">Nos Missions</h2>
                <p class="leading-relaxed text-gray-600 font-medium italic">
                    La Division Provinciale des Mines du Haut-Lomami assure la supervision technique, administrative et cartographique de toutes les activités minières. 
                    Nous garantissons l'application stricte du Code Minier pour une exploitation transparente des ressources de la province.
                </p>
            </div>
            <!-- Objectifs -->
            <div class="bg-white p-10 rounded-3xl shadow-xl border-l-8 border-amber-500 text-right">
                <h2 class="text-3xl font-bold text-blue-900 mb-6 uppercase italic">Nos Objectifs</h2>
                <ul class="text-gray-600 space-y-4 font-black uppercase text-xs tracking-widest italic">
                    <li>● Numérisation intégrale des procédures cadastrales</li>
                    <li>● Encadrement et promotion de l'artisanat minier responsable</li>
                    <li>● Monitoring permanent des titres et carrés miniers</li>
                    <li>● Maximisation de la contribution minière au budget provincial</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- STATISTIQUES AVEC GRAPHIQUE -->
    <section id="stats" class="bg-white py-20 border-y border-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-black text-blue-900 mb-12 text-center uppercase tracking-widest underline decoration-amber-500 underline-offset-8">Statistiques & Monitoring</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-blue-900 p-8 rounded-3xl text-white text-center shadow-lg transform hover:scale-105 transition">
                        <p class="text-5xl font-black text-amber-400">120+</p>
                        <p class="text-[10px] uppercase font-bold opacity-60">Permis Actifs</p>
                    </div>
                    <div class="bg-gray-100 p-8 rounded-3xl text-blue-900 text-center shadow-inner">
                        <p class="text-5xl font-black">45</p>
                        <p class="text-[10px] uppercase font-bold opacity-60">Coopératives</p>
                    </div>
                </div>
                <!-- Graphique Pie Chart -->
                <div class="bg-white p-6 rounded-3xl shadow-2xl border border-gray-50 h-[400px] flex flex-col items-center">
                    <h3 class="text-[10px] font-black uppercase text-gray-400 mb-6 tracking-widest">Répartition des Titres</h3>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- CARTE SIG -->
    <section id="carte" class="py-20 container mx-auto px-6 text-center">
        <h2 class="text-3xl font-black text-blue-900 mb-10 uppercase tracking-widest">Visualisation Cartographique</h2>
        <div id="map" class="h-[550px] w-full rounded-3xl shadow-2xl border-8 border-white ring-1 ring-gray-200"></div>
    </section>

    <footer class="bg-gray-900 text-white py-12 text-center">
        <p class="opacity-50 text-xs font-black uppercase tracking-[0.4em]">
            RDC | DP Mines Haut-Lomami &copy; {{ date('Y') }}
        </p>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Carte Leaflet
        var map = L.map('map').setView([-8.7410, 24.9960], 7); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([-8.7410, 24.9960]).addTo(map).bindPopup('<b>KAMINA</b>').openPopup();

        // Diaporama Automatique
        let slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        setInterval(nextSlide, 5000);

        // Graphique Chart.js
        new Chart(document.getElementById('myChart'), {
            type: 'pie',
            data: {
                labels: ['PR', 'PE', 'PEPM', 'PER'],
                datasets: [{
                    data: [65, 25, 15, 10],
                    backgroundColor: ['#1e3a8a', '#f59e0b', '#3b82f6', '#10b981'],
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });
    </script>
</body>
</html>