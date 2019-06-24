<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsEstrategiaVinculada.php");

$acao = $_REQUEST['acao'];
$cod_estrategia = $_REQUEST['id'];
$txt_estrategia = $_REQUEST['txt_estrategia'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_descricao = $_REQUEST['txt_descricao'];

switch ($acao) {
    case 'incluir':
        $clsEstrategiaVinculada = new clsEstrategiaVinculada();
        $clsEstrategiaVinculada->txt_estrategia = $txt_estrategia;
        $clsEstrategiaVinculada->cod_ativo = $cod_ativo;
        $clsEstrategiaVinculada->txt_descricao = $txt_descricao;
        $clsEstrategiaVinculada->IncluirEstrategia();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsEstrategiaVinculada = new clsEstrategiaVinculada();
        $clsEstrategiaVinculada->cod_estrategia = $cod_estrategia;
        $resultado = $clsEstrategiaVinculada->ExcluirEstrategia();        
        echo($resultado);
        break;

    case 'alterar':
        $clsEstrategiaVinculada = new clsEstrategiaVinculada();
        $clsEstrategiaVinculada->cod_estrategia = $cod_estrategia;
        $clsEstrategiaVinculada->txt_estrategia = $txt_estrategia;
        $clsEstrategiaVinculada->cod_ativo = $cod_ativo;
        $clsEstrategiaVinculada->txt_descricao = $txt_descricao;
        $clsEstrategiaVinculada->AlterarEstrategia();   
                        
        js_go('incluir.php?id='.$cod_estrategia.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsEstrategiaVinculada = new clsEstrategiaVinculada();        
        $r1 = $clsEstrategiaVinculada->ListarEstrategia(" UPPER(txt_estrategia) = '" .trim(strtoupper($txt_estrategia))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsEstrategiaVinculada = new clsEstrategiaVinculada();        
        $r1 = $clsEstrategiaVinculada->ListarEstrategia(" cod_estrategia <> ".$cod_estrategia." AND UPPER(txt_estrategia) = '" .trim(strtoupper($txt_estrategia))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>