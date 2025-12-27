<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Category;
use App\Models\ResearchTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::with(['auteur', 'equipe', 'categorie'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::all();
        $types = ['article', 'conference', 'chapitre'];

        return view('publications.index', compact('publications', 'categories', 'types'));
    }

    public function show($id)
    {
        $publication = Publication::with(['auteur', 'equipe', 'categorie'])->findOrFail($id);
        return view('publications.show', compact('publication'));
    }

    public function create()
    {
        // Vérifier si connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categories = Category::all();
        $equipes = ResearchTeam::all();
        $types = ['article', 'conference', 'chapitre'];

        return view('publications.create', compact('categories', 'equipes', 'types'));
    }

    public function store(Request $request)
    {
        // Vérifier si connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'titre' => 'required|max:255',
            'resume' => 'required',
            'annee' => 'required|digits:4|min:1900|max:' . date('Y'),
            'type' => 'required|in:article,conference,chapitre',
            'research_team_id' => 'required|exists:research_teams,id',
            'category_id' => 'required|exists:categories,id',
            'journal' => 'required|max:255',
            'fichier_pdf' => 'nullable|url',
        ]);

        Publication::create([
            'titre' => $request->titre,
            'resume' => $request->resume,
            'annee' => $request->annee,
            'type' => $request->type,
            'user_id' => Auth::id(),
            'research_team_id' => $request->research_team_id,
            'category_id' => $request->category_id,
            'journal' => $request->journal,
            'fichier_pdf' => $request->fichier_pdf,
        ]);

        return redirect()->route('publications.mes')
            ->with('success', 'Publication ajoutée avec succès!');
    }

    public function mesPublications()
    {
        // Vérifier si connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $publications = $user->publications()
            ->with('categorie')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('publications.mes', compact('publications'));
    }

    public function destroy($id)
    {
        // Vérifier si connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $publication = Publication::findOrFail($id);
        
        if ($publication->user_id != Auth::id() && !Auth::user()->isAdmin()) {
            return back()->with('error', 'Vous n\'avez pas la permission de supprimer cette publication');
        }
        
        $publication->delete();
        
        return back()->with('success', 'Publication supprimée avec succès!');
    }
}