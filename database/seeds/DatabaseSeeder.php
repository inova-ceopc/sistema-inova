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
            $this->call(RelacaoAgSrComEmailSeeder::class);
        
        // BNDES
            // GERAL
            $this->call(AcessaEmpregadoTableSeeder::class);
            
            // SIAF
            // $this->call(SiafContratosTableSeeder::class);
        
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
