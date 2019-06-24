<?php
ini_set('magic_quotes_gpc', '0');

include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();

if ($_SESSION['txt_login'] != "02466269171" && $_SESSION['txt_login'] != "78899648115") {
    js_go($_SESSION["txt_pagina_inicial"]);
}

$acao = $_REQUEST['acao'];
$txt_sql = $_REQUEST["txt_sql"];
?>
<form method="post">
    <textarea id="txt_sql" name="txt_sql" rows="10" cols="100"><?=$txt_sql; ?></textarea>
    <br />
    <input type="submit" id="acao" name="acao" value="SUBMIT QUERY">
</form>
<script type="text/javascript">
    function mudaBack(el){
        el.style.backgroundColor = 'gray';
        el.style.color = 'white';
    }
    function voltaBack(el){
        el.style.backgroundColor = 'white';
        el.style.color = 'black';
}
</script>
<?php 
if(isset($acao)) 
{ ?>
    <div id="result" style="width: 100%">
        <?php
        if( strtolower(substr($txt_sql,0,6)) == "select" ){
            $q = pg_query($txt_sql);
            if(pg_num_rows($q) > 0){
                echo "<table border='1px' cellspacing='0' style='texta-align='center'>";
                $rs = pg_fetch_array($q);
                echo "<tr style='background-color:red;color:white'>";
                foreach($rs as $c => $v){
                    echo "<td>".$c."</td>";
                }
                echo "</tr>";
                $q = pg_query($txt_sql);
                while($rs = pg_fetch_array($q)){
                    echo "<tr onmouseover=\"mudaBack(this)\" onmouseout='voltaBack(this)'>";
                    foreach($rs as $c => $v){
                        echo "<td>".($v == "" ? "&nbsp;" : $v)."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";

            }else{
                echo "Não retornou registros.";
            }
        }else{
            $txt_sql = str_replace("\\'", "'", $txt_sql);
            $txt_sql = str_replace("\\'", "'", $txt_sql);
            $txt_sql = str_replace("\\'", "'", $txt_sql);
            $txt_sql = str_replace("\'", "'", $txt_sql);
            if(pg_query($txt_sql)){
                echo "SUCESSO!";
            }else{
                echo "FALHOU.<br />$txt_sql<br />";
                echo pg_last_error();
            }
        }
        ?>
    </div>
<?php 
} 
rodape($dbcon);
?>
