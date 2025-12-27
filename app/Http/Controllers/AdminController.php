<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ResearchTeam;
use App\Models\Category;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Vérifier si l'utilisateur est admin
    private function checkAdmin()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Accès réservé aux administrateurs');
        }
        
        return null;
    }

    // Dashboard admin
    public function index()
    {
        if ($error = $this->checkAdmin()) return $error;

        $stats = [
            'total_users' => User::count(),
            'chercheurs' => User::where('role', 'chercheur')->count(),
            'equipes' => ResearchTeam::count(),
            'publications' => Publication::count(),
            'categories' => Category::count(),
        ];

        return view('admin.index', compact('stats'));
    }

    // GESTION UTILISATEURS
    public function utilisateurs()
    {
        if ($error = $this->checkAdmin()) return $error;

        $users = User::with('researchTeam')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $equipes = ResearchTeam::all();

        return view('admin.utilisateurs', compact('users', 'equipes'));
    }

    public function creerUtilisateur(Request $request)
    {
        if ($error = $this->checkAdmin()) return $error;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,chercheur',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.utilisateurs')->with('success', 'Utilisateur créé avec succès');
    }

    // GESTION ÉQUIPES
    public function equipes()
    {
        if ($error = $this->checkAdmin()) return $error;

        $equipes = ResearchTeam::withCount(['members', 'publications'])
            ->with('teamLeader')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $chefs = User::where('role', 'chercheur')->get();

        return view('admin.equipes', compact('equipes', 'chefs'));
    }

    public function creerEquipe(Request $request)
    {
        if ($error = $this->checkAdmin()) return $error;

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'domaine' => 'required|string|max:255',
        ]);

        ResearchTeam::create([
            'name' => $request->name,
            'description' => $request->description,
            'domaine' => $request->domaine,
        ]);

        return redirect()->route('admin.equipes')->with('success', 'Équipe créée avec succès');
    }

    // GESTION CATÉGORIES
    public function categories()
    {
        if ($error = $this->checkAdmin()) return $error;

        $categories = Category::withCount('publications')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.categories', compact('categories'));
    }

    public function creerCategorie(Request $request)
    {
        if ($error = $this->checkAdmin()) return $error;

        $request->validate([
            'nom' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Catégorie créée avec succès');
    }

    // NOUVELLES MÉTHODES CRUD POUR MODIFIER/SUPPRIMER
    public function modifierUtilisateur(Request $request, $id)
    {
        if ($error = $this->checkAdmin()) return $error;

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'required|in:admin,chercheur',
            'specialite' => 'nullable|string|max:255',
            'research_team_id' => 'nullable|exists:research_teams,id',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'specialite' => $request->specialite,
            'research_team_id' => $request->research_team_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.utilisateurs')->with('success', 'Utilisateur modifié avec succès');
    }

    public function supprimerUtilisateur($id)
    {
        if ($error = $this->checkAdmin()) return $error;

        $user = User::findOrFail($id);
        
        // Empêcher de supprimer son propre compte
        if ($user->id == Auth::id()) {
            return redirect()->route('admin.utilisateurs')->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }
        
        $user->delete();

        return redirect()->route('admin.utilisateurs')->with('success', 'Utilisateur supprimé avec succès');
    }

    public function modifierEquipe(Request $request, $id)
    {
        if ($error = $this->checkAdmin()) return $error;

        $equipe = ResearchTeam::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'domaine' => 'required|string|max:255',
            'team_leader_id' => 'nullable|exists:users,id',
        ]);

        $equipe->update([
            'name' => $request->name,
            'description' => $request->description,
            'domaine' => $request->domaine,
            'team_leader_id' => $request->team_leader_id,
        ]);

        return redirect()->route('admin.equipes')->with('success', 'Équipe modifiée avec succès');
    }

    public function supprimerEquipe($id)
    {
        if ($error = $this->checkAdmin()) return $error;

        $equipe = ResearchTeam::findOrFail($id);
        $equipe->delete();

        return redirect()->route('admin.equipes')->with('success', 'Équipe supprimée avec succès');
    }

    public function modifierCategorie(Request $request, $id)
    {
        if ($error = $this->checkAdmin()) return $error;

        $categorie = Category::findOrFail($id);

        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($categorie->id),
            ],
            'description' => 'nullable|string',
        ]);

        $categorie->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Catégorie modifiée avec succès');
    }

    public function supprimerCategorie($id)
    {
        if ($error = $this->checkAdmin()) return $error;

        $categorie = Category::findOrFail($id);
        $categorie->delete();

        return redirect()->route('admin.categories')->with('success', 'Catégorie supprimée avec succès');
    }
}