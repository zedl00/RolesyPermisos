<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit)?$request->limit:10;
        $buscar = isset($request->q)?$request->q:null;
        if ($buscar) {
            $usuarios = User::orderBy("id", "desc")
                                ->where("email", "like", "%$buscar%")
                                ->paginate($limit);
        }else {
            $usuarios = User::orderBy("id", "desc")
                                ->paginate($limit);
        }

        return response()->json($usuarios, 200);
    }
 
    public function store(Request $request)
    {
        // Guardar Usuario 

        // Validar
        $request->validate([
            "name" => 'required',
            "email" => 'required|email|unique:users',
            "password" => 'required'
        ]);

        // Guardar registro 
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        // Responder
        return response()->json(["mensaje" => "Usuario Registrado", "data" => $usuario]);
    }

    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario, 200);
    }

    public function update(Request $request, string $id)
    {
        // Validar
        $request->validate([
            "name" => 'required',
            "email" => "required|email|unique:users,email,$id",
            "password" => 'required'
        ]);

        $usuario = User::findOrFail($id);
        $usuario->name = $request->name;      
        $usuario->email = $request->email;     

        if(isset($request->password)){
            $usuario->password = bcrypt($request->password);      
        };
        $usuario->update();

        return response()->json(["mensaje" => "Usuario Actualizado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json(["mensaje" => "Usuario Eliminado"])
    }
}
