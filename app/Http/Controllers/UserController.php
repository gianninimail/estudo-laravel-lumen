<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'password' => 'required|confirmed|max:255'
        ]);

        $usuario = new User($request->all());
        $usuario->save();

        return $usuario;
    }

    //RECUPERA UM OBJETO DO BANCO DE DADOS
    public function view($id) {

        return User::find($id);
    }

    //ALTERA OBJETO DO BANCO DE DADOS
    public function update(Request $request, $id) {

        $dados = [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',

        ];

        if (isset($request->all()['password'])) {
            $dados['password'] = 'required|confirmed|max:255';
            echo "PASSOU NO IFFFFF.....................................................................";
        }

        $this->validate($request, $dados);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (isset($request->all()['password'])) {
            $user->password = $request->input('password');
        }

        $user->update();

        return $user;
    }

    //DELETA UM OBJETO DO BANCO DE DADOS
    public function delete($id) {

        User::destroy($id);

        if (true) {
            return new Response('Removido com sucesso!', 200);
        }
        else {
            return new Response('Erro ao remover!', 401);
        }

    }

    //RECUPERA TODOS OBJETOS DO BANCO DE DADOS
    public function list() {

        return User::all();
    }
}