<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseTransactions;

    public $dados = [];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dados = [
            'name' => 'Teste00',
            'email' => 'teste321321@gmail.com',
            'password' => '123',
            'password_confirmation' => '123'
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testLoginUser()
    {
        $this->post('/api/user', $this->dados);

        echo "\n".$this->response->content();

        $this->assertResponseOk();

        $this->post('/api/login', $this->dados);

        echo "\n".$this->response->content();

        $this->assertResponseOk();

        $resposta =  (array) json_decode($this->response->content());

        $this->assertArrayHasKey('api_token', $resposta);

        echo "\nPASSOU POR AQUI......Teste de LOGIN........\n";
    }

    public function testCreateUser()
    {
        $this->post('/api/user', $this->dados);

        echo $this->response->content();

        $this->assertResponseOk();

        $resposta =  (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);
        //$this->assertArrayHasKey('password', $resposta);

        echo "\nPASSOU POR AQUI......Teste de Criação........\n";
    }

    public function testViewUser()
    {
        $user = \App\User::first();

        $this->get('/api/user/'.$user->id);

        $this->assertResponseOk();

        $resposta =  (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        print_r($resposta);

        echo "\nPASSOU POR AQUI......Teste de Visualização........\n";
    }

    public function testUpdateUser()
    {
        $user = \App\User::first();

        $dados = [
            'name' => 'Nome alterado de Teste',
            'email' => 't@gmail.com',
            'password' => '12345',
            'password_confirmation' => '12345'
        ];

        $this->put('/api/user/'.$user->id, $dados);

        echo $this->response->content();

        $this->assertResponseOk();

        $resposta =  (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        $this->notSeeInDatabase('users', [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id
        ]);

        echo "\nPASSOU POR AQUI......Teste de Alteração........\n";
    }

    public function testUpdateUserNoPassword()
    {
        $user = \App\User::first();

        $dados = [
            'name' => 'Nome alterado de Teste',
            'email' => 't@gmail.com'
        ];

        $this->put('/api/user/'.$user->id, $dados);

        echo $this->response->content();

        $this->assertResponseOk();

        $resposta =  (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        $this->notSeeInDatabase('users', [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id
        ]);

        echo "\nPASSOU POR AQUI......Teste de Alteração........\n";
    }

    public function testAllUsers()
    {
        $this->get('/api/users');
        $this->assertResponseOk();

        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'email'
            ]
        ]);

        print_r($this->response->content());

        echo "\nPASSOU POR AQUI......Teste de Lista de Usuarios........\n";
    }

    public function testDeleteUser()
    {
        $user = \App\User::first();

        $this->delete('/api/user/'.$user->id);

        $this->assertResponseOk();

        $this->assertEquals("Removido com sucesso!", $this->response->content());

        echo "\nPASSOU POR AQUI......Teste de Deleção........\n";
    }
}