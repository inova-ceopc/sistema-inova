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
<<<<<<< HEAD
         $this->call(EmpregadosTableSeeder::class);
         $this->call(RelacaoAgSrComEmailSeeder::class);
        
        // BNDES
            // // SIAF
            $this->call(AcessaEmpregadoTableSeeder::class);
            $this->call(SiafContratosTableSeeder::class);
        
        // COMEX
            $this->call(EsteiraComexPerfilAcessoSeeder::class);
            $this->call(AccAceLiquidacaoSeeder::class);

        //INDICADORES PAINEL MATRIZ

        $this->call(OpesEnviadas::class);
        $this->call(ResumoDtLiquidacao::class);
=======
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
            // $this->call(AccAceLiquidacaoSeeder::class);

        // INDICADORES PAINEL MATRIZ
            // $this->call(OpesEnviadas::class);
            // $this->call(ResumoDtLiquidacao::class);
>>>>>>> 7a1c44048d7ce4c0e8fab795c2826ce5022b8ea9
        
    }
}
