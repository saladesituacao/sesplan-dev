<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	$id = $_REQUEST['id'];
	$idPlanoAcao = $_REQUEST['idPlanoAcao'];
	
	if($acao == "fn_fonte_recurso")
	{
		$sql = "SELECT cod_fonte_recurso_orcamento, txt_fonte_recurso_orcamento FROM tb_fonte_recurso_orcamento 
		WHERE cod_fonte_recurso = ".$_REQUEST['cod_fonte_recurso']." ORDER BY txt_fonte_recurso_orcamento";
        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;            
            } 
        }                
        echo(json_encode($arr));        
	}

	

}


?>
      
