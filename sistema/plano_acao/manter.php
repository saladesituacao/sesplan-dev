<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	$id = $_REQUEST['id'];
	$cod_acao = trim($_REQUEST['cod_acao']);
	$cod_secretaria = trim($_REQUEST['cod_secretaria']);
	$cod_programa_governo = trim($_REQUEST['cod_programa_governo']);
	$txt_projeto = trim($_REQUEST['txt_projeto']);
	$cod_objetivo = trim($_REQUEST['cod_objetivo']);
	$cod_estrategia = $_REQUEST['cod_estrategia'];	

	//echo $cod_estrategia;exit;

	if($acao == "incluir")
	{		
		if($erro == "") 
		{			
			$q=pg_query("SELECT nr_acao FROM tb_plano_acao WHERE LOWER(nr_acao)='".trim(strtolower($cod_acao))."'");
			if (pg_num_rows($q) > 0) {
				$erro = "Ação já está cadastrada.";
				js_go_back($erro);
			}

			if($erro == "") {

				if (empty($cod_estrategia)) {
					$cod_estrategia = 'NULL';
				}
				if (empty($cod_objetivo)) {
					$cod_objetivo = 'NULL';
				}


				$sql = "INSERT INTO tb_plano_acao(nr_acao, cod_secretaria, cod_programa_governo, txt_projeto_acao, cod_usuario, ";
				$sql .= " dt_atualizacao, cod_objetivo) ";
				$sql .= " VALUES ('".$cod_acao."', ".$cod_secretaria.", ".$cod_programa_governo.", '".trim($txt_projeto)."', ";
				$sql .= " ".$_SESSION['cod_usuario'].", CURRENT_TIMESTAMP, ".$cod_objetivo.")";				
				pg_query($sql);
				Auditoria(137, "", $sql);

				$rs1 = pg_fetch_array(pg_query("SELECT cod_plano_acao FROM tb_plano_acao WHERE nr_acao = '".$cod_acao."'"));

				
				if ($cod_estrategia != 'NULL') {
				
					foreach($cod_estrategia as $i) {
						$sql = "INSERT INTO tb_plano_acao_estrategia_vinculada(cod_estrategia, cod_plano_acao) VALUES(".$i.", ".$rs1['cod_plano_acao'].")";
						pg_query($sql);
						Auditoria(137, "", $sql);
					}	
				}

				js_go("default.php");
			}
		}					
	}	
	else if($acao == "alterar") 
	{		
		if($erro == "") 
		{			
			$q=pg_query("SELECT nr_acao FROM tb_plano_acao WHERE LOWER(nr_acao)='".trim(strtolower($cod_acao))."' AND cod_plano_acao <> ".$id);
			if (pg_num_rows($q) > 0) {
				$erro = "Ação já está cadastrada.";
				js_go_back($erro);
			}

			if($erro == "") {

				if (empty($cod_estrategia)) {
					$cod_estrategia = 'NULL';
				}
				if (empty($cod_objetivo)) {
					$cod_objetivo = 'NULL';
				}

				$sql = "UPDATE tb_plano_acao SET nr_acao = '".$cod_acao."', cod_secretaria = ".$cod_secretaria.", ";
				$sql .= " cod_programa_governo = ".$cod_programa_governo.", txt_projeto_acao = '".trim($txt_projeto)."', ";
				$sql .= " cod_usuario = ".$_SESSION['cod_usuario']. ", cod_objetivo = ".$cod_objetivo." WHERE cod_plano_acao=" . $id;
				pg_query($sql);
				Auditoria(138, "", $sql);

				$sql = "DELETE FROM tb_plano_acao_estrategia_vinculada WHERE cod_plano_acao = ".$id;
				pg_query($sql);
				Auditoria(138, "", $sql);


				if ($cod_estrategia != 'NULL') {
						foreach($cod_estrategia as $i) {
							$sql = "INSERT INTO tb_plano_acao_estrategia_vinculada(cod_estrategia, cod_plano_acao) VALUES(".$i.", ".$id.")";
							pg_query($sql);
							Auditoria(138, "", $sql);
						}
					}		

				js_go("default.php");
			}
		}	
	}
	else if($acao == "desabilitar")
	{
		$cod_plano_acao = isset($_REQUEST["cod_plano_acao"]) ? $_REQUEST["cod_plano_acao"] : null;

		$q=pg_query("SELECT * FROM tb_atividade_plano_acao WHERE ind_habilitado = 'S' AND cod_plano_acao = " .$cod_plano_acao . " LIMIT 1");
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Plano de Ação não pode ser desabilitado. Pois, está vinculada a atividade ". $rs['nr_atividade'] .".";
		}

		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_projeto_acao FROM tb_plano_acao WHERE cod_plano_acao = ".$cod_plano_acao));        

			$sql = "UPDATE tb_plano_acao SET ind_habilitado = 'N' WHERE cod_plano_acao = '$cod_plano_acao'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(136, "DESABILITAR PLANO DE AÇÃO: ".$rs['txt_projeto_acao'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "PLANO DESABILITADO.";
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = $sql;
			}		
		}
		else {
			$retorno["status"] = "falha";
			$retorno["mensagem"] = $erro;
		}		

		echo(json_encode($retorno));
	}

	
	else if($acao == "habilitar")
	{
		$cod_plano_acao = isset($_REQUEST["cod_plano_acao"]) ? $_REQUEST["cod_plano_acao"] : null;

		

		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_projeto_acao FROM tb_plano_acao WHERE cod_plano_acao = ".$cod_plano_acao));        

			$sql = "UPDATE tb_plano_acao SET ind_habilitado = 'S' WHERE cod_plano_acao = '$cod_plano_acao'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(135, "HABILITAR PLANO DE AÇÃO: ".$rs['txt_projeto_acao'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "PLANO HABILITADO.";
			}
			else
			{
				$retorno["status"] = "falha";
				$retorno["mensagem"] = $sql;
			}		
		}
		else {
			$retorno["status"] = "falha";
			$retorno["mensagem"] = $erro;
		}		

		echo(json_encode($retorno));
	}

	
}
?>