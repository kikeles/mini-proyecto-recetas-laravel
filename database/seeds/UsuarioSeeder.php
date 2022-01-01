<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Pedro',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://pedro.com',
        ]);
        // $user->perfil()->create();
        
        User::create([
            'name' => 'Armando',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://armando.com',
        ]);
        // $user2->perfil()->create();
    }
}
