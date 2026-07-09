<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function users()
    {
        if (strtolower(Auth::user()->role) !== 'admin') {
            abort(403);
        }

        $users = User::orderBy('name', 'asc')->get();
        return view('dashboards.admin', compact('users'));
    }

    /**
     * CRÉATION : Enregistre un nouvel agent
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'territoire' => $request->territoire,
        ]);

        return back()->with('status', 'Utilisateur créé avec succès.');
    }

    /**
     * MISE À JOUR : C'est la méthode "updateRole" attendue par ta route
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string',
            'territoire' => 'nullable|string',
        ]);

        $user->update([
            'role' => $request->role,
            'territoire' => $request->territoire,
        ]);

        return back()->with('status', 'Rôle et Territoire mis à jour pour ' . $user->name);
    }

    /**
     * SUPPRESSION
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Impossible de supprimer votre propre compte.']);
        }

        $user->delete();
        return back()->with('status', 'Compte supprimé.');
    }
}