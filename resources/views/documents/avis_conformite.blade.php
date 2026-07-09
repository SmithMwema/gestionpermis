<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.6; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .rdc-logo { width: 80px; float: left; }
        .div-logo { width: 80px; float: right; }
        .title { text-align: center; text-decoration: underline; font-size: 20px; font-weight: bold; clear: both; margin-top: 100px; }
        .content { margin-top: 40px; text-align: justify; }
        .footer { margin-top: 60px; float: right; width: 300px; text-align: center; }
        .signature { margin-top: 20px; height: 80px; }
        .stamp { position: absolute; opacity: 0.8; width: 120px; margin-top: -50px; margin-left: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('image/logo_gauche.jpg') }}" class="rdc-logo">
        <img src="{{ public_path('image/logo_droite.png') }}" class="div-logo">
        <div style="font-weight: bold; font-size: 14px;">
            RÉPUBLIQUE DÉMOCRATIQUE DU CONGO<br>
            PROVINCE DU HAUT-LOMAMI<br>
            DIVISION PROVINCIALE DES MINES ET GÉOLOGIE
        </div>
    </div>

    <div class="title">AVIS DE CONFORMITÉ TECHNIQUE N°{{ $dossier->id }}/2026</div>

    <div class="content">
        <p>Concerne : Instruction technique du dossier n° <strong>{{ $dossier->numero_demande }}</strong></p>

        <p>Nous, Chef de Division Provinciale des Mines et Géologie du Haut-Lomami, certifions par la présente avoir examiné la demande introduite par l'opérateur minier <strong>{{ $dossier->user->name }}</strong>, relative au permis de type <strong>{{ $dossier->type_permis }}</strong> sur le site <strong>{{ $dossier->nom_site }}</strong>, Territoire de <strong>{{ $dossier->territoire }}</strong>.</p>

        <p>Après vérification approfondie par le Bureau de la Géométrie (SIG), il ressort que le périmètre sollicité couvrant <strong>{{ $dossier->nombre_carres }} carrés miniers</strong> pour la substance <strong>{{ $dossier->substance }}</strong> est libre de tout empiètement ou conflit de voisinage avec des titres tiers.</p>

        <p>En conséquence, un avis <strong>FAVORABLE</strong> est émis ce jour. Le présent dossier est transmis au Cabinet du Ministre Provincial des Mines pour octroi définitif.</p>
    </div>

    <div class="footer">
        Fait à Kamina, le {{ date('d/m/Y') }}<br>
        <strong>Le Chef de Division</strong>
        <div class="signature">
             <!-- On simule la signature et le sceau avec tes images si tu les as -->
             <img src="{{ public_path('image/sceau.png') }}" class="stamp">
             <br>
             <span style="font-style: italic;">Signé Électroniquement</span>
        </div>
        <br>
        <strong>{{ Auth::user()->name }}</strong>
    </div>
</body>
</html>