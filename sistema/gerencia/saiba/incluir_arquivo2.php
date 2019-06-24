<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsSaiba.php");

$clsSaiba = new clsSaiba();  

$cod_tipo_documento     = $_POST['cod_tipo_documento'];
$txt_arquivo            = $_FILES["txt_arquivo"];
$txt_arquivo_nome       = $_FILES["txt_arquivo"]['name'];
$txt_arquivo_unico =  "{" . md5(uniqid(time())) . "}_" . remove_acento($txt_arquivo_nome);
$binario = file_get_contents($txt_arquivo['tmp_name']);
$binario = pg_escape_bytea($binario);

$clsSaiba->cod_tipo_documento = $cod_tipo_documento;
$clsSaiba->txt_arquivo = $txt_arquivo_unico;
$clsSaiba->cod_usuario = $_SESSION["cod_usuario"];
$clsSaiba->binario = $binario;

$sql = "SELECT * FROM tb_saiba WHERE cod_tipo_documento = ".$cod_tipo_documento;
$q1 = pg_query($sql);
if (pg_num_rows($q1) > 0) {
    $rs1 = pg_fetch_array($q1);   

    $clsSaiba->AlterarArquivo();
    
} else {       
    
    $clsSaiba->IncluirArquivo();
}

js_go('incluir.php');

?>