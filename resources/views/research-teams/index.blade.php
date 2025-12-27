@extends('layouts.app')

@section('title', 'Équipes de Recherche')
@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>👥 Équipes de Recherche</h1>
        <p class="lead">Découvrez les équipes de recherche de notre plateforme</p>
    </div>
</div>

@if(isset($equipes) && $equipes->count() > 0)
    <div class="row">
        @foreach($equipes as $equipe)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $equipe->name }}</h5>
                        <p class="card-text">{{ Str::limit($equipe->description, 150) }}</p>
                        
                        <div class="mb-3">
                            <p class="mb-1"><strong>Domaine:</strong> {{ $equipe->domaine }}</p>
                            <p class="mb-1"><strong>Chef d'équipe:</strong> {{ $equipe->teamLeader->name ?? 'Non défini' }}</p>
                            <p class="mb-1">
                                <strong>Membres:</strong> 
                                <span class="badge bg-primary">{{ $equipe->members_count ?? 0 }}</span>
                            </p>
                            <p class="mb-1">
                                <strong>Publications:</strong> 
                                <span class="badge bg-success">{{ $equipe->publications_count ?? 0 }}</span>
                            </p>
                        </div>
                        
                        <a href="{{ route('equipes.show', $equipe->id) }}" class="btn btn-outline-primary">
                            Voir l'équipe
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            {{ $equipes->links() }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4 class="alert-heading">Aucune équipe trouvée</h4>
                <p>Aucune équipe de recherche n'est disponible pour le moment.</p>
            </div>
        </div>
    </div>
@endif
@endsection