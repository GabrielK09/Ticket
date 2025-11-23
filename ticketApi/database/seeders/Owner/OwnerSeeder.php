<?php

namespace Database\Seeders\Owner;

use App\Models\Owner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Owner::create([
            'user_id' => 1,
            'company_name' => 'Teste',
            'trade_name' => 'Teste',
            'cnpj_cpf' => '088.051.669-01',
            'phone' => '49 99948-2859', 
            'cep' => '89711226',
            'address' => 'Teste',
            'number' => '123',
            'cnae' => '344566756',
            'activity' => 'Teste'
        ]);
    }
}
