<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

//Modelos
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuario.index')->with('usuarios', $usuarios);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'nombre' => 'required|string',
        //     'usuario' => 'required|string',
        //     'password' => 'required|string',
        //     'is_admin' => 'required|string',
        // ]);
        $isAdmin = $request->is_admin == 'true'?true:false; 
        $usuario = new User;
        $usuario->nombre = $request->nombre;
        $usuario->usuario = $request->usuario;
        $usuario->password = Hash::make($request->password);
        $usuario->is_admin = $isAdmin;
        $usuario->save();
        
        return redirect()->route('usuario.index');
    }

    public function show($id)
    {
        $usuario = User::find($id);
        return response()->json($usuario);
    }

    public function update(Request $request, string $id)
    {
        $isAdmin = $request->is_admin == 'true'?true:false; 
        $usuario = User::where('id', $id)->first();
        $usuario->nombre = $request->nombre;
        $usuario->usuario = $request->usuario;
        $usuario->password = Hash::make($request->password);
        $usuario->is_admin = $isAdmin;
        $usuario->save();

        return redirect()->route('usuario.index');
    }

    public function delete(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect()->route('usuario.index');
    }
}
