@extends('layouts.app')

@section('title', 'Toutes les Publications')
@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>📚 Toutes les Publications</h1>
        <p class="lead">Explorez les travaux de recherche de notre communauté</p>
    </div>
    <div class="col-md-4 text-end">
        @auth
            <a href="{{ route('publications.create') }}" class="btn btn-success">
                ✍️ Nouvelle Publication
            </a>
        @endauth
    </div>
</div>

@if(isset($publications) && $publications->count() > 0)
    <div class="row">
        @foreach($publications as $publication)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('publications.show', $publication->id) }}" 
                               class="text-decoration-none text-dark">
                                {{ Str::limit($publication->titre, 80) }}
                            </a>
                        </h5>
                        
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $publication->auteur->name ?? 'Auteur inconnu' }} • {{ $publication->annee }}
                        </h6>
                        
                        <p class="card-text">
                            {{ Str::limit($publication->resume, 150) }}
                        </p>
                        
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $publication->type }}</span>
                            <span class="badge bg-secondary">{{ $publication->categorie->nom ?? 'Non catégorisé' }}</span>
                            <span class="badge bg-info">{{ $publication->equipe->name ?? 'Équipe inconnue' }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                {{ $publication->journal }}
                            </small>
                            <div>
                                <a href="{{ route('publications.show', $publication->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            {{ $publications->links() }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4 class="alert-heading">Aucune publication trouvée</h4>
                <p>Aucune publication n'est disponible pour le moment.</p>
                @auth
                    <hr>
                    <p class="mb-0">
                        <a href="{{ route('publications.create') }}" class="alert-link">
                            Créer votre première publication
                        </a>
                    </p>
                @endauth
            </div>
        </div>
    </div>
@endif
@endsection