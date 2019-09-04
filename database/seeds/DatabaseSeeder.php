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
<<<<<<< HEAD
            $this->call(RelacaoAgSrComEmailSeeder::class);
=======
            // $this->call(RelacaoAgSrComEmailSeeder::class);
>>>>>>> 2d667eeef05d24374ec47f7ac1dcb30875a96d0f
        
        // BNDES
            // GERAL
            $this->call(AcessaEmpregadoTableSeeder::class);
            
            // SIAF
            $this->call(SiafContratosTableSeeder::class);
        
        // COMEX
            // GERAL
            $this->call(EsteiraComexPerfilAcessoSeeder::class);
            
            // LIQUIDAÇÃO
            $this->call(AccAceLiquidacaoSeeder::class);

        // INDICADORES PAINEL MATRIZ
            $this->call(OpesEnviadas::class);
            $this->call(ResumoDtLiquidacao::class);
        
    }
}
