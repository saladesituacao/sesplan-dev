<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	$id = $_REQUEST['id'];
	$idPlanoAcao = $_REQUEST['idPlanoAcao'];
	
	$txt_escopo_tarefa = trim($_REQUEST['txt_escopo_tarefa']);
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
	$txt_tarefa = trim($_REQUEST['txt_tarefa']);
	


	if($acao == "incluir_tarefa")
	{		
		if($erro == "") 
		{			
			$q=pg_query("SELECT txt_tarefa FROM tb_tarefa_plano_acao WHERE ind_habilitado = 'S' AND cod_plano_acao = $idPlanoAcao AND LOWER(txt_tarefa)='".trim(strtolower($txt_tarefa))."'");
			if (pg_num_rows($q) > 0) {
				$erro = "TAREFA já está cadastrada para esta ação.";
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
				
				$sql = "INSERT INTO tb_tarefa_plano_acao(cod_plano_acao, txt_escopo_tarefa, dt_inicial, dt_final, nr_valor, cod_fonte_recurso_orcamento, dt_inauguracao_lancamento, 
				nr_status_percentual_execucao, nr_processo_sei, txt_reporte_execucao, txt_entraves_riscos, txt_desburocratizacao, cod_usuario_responsavel, cod_usuario, txt_tarefa, cod_fonte_recurso, cod_orgao, dt_atualizacao) ";
				$sql .= " VALUES (".$idPlanoAcao.", '".trim($txt_escopo_tarefa)."', '".trim(DataBanco($dt_inicial))."', '".trim(DataBanco($dt_final))."', ".$nr_valor.", ".trim($cod_fonte_recurso_orcamento).",   
				".$dt_inauguracao_lancamento.", '".trim($nr_status_percentual_execucao)."', '".trim($nr_processo_sei)."', '".trim($txt_reporte_execucao)."', '".trim($txt_entraves_riscos)."',  '".trim($txt_desburocratizacao)."',  ".trim($cod_usuario_responsavel).", ".$_SESSION['cod_usuario'].", '".trim($txt_tarefa)."',  ".trim($cod_fonte_recurso).",  ".trim($cod_orgao).", CURRENT_TIMESTAMP)";				
				
				//echo $sql; exit; 
				pg_query($sql);
				Auditoria(141, "", $sql);
				js_go("listar_tarefa.php?id=".$idPlanoAcao);
			}
		}					
	}	
	
	else if($acao == "desabilitar")
	{
		$cod_tarefa_plano_acao = isset($_REQUEST["cod_tarefa_plano_acao"]) ? $_REQUEST["cod_tarefa_plano_acao"] : null;

		
		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_escopo_tarefa FROM tb_tarefa_plano_acao WHERE cod_tarefa_plano_acao = ".$cod_tarefa_plano_acao));        

			$sql = "UPDATE tb_tarefa_plano_acao SET ind_habilitado = 'N' WHERE cod_tarefa_plano_acao = '$cod_tarefa_plano_acao'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(144, "DESABILITAR TAREFA: ".$rs['txt_escopo_tarefa'], $sql);

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
	
	else if($acao == "fn_usuario_orgao") 
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
	
	else if($acao == "fn_fonte_recurso")
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

	else if($acao == "habilitar")
	{
		$cod_tarefa_plano_acao = isset($_REQUEST["cod_tarefa_plano_acao"]) ? $_REQUEST["cod_tarefa_plano_acao"] : null;
		
		if($erro == "") {
			$rs=pg_fetch_array(pg_query("SELECT txt_escopo_tarefa FROM tb_tarefa_plano_acao WHERE cod_tarefa_plano_acao = ".$cod_tarefa_plano_acao));        

			$sql = "UPDATE tb_tarefa_plano_acao SET ind_habilitado = 'S' WHERE cod_tarefa_plano_acao = '$cod_tarefa_plano_acao'";
			$resultado = pg_query($sql);
			if($resultado)
			{
				Auditoria(143, "HABILITAR TAREFA: ".$rs['txt_escopo_tarefa'], $sql);

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

	else if ($acao == "alterar_tarefa") {
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

		$sql = "UPDATE tb_tarefa_plano_acao SET txt_escopo_tarefa = '".$txt_escopo_tarefa."', nr_valor = ".$nr_valor.", cod_fonte_recurso = ".$cod_fonte_recurso.", ";
		$sql .= " cod_fonte_recurso_orcamento = ".$cod_fonte_recurso_orcamento.", dt_inicial = '".trim(DataBanco($dt_inicial))."', ";
		$sql .= " dt_final = '".trim(DataBanco($dt_final))."', dt_inauguracao_lancamento = ".$dt_inauguracao_lancamento.", ";
		$sql .= " nr_status_percentual_execucao = '".trim($nr_status_percentual_execucao)."', nr_processo_sei = '".trim($nr_processo_sei)."', ";
		$sql .= " txt_reporte_execucao = '".trim($txt_reporte_execucao)."', txt_entraves_riscos = '".trim($txt_entraves_riscos)."', ";
		$sql .= " txt_desburocratizacao = '".trim($txt_desburocratizacao)."', cod_orgao = ".$cod_orgao.", ";
		$sql .= " cod_usuario_responsavel = ".$cod_usuario_responsavel.", txt_tarefa = '".trim($txt_tarefa)."'";
		$sql .= " WHERE cod_tarefa_plano_acao = ".$id;		
		
		pg_query($sql);	
		Auditoria(142, "", $sql);			
		js_go("listar_tarefa.php?id=".$idPlanoAcao);
	}


}


?>
      
