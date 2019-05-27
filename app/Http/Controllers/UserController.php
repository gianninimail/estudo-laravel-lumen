<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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

    public function login(Request $request)
    {
        $dados = $request->only('email', 'password');

        $usuario = User::where('email', $dados['email'])
        ->where('password', $dados['password'])
        ->first();

        $usuario->api_token = Str::random(60);
        $usuario->update();

        return ['api_token' => $usuario->api_token];
    }

    //GUARDA OBJETO DO BANCO DE DADOS
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|max:255'
        ]);

        $usuario = new User($request->all());

        $usuario->api_token = Str::random(60);

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