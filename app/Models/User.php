<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'territoire', // Ressort d'affectation pour les agents territoriaux
        'role',       // Ré-ajouté ici pour faciliter les tests, à sécuriser en production
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ---------------------------------------------------------------
    // RELATIONS
    // ---------------------------------------------------------------

    /**
     * Un utilisateur (titulaire) peut avoir plusieurs dossiers
     */
    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    // ---------------------------------------------------------------
    // HELPERS DE RÔLE
    // ---------------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTitulaire(): bool
    {
        return $this->role === 'titulaire';
    }

    public function isSecretaire(): bool
    {
        return $this->role === 'secretaire';
    }

    public function isGeometre(): bool
    {
        return $this->role === 'geometre' || $this->role === 'geologue';
    }

    public function isChefDivision(): bool
    {
        return $this->role === 'chef_division';
    }

    public function isMinistre(): bool
    {
        return $this->role === 'ministre';
    }

    public function isAgentTerritorial(): bool
    {
        return $this->role === 'agent_territorial';
    }

    /**
     * Agent de la Division (Tout ce qui n'est pas titulaire ou public)
     */
    public function isAgent(): bool
    {
        return in_array($this->role, ['admin', 'secretaire', 'geometre', 'geologue', 'chef_division', 'ministre', 'agent_territorial']);
    }

    // ---------------------------------------------------------------
    // ACCESSEURS
    // ---------------------------------------------------------------

    /**
     * Libellé du rôle en français
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin'             => 'Administrateur',
            'titulaire'         => 'Opérateur Minier',
            'secretaire'        => 'Secrétaire',
            'geometre'          => 'Géomètre / SIG',
            'geologue'          => 'Géologue / SIG',
            'chef_division'     => 'Chef de Division',
            'ministre'          => 'Ministre Provincial',
            'agent_territorial' => 'Agent Territorial',
            default             => ucfirst(str_replace('_', ' ', $this->role ?? 'Utilisateur')),
        };
    }

    /**
     * Couleur associée au rôle
     */
    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'admin'             => 'gray',
            'titulaire'         => 'blue',
            'secretaire'        => 'teal',
            'geometre'          => 'purple',
            'chef_division'     => 'amber',
            'ministre'          => 'red',
            'agent_territorial' => 'emerald',
            default             => 'slate',
        };
    }

    /**
     * Initiales pour l'avatar
     */
    public function getInitialesAttribute(): string
    {
        $mots = explode(' ', trim($this->name));
        if (count($mots) >= 2) {
            return strtoupper(substr($mots[0], 0, 1) . substr($mots[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    // ---------------------------------------------------------------
    // SCOPES
    // ---------------------------------------------------------------

    /**
     * Liste des agents (utilisé par l'admin pour la gestion du personnel)
     */
    public function scopeAgents($query)
    {
        return $query->whereIn('role', [
            'secretaire', 'geometre', 'geologue', 'chef_division', 'ministre', 'agent_territorial', 'admin'
        ]);
    }

    public function scopeParRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}