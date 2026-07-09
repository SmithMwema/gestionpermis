<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Acte d'Octroi - {{ $dossier->numero_demande }}</title>
    <style>
        /* Configuration de la page A4 */
        @page { margin: 0; }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            margin: 0; 
            padding: 0; 
            color: #1a202c;
        }

        /* Bordure officielle double */
        .page-border {
            margin: 30px;
            padding: 40px;
            border: 10px double #003B31;
            height: 90%;
            position: relative;
        }

        /* En-tête institutionnel */
        .header { text-align: center; margin-bottom: 50px; position: relative; }
        .rdc-logo { width: 70px; position: absolute; left: 0; top: 0; }
        .mines-logo { width: 70px; position: absolute; right: 0; top: 0; }
        
        .header-text h2 { margin: 0; font-size: 18px; color: #000; }
        .header-text h3 { margin: 5px 0; font-size: 16px; color: #003B31; }
        .header-text h4 { margin: 0; font-size: 14px; color: #d97706; text-decoration: underline; }

        /* Titre du document */
        .doc-title {
            text-align: center;
            margin-top: 60px;
            margin-bottom: 40px;
        }
        .doc-title h1 {
            font-size: 28px;
            font-weight: bold;
            color: #003B31;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .doc-title p {
            font-size: 14px;
            font-weight: bold;
            margin-top: 0;
        }

        /* Corps du texte */
        .content {
            text-align: justify;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 50px;
        }
        .content strong { color: #000; }

        /* Bloc de signature */
        .signature-block {
            float: right;
            width: 300px;
            text-align: center;
            margin-top: 40px;
        }
        .signature-space {
            height: 120px;
            position: relative;
            margin: 15px 0;
        }
        .official-stamp {
            position: absolute;
            width: 140px;
            top: -20px;
            left: 80px;
            opacity: 0.85;
            z-index: 10;
        }
        .digital-mention {
            display: inline-block;
            padding: 5px 10px;
            border: 2px solid #001f3f;
            color: #001f3f;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            text-transform: uppercase;
            transform: rotate(-5deg);
            font-size: 12px;
            margin-top: 30px;
        }

        .footer-note {
            position: absolute;
            bottom: 40px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="page-border">
        <!-- EN-TÊTE -->
        <div class="header">
            <img src="{{ public_path('image/logo_gauche.jpg') }}" class="rdc-logo">
            <img src="{{ public_path('image/logo_droite.png') }}" class="mines-logo">
            <div class="header-text">
                <h2>RÉPUBLIQUE DÉMOCRATIQUE DU CONGO</h2>
                <h3>GOUVERNEMENT PROVINCIAL DU HAUT-LOMAMI</h3>
                <h4>MINISTÈRE PROVINCIAL DES MINES</h4>
            </div>
        </div>

        <!-- TITRE -->
        <div class="doc-title">
            <h1>ACTE D'OCTROI DE TITRE MINIER</h1>
            <p>N° {{ str_pad($dossier->id, 4, '0', STR_PAD_LEFT) }}/MIN-MINES/HL/2026</p>
        </div>

        <!-- CORPS -->
        <div class="content">
            <p>
                Nous, <strong>{{ Auth::user()->name }}</strong>, Ministre Provincial des Mines de la Province du Haut-Lomami ;
            </p>
            <p>
                Vu la Constitution de la République Démocratique du Congo ;<br>
                Vu le Code Minier tel que révisé à ce jour ;<br>
                Vu l'Avis de Conformité Technique favorable émis par la Division Provinciale sous le numéro <strong>{{ $dossier->id }}/AV-TECH/2026</strong> ;
            </p>
            <p>
                Accordons par la présente à l'Opérateur Minier <strong>{{ strtoupper($dossier->user->name) }}</strong>, le droit exclusif d'exercer des activités de type <strong>{{ $dossier->type_permis }}</strong> sur le périmètre dénommé <strong>"{{ $dossier->nom_site }}"</strong>, situé dans le Territoire de <strong>{{ $dossier->territoire }}</strong>.
            </p>
            <p>
                Le présent titre couvre une superficie de <strong>{{ $dossier->nombre_carres }} carrés miniers</strong> pour l'exploitation de la substance minérale : <strong>{{ strtoupper($dossier->substance) }}</strong>.
            </p>
        </div>

        <!-- SIGNATURE -->
        <div class="signature-block">
            <p>Fait à Kamina, le {{ date('d/m/Y') }}</p>
            <p><strong>LE MINISTRE PROVINCIAL,</strong></p>
            
            <div class="signature-space">
                <!-- Sceau officiel (vérifie que l'image existe dans public/image/sceau.png) -->
                @if(file_exists(public_path('image/sceau.png')))
                    <img src="{{ public_path('image/sceau.png') }}" class="official-stamp">
                @endif
                
                <div class="digital-mention">
                    ACTE CERTIFIÉ CONFORME
                </div>
            </div>
            
            <p style="margin-top: 20px;"><strong>Excellence {{ Auth::user()->name }}</strong></p>
        </div>

        <!-- FOOTER -->
        <div class="footer-note">
            Ce document est une pièce officielle générée par le Système Numérique de Gestion des Permis de la Division des Mines du Haut-Lomami.
        </div>
    </div>
</body>
</html>