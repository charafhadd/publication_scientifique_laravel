<?php

namespace App\Http\Controllers;

use App\Models\ResearchTeam;
use App\Models\Publication;
use Illuminate\Http\Request;

class ResearchTeamController extends Controller
{
    public function index()
    {
        $equipes = ResearchTeam::withCount(['members', 'publications'])
            ->with('teamLeader')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('research-teams.index', compact('equipes'));
    }

    public function show($id)
    {
        $equipe = ResearchTeam::with(['teamLeader', 'members', 'publications.auteur'])
            ->findOrFail($id);

        // Publications récentes de l'équipe
        $publications = $equipe->publications()
            ->with('auteur')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistiques
        $stats = [
            'membres' => $equipe->members->count(),
            'publications' => $equipe->publications->count(),
            'publications_annee' => $equipe->publications()
                ->selectRaw('annee, COUNT(*) as count')
                ->groupBy('annee')
                ->orderBy('annee', 'desc')
                ->get(),
        ];

        return view('research-teams.show', compact('equipe', 'publications', 'stats'));
    }
}