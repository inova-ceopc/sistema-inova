--USE [SP5459_DES]
GO

INSERT INTO [dbo].[TBL_SIAF_HISTORICO_DEMANDAS]
           ([contratoCaixa]
           ,[loteAmortizacao]
           ,[tipoHistorico]
           ,[historico]
           ,[matriculaResponsavel]
           ,[unidadeResponsavel]
           ,[created_at]
           ,[updated_at])
SELECT 
	'contratoCaixa' = [CONTRATO_CAIXA]
	,'loteAmortizacao' = [DT_LT_AMORTIZADOR]
	,'tipoHistorico' = 'CADASTRO'
	,'unidadeResponsavel' = [CO_PA]
	,'created_at' = GETDATE()
	,'updated_at' = GETDATE()
	,'historico' = dbo.udf_StripHTML(dbo.DecodeUTF8String([CO_OBSERVACAO_SOLIC]))
	,'matriculaResponsavel' = [CO_MATRICULA_SOLIC]
FROM [SP5459_DES].[dbo].[TBL_SIAF_AMORTIZACOES]
GO