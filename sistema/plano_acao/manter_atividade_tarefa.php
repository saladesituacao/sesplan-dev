<?php
include_once (__DIR__ . "/../include/conexao.php");

if(isset($_REQUEST["acao"]))
{	
	$acao = utf8_decode($_REQUEST["acao"]);
	$retorno = array();
	$erro = "";

	

	if ($acao == "fn_listar_atividades") {
		$sql = " SELECT apa.cod_atividade_plano_acao, apa.nr_atividade, apa.txt_atividade, apa.nr_prazo, up.txt_unidade_prazo, apa.nr_valor, apa.cod_fonte_recurso_orcamento, ";
		$sql .= " TO_CHAR(apa.dt_inicial, 'DD/MM/YYYY') AS dt_inicial, TO_CHAR(apa.dt_final, 'DD/MM/YYYY') AS dt_final, ";
		$sql .= " TO_CHAR(apa.dt_inauguracao_lancamento, 'DD/MM/YYYY') AS dt_inauguracao_lancamento, apa.nr_status_percentual_execucao, ";
		$sql .= " apa.nr_processo_sei,apa.txt_reporte_execucao,apa.txt_entraves_riscos,apa.txt_desburocratizacao, ";
		$sql .= " u.txt_usuario, o.txt_sigla, CASE WHEN apa.ind_habilitado = 'S' THEN 'SIM' WHEN apa.ind_habilitado = 'N' THEN 'NÃO' END AS ind_habilitado ";
		$sql .= " FROM tb_atividade_plano_acao apa ";
		$sql .= " INNER JOIN tb_plano_acao pa ON apa.cod_plano_acao = pa.cod_plano_acao ";
		$sql .= " INNER JOIN tb_fonte_recurso_orcamento fro ON apa.cod_fonte_recurso_orcamento = fro.cod_fonte_recurso_orcamento ";
		$sql .= " LEFT JOIN tb_unidade_prazo up ON apa.cod_unidade_prazo = up.cod_unidade_prazo ";
		$sql .= " LEFT JOIN tb_usuario u ON apa.cod_usuario_responsavel = u.cod_usuario ";
		$sql .= " LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao WHERE apa.cod_plano_acao= ".$_REQUEST['cod_plano_acao']." ORDER BY apa.cod_atividade_plano_acao ASC ";
		$query = pg_query($sql);		

		$arr = array();
		if(pg_num_rows($query) > 0) {
			while($row = pg_fetch_assoc($query)) {
				$arr[] = $row;            
			} 
		}                
		echo(json_encode($arr));
	}


	else if ($acao == "fn_listar_tarefas") {
		$query = pg_query("SELECT ta.cod_tarefa_atividade, ta.nr_tarefa, ta.txt_tarefa, ta.nr_prazo, up.txt_unidade_prazo, ta.nr_valor, ta.cod_fonte_recurso_orcamento, 
		TO_CHAR(ta.dt_inicial, 'DD/MM/YYYY') AS dt_inicial, TO_CHAR(ta.dt_final, 'DD/MM/YYYY') AS dt_final, 
		TO_CHAR(ta.dt_inauguracao_lancamento, 'DD/MM/YYYY') AS dt_inauguracao_lancamento, ta.nr_status_percentual_execucao,
		ta.nr_processo_sei,ta.txt_reporte_execucao,ta.txt_entraves_riscos,ta.txt_desburocratizacao,
		u.txt_usuario, o.txt_sigla, up.txt_unidade_prazo, CASE WHEN ta.ind_habilitado = 'S' THEN 'SIM' WHEN ta.ind_habilitado = 'N' THEN 'NÃO' END AS ind_habilitado 
		FROM tb_tarefa_atividade ta
		INNER JOIN tb_atividade_plano_acao apa ON ta.cod_atividade_plano_acao = apa.cod_atividade_plano_acao
		INNER JOIN tb_fonte_recurso_orcamento fro ON ta.cod_fonte_recurso_orcamento = fro.cod_fonte_recurso_orcamento
		LEFT JOIN tb_unidade_prazo up ON ta.cod_unidade_prazo = up.cod_unidade_prazo
		LEFT JOIN tb_usuario u ON ta.cod_usuario_responsavel = u.cod_usuario
		LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao WHERE ta.cod_atividade_plano_acao= ".$_REQUEST['cod_atividade_plano_acao']." ORDER BY ta.cod_tarefa_atividade ASC");		
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
      
