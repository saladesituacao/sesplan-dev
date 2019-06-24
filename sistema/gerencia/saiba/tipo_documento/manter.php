<?php
include_once (__DIR__ . "/../../../include/conexao.php");
include_once (__DIR__ . "/../../../classes/clsSaiba.php");

$acao = $_REQUEST['acao'];
$cod_tipo_documento = $_REQUEST['id'];
$txt_tipo_documento = $_REQUEST['txt_tipo_documento'];
$cod_ativo = $_REQUEST['cod_ativo'];

switch ($acao) {
    case 'incluir':
        $clsSaiba = new clsSaiba();
        $clsSaiba->txt_tipo_documento = $txt_tipo_documento;
        $clsSaiba->cod_ativo = $cod_ativo;        
        $clsSaiba->IncluirTipodocumento();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsSaiba = new clsSaiba();
        $clsSaiba->cod_tipo_documento = $cod_tipo_documento;
        $resultado = $clsSaiba->ExcluirTipodocumento();        
        echo($resultado);
        break;

    case 'alterar':
        $clsSaiba = new clsSaiba();
        $clsSaiba->cod_tipo_documento = $cod_tipo_documento;
        $clsSaiba->txt_tipo_documento = $txt_tipo_documento;
        $clsSaiba->cod_ativo = $cod_ativo;        
        $clsSaiba->AlterarTipodocumento();   
                        
        js_go('incluir.php?id='.$cod_tipo_documento.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsSaiba = new clsSaiba();        
        $r1 = $clsSaiba->ListarTipodocumento(" UPPER(txt_tipo_documento) = '" .trim(strtoupper($txt_tipo_documento))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsSaiba = new clsSaiba();        
        $r1 = $clsSaiba->ListarTipodocumento(" cod_tipo_documento <> ".$cod_tipo_documento." AND UPPER(txt_tipo_documento) = '" .trim(strtoupper($txt_tipo_documento))."'");
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>