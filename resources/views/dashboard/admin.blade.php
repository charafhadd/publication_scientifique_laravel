@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Tableau de bord Admin</h1>
        <p class="lead">Gestion de la plateforme</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h5>Utilisateurs</h5>
                <h2>{{ $stats['total_users'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h5>Publications</h5>
                <h2>{{ $stats['publications'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h5>Équipes</h5>
                <h2>{{ $stats['equipes'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h5>Catégories</h5>
                <h2>{{ $stats['categories'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Derniers utilisateurs</h5>
            </div>
            <div class="card-body">
                @if(isset($recentUsers) && $recentUsers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-success">Chercheur</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Aucun utilisateur récent.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Dernières publications</h5>
            </div>
            <div class="card-body">
                @if(isset($recentPublications) && $recentPublications->count() > 0)
                    <div class="list-group">
                        @foreach($recentPublications as $publication)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $publication->titre }}</h6>
                                    <small>{{ $publication->annee }}</small>
                                </div>
                                <p class="mb-1 small">Par: {{ $publication->auteur->name ?? 'Auteur inconnu' }}</p>
                                <div class="mt-2">
                                    <span class="badge bg-primary">{{ $publication->type }}</span>
                                    <span class="badge bg-secondary">{{ $publication->categorie->nom ?? 'Non catégorisé' }}</span>
                                    <a href="{{ route('publications.show', $publication->id) }}" 
                                       class="btn btn-sm btn-outline-primary float-end">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        Aucune publication récente.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.utilisateurs') }}" class="btn btn-primary w-100">
                            Gérer utilisateurs
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.equipes') }}" class="btn btn-success w-100">
                            Gérer équipes
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.categories') }}" class="btn btn-info w-100">
                            Gérer catégories
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('publications.index') }}" class="btn btn-warning w-100">
                            Voir publications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection