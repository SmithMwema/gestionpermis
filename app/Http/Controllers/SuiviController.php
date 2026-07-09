<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuiviController extends Controller
{
    /**
     * 1. INSTALLATION DU TITULAIRE SUR LE TERRAIN
     * Action posée par l'Agent Territorial lors de la descente initiale.
     */
    public function installer(Request $request, Dossier $dossier)
    {
        // Sécurité : Seul l'agent territorial assigné ou l'admin peut installer
        if (Auth::user()->role !== 'agent_territorial' && Auth::user()->role !== 'admin') {
            abort(403, 'Seul l’agent territorial peut confirmer l’installation.');
        }

        $request->validate([
            'date_installation' => 'required|date|before_or_equal:today',
        ], [
            'date_installation.required' => 'Veuillez saisir la date de descente sur terrain.',
            'date_installation.before_or_equal' => 'La date d’installation ne peut pas être dans le futur.'
        ]);

        // Mise à jour du dossier
        $dossier->update([
            'date_installation' => $request->date_installation,
            'etat_activite' => 'actif', // Le permis devient officiellement actif
            'dernier_rapport_at' => now()
        ]);

        return back()->with('status', '✅ Installation confirmée à ' . $dossier->nom_site . '. Le titulaire est désormais en activité.');
    }

    /**
     * 2. RAPPORT DE CONSTATATION PÉRIODIQUE
     * Permet de signaler la production ou une inactivité.
     */
    public function rapport(Request $request, Dossier $dossier)
    {
        if (Auth::user()->role !== 'agent_territorial' && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'motif' => 'required|string|min:10',
            'constat' => 'required|in:favorable,alerte_inactivite,infraction'
        ], [
            'motif.min' => 'Le rapport doit contenir au moins 10 caractères pour être valide.'
        ]);

        // Détermination du nouvel état de l'activité
        $nouvelEtat = 'actif';
        if ($request->constat === 'alerte_inactivite') {
            $nouvelEtat = 'alerte'; // Cela fera clignoter le dossier chez le Chef de Division
        } elseif ($request->constat === 'infraction') {
            $nouvelEtat = 'infraction';
        }

        // Enregistrement du rapport dans le message d'administration
        $dossier->update([
            'message_administration' => "RAPPORT TERRAIN (" . now()->format('d/m/Y') . ") : " . $request->motif,
            'dernier_rapport_at' => now(),
            'etat_activite' => $nouvelEtat
        ]);

        return back()->with('status', '📝 Rapport de terrain archivé. État actuel : ' . strtoupper($nouvelEtat));
    }
}