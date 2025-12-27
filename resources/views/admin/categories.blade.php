@extends('layouts.app')

@section('title', 'Gestion des Catégories')
@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>📂 Gestion des Catégories</h1>
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
                <h5>Créer une nouvelle catégorie</h5>
                <form method="POST" action="{{ route('admin.categories.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Description">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info w-100">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($categories) && $categories->count() > 0)
    <div class="row">
        @foreach($categories as $categorie)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5>{{ $categorie->nom }}</h5>
                            <div class="btn-group">
                                <!-- Bouton Modifier -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                        data-bs-target="#editCategoryModal{{ $categorie->id }}">modifier 
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <!-- Bouton Supprimer -->
                                <form action="{{ route('admin.categories.destroy', $categorie->id) }}" 
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">supprimer
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <p class="mb-2">{{ $categorie->description ?? 'Pas de description' }}</p>
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $categorie->publications_count }} publications</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal pour modifier la catégorie -->
            <div class="modal fade" id="editCategoryModal{{ $categorie->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier {{ $categorie->nom }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.categories.update', $categorie->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" class="form-control" value="{{ $categorie->nom }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $categorie->description }}</textarea>
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
            {{ $categories->links() }}
        </div>
    </div>
@else
    <div class="alert alert-info">
        <p class="mb-0">Aucune catégorie trouvée.</p>
    </div>
@endif
@endsection