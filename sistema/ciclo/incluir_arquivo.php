<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsCiclo.php");

$clsCiclo = new clsCiclo();  

$cod_tipo_documento     = $_POST['cod_tipo_documento'];
$txt_arquivo            = $_FILES["txt_arquivo"];
$txt_arquivo_nome       = $_FILES["txt_arquivo"]['name'];
//PEGAR DIRETÓRIO ATUAL
$txt_caminho_documento  = getcwd()."/digital/";
$txt_arquivo_unico =  "{" . md5(uniqid(time())) . "}_" . remove_acento($txt_arquivo_nome);

$txt_caminho = $txt_caminho_documento . $txt_arquivo_unico;
$txt_caminho = str_replace("\\", "/", $txt_caminho);

$erro_upload = move_uploaded_file($txt_arquivo['tmp_name'], $txt_caminho);

$clsCiclo->cod_tipo_documento = $cod_tipo_documento;
$clsCiclo->txt_arquivo = $txt_arquivo_unico;
$clsCiclo->cod_usuario = $_SESSION["cod_usuario"];

$sql = "SELECT * FROM tb_ciclo_planejamento WHERE cod_tipo_documento = ".$cod_tipo_documento;
$q1 = pg_query($sql);
if (pg_num_rows($q1) > 0) {
    $rs1 = pg_fetch_array($q1);   

    $clsCiclo->AlterarArquivo();

    //APAGAR O ARQUIVO DA PASTA
    unlink($txt_caminho_documento.$rs1['txt_arquivo']);
} else {       
    
    $clsCiclo->IncluirArquivo();
}

js_go('incluir.php');
?>