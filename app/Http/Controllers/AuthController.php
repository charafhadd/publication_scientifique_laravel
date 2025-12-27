<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Afficher formulaire login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Afficher formulaire inscription
    public function showRegister()
    {
        $equipes = \App\Models\ResearchTeam::all();
        return view('auth.register', compact('equipes'));
    }

    // Connecter l'utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    // Inscrire un nouvel utilisateur
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'specialite' => 'nullable|string|max:255',
            'research_team_id' => 'nullable|exists:research_teams,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'chercheur', // Par défaut, un nouvel utilisateur est chercheur
            'specialite' => $request->specialite,
            'research_team_id' => $request->research_team_id,
        ]);

        // Connecter automatiquement l'utilisateur
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Inscription réussie ! Bienvenue sur la plateforme.');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}