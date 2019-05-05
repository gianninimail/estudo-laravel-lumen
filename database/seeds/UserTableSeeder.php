<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Pete Houston',
            'email' => 'petehouston@gmail.com',
            'password' => '123secret'
        ]);

        User::create([
            'name' => 'Taylor Otwell',
            'email' => 'taylorotwell@gmail.com',
            'password' => 'greatsecret'
        ]);
    }
}