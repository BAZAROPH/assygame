<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class FinalisationInscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()) {
            if(!empty(auth()->user()->prenom) or Route::current()->getName() == 'profil.finish' or Route::current()->getName() == 'profil.register') {
                return $next($request);
            }
        }
        flash("Bienvenue dans votre espace membre ! <br> Finalisez votre inscription")->info();
        return redirect('/profil/finish');
    }
}
