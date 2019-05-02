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
            'name' => 'Teste 01',
            'email' => 'teste321321@gmail.com',
            'password' => '123'
        ];

        $this->post('/api/user', $dados);

        echo $this->response->content();

        $this->assertResponseOk();

        $resposta =  (array) json_decode($this->response->content());

        //echo $resposta.$this->toString();

        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        //$this->assertArrayHasKey('password', $resposta);
        $this->assertArrayHasKey('id', $resposta);
    }
}