@extends('adminlte::page')

@section('title', 'Esteira Comex - Cadastro Email Op')


@section('content_header')
    
    <h4 class="animated bounceInLeft">
        Indicadores | 
        <small> Dados e Estatísticas dos prazos para análise</small>
    </h4>
    
    <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Gerencial</a></li>
            <li><a href="#"></i>Indicadores</a></li>
    </ol>

@stop


@section('content')
<!-- box com os resultados da ceopc backoffice -->
<p>Abaixo é apresentada a quantidade de demandas já tratadas por período e o tempo médio de atendimento (TMA) das etapas de evolução dos pedidos de liquidação cadastrados na Esteira.</p>
    
    @component('Componentes.box')
   

    @endcomponent							
                
@stop


@section('css')
   

   
@stop


@section('js')

 

@stop