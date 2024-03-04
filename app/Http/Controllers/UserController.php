<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Pays;
use App\Models\Transitaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Rules\MatchOldPassword;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')
        ->with([
            'commandes',
            'produits',
            'message_emis',
            'message_recus',
            'produit_likes',
        ])
        ->where([
            'type' => request('type')
        ])
        ->get();

        $trashed = User::onlyTrashed()
        ->get();
        //dd($categories->toArray());

        return view('user.index')->with([
            'trashed' => $trashed,
            'valeurs' => $users,
            'infosPage' => array(
                'title' => 'Utilisateurs : '.request('type'),
                'icon' => 'icofont-users-social',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)
        ->with([
            'commandes',
            'message_emis',
            'message_recus',
            'produit_likes',
            'produits' => function($q){
                $q->with([
                    'categorie',
                    'tarifs',
                ]);
            },
        ])
        ->firstOrFail();
        //dd($user->toArray());

        return view('user.show')->with([
            'valeur' => $user,
            'infosPage' => array(
                'title' => 'Utilisateur : '.$user->nom.' '.$user->prenom,
                'icon' => 'icofont-users-social',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function transitaire($user)
    {
        //dd($user);
        $user = User::where([
            'email' => $user
        ])->firstOrFail();
        //dd($user->toArray());
        $commande = Commande::where([
            'client_id' => $user->id,
        ])
        ->orderBy('created_at', 'desc')
        ->first();
        //dd($commande->toArray());
        $transitaire = Transitaire::where('user_id', $user->id)->first();
        //dd($transitaire->toArray());
        return view('user.transitaire')->with([
            'user' => $user,
            'transitaire' => $transitaire,
            'commande' => $commande,
        ]);
    }


    public function transitaire_send(Request $request, $user)
    {
        $user = User::where([
            'email' => $user
        ])->first();

        $commande = Commande::where([
            'client_id' => $user->id,
        ])
        ->orderBy('created_at', 'desc')
        ->first();

        if (request('selection') == 'oui') {
            $this->validate($request,[
                'nom' => 'required|max:255',
                'telephone' => 'required|max:255',
            ]);

            Transitaire::create([
                'nom' => request('nom'),
                'telephone' => request('telephone'),
                'user_id' => $user->id,
                'commande_id' => $commande->id,
            ]);
        }
        /* $url = "whatsapp://send?phone=+2250779851243&text=Par quel moyen de paiement souhaitez-vous recevoir l'argent de ma commande";
        header('Location: '.$url); */

        envoieSMS($user->contact);
        flash('Félicitation! Votre commande a été bien enregistrée. Un commercial vous contactera. Infoline : 225 0707823299')->success();
        return view('user.message')->with([
            'user' => $user,
        ]);
        //return back();
        //return Redirect::to($url);
        //return redirect("//whatsapp://send?phone=+2250779851243&text=Par quel moyen de paiement souhaitez-vous recevoir l'argent de ma commande");
    }

    public function transitaire_update(Request $request, User $user)
    {
        $this->validate($request,[
            'nom' => 'required|max:255',
            'telephone' => 'required|max:255',
        ]);

        $transitaire = Transitaire::where('user_id', $user->id)->first();
        //dd($categorie->toArray());
        $transitaire->nom = request('nom');
        $transitaire->telephone = request('telephone');
        $transitaire->save();
        /* $url = "whatsapp://send?phone=+2250779851243&text=Par quel moyen de paiement souhaitez-vous recevoir l'argent de ma commande";
        header('Location: '.$url); */

        envoieSMS($user->contact);
        flash('Félicitation! Votre commande a été bien enregistrée. Un commercial vous contacteras. Infoline : 225 0707823299')->success();
        return view('user.message')->with([
            'user' => $user,
        ]);
        //return back();
    }

    /**
     * Home page customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function profil()
    {
        $user = User::with([
            'commandes',
            'produits',
            'produit_likes',
        ])
        ->find(auth()->user()->id);

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil');
        // End journalisation
        return view('web.user.profil')->with([
            'user' => $user,
            'infosPage' => array(
                'title' => 'Espace membre',
                'slug' => route('profil'),
            ),
        ]);
    }

    /**
     * Finish registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function finishAccount()
    {
        $pays = Pays::all();
        // Journalisation
        activity()
            ->log('finalisation inscription');
        // End journalisation
        return view('web.user.finish')->with([
            'pays' => $pays,
            'infosPage' => array(
                'title' => 'Finalisation inscription',
                'slug' => route('profil.finish'),
            ),
        ]);
    }

    /**
     * Finish registration store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finishRegister(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $this->validate($request,[
            'prenom' => 'required|max:255|string',
            'contact' => 'required|max:255|string',
            'pays_id' => 'integer|max:255|required',
            'ville' => 'required|max:255|string',
            'adresse' => 'required|max:255|string',
            //'boutique' => 'required|max:255|string',
        ]);

        $user->update([
            'prenom' => request('prenom'),
            'contact' => request('contact'),
            'pays_id' => request('pays_id'),
            'ville' => request('ville'),
            'adresse' => request('adresse'),
            'boutique' => request('boutique'),
        ]);
        flash('Inscription finalisée avec succès')->success();
        return redirect('/profil');
    }

    public function edit_member()
    {
        $user = User::find(auth()->user()->id);
        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil edit');
        // End journalisation
        return view('web.user.edit')->with([
            'user' => $user,
            'infosPage' => array(
                'title' => 'Profil utilisateur',
                'slug' => 'profil/edit',
            ),
        ]);
    }

    public function update_member(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'name' => 'required',
            'date_naissance' => 'date|nullable',
            'contact' => 'required',
        ]);

        if(request('email')){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
            if(request('email') != auth()->user()->email){
                $request->validate([
                    'email' => ['unique:users'],
                ]);
            }
        }
        $user = User::findOrFail(auth()->id());
        $user->nom = request('name');
        $user->prenom = request('prenom');
        $user->sexe = request('sexe');
        $user->date_naissance = request('date_naissance');
        $user->biographie = request('biographie');
        $user->boutique = request('boutique');
        $user->contact = request('contact');
        if (!empty(request('email'))) {
            $user->email = request('email');
        }
        $user->save();

        flash('Vos informations ont été mise à jour avec succès')->success();
        return back();
    }

    public function edit_password()
    {
        $user = User::find(auth()->user()->id);

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil edit password');
        // End journalisation
        return view('web.user.password')->with([
            'user' => $user,
            'infosPage' => array(
                'title' => 'Modification de mot de passe',
                'slug' => 'profil',
            ),
        ]);
    }

    public function update_password(Request $request)
    {
        if(auth()->user()->password){
            $request->validate([
                'current_password' => [new MatchOldPassword],
            ]);
        }

        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = User::findOrFail(auth()->id());
        $user->password = request('new_password');
        $user->save();
        //echo request('new_password').' ------ '.Hash::make(request('new_password'));
        /* if (Hash::check(request('new_password'), Hash::make(request('new_password')))) {
            $resultat = '<br><br>' .request('new_password') . ' ------ ' . Hash::make(request('new_password')).' -------- '. $user->password;
        } */
        flash('Mot de passe changé avec succès ')->success();
        return back();
    }

    public function edit_picture()
    {
        $user = User::find(auth()->user()->id);

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil edit picture');
        // End journalisation
        return view('web.user.picture')->with([
            'user' => $user,
            'infosPage' => array(
                'title' => 'Modifier image',
                'slug' => 'profil',
            ),
        ]);
    }

    public function update_picture(Request $request)
    {
        $request->validate([

        ]);
        $this->validate($request,[
            'photo' => 'required|image|max:11000',
        ]);
        $media = auth()->user()->getMedia('image')->first();
        if (!$media) {
            auth()->user()->addMediaFromRequest('photo')
            ->toMediaCollection('image');
        }
        else {
            //dd($media->toArray());
            $media->delete();
            auth()->user()->addMediaFromRequest('photo')
            ->toMediaCollection('image');
        }
        flash('Photo de profil mise à jour avec succès', 'Message')->success();
        return back();
    }

    public function commande()
    {
        $user = User::with([
            'commandes' => function($q){
                $q->with([
                    'produits' => function($q){
                        $q->with([
                            'tailles',
                            'couleurs',
                        ]);
                    },
                ]);
            },
            'produits',
            'produit_likes',
        ])
        ->find(auth()->user()->id);
        //dd(json_decode($user->commandes->first()->produits->first()->pivot->options)->couleur);
        return view('web.user.order')->with([
            'user' => $user,
            'infosPage' => array(
                'title' => 'Commandes',
                'slug' => route('profil'),
            ),
        ]);
    }
}
