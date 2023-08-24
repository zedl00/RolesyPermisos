<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPassportController extends Controller
{

    public function funIngresar(Request $request) {

        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Validar correo y password
        if(!Auth::attempt($credenciales)){
            return response()->json(["mensaje" => "No Autenticado"], 401);
        }

        // Generar Token
        $user = Auth::user();
        $tokenResult = $user->createToken("Token Personal Passport");
        $token = $tokenResult->accessToken;

        // Respuesta
        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "usuario" => $user
        ]);
    }

    public function funRegistro(Request $request) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Respuesta

        return response()->json(["mensaje" => "El Usuario ha sido registrado"], 201);

    }

    public function funPerfil() 
    {
        $usuario = Auth::user();
        return response()->json($usuario, 200);
    }

}
