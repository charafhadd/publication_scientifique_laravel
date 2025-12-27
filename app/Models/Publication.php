<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'titre',
        'resume',
        'annee',
        'type',
        'user_id',
        'research_team_id',
        'category_id',
        'journal',
        'fichier_pdf',
    ];

    // Relation avec l'auteur
    public function auteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec l'équipe
    public function equipe()
    {
        return $this->belongsTo(ResearchTeam::class, 'research_team_id');
    }

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }

    // Formatage de l'année
    public function getAnneeFormateeAttribute()
    {
        return $this->annee;
    }

    // Vérifier si un PDF existe
    public function hasPdf()
    {
        return !empty($this->fichier_pdf);
    }
}