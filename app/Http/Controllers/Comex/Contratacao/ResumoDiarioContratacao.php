<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResumoDiarioContratacao extends Controller
{
    public function resumoDiarioConformidadeContratacao ()
    {
        $resumo = DB::statement("
            WITH RESUMO_DIARIO_CONFORMIDADE_CONTRATACAO AS (
                SELECT 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,'prontoImportacao' = COUNT(DEMANDAS.[tipoOperacao])
                    ,'prontoImportacaoAntecipado' = SUM(0)
                    ,'prontoExportacao' = SUM(0)
                    ,'prontoExportacaoAntecipado' = SUM(0)
                    ,DEMANDAS.[dataCadastro]
                FROM 
                    [TBL_EST_CONTRATACAO_DEMANDAS] AS DEMANDAS LEFT JOIN [TBL_EMPREGADOS] AS EMPREGADOS ON DEMANDAS.[responsavelCeopc] = EMPREGADOS.[MATRICULA]
                WHERE
                    DEMANDAS.[tipoOperacao] = 'Pronto Importação'
                    AND DEMANDAS.[responsavelCeopc] IS NOT NULL
                    AND DEMANDAS.[dataCadastro] = CONVERT(DATE, GETDATE())
                GROUP BY 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,DEMANDAS.[dataCadastro]
                
                UNION ALL
                
                SELECT 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,'prontoImportacao' = SUM(0)
                    ,'prontoImportacaoAntecipado' = COUNT(DEMANDAS.[tipoOperacao])
                    ,'prontoExportacao' = SUM(0)
                    ,'prontoExportacaoAntecipado' = SUM(0)
                    ,DEMANDAS.[dataCadastro]
                FROM 
                    [TBL_EST_CONTRATACAO_DEMANDAS] AS DEMANDAS LEFT JOIN [TBL_EMPREGADOS] AS EMPREGADOS ON DEMANDAS.[responsavelCeopc] = EMPREGADOS.[MATRICULA]
                WHERE
                    DEMANDAS.[tipoOperacao] = 'Pronto Importação Antecipado'
                    AND DEMANDAS.[responsavelCeopc] IS NOT NULL
                    AND DEMANDAS.[dataCadastro] = CONVERT(DATE, GETDATE())
                GROUP BY 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,DEMANDAS.[dataCadastro]
                
                UNION ALL
                
                SELECT 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,'prontoImportacao' = SUM(0)
                    ,'prontoImportacaoAntecipado' = SUM(0)
                    ,'prontoExportacao' = COUNT(DEMANDAS.[tipoOperacao])
                    ,'prontoExportacaoAntecipado' = SUM(0)
                    ,DEMANDAS.[dataCadastro]
                FROM 
                    [TBL_EST_CONTRATACAO_DEMANDAS] AS DEMANDAS LEFT JOIN [TBL_EMPREGADOS] AS EMPREGADOS ON DEMANDAS.[responsavelCeopc] = EMPREGADOS.[MATRICULA]
                WHERE
                    DEMANDAS.[tipoOperacao] = 'Pronto Exportação'
                    AND DEMANDAS.[responsavelCeopc] IS NOT NULL
                    AND DEMANDAS.[dataCadastro] = CONVERT(DATE, GETDATE())
                GROUP BY 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,DEMANDAS.[dataCadastro]
                
                UNION ALL
                
                SELECT 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,'prontoImportacao' = SUM(0)
                    ,'prontoImportacaoAntecipado' = SUM(0)
                    ,'prontoExportacao' = SUM(0)
                    ,'prontoExportacaoAntecipado' = COUNT(DEMANDAS.[tipoOperacao])
                    ,DEMANDAS.[dataCadastro]
                FROM 
                    [TBL_EST_CONTRATACAO_DEMANDAS] AS DEMANDAS LEFT JOIN [TBL_EMPREGADOS] AS EMPREGADOS ON DEMANDAS.[responsavelCeopc] = EMPREGADOS.[MATRICULA]
                WHERE
                    DEMANDAS.[tipoOperacao] = 'Pronto Exportação Antecipado'
                    AND DEMANDAS.[responsavelCeopc] IS NOT NULL
                    AND DEMANDAS.[dataCadastro] = CONVERT(DATE, GETDATE())
                GROUP BY 
                    DEMANDAS.[responsavelCeopc]
                    ,EMPREGADOS.[nomeCompleto]
                    ,DEMANDAS.[dataCadastro]
                
            )
                
            SELECT 
                [responsavelCeopc]
                ,[nomeCompleto]
                ,'prontoImportacao' = SUM([prontoImportacao])
                ,'prontoImportacaoAntecipado' = SUM([prontoImportacaoAntecipado])	
                ,'prontoExportacao' = SUM([prontoExportacao])
                ,'prontoExportacaoAntecipado' = SUM([prontoExportacaoAntecipado])
                ,'total' = SUM([prontoImportacao]) + SUM([prontoImportacaoAntecipado]) + SUM([prontoExportacao]) + SUM([prontoExportacaoAntecipado])
            FROM 
                RESUMO_DIARIO_CONFORMIDADE_CONTRATACAO
            GROUP BY
                [responsavelCeopc]
                ,[nomeCompleto]
        ");
        return json_encode($resumo);
    }
}
