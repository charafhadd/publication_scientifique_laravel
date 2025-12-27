@extends('layouts.app')

@section('title', 'Mes Publications')
@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>📋 Mes Publications</h1>
        <p class="lead">Gérez vos travaux de recherche</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('publications.create') }}" class="btn btn-success">
            ✍️ Nouvelle Publication
        </a>
    </div>
</div>

@if(isset($publications) && $publications->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Titre</th>
                    <th>Année</th>
                    <th>Type</th>
                    <th>Journal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publications as $publication)
                    <tr>
                        <td>
                            <a href="{{ route('publications.show', $publication->id) }}" 
                               class="text-decoration-none">
                                {{ Str::limit($publication->titre, 50) }}
                            </a>
                        </td>
                        <td>{{ $publication->annee }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $publication->type }}</span>
                        </td>
                        <td>{{ Str::limit($publication->journal, 30) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('publications.show', $publication->id) }}" 
                                   class="btn btn-outline-primary">
                                    Voir
                                </a>
                                <form action="{{ route('publications.destroy', $publication->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('Supprimer cette publication?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            {{ $publications->links() }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h2 class="text-muted mb-4">📭 Aucune publication</h2>
                    <p class="lead mb-4">Vous n'avez pas encore publié de travaux de recherche.</p>
                    <a href="{{ route('publications.create') }}" class="btn btn-success btn-lg">
                        ✍️ Publier mon premier travail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection