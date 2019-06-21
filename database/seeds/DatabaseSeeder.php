<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // GERAL
        $this->call(EmpregadosTableSeeder::class);
        
        // BNDES
            // SIAF
            $this->call(AcessaEmpregadoTableSeeder::class);
            $this->call(SiafContratosTableSeeder::class);
    }
}
