<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Facades\Storage;

class DossierController extends Controller
{
    /**
     * INDEX : Liste des dossiers filtrée par rôle et par territoire
     */
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->role);

        // 1. Les agents centraux (Admin, Secrétaire, Géo, Chef, Ministre) voient tout
        if (in_array($role, ['admin', 'secretaire', 'geometre', 'geologue', 'chef_division', 'ministre'])) {
            $dossiers = Dossier::with('user')->orderBy('created_at', 'desc')->get();
        } 
        // 2. L'agent territorial ne voit que les dossiers de SON ressort
        elseif ($role == 'agent_territorial') {
            $dossiers = Dossier::with('user')
                        ->where('territoire', $user->territoire)
                        ->orderBy('created_at', 'desc')
                        ->get();
        } 
        // 3. Le Titulaire ne voit que ses propres dossiers
        else {
            $dossiers = Dossier::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        return view('dossiers.index', compact('dossiers'));
    }

    /**
     * CREATE : Formulaire de soumission
     */
    public function create() { return view('dossiers.create'); }

    /**
     * STORE : Enregistrement initial (Option A: Ligne / Option B: Guichet)
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_demande' => 'required|unique:dossiers',
            'type_permis'    => 'required',
            'nom_site'       => 'required|string|max:255',
            'territoire'     => 'required',
            'substance'      => 'required',
            'nombre_carres'  => 'required|integer',
            'document_pdf'   => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $pdfPath = null;
        if ($request->hasFile('document_pdf')) {
            $file = $request->file('document_pdf');
            $fileName = 'doc_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/dossiers/documents'), $fileName);
            $pdfPath = 'dossiers/documents/' . $fileName;
        }

        Dossier::create([
            'numero_demande' => $request->numero_demande,
            'user_id'        => Auth::id(),
            'type_permis'    => $request->type_permis,
            'nom_site'       => $request->nom_site,
            'territoire'     => $request->territoire,
            'substance'      => $request->substance,
            'nombre_carres'  => $request->nombre_carres,
            'statut'         => 'soumis',
            'document_pdf'   => $pdfPath,
        ]);

        return redirect()->route('dashboard')->with('status', 'Dossier transmis avec succès.');
    }

    /**
     * SHOW : Consultation de la fiche d'instruction (Poste de travail)
     */
    public function show(Dossier $dossier) { return view('dossiers.show', compact('dossier')); }

    /**
     * TRAITER : Moteur de décision du circuit administratif (Étapes 1 à 4)
     */
    public function traiter(Request $request, Dossier $dossier)
    {
        $user = Auth::user();
        $role = strtolower($user->role);
        
        if (!in_array($role, ['secretaire', 'geometre', 'geologue', 'chef_division', 'ministre', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'action' => 'required|in:valider,rejeter',
            'motif'  => 'required|string|min:5',
        ]);

        if ($request->action === 'valider') {
            
            // ÉTAPE 1 : SECRÉTAIRE
            if ($role == 'secretaire') {
                $dossier->update(['statut' => 'en_instruction', 'message_administration' => $request->motif, 'motif_rejet' => null]);
                $msg = "Réception validée. Dossier envoyé au Bureau Technique SIG.";
            } 
            // ÉTAPE 2 : GÉOMÈTRE / GÉOLOGUE
            elseif ($role == 'geometre' || $role == 'geologue') {
                $dossier->update(['statut' => 'avis_technique', 'avis_geologue' => $request->motif, 'motif_rejet' => null]);
                $msg = "Expertise cartographique terminée. Transmis à la Direction.";
            }
            // ÉTAPE 3 : CHEF DE DIVISION (Génération Avis PDF)
            elseif ($role == 'chef_division') {
                $pdf = Pdf::loadView('documents.avis_conformite', ['dossier' => $dossier, 'chef' => $user]);
                $finalPath = 'dossiers/avis_officiels/AVIS_' . $dossier->id . '.pdf';
                Storage::disk('public')->put($finalPath, $pdf->output());

                $dossier->update([
                    'statut' => 'en_signature', 
                    'avis_technique_pdf' => $finalPath, 
                    'avis_chef_division' => $request->motif,
                    'motif_rejet' => null
                ]);
                $msg = "Avis technique généré. Dossier transmis au Cabinet du Ministre.";
            }
            // ÉTAPE 4 : MINISTRE (Signature et retour à la Division)
            elseif ($role == 'ministre') {
                $pdfTitre = Pdf::loadView('documents.titre_minier', ['dossier' => $dossier]);
                $titrePath = 'dossiers/titres_octroyes/TITRE_' . $dossier->id . '.pdf';
                Storage::disk('public')->put($titrePath, $pdfTitre->output());

                $dossier->update([
                    'statut' => 'signé_ministre',
                    'titre_final_pdf' => $titrePath,
                    'message_administration' => "Accord du Ministre : " . $request->motif,
                    'motif_rejet' => null
                ]);
                $msg = "Titre minier signé. Dossier retourné à la Division pour notification.";
            }
        } else {
            // CAS DE REJET
            $dossier->update(['statut' => 'rejeté', 'motif_rejet' => $request->motif]);
            $msg = "Dossier rejeté et renvoyé au titulaire.";
        }

        return redirect()->route('dashboard')->with('status', $msg);
    }

    /**
     * NOTIFIER : Action finale du Chef de Division (Transmission au Territoire)
     */
    public function notifierTerritoire(Dossier $dossier)
    {
        if (!in_array(strtolower(Auth::user()->role), ['chef_division', 'admin'])) {
            abort(403);
        }

        $dossier->update([
            'statut' => 'octroyé', // Statut final d'octroi
            'date_validation_finale' => now()
        ]);

        return redirect()->route('dashboard')->with('status', "Le Bureau Territorial de " . $dossier->territoire . " a été notifié officiellement.");
    }

    /**
     * INSTALLER : Action de l'Agent Territorial sur le terrain
     */
    public function installer(Request $request, Dossier $dossier)
    {
        $request->validate(['date_installation' => 'required|date']);

        $dossier->update([
            'date_installation' => $request->date_installation,
            'etat_activite' => 'actif',
            'dernier_rapport_at' => now()
        ]);

        return back()->with('status', 'Installation confirmée sur le site de ' . $dossier->nom_site);
    }

    /**
     * RAPPORT : Suivi périodique par l'Agent Territorial
     */
    public function rapport(Request $request, Dossier $dossier)
    {
        $request->validate([
            'motif' => 'required|string|min:10',
            'constat' => 'required|in:favorable,alerte_inactivite,infraction'
        ]);

        $etat = ($request->constat == 'alerte_inactivite') ? 'alerte' : 'actif';

        $dossier->update([
            'message_administration' => "RAPPORT TERRAIN : " . $request->motif,
            'dernier_rapport_at' => now(),
            'etat_activite' => $etat
        ]);

        return back()->with('status', 'Rapport de terrain enregistré. État : ' . $etat);
    }
}