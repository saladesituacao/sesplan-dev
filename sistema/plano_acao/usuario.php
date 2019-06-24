<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	$id = $_REQUEST['id'];
	$idPlanoAcao = $_REQUEST['idPlanoAcao'];
	
	if($acao == "fn_usuario_orgao") 
	{
		$sql = "SELECT tb_usuario.cod_usuario, UPPER(txt_usuario) AS txt_usuario FROM tb_usuario
		INNER JOIN tb_usuario_orgao ON tb_usuario_orgao.cod_orgao = tb_usuario.cod_orgao 
		WHERE tb_usuario.cod_ativo = 1 AND tb_usuario.cod_orgao = ".$_REQUEST['cod_orgao'] ."
		GROUP BY tb_usuario.cod_usuario, txt_usuario ORDER BY txt_usuario";
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
      
