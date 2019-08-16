-- indicadore de produção mensal antecipados
SELECT [LOTE]
		      
		     ,sum([TOTAL]) as total
		  FROM [DB5624_GEOPC_COMPLEMEX].[dbo].[tbl_ANT_RELATORIO_TEMP_PRODUCAO] 
		  group by lote
		-- resultado
        -- LOTE	total
        -- 1/2019	215
        -- 10/2018	271
        -- 11/2018	223
        -- 12/2018	222
        -- 2/2019	227
        -- 3/2018	586
        -- 3/2019	298
        -- 4/2018	451
        -- 4/2019	310
        -- 5/2018	522