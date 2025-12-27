<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\ResearchTeam;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $publications = Publication::with(['auteur', 'equipe', 'categorie'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $equipes = ResearchTeam::withCount('members')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $categories = Category::withCount('publications')
            ->orderBy('publications_count', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('publications', 'equipes', 'categories'));
    }

    public function dashboard()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }
        
        return $this->chercheurDashboard();
    }

    private function adminDashboard()
    {
        $stats = [
            'users' => \App\Models\User::count(),
            'chercheurs' => \App\Models\User::where('role', 'chercheur')->count(),
            'equipes' => ResearchTeam::count(),
            'publications' => Publication::count(),
            'categories' => Category::count(),
        ];

        $recentPublications = Publication::with('auteur')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentUsers = \App\Models\User::where('role', 'chercheur')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentPublications', 'recentUsers'));
    }

    private function chercheurDashboard()
    {
        $user = Auth::user();
        $publications = $user->publications()
            ->with('categorie')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $equipe = $user->researchTeam;

        $teamPublications = [];
        if ($equipe) {
            $teamPublications = $equipe->publications()
                ->with('auteur')
                ->where('user_id', '!=', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('dashboard.chercheur', compact('publications', 'equipe', 'teamPublications'));
    }
}