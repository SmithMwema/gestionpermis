<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect('login');
        }

        // 2. Récupérer le rôle de l'utilisateur (on nettoie les espaces et on met en minuscule)
        $userRole = trim(strtolower(auth()->user()->role));

        // 3. Vérifier si le rôle est dans la liste autorisée
        // On nettoie aussi chaque rôle envoyé par la route
        $allowedRoles = array_map('trim', array_map('strtolower', $roles));

        if (!in_array($userRole, $allowedRoles)) {
            // Debug pour toi : si ça bloque encore, tu verras quel rôle pose problème
            abort(403, "Accès refusé. Votre rôle est [".$userRole."], mais cette page demande : ".implode(', ', $allowedRoles));
        }

        return $next($request);
    }
}