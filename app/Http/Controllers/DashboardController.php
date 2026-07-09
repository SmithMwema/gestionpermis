<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Console de Pilotage Dynamique
     * Gère l'aiguillage intelligent vers les 5 bureaux de la Division.
     */
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->role);
        $now = Carbon::now();

        // --------------------------------------------------------------------------
        // 1. CONSOLE ADMINISTRATEUR (Système & Comptes)
        // --------------------------------------------------------------------------
        if ($role == 'admin') {
            $stats = [
                'utilisateurs_total' => User::count(),
                'agents_count' => User::whereNotIn('role', ['titulaire', 'public'])->count(),
                'dossiers_total' => Dossier::count(),
                'octroyes' => Dossier::where('statut', 'octroyé')->count(),
            ];
            $allUsers = User::orderBy('name', 'asc')->get();
            return view('dashboards.admin', compact('stats', 'allUsers'));
        }

        // --------------------------------------------------------------------------
        // 2. BUREAU SECRÉTARIAT (Guichet & Recevabilité)
        // --------------------------------------------------------------------------
        if ($role == 'secretaire') {
            $stats = [
                'total' => Dossier::count(),
                'nouveaux' => Dossier::where('statut', 'soumis')->count(),
                'en_instruction' => Dossier::whereIn('statut', ['en_instruction', 'avis_technique', 'en_signature'])->count(),
                'rejetes' => Dossier::where('statut', 'rejeté')->count(),
            ];
            $dossiersAttente = Dossier::with('user')->where('statut', 'soumis')->orderBy('created_at', 'asc')->get();
            return view('dashboards.secretaire', compact('stats', 'dossiersAttente'));
        }

        // --------------------------------------------------------------------------
        // 3. BUREAU DE LA GÉOMÉTRIE (Expertise SIG & Périmètres)
        // --------------------------------------------------------------------------
        if ($role == 'geologue' || $role == 'geometre') {
            $stats = [
                'a_verifier' => Dossier::where('statut', 'en_instruction')->count(),
                'conflits' => Dossier::where('statut', 'en_instruction')->where('conflit_detecte', true)->count(),
                'expertises_du_mois' => Dossier::where('statut', 'avis_technique')->whereMonth('updated_at', $now->month)->count(),
            ];
            $fileAttente = Dossier::with('user')->where('statut', 'en_instruction')->orderBy('updated_at', 'asc')->get();
            return view('dashboards.geologie', compact('stats', 'fileAttente'));
        }

        // --------------------------------------------------------------------------
        // 4. BUREAU CHEF DE DIVISION (Direction & Monitoring des Permis)
        // --------------------------------------------------------------------------
        if ($role == 'chef_division') {
            // Calcul des dossiers en retard (stagnation > 48h)
            $dateLimite = Carbon::now()->subHours(48);

            $stats = [
                'total_province' => Dossier::count(),
                'attente_avis' => Dossier::where('statut', 'avis_technique')->count(),
                'titres_finis' => Dossier::where('statut', 'octroyé')->count(),
                
                // ALERTES DE LENTEUR ADMINISTRATIVE
                'stagnation_count' => Dossier::whereNotIn('statut', ['octroyé', 'rejeté'])
                                            ->where('updated_at', '<=', $dateLimite)
                                            ->count(),

                // RÉPARTITION PAR TERRITOIRE
                'malemba' => Dossier::where('territoire', 'Malemba-Nkulu')->count(),
                'bukama'  => Dossier::where('territoire', 'Bukama')->count(),
                'kamina'  => Dossier::where('territoire', 'Kamina')->count(),
                'kabongo' => Dossier::where('territoire', 'Kabongo')->count(),
                'kaniama' => Dossier::where('territoire', 'Kaniama')->count(),

                // RÉPARTITION PAR TYPE DE PERMIS (Pour Graphique)
                'count_pr'   => Dossier::where('type_permis', 'PR')->count(),
                'count_pe'   => Dossier::where('type_permis', 'PE')->count(),
                'count_pepm' => Dossier::where('type_permis', 'PEPM')->count(),
            ];

            // File d'attente prioritaire pour Avis Technique
            $dossiersPrioritaires = Dossier::with('user')->where('statut', 'avis_technique')->orderBy('updated_at', 'asc')->get();

            return view('dashboards.chef_division', compact('stats', 'dossiersPrioritaires'));
        }

        // --------------------------------------------------------------------------
        // 5. CABINET DU MINISTRE (Signature & Octroi)
        // --------------------------------------------------------------------------
        if ($role == 'ministre') {
            $stats = [
                'total' => Dossier::count(),
                'a_signer' => Dossier::where('statut', 'en_signature')->count(),
                'octroyes_total' => Dossier::where('statut', 'octroyé')->count(),
            ];
            $dossiersMinistre = Dossier::with('user')->where('statut', 'en_signature')->orderBy('updated_at', 'asc')->get();
            return view('dashboards.ministre', compact('stats', 'dossiersMinistre'));
        }

        // --------------------------------------------------------------------------
        // 6. BUREAU TERRITORIAL (Suivi de Proximité)
        // --------------------------------------------------------------------------
        if ($role == 'agent_territorial') {
            $territoireAgent = $user->territoire;
            $stats = [
                'titres_actifs' => Dossier::where('territoire', $territoireAgent)->where('statut', 'octroyé')->count(),
                'nouveaux_arrivants' => Dossier::where('territoire', $territoireAgent)->whereIn('statut', ['avis_technique', 'en_signature', 'signé_ministre'])->count(),
            ];
            $dossiersLocaux = Dossier::with('user')->where('territoire', $territoireAgent)->orderBy('updated_at', 'desc')->get();
            return view('dashboards.territorial', compact('stats', 'dossiersLocaux', 'territoireAgent'));
        }

        // --------------------------------------------------------------------------
        // 7. ESPACE TITULAIRE (Opérateur Minier)
        // --------------------------------------------------------------------------
        $stats = [
            'total' => Dossier::where('user_id', $user->id)->count(),
            'en_cours' => Dossier::where('user_id', $user->id)->whereIn('statut', ['soumis', 'en_instruction', 'avis_technique', 'en_signature', 'signé_ministre'])->count(),
            'termines' => Dossier::where('user_id', $user->id)->where('statut', 'octroyé')->count(),
            'rejetes' => Dossier::where('user_id', $user->id)->where('statut', 'rejeté')->count(),
        ];
        $recents = Dossier::where('user_id', $user->id)->orderBy('updated_at', 'desc')->take(5)->get();
        return view('dashboards.titulaire', compact('stats', 'recents'));
    }
}