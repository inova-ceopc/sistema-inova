--USE [SP5459_DES]
GO
SET IDENTITY_INSERT [dbo].[TBL_SIAF_DEMANDAS] on
go
INSERT INTO [dbo].[TBL_SIAF_DEMANDAS]
           (
		   [codigoDemanda]
		   ,[nomeCliente]
           ,[cnpj]
           ,[contratoCaixa]
           ,[contratoBndes]
           ,[valorOperacao]
           ,[tipoOperacao]
           ,[codigoPa]
           ,[nomePa]
           ,[emailPa]
           ,[codigoSr]
           ,[nomeSr]
           ,[emailSr]
           ,[codigoGigad]
           ,[nomeGigad]
           ,[emailGigad]
           ,[dataCadastramento]
           ,[dataLote]
           ,[status]
           ,[matriculaSolicitante]
           ,[contaDebito]
           )
     SELECT [CO_PEDIDO]
      ,[NO_CLIENTE]
      ,[CO_CNPJ]
      ,[CONTRATO_CAIXA]
      ,[CONTRATO_BNDES]
      ,[VL_AMORTIZADO]
      ,[TP_AMORTIZACAO]
      ,[CO_PA]
      ,[NO_PA]
      ,[CO_EMAIL_PA]
      ,[CO_SR]
      ,[NO_SR]
      ,[CO_EMAIL_SR]
      ,[CO_GIGAD]
      ,[NO_GIGAD]
      ,[CO_EMAIL_GIGAD]
      ,[DT_CADASTRAMENTO] = CONVERT(DATETIME, CONCAT(CONVERT(DATE,SUBSTRING([DT_CADASTRAMENTO], 1, 10), 103), ' ', SUBSTRING([DT_CADASTRAMENTO], 12, 8)))
      ,[DT_LT_AMORTIZADOR]
      ,[STATUS]
      ,[CO_MATRICULA_SOLIC]
      ,[CONTA_CORRENTE]
  FROM [SP5459_DES].[dbo].[TBL_SIAF_AMORTIZACOES]
GO


