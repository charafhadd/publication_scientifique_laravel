@extends('layouts.app')

@section('title', 'Nouvelle Publication')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Ajouter une Nouvelle Publication</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('publications.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="titre" class="form-control" required 
                               placeholder="Titre de votre publication">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Résumé *</label>
                        <textarea name="resume" class="form-control" rows="4" required 
                                  placeholder="Résumé de votre travail"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Année *</label>
                                <input type="number" name="annee" class="form-control" 
                                       min="1900" max="{{ date('Y') }}" value="{{ date('Y') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type *</label>
                                <select name="type" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    <option value="article">Article</option>
                                    <option value="conference">Conférence</option>
                                    <option value="chapitre">Chapitre de livre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Journal/Conférence *</label>
                        <input type="text" name="journal" class="form-control" required 
                               placeholder="Nom du journal ou de la conférence">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Fichier PDF (URL optionnelle)</label>
                        <input type="url" name="fichier_pdf" class="form-control" 
                               placeholder="https://example.com/publication.pdf">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Publier</button>
                        <a href="{{ route('publications.mes') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection