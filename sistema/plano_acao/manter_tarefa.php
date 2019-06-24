<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	$id = $_REQUEST['id'];
	$idPlanoAcao = $_REQUEST['idPlanoAcao'];
	$idAtividadePlanoAcao = $_REQUEST['idAtividadePlanoAcao'];


	
	
	$nr_tarefa = trim($_REQUEST['nr_tarefa']);
	$txt_tarefa = trim($_REQUEST['txt_tarefa']);
	$nr_valor = trim($_REQUEST['nr_valor']);
	$cod_fonte_recurso = trim($_REQUEST['cod_fonte_recurso']);
	$cod_fonte_recurso_orcamento = trim($_REQUEST['cod_fonte_recurso_orcamento']);
	$dt_inicial = trim($_REQUEST['dt_inicial']);
	$dt_final = trim($_REQUEST['dt_final']);
	$dt_inauguracao_lancamento = trim($_REQUEST['dt_inauguracao_lancamento']);
	$nr_status_percentual_execucao = trim($_REQUEST['nr_status_percentual_execucao']);
	$nr_processo_sei = trim($_REQUEST['nr_processo_sei']);
	$txt_reporte_execucao = trim($_REQUEST['txt_reporte_execucao']);
	$txt_entraves_riscos = trim($_REQUEST['txt_entraves_riscos']);
	$txt_desburocratizacao = trim($_REQUEST['txt_desburocratizacao']);
	$cod_usuario_responsavel = trim($_REQUEST['cod_usuario_responsavel']);
	$cod_orgao = trim($_REQUEST['cod_orgao']);


	$nr_prazo = trim($_REQUEST['nr_prazo']);
	$cod_unidade_prazo = trim($_REQUEST['cod_unidade_prazo']);
	

	
	


	if($acao == "incluir")
	{		
		if($erro == "") 
		{			
			$q=pg_query("SELECT nr_tarefa FROM tb_tarefa_atividade WHERE ind_habilitado = 'S' AND cod_atividade_plano_acao = $idAtividadePlanoAcao AND LOWER(nr_tarefa)='".trim(strtolower($nr_tarefa))."'");
			if (pg_num_rows($q) > 0) {
				$erro = "TAREFA já está cadastrada para esta ATIVIDADE.";
				js_go_back($erro);
			}
			
			if($erro == "") {
				if (empty($dt_inauguracao_lancamento)) {
					$dt_inauguracao_lancamento = 'null';
				} else {
					$dt_inauguracao_lancamento = "'".trim(DataBanco($dt_inauguracao_lancamento))."'";
				}
				if (empty($nr_valor)) {
					$nr_valor = 'null';
				} else {
					$nr_valor = str_replace('.', '', $nr_valor);
					$nr_valor = str_replace(',', '.', $nr_valor);
					$nr_valor = "'".trim($nr_valor)."'";
				}						
				if (empty($cod_fonte_recurso_orcamento)) {
					$cod_fonte_recurso_orcamento = 'null';
				}
				if (empty($cod_fonte_recurso)) {
					$cod_fonte_recurso = 'null';
				}

				if (empty($nr_prazo)) {
					$nr_prazo = 'null';
				}

				if (empty($cod_unidade_prazo)) {
					$cod_unidade_prazo = '';
				}
				
				
				$sql = "INSERT INTO tb_tarefa_atividade(cod_atividade_plano_acao, txt_tarefa, dt_inicial, dt_final, nr_valor, cod_fonte_recurso_orcamento, dt_inauguracao_lancamento, 
				nr_status_percentual_execucao, nr_processo_sei, txt_reporte_execucao, txt_entraves_riscos, txt_desburocratizacao, cod_usuario_responsavel, cod_usuario, nr_tarefa, cod_fonte_recurso, cod_orgao, dt_atualizacao, nr_prazo, cod_unidade_prazo) ";
				$sql .= " VALUES (".$idAtividadePlanoAcao.", '".trim($txt_tarefa)."', '".trim(DataBanco($dt_inicial))."', '".trim(DataBanco($dt_final))."', ".$nr_valor.", ".trim($cod_fonte_recurso_orcamento).",   
				".$dt_inauguracao_lancamento.", '".trim($nr_status_percentual_execucao)."', '".trim($nr_processo_sei)."', '".trim($txt_reporte_execucao)."', '".trim($txt_entraves_riscos)."',  '".trim($txt_desburocratizacao)."',  ".trim($cod_usuario_responsavel).", ".$_SESSION['cod_usuario'].", '".trim($nr_tarefa)."',  ".trim($cod_fonte_recurso).",  ".trim($cod_orgao).", CURRENT_TIMESTAMP, ".$nr_prazo. ", '" .$cod_unidade_prazo."')";
				
				//echo $sql; exit; 
				pg_query($sql);
				Auditoria(141, "", $sql);
				js_go("listar_tarefa.php?id=". $idAtividadePlanoAcao . "&idPlanoAcao=".$idPlanoAcao);
			}
		}					
	}	
	
	else if($acao == "desabilitar")
	{
		$cod_tarefa_atividade = isset($_REQUEST["cod_tarefa_atividade"]) ? $_REQUEST["cod_tarefa_atividade"] : null;

		
		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_tarefa FROM tb_tarefa_atividade WHERE cod_tarefa_atividade = ".$cod_tarefa_atividade));        

			$sql = "UPDATE tb_tarefa_atividade SET ind_habilitado = 'N' WHERE cod_tarefa_atividade = '$cod_tarefa_atividade'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(144, "DESABILITAR TAREFA: ".$rs['txt_tarefa'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "TAREFA DESABILITADA.";
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
		$cod_tarefa_atividade = isset($_REQUEST["cod_tarefa_atividade"]) ? $_REQUEST["cod_tarefa_atividade"] : null;
		
		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_tarefa FROM tb_tarefa_atividade WHERE cod_tarefa_atividade = ".$cod_tarefa_atividade));        

			$sql = "UPDATE tb_tarefa_atividade SET ind_habilitado = 'S' WHERE cod_tarefa_atividade = '$cod_tarefa_atividade'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(143, "HABILITAR TAREFA: ".$rs['txt_tarefa'], $sql);

				$retorno["status"] = "sucesso";
				$retorno["mensagem"] = "TAREFA HABILITADA.";
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

	else if ($acao == "alterar") {
		$nr_valor = str_replace('.', '', $nr_valor);
		$nr_valor = str_replace(',', '.', $nr_valor);

		if (empty($dt_inauguracao_lancamento)) {
            $dt_inauguracao_lancamento = 'null';
        } else {
			$dt_inauguracao_lancamento = "'".trim(DataBanco($dt_inauguracao_lancamento))."'";
		}
		if (empty($nr_valor)) {
			$nr_valor = 'null';
		} else {
			$nr_valor = str_replace('.', '', $nr_valor);
			$nr_valor = str_replace(',', '.', $nr_valor);
			$nr_valor = "'".trim($nr_valor)."'";
		}
		if (empty($cod_fonte_recurso_orcamento)) {
			$cod_fonte_recurso_orcamento = 'null';
		}
		if (empty($cod_fonte_recurso)) {
			$cod_fonte_recurso = 'null';
		}

		if (empty($nr_prazo)) {
			$nr_prazo = 'null';
		}

		if (empty($cod_unidade_prazo)) {
			$cod_unidade_prazo = '';
		}



		$sql = "UPDATE tb_tarefa_atividade SET txt_tarefa = '".$txt_tarefa."', nr_valor = ".$nr_valor.", cod_fonte_recurso = ".$cod_fonte_recurso.", ";
		$sql .= " cod_fonte_recurso_orcamento = ".$cod_fonte_recurso_orcamento.", dt_inicial = '".trim(DataBanco($dt_inicial))."', ";
		$sql .= " dt_final = '".trim(DataBanco($dt_final))."', dt_inauguracao_lancamento = ".$dt_inauguracao_lancamento.", ";
		$sql .= " nr_status_percentual_execucao = '".trim($nr_status_percentual_execucao)."', nr_processo_sei = '".trim($nr_processo_sei)."', ";
		$sql .= " txt_reporte_execucao = '".trim($txt_reporte_execucao)."', txt_entraves_riscos = '".trim($txt_entraves_riscos)."', ";
		$sql .= " txt_desburocratizacao = '".trim($txt_desburocratizacao)."', cod_orgao = ".$cod_orgao.", ";
		$sql .= " cod_usuario_responsavel = ".$cod_usuario_responsavel.", nr_tarefa = '".trim($nr_tarefa)."', ";
		$sql .= " nr_prazo = ".$nr_prazo.", cod_unidade_prazo = '".trim($cod_unidade_prazo)."'";
		$sql .= " WHERE cod_tarefa_atividade = ".$id;		
		
		//echo $sql;exit;

		pg_query($sql);	
		//Criar auditoria para atividades
		Auditoria(142, "", $sql);			
		js_go("listar_tarefa.php?id=". $idAtividadePlanoAcao . "&idPlanoAcao=".$idPlanoAcao);
	}


}


?>
      
