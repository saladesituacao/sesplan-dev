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
	$txt_escopo = trim($_REQUEST['txt_escopo']);
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
				$sql = "INSERT INTO tb_plano_acao(nr_acao, cod_secretaria, cod_programa_governo, txt_projeto_acao, txt_escopo_atividade, cod_usuario, dt_atualizacao, cod_orgao, cod_usuario_responsavel) ";
				$sql .= " VALUES ('".$cod_acao."', ".$cod_secretaria.", ".$cod_programa_governo.", '".trim($txt_projeto)."', '".trim($txt_escopo)."', ".$_SESSION['cod_usuario'].", CURRENT_TIMESTAMP, ".$cod_orgao.", ".$cod_usuario_responsavel.")";				
				pg_query($sql);
				Auditoria(137, "", $sql);
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
				$sql = "UPDATE tb_plano_acao SET nr_acao = '".$cod_acao."', cod_secretaria = ".$cod_secretaria.", ";
				$sql .= " cod_programa_governo = ".$cod_programa_governo.", txt_projeto_acao = '".trim($txt_projeto)."', ";
				$sql .= " txt_escopo_atividade = '".trim($txt_escopo)."', cod_usuario = ".$_SESSION['cod_usuario'].", ";
				$sql .= " cod_orgao = ".$cod_orgao.", cod_usuario_responsavel = ".$cod_usuario_responsavel." WHERE cod_plano_acao = ".$id;
				pg_query($sql);
				Auditoria(138, "", $sql);
				js_go("default.php");
			}
		}	
	}
	else if($acao == "desabilitar")
	{
		$cod_plano_acao = isset($_REQUEST["cod_plano_acao"]) ? $_REQUEST["cod_plano_acao"] : null;

		$q=pg_query("SELECT * FROM tb_tarefa_plano_acao WHERE ind_habilitado = 'S' AND cod_plano_acao = " .$cod_plano_acao . " LIMIT 1");
		$rs=pg_fetch_array($q);
		if (pg_num_rows($q) > 0) {
			$erro = "Plano de Ação não pode ser desabilitado. Pois, está vinculada a tarefa ". $rs['txt_escopo_tareda'] .".";
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

	else if($acao == "fn_usuario_orgao") {
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

	else if($acao == "fn_fonte_recurso") {
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

	else if ($acao == "complementrar_acao") {
		$nr_valor = str_replace('.', '', $nr_valor);
		$nr_valor = str_replace(',', '.', $nr_valor);

		$sql = "UPDATE tb_plano_acao SET nr_valor = '".$nr_valor."', cod_fonte_recurso = ".$cod_fonte_recurso.", ";
		$sql .= " cod_fonte_recurso_orcamento = ".$cod_fonte_recurso_orcamento.", dt_inicial = '".trim(DataBanco($dt_inicial))."', ";
		$sql .= " dt_final = '".trim(DataBanco($dt_final))."', dt_inauguracao_lancamento = '".trim(DataBanco($dt_inauguracao_lancamento))."', ";
		$sql .= " nr_status_percentual_execucao = '".trim($nr_status_percentual_execucao)."', nr_processo_sei = '".trim($nr_processo_sei)."', ";
		$sql .= " txt_reporte_execucao = '".trim($txt_reporte_execucao)."', txt_entraves_riscos = '".trim($txt_entraves_riscos)."', ";
		$sql .= " txt_desburocratizacao = '".trim($txt_desburocratizacao)."' ";
		$sql .= " WHERE cod_plano_acao = ".$id;		
		pg_query($sql);	
		Auditoria(138, "", $sql);			
		js_go("listar_tarefa.php?id=".$id);
	}

	else if ($acao == "fn_listar_tarefas") {
		$query = pg_query("SELECT tpa.txt_tarefa, tpa.txt_escopo_tarefa, tpa.nr_valor, tpa.cod_fonte_recurso_orcamento, 
		TO_CHAR(tpa.dt_inicial, 'DD/MM/YYYY') AS dt_inicial, TO_CHAR(tpa.dt_final, 'DD/MM/YYYY') AS dt_final, 
		TO_CHAR(tpa.dt_inauguracao_lancamento, 'DD/MM/YYYY') AS dt_inauguracao_lancamento, tpa.nr_status_percentual_execucao,
		tpa.nr_processo_sei,tpa.txt_reporte_execucao,tpa.txt_entraves_riscos,tpa.txt_desburocratizacao,
		u.txt_usuario, o.txt_sigla, CASE WHEN tpa.ind_habilitado = 'S' THEN 'SIM' WHEN tpa.ind_habilitado = 'N' THEN 'NÃO' END AS ind_habilitado 
		FROM tb_tarefa_plano_acao tpa
		INNER JOIN tb_plano_acao pa ON tpa.cod_plano_acao = pa.cod_plano_acao
		INNER JOIN tb_fonte_recurso_orcamento fro ON tpa.cod_fonte_recurso_orcamento = fro.cod_fonte_recurso_orcamento
		LEFT JOIN tb_usuario u ON tpa.cod_usuario_responsavel = u.cod_usuario
		LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao WHERE tpa.cod_plano_acao= ".$_REQUEST['cod_plano_acao']." ORDER BY tpa.cod_tarefa_plano_acao ASC");		
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
      
