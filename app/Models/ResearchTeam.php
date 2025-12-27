<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchTeam extends Model
{
    protected $fillable = [
        'name',
        'description',
        'domaine',
        'team_leader_id',
    ];

    // Relation avec le chef d'équipe
    public function teamLeader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    // Relation avec les membres
    public function members()
    {
        return $this->hasMany(User::class);
    }

    // Relation avec les publications
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    // Nombre de membres
    public function getMembersCountAttribute()
    {
        return $this->members()->count();
    }

    // Nombre de publications
    public function getPublicationsCountAttribute()
    {
        return $this->publications()->count();
    }
}