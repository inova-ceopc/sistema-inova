<?php

use Illuminate\Database\Seeder;

class AccAceLiquidacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('tbl_LIQUIDACAO')->insert(
                       
            ['CO_OPERACAO'=>'VALOR',
            'NO_RAZAO_SOCIAL'=>'VALOR',
            'CNPJ'=>'VALOR',
            'CO_SR'=>'VALOR',
            'CO_PV'=>'VALOR',
            'CO_AREA'=>'VALOR',
            'CO_MATRICULA'=>'VALOR',
            'NO_EMPREGADO'=>'VALOR',
            'VL_CONTRATADO'=>'VALOR',
            'VL_SALDO_MN'=>'VALOR',
            'DT_VENCIMENTO'=>'VALOR',
            'NU_O_PAGTO'=>'VALOR',
            'NO_FATURA'=>'VALOR',
            'VL_O_PGTO'=>'VALOR',
            'VL_DP_BANQ'=>'VALOR',
            'VL_AP_CONTRATO'=>'VALOR',
            'TP_MOEDA'=>'VALOR',
            'DT_NEGOCIACAO'=>'VALOR',
            'DT_INICIAL'=>'VALOR',
            'CO_STATUS'=>'VALOR',
            'NO_CAMINHO'=>'VALOR',
            'NO_OBSERVACOES'=>'VALOR',
            'CO_MATRICULA_CEOPC'=>'VALOR',
            'CO_POSICAO'=>'VALOR',
            'VL_CO_AGENTE'=>'VALOR',
            'NO_AGENTE'=>'VALOR',
            'CO_BANCO_AGENTE'=>'VALOR',
            'NU_AGENTE_CONTA'=>'VALOR',
            'NO_AGENTE_ENDERECO'=>'VALOR',
            'NU_CONF_NU_O_PAGTO' =>'VALOR',
            'NU_CONF_VL_O_PAGTO'=>'VALOR',
            'NU_CONF_VL_BANQUEIRO'=>'VALOR',
            'NU_CONF_VL_APLICADO'=>'VALOR',
            'NU_CONF_MOEDA'=>'VALOR',
            'DT_CALC_JUROS' =>'VALOR',
            'DT_EMBARQUE' =>'VALOR',
            'NU_CONF_VL_AGENTE' =>'VALOR',
            'NU_CONF_NO_AGENTE'=>'VALOR',
            'NU_CONF_CD_BANCO'=>'VALOR',
            'NU_CONF_NU_CONTA'=>'VALOR',
            'NU_CONF_ENDERECO'=>'VALOR',
            'NU_CONF_CAMINHO'=>'VALOR',
            'NU_CONF_OBSERVACOES'=>'VALOR',
            'NU_CAMBIAL'=>'VALOR',
            'NO_CONCLUSAO'=>'VALOR',
            'DT_ATUAL'=>'VALOR',
            'DOCS_COPY'=>'VALOR',]


        );

    }
}
