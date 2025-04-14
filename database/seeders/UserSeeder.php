<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuários com dados fixos
        $names = [
            'João Silva', 'Maria Santos', 'Pedro Oliveira', 'Ana Costa', 'Lucas Pereira',
            'Julia Rodrigues', 'Carlos Souza', 'Mariana Ferreira', 'Rafael Alves', 'Beatriz Lima',
            'Gabriel Martins', 'Isabela Gomes', 'Daniel Ribeiro', 'Laura Carvalho', 'Matheus Santos',
            'Sophia Oliveira', 'Enzo Costa', 'Valentina Pereira', 'Leonardo Rodrigues', 'Helena Souza',
            'Miguel Ferreira', 'Alice Alves', 'Arthur Lima', 'Manuela Martins', 'Bernardo Gomes',
        ];

        foreach ($names as $name) {
            $username = Str::slug(explode(' ', $name)[0]) . Str::random(3);
            $email = Str::slug($name) . '@example.com';

            User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        // Criar usuários aleatórios usando a factory
        User::factory(25)->create();
    }
}
