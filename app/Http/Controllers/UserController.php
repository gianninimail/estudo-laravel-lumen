<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //GUARDA OBJETO DO BANCO DE DADOS
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|max:255'
        ]);

        $usuario = new User($request->all());
        $usuario->save();

        return $usuario;
    }

    //RECUPERA UM OBJETO DO BANCO DE DADOS
    public function view($id) {

        return User::find($id);
    }
}