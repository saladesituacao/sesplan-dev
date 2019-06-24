<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsSaiba.php");

$acao = $_REQUEST['acao'];
$cod_id = $_REQUEST['id'];
$cod_tipo_documento = $_REQUEST['cod_tipo_documento'];

switch ($acao) {
    case 'excluir':
        //$txt_caminho_documento  = getcwd()."\\digital\\";
        //$sql = "SELECT txt_arquivo FROM tb_saiba WHERE cod_tipo_documento = ".$cod_id;
        //$q1 = pg_query($sql);
        //$rs1 = pg_fetch_array($q1);

        $clsSaiba = new clsSaiba();
        $clsSaiba->cod_tipo_documento = $cod_id;        
        $clsSaiba->ExcluirArquivo();             

        //APAGAR O ARQUIVO DA PASTA
        //unlink($txt_caminho_documento.$rs1['txt_arquivo']);
        break;
    case 'temp':      
        if (!empty($cod_tipo_documento)) {
            $sql = "SELECT * FROM tb_saiba WHERE cod_tipo_documento = ".$cod_tipo_documento." AND byte IS NOT NULL";
            $q1 = pg_query($sql);
        
            if (pg_num_rows($q1) > 0) {                             
                $rs1 = pg_fetch_array($q1);
                $txt_nome_arquivo = "{" . md5(uniqid(time())) . "}_".$rs1['txt_arquivo'];  
                $txt_caminho_gravar = "/var/www/html/ms_temp/";                     
                $txt_caminho_completo = $txt_caminho_gravar.$txt_nome_arquivo;                                
                
                if (file_exists($txt_caminho_gravar)) {
                    $handle = fopen($txt_caminho_completo, 'w+');   
                } 
                else {
                    $txt_caminho_completo = ini_get('upload_tmp_dir')."/".$txt_nome_arquivo;
                    $handle = fopen($txt_caminho_completo, 'w+');  
                }                
                fwrite($handle, pg_unescape_bytea($rs1['byte']));
                fclose($handle); 
                
                $txt_caminho = str_replace('gerencia\saiba', 'ciclo', getcwd()) ."/digital/".$txt_nome_arquivo; 
                $txt_caminho = str_replace('gerencia/saiba', 'ciclo', getcwd()) ."/digital/".$txt_nome_arquivo;           
                
                copy($txt_caminho_completo, $txt_caminho);
                unlink($txt_caminho_completo);                              
                
                $retorno = $_SESSION["txt_caminho_aplicacao"]."/visualizador/web/viewer.html?file=".urlencode($_SESSION["txt_caminho_aplicacao"]."/ciclo/digital/".$txt_nome_arquivo);
                //echo(json_encode($retorno));                              
                js_go($retorno);
            } 
        }
        break;
}

?>