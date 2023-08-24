<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
   
    public function index()
    {
        $roles = Roles::get();

        return response()->json($roles);
    }


    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|unique:roles"
        ]);

        $role = new Role();
        $role->nombre = $request->nombre;
        $role->detalle = $request->detalle;
        $role->save();

        return response()->json(["mensaje" => "El Rol ha sido registrado"]);
        
    }

    public function show(string $id)
    {
        $rol = Role::findOrFail($id);

        return response()->json($rol, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required|unique:roles,nombre,$id"
        ]);

        $role = Role::findOrFail($id);
        $role->nombre = $request->nombre;
        $role->detalle = $request->detalle;
        $role->update();

        return response()->json(["mensaje" => "El Rol ha sido Actualizado", 201]);

    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return response()->json(["mensaje" => "El Rol ha sido Eliminado"]);
    }
}
