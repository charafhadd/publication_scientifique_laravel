@extends('layouts.app')

@section('title', 'Gestion des Équipes')
@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>👥 Gestion des Équipes</h1>
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
                <h5>Créer une nouvelle équipe</h5>
                <form method="POST" action="{{ route('admin.equipes.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Nom de l'équipe" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="domaine" class="form-control" placeholder="Domaine" required>
                    </div>
                    <div class="col-md-3">
                        <textarea name="description" class="form-control" placeholder="Description" rows="1" required></textarea>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($equipes) && $equipes->count() > 0)
    <div class="row">
        @foreach($equipes as $equipe)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5>{{ $equipe->name }}</h5>
                            <div class="btn-group">
                                <!-- Bouton Modifier -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                        data-bs-target="#editTeamModal{{ $equipe->id }}">modifier 
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <!-- Bouton Supprimer -->
                                <form action="{{ route('admin.equipes.destroy', $equipe->id) }}" 
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?')">supprimer
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <p class="mb-2">{{ $equipe->description }}</p>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Domaine:</strong> {{ $equipe->domaine }}</p>
                            <p class="mb-1"><strong>Chef:</strong> {{ $equipe->teamLeader->name ?? 'Non défini' }}</p>
                            <p class="mb-1"><strong>Membres:</strong> {{ $equipe->members_count }}</p>
                            <p class="mb-1"><strong>Publications:</strong> {{ $equipe->publications_count }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal pour modifier l'équipe -->
            <div class="modal fade" id="editTeamModal{{ $equipe->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier {{ $equipe->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.equipes.update', $equipe->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="name" class="form-control" value="{{ $equipe->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $equipe->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Domaine</label>
                                    <input type="text" name="domaine" class="form-control" value="{{ $equipe->domaine }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Chef d'équipe</label>
                                    <select name="team_leader_id" class="form-control">
                                        <option value="">Aucun chef</option>
                                        @foreach($chefs as $chef)
                                            <option value="{{ $chef->id }}" {{ $equipe->team_leader_id == $chef->id ? 'selected' : '' }}>
                                                {{ $chef->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            {{ $equipes->links() }}
        </div>
    </div>
@else
    <div class="alert alert-info">
        <p class="mb-0">Aucune équipe trouvée.</p>
    </div>
@endif
@endsection