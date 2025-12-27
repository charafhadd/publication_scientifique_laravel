@extends('layouts.app')

@section('title', 'Administration')
@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>👑 Administration</h1>
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

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5>👥 Gérer les utilisateurs</h5>
                <a href="{{ route('admin.utilisateurs') }}" class="btn btn-primary w-100">
                    Accéder
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5>👥 Gérer les équipes</h5>
                <a href="{{ route('admin.equipes') }}" class="btn btn-success w-100">
                    Accéder
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5>📂 Gérer les catégories</h5>
                <a href="{{ route('admin.categories') }}" class="btn btn-info w-100">
                    Accéder
                </a>
            </div>
        </div>
    </div>
</div>
@endsection