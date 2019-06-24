<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsMensagem.php");

$acao = $_REQUEST['acao'];
$cod_mensagem = $_REQUEST['id'];
$txt_titulo = $_REQUEST['txt_titulo'];
$cod_ativo = $_REQUEST['cod_ativo'];
$txt_mensagem = $_REQUEST['txt_mensagem'];
$cod_tipo_mensagem = $_REQUEST['cod_tipo_mensagem'];
$cod_dia = $_REQUEST['cod_dia']; 

switch ($acao) {
    case 'incluir':
        $clsMensagem = new clsMensagem();
        $clsMensagem->txt_titulo = $txt_titulo;
        $clsMensagem->cod_ativo = $cod_ativo;
        $clsMensagem->txt_mensagem = $txt_mensagem;
        $clsMensagem->cod_tipo_mensagem = $cod_tipo_mensagem;
        $clsMensagem->cod_dia = $cod_dia;
        $clsMensagem->IncluirMensagem();

        js_go('default.php');                      
        break; 

    case 'excluir':   
        $clsMensagem = new clsMensagem();
        $clsMensagem->cod_mensagem = $cod_mensagem;
        $resultado = $clsMensagem->ExcluirMensagem();        
        echo($resultado);
        break;

    case 'alterar':
        $clsMensagem = new clsMensagem();
        $clsMensagem->cod_mensagem = $cod_mensagem;
        $clsMensagem->txt_titulo = $txt_titulo;
        $clsMensagem->cod_ativo = $cod_ativo;
        $clsMensagem->txt_mensagem = $txt_mensagem;
        $clsMensagem->cod_tipo_mensagem = $cod_tipo_mensagem;
        $clsMensagem->cod_dia = $cod_dia;
        $clsMensagem->AlterarMensagem();   
                        
        js_go('incluir.php?id='.$cod_mensagem.'&status=sucesso');
        break;
    
    case 'validacao_incluir':        
        $clsMensagem = new clsMensagem();        
        $r1 = $clsMensagem->ListarMensagem(" UPPER(txt_titulo) = '" .trim(strtoupper($txt_titulo))."' AND cod_tipo_mensagem = ".$cod_tipo_mensagem);
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;
    
    case 'validacao_alterar':
        $clsMensagem = new clsMensagem();        
        $r1 = $clsMensagem->ListarMensagem(" cod_mensagem <> ".$cod_mensagem." AND UPPER(txt_titulo) = '" .trim(strtoupper($txt_titulo))."' AND cod_tipo_mensagem = ".$cod_tipo_mensagem);
        if (pg_num_rows($r1) > 0) {
            echo("falha");
        }
        else {
            echo("sucesso");
        }
        break;

}   

?>