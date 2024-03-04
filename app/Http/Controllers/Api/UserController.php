<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        try{
            $user = $request->user();
            $user->tokens()->delete();

            $response = APIHelpers::createAPIResponse(false, 0, 'Deconnexion effectuée.', null);
                return response()->json($response, 200);
        }catch (Exception $error){

            $response = APIHelpers::createAPIResponse(true, 1, 'Impossible de vous deconnectez.', null);
                return response()->json($response, 200);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            
            if (!Auth::attempt($credentials)) {

                $response = APIHelpers::createAPIResponse(true, 1, 'Vous n\'est pas autorisé.', null);
                return response()->json($response, 200);
            }
            
            $user = User::where('email', $request->email)->first();
            
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }
            $token=[];
            $token['access_token'] = $user->createToken('authToken')->plainTextToken;
            $token['token_type'] = 'Bearer';

            $response = APIHelpers::createAPIResponse(false, 0, 'Voici votre token authentification.', $token);
            return response()->json($response, 200);
        } catch (Exception $error) {

            $response = APIHelpers::createAPIResponse(true, 1, 'Impossible de vous authentifier.', $error);
            return response()->json($response, 200);
        }
    }
  
    public function saveToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required',
        ]);

        $user = User::where('id', $request->user()->id)->first();
        if($user->device_token != $request->device_token)
        {
            $user->device_token = $request->device_token;
            $user->save();
        }

        $response = APIHelpers::createAPIResponse(false, 0, 'Votre token a été enregistré avec succès.', $user);
        return response()->json($response, 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required',
            'contact' => 'required',
        ]);
        
        if(Count(User::where("contact",$request->contact)->orWhere("email", $request->email)->get()) == 0){
            $user = new User();
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->type = $request->type;
            $user->password = Hash::make($request->password);
            $user_save = $user->save();
        }else{
            $user_save= false;
        }

            if ($user_save) {
                $response = APIHelpers::createAPIResponse(false, 0, 'Votre inscription a bien été effectuée.', null);
                return response()->json($response, 200);
            }else{
                $response = APIHelpers::createAPIResponse(true, 1, 'Votre inscription a echouée.', null);
                return response()->json($response, 200);
            }
    }

    public function show(Request $request)
    {
        $user = User::find($request->user()->id);

        $photo =  count($user->getMedia()) == 0 ? null : $user->getMedia()->last()->getFullUrl();

        $user->photo = $photo;

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici votre profil utilisateur.', $user);
        return response()->json($response, 200);
    }

    public function photo(Request $request)
    {
        $user = User::find($request->user()->id);
        
        $user->addMedia($request->photo)->toMediaCollection();
        
        $photo = $user->getMedia()->last()->getFullUrl();

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici votre profil utilisateur.', $photo);
        return response()->json($response, 200);
    }
   

    public function update(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required',
            'contact' => 'required',
        ]);

        $user = User::find($request->user()->id);

            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            $user->contact = $request->contact;

        if($request->password != null){
            $user->password = Hash::make($request->password);
            
        }

        $user_save = $user->save();

            if ($user_save) {
                $response = APIHelpers::createAPIResponse(false, 0, 'Votre profil a bien été modifié.', null);
                return response()->json($response, 200);
            }else{
                $response = APIHelpers::createAPIResponse(true, 1, 'Votre modification de profil a echouée.', null);
                return response()->json($response, 200);
            }
    }

    
    public function destroy($id)
    {
        //
    }
}
