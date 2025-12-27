@extends('layouts.app')

@section('title', 'Détails Publication')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h1>{{ $publication->titre ?? 'Titre non disponible' }}</h1>
                
                <div class="mb-3">
                    <span class="badge bg-primary">{{ $publication->type ?? 'Type inconnu' }}</span>
                    <span class="badge bg-secondary">{{ $publication->categorie->nom ?? 'Non catégorisé' }}</span>
                    <span class="badge bg-info">{{ $publication->annee ?? 'Année inconnue' }}</span>
                </div>
                
                <div class="mb-4">
                    <p><strong>Auteur:</strong> {{ $publication->auteur->name ?? 'Auteur inconnu' }}</p>
                    <p><strong>Équipe:</strong> {{ $publication->equipe->name ?? 'Équipe inconnue' }}</p>
                    <p><strong>Journal/Conférence:</strong> {{ $publication->journal ?? 'Non spécifié' }}</p>
                </div>
                
                <div class="mb-4">
                    <h4>Résumé</h4>
                    <p>{{ $publication->resume ?? 'Aucun résumé disponible' }}</p>
                </div>
                
                @if($publication->fichier_pdf)
                    <div class="mb-3">
                        <a href="{{ $publication->fichier_pdf }}" target="_blank" class="btn btn-primary">
                            📄 Voir le PDF
                        </a>
                    </div>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('publications.index') }}" class="btn btn-secondary">
                        ← Retour aux publications
                    </a>
                    
                    @auth
                        @if(auth()->user()->id == ($publication->user_id ?? null) || auth()->user()->isAdmin())
                            <form action="{{ route('publications.destroy', $publication->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Supprimer cette publication?')">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection