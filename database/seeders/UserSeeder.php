<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // adicionar três usuários de exemplo (o primeiro vai ser sysadmin)
        /*
            sys-admin - gestor da aplicação
            client-admin - gestor da empresa
            client-user - usuário comum da empresa
        */
        $users = [
            [
                'email' => 'sysadmin@localhost.com',
                'password' => bcrypt('Aa123456'),
                'id_company' => 0,
                'role' => 'sys-admin',
                'active' => true,
            ],
            [
                'email' => 'admin1@localhost.com',
                'password' => bcrypt('Aa123456'),
                'id_company' => 1,
                'role' => 'client-admin',
                'active' => true,
            ],
            [
                'email' => 'admin2@localhost.com',
                'password' => bcrypt('Aa123456'),
                'id_company' => 2,
                'role' => 'client-admin',
                'active' => true,
            ]
        ];

        DB::table('users')->insert($users);

        echo count($users) . " usuários criados com sucesso.\n";
    }
}
