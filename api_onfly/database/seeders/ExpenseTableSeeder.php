<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;

require_once 'vendor/autoload.php';

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gera despesas para cada usuario afim de testar as validacoes das policies
        for ($i = 1; $i <= 11; $i++) {
            \App\Models\Expense::create([
                'description' => 'Despesa ' . $i,
                'user_id' => $i,
                'date' => now(),
                'cost' => rand(1, 500)
            ]);
        }
    }
}
