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
        // $this->call(EmpregadosTableSeeder::class);
        // $this->call(RelacaoAgSrComEmailSeeder::class);
        
        // BNDES
            // // SIAF
            // $this->call(AcessaEmpregadoTableSeeder::class);
            // $this->call(SiafContratosTableSeeder::class);
        
        // COMEX
            // $this->call(EsteiraComexPerfilAcessoSeeder::class);
            $this->call(AccAceLiquidacaoSeeder::class);

        //INDICADORES PAINEL MATRIZ

        // $this->call(OpesEnviadas::class);
        
    }
}
