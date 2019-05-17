<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreateUser()
    {
        $dados = [
            'name' => 'Teste 00',
            'email' => 'teste321321@gmail.com',
            'password' => '123'
        ];

        $this->post('/api/user', $dados);

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

    public function testAlterUser()
    {
        $user = \App\User::first();

        $dados = [
            'name' => 'Nome alterado de Teste',
            'email' => 't@gmail.com',
            'password' => '123654'
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
}