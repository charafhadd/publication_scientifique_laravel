@extends('layouts.app')

@section('title', 'Inscription')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Créer un compte chercheur</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom complet *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe *</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialite" class="form-label">Spécialité</label>
                                <input type="text" class="form-control @error('specialite') is-invalid @enderror" 
                                       id="specialite" name="specialite" value="{{ old('specialite') }}" 
                                       placeholder="Ex: Intelligence Artificielle">
                                @error('specialite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="research_team_id" class="form-label">Équipe de recherche (optionnel)</label>
                                <select class="form-control @error('research_team_id') is-invalid @enderror" 
                                        id="research_team_id" name="research_team_id">
                                    <option value="">Sélectionnez une équipe</option>
                                    @foreach($equipes as $equipe)
                                        <option value="{{ $equipe->id }}" 
                                            {{ old('research_team_id') == $equipe->id ? 'selected' : '' }}>
                                            {{ $equipe->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('research_team_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" required id="terms">
                            <label class="form-check-label" for="terms">
                                J'accepte les conditions d'utilisation et la politique de confidentialité
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">S'inscrire</button>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Déjà un compte ? Se connecter
                        </a>
                    </div>
                </form>
                
                <hr class="my-4">
                
                <div class="alert alert-info">
                    <h5>📝 Information</h5>
                    <p class="mb-2">
                        En vous inscrivant, vous devenez un <strong>chercheur</strong> sur la plateforme.
                    </p>
                    <p class="mb-0">
                        Vous pourrez : publier vos travaux, consulter les publications des autres chercheurs, 
                        et rejoindre une équipe de recherche.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection