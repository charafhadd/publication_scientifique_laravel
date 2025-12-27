@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')
@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>👥 Gestion des Utilisateurs</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Créer un nouvel utilisateur</h5>
                <form method="POST" action="{{ route('admin.utilisateurs.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Nom" required>
                    </div>
                    <div class="col-md-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-2">
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    </div>
                    <div class="col-md-2">
                        <select name="role" class="form-control" required>
                            <option value="chercheur">Chercheur</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($users) && $users->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Spécialité</th>
                    <th>Équipe</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->isAdmin())
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-success">Chercheur</span>
                            @endif
                        </td>
                        <td>{{ $user->specialite ?? '-' }}</td>
                        <td>{{ $user->researchTeam->name ?? '-' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#editUserModal{{ $user->id }}"> modifier
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <!-- Bouton Supprimer -->
                            <form action="{{ route('admin.utilisateurs.destroy', $user->id) }}" 
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                    <i class="fas fa-trash"></i>
                                    supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    
                    <!-- Modal pour modifier l'utilisateur -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier l'utilisateur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.utilisateurs.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nom</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rôle</label>
                                            <select name="role" class="form-control" required>
                                                <option value="chercheur" {{ $user->role == 'chercheur' ? 'selected' : '' }}>Chercheur</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Spécialité</label>
                                            <input type="text" name="specialite" class="form-control" value="{{ $user->specialite }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nouveau mot de passe (optionnel)</label>
                                            <input type="password" name="password" class="form-control" placeholder="Laisser vide pour ne pas changer">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            {{ $users->links() }}
        </div>
    </div>
@else
    <div class="alert alert-info">
        <p class="mb-0">Aucun utilisateur trouvé.</p>
    </div>
@endif
@endsection

@push('styles')
<style>
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .badge {
        font-size: 0.8em;
    }
</style>
@endpush