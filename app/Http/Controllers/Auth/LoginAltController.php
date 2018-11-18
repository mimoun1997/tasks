<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginAltController extends Controller
{
        // Exercici fer validació valtros
   public function login(LoginRequest $request)
   {
   	    $user = User::where('email',$request->email)->first();

        if (!$user) return redirect('/');
        if (!Hash::check($request->password, $user->password)) return redirect('/');
        // Logar
        Auth::login($user);
        return redirect('/home');
   }

    public function login(Request $request)
    {
        // TODO -> VALIDATE
//        $request->email
//        $request->password

            // Buscar el usuari a la base de dades i comprovar password ok

        $user = User::where('email',$request->email)->first();

        if (!$user) return redirect('/');
        if (!Hash::check($request->password, $user->password)) return redirect('/');
        // Logar
        Auth::login($user);
        return redirect('/home');
    }
}
