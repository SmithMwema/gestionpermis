<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dossier extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'numero_demande',
        'user_id',
        'type_permis',
        'nom_site',
        'territoire',
        'substance',
        'nombre_carres',
        'coordonnees_gps',
        'conflit_detecte',
        'statut',
        'document_pdf',
        'photo_site',
        'avis_geologue',
        'avis_chef_division',
        'avis_technique_pdf',    // Avis généré par le Chef de Division
        'titre_final_pdf',       // Titre généré par le Ministre (AJOUTÉ)
        'motif_rejet',
        'message_administration',
        'date_validation_finale'
    ];

    /**
     * Typage automatique des colonnes
     */
    protected $casts = [
        'date_validation_finale' => 'datetime',
        'coordonnees_gps'        => 'array', 
        'conflit_detecte'        => 'boolean',
        'created_at'             => 'datetime',
        'updated_at'             => 'datetime',
    ];

    // ---------------------------------------------------------------
    // RELATIONS
    // ---------------------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historiques()
    {
        return $this->hasMany(DossierHistorique::class)->orderBy('created_at', 'desc');
    }

    // ---------------------------------------------------------------
    // SCOPES (Filtres de requêtes)
    // ---------------------------------------------------------------

    public function scopeSoumis($query) { return $query->where('statut', 'soumis'); }
    public function scopeEnInstruction($query) { return $query->where('statut', 'en_instruction'); }
    public function scopeAvisTechnique($query) { return $query->where('statut', 'avis_technique'); }
    public function scopeEnSignature($query) { return $query->where('statut', 'en_signature'); }
    public function scopeOctroyes($query) { return $query->where('statut', 'octroyé'); }
    public function scopeRejetes($query) { return $query->where('statut', 'rejeté'); }

    // ---------------------------------------------------------------
    // ACCESSEURS (Logique d'affichage)
    // ---------------------------------------------------------------

    /**
     * Vérifie si l'Avis de Conformité est disponible au téléchargement
     */
    public function getHasAvisAttribute(): bool
    {
        return !empty($this->avis_technique_pdf);
    }

    /**
     * Vérifie si le Titre Minier Final est disponible au téléchargement
     */
    public function getHasTitreAttribute(): bool
    {
        return !empty($this->titre_final_pdf);
    }

    /**
     * Libellé lisible du statut
     */
    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'soumis'         => 'Soumis (Réception)',
            'en_instruction' => 'En expertise SIG',
            'avis_technique' => 'Attente Avis Direction',
            'en_signature'   => 'Attente Signature Ministre',
            'octroyé'        => 'Titre Octroyé',
            'rejeté'         => 'Dossier Rejeté',
            default          => ucfirst(str_replace('_', ' ', $this->statut)),
        };
    }

    /**
     * Couleur Tailwind associée au statut
     */
    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'soumis'         => 'blue',
            'en_instruction' => 'indigo',
            'avis_technique' => 'amber',
            'en_signature'   => 'orange',
            'octroyé'        => 'emerald',
            'rejeté'         => 'red',
            default          => 'slate',
        };
    }

    /**
     * Icône FontAwesome associée au statut
     */
    public function getStatutIconAttribute(): string
    {
        return match($this->statut) {
            'soumis'         => 'fa-file-import',
            'en_instruction' => 'fa-map-location-dot',
            'avis_technique' => 'fa-file-signature',
            'en_signature'   => 'fa-pen-fancy',
            'octroyé'        => 'fa-certificate',
            'rejeté'         => 'fa-circle-exclamation',
            default          => 'fa-circle-question',
        };
    }
}