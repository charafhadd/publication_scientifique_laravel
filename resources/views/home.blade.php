@extends('layouts.app')

@section('title', 'Accueil')
@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <div class="jumbotron bg-primary text-white p-5 rounded">
            <h1 class="display-4">📚 Plateforme de Publications Scientifiques</h1>
            <p class="lead">Gérez, partagez et découvrez les travaux de recherche</p>
            
            @auth
                <a class="btn btn-light btn-lg" href="{{ route('dashboard') }}" role="button">
                    Accéder à mon tableau de bord
                </a>
            @else
                <div class="mt-4">
                    <a class="btn btn-light btn-lg" href="{{ route('register') }}" role="button">
                        S'inscrire gratuitement
                    </a>
                    <a class="btn btn-outline-light btn-lg ms-2" href="{{ route('login') }}" role="button">
                        Se connecter
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3>📝 Publier</h3>
                <p>Partagez vos travaux de recherche avec la communauté scientifique</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3>🔍 Découvrir</h3>
                <p>Explorez des milliers de publications dans tous les domaines</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3>👥 Collaborer</h3>
                <p>Travaillez en équipe et collaborez avec d'autres chercheurs</p>
            </div>
        </div>
    </div>
</div>

@auth
    {{-- Si connecté, montre le dashboard --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3>Bienvenue {{ auth()->user()->name }} !</h3>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        Accéder à mon tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Si pas connecté, montre l'appel à l'action --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h2>Rejoignez notre communauté de chercheurs</h2>
                    <p class="lead mb-4">Inscrivez-vous gratuitement et commencez à publier vos travaux</p>
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                        Créer mon compte chercheur
                    </a>
                </div>
            </div>
        </div>
    </div>
@endauth
@endsection