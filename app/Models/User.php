<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'specialite',
        'research_team_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relation avec l'équipe de recherche
    public function researchTeam()
    {
        return $this->belongsTo(ResearchTeam::class);
    }

    // Relation avec les publications
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    // Relation avec les équipes dirigées
    public function teamsLed()
    {
        return $this->hasMany(ResearchTeam::class, 'team_leader_id');
    }

    // Vérifier le rôle
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isChercheur()
    {
        return $this->role === 'chercheur';
    }

    // Nombre de publications
    public function getPublicationsCountAttribute()
    {
        return $this->publications()->count();
    }
}