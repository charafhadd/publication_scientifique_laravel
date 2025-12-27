@extends('layouts.app')

@section('title', 'Connexion')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">🔐 Connexion</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required 
                               placeholder="exemple@lab.com">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p>Nouveau chercheur ?</p>
                    <a href="{{ route('register') }}" class="btn btn-success">
                        Créer un compte
                    </a>
                </div>
                
                <hr>
                
                <div class="alert alert-light border">
                    <h5>📋 Comptes de test</h5>
                    <div class="mb-2">
                        <strong>Administrateur :</strong><br>
                        Email: admin@lab.com<br>
                        Mot de passe: admin123
                    </div>
                    <div>
                        <strong>Chercheur :</strong><br>
                        Email: chercheur1@lab.com<br>
                        Mot de passe: password
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection