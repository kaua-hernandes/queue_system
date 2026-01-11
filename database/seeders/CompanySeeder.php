<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [];

        for($index = 1; $index <=3; $index++)
        {
            $companies[] = [
                'company_name' => "Empresa " . $index,
                'company_logo' => 'empresa_0' . $index . '.png',
                'uuid' => Str::uuid(),
                'address' => 'Rua da Empresa ' . $index . ', 123, Bairro Exemplo, Cidade Exemplo',
                'phone' => '98765432' . $index,
                'email' => 'empresa' . $index . '@gmail.com',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ];
        }

        DB::table('companies')->insert($companies);

        echo count($companies) . " empresas criadas com sucesso.\n";
    }
}
