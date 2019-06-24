<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
permissao_acesso_pagina(94);

$cod_tipo_documento = $_REQUEST['cod_tipo_documento'];

if (!empty($cod_tipo_documento)) {
    $sql = "SELECT * FROM tb_ciclo_planejamento WHERE cod_tipo_documento = ".$cod_tipo_documento." AND byte IS NOT NULL";
    $q1 = pg_query($sql);

    if (pg_num_rows($q1) > 0) {
        $rs1 = pg_fetch_array($q1);        
        header("Content-Disposition:attachment;filename='".substr($rs1['txt_arquivo'], 35)."'");        
        echo pg_unescape_bytea($rs1['byte']);       
        js_go('incluir.php');
    } else {
        js_go('incluir.php');
    }
} else {
    js_go('incluir.php');
}
?>

<?php
rodape($dbcon);
?>