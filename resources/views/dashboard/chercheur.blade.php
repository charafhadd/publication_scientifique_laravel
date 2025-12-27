@extends('layouts.app')

@section('title', 'Tableau de bord Chercheur')
@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>👨‍🔬 Tableau de bord Chercheur</h1>
        <p class="lead">Bienvenue, {{ auth()->user()->name }}</p>
    </div>
</div>

<div class="row mb-4">
    @if($equipe)
        <div class="col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Mon Équipe</h5>
                    <h4>{{ $equipe->name }}</h4>
                    <p class="mb-0"><strong>Domaine:</strong> {{ $equipe->domaine }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white stat-card">
            <div class="card-body text-center">
                <h5 class="card-title">Mes Publications</h5>
                <h1 class="display-4">{{ auth()->user()->publications->count() }}</h1>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white stat-card">
            <div class="card-body text-center">
                <h5 class="card-title">Ma Spécialité</h5>
                <h4>{{ auth()->user()->specialite ?? 'Non définie' }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Mes Publications Récentes</h5>
            </div>
            <div class="card-body">
                @if(isset($publications) && $publications->count() > 0)
                    <div class="list-group">
                        @foreach($publications as $pub)
                            <div class="list-group-item">
                                <h6>{{ $pub->titre }}</h6>
                                <p class="mb-1 small">{{ Str::limit($pub->resume, 100) }}</p>
                                <div class="mt-2">
                                    <span class="badge bg-primary">{{ $pub->type }}</span>
                                    <span class="badge bg-secondary">{{ $pub->categorie->nom ?? 'Non catégorisé' }}</span>
                                    <span class="badge bg-info">{{ $pub->annee }}</span>
                                    <div class="float-end">
                                        <a href="{{ route('publications.show', $pub->id) }}" 
                                           class="btn btn-sm btn-outline-primary">Voir</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="mb-0">Vous n'avez pas encore de publications.</p>
                    </div>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('publications.create') }}" class="btn btn-success">
                        ✍️ Nouvelle Publication
                    </a>
                    <a href="{{ route('publications.mes') }}" class="btn btn-primary">
                        📋 Toutes mes publications
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection