<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nom',
        'description',
    ];

    // Relation avec les publications
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    // Nombre de publications dans cette catégorie
    public function getPublicationsCountAttribute()
    {
        return $this->publications()->count();
    }
}