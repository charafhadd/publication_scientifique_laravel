@extends('layouts.app')

@section('title', 'Détails Équipe')
@section('content')
@if(isset($equipe))
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>{{ $equipe->name }}</h1>
            <p class="lead">{{ $equipe->description }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <p><strong>Domaine:</strong> {{ $equipe->domaine }}</p>
                    <p><strong>Chef d'équipe:</strong> {{ $equipe->teamLeader->name ?? 'Non défini' }}</p>
                    <p><strong>Créée le:</strong> {{ $equipe->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <p><strong>Membres:</strong> {{ $stats['membres'] ?? 0 }}</p>
                    <p><strong>Publications:</strong> {{ $stats['publications'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('publications.index') }}?equipe={{ $equipe->id }}" 
                       class="btn btn-primary mb-2 w-100">
                        📚 Voir publications
                    </a>
                    <a href="{{ route('equipes.index') }}" class="btn btn-secondary w-100">
                        ← Retour aux équipes
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(isset($publications) && $publications->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <h3>Publications Récentes</h3>
                <div class="list-group">
                    @foreach($publications as $publication)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $publication->titre }}</h6>
                                <small>{{ $publication->annee }}</small>
                            </div>
                            <p class="mb-1 small">Par: {{ $publication->auteur->name ?? 'Auteur inconnu' }}</p>
                            <div class="mt-2">
                                <span class="badge bg-primary">{{ $publication->type }}</span>
                                <a href="{{ route('publications.show', $publication->id) }}" 
                                   class="btn btn-sm btn-outline-primary float-end">
                                    Voir
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    {{ $publications->links() }}
                </div>
            </div>
        </div>
    @endif
@else
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Équipe non trouvée</h4>
                <p>L'équipe que vous recherchez n'existe pas.</p>
                <a href="{{ route('equipes.index') }}" class="btn btn-primary">
                    Retour aux équipes
                </a>
            </div>
        </div>
    </div>
@endif
@endsection