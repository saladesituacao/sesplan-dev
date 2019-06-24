<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsPrograma.php");

$acao = $_REQUEST['acao'];
$cod_programa_governo = $_REQUEST['id'];
$txt_programa_governo = $_REQUEST['txt_programa_governo'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_descricao = $_REQUEST['txt_descricao'];
$cod_orgao = $_REQUEST['cod_orgao'];

switch ($acao) {
    case 'incluir':
        $clsPrograma = new clsPrograma();
        $clsPrograma->txt_programa_governo = $txt_programa_governo;
        $clsPrograma->cod_ativo = $cod_ativo;
        $clsPrograma->txt_descricao = $txt_descricao;
        $clsPrograma->cod_orgao = $cod_orgao;
        $clsPrograma->IncluirPrograma();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsPrograma = new clsPrograma();
        $clsPrograma->cod_programa_governo = $cod_programa_governo;
        $resultado = $clsPrograma->ExcluirPrograma();        
        echo($resultado);
        break;

    case 'alterar':
        $clsPrograma = new clsPrograma();
        $clsPrograma->cod_programa_governo = $cod_programa_governo;
        $clsPrograma->txt_programa_governo = $txt_programa_governo;
        $clsPrograma->cod_ativo = $cod_ativo;
        $clsPrograma->txt_descricao = $txt_descricao;
        $clsPrograma->cod_orgao = $cod_orgao;
        $clsPrograma->AlterarPrograma();   
                        
        js_go('incluir.php?id='.$cod_programa_governo.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsPrograma = new clsPrograma();        
        $r1 = $clsPrograma->ListarPrograma(" UPPER(txt_programa_governo) = '" .trim(strtoupper($txt_programa_governo))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsPrograma = new clsPrograma();        
        $r1 = $clsPrograma->ListarPrograma(" cod_programa_governo <> ".$cod_programa_governo." AND UPPER(txt_programa_governo) = '" .trim(strtoupper($txt_programa_governo))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>