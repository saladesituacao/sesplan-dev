<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(102);

if (empty($_REQUEST['log'])) {
	Auditoria(140, "Listar Tarefas Plano de Ação", "");
}

$txt_pesquisa = isset($_REQUEST["txt_pesquisa"]) ? $_REQUEST["txt_pesquisa"] : null;
$idPlanoAcao = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
?>
<script>
	jQuery(function($) {
		$('#dtBasicExample').DataTable();
	});
</script>
 <div id="main" class="container-fluid" style="margin-top: 50px">
	<form id="frm1">  
		<input type="hidden" name="log" id="log" value="1" />
		<div id="top" class="row">
			<div class="col-sm-3">
				<h2>Plano de Ação > Tarefas</h2>
			</div>
			<div class="col-sm-6">
				
				<div class="input-group h2">
					<input name="txt_pesquisa" class="form-control" id="txt_pesquisa" type="text" placeholder="Pesquisar" value="<?=$txt_pesquisa?>">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" onclick="frm1.submit();">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
				</div>
				
			</div>
			<div class="col-sm-3">							
				<?php if (permissao_acesso(102)) { ?>
					<a href="incluir_tarefa.php?idPlanoAcao=<?php echo $idPlanoAcao ?>" class="btn btn-primary pull-right h2">Nova Tarefa</a>
				<?php } ?>											
			</div>
		</div> <!-- /#top -->
		<br />
		<div class="row">
			<?php
			$q1 = pg_query("SELECT pa.*, s.txt_secretaria, pg.txt_programa_governo, u.txt_usuario, o.txt_sigla FROM tb_plano_acao pa
			INNER JOIN tb_secretaria s ON pa.cod_secretaria = s.cod_secretaria
			INNER JOIN tb_programa_governo pg ON pa.cod_programa_governo = pg.cod_programa_governo
			LEFT JOIN tb_usuario u ON pa.cod_usuario_responsavel = u.cod_usuario
			LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao WHERE pa.cod_plano_acao = ".$idPlanoAcao." ORDER BY pa.nr_acao ASC");
			$rs1 = pg_fetch_array($q1)			
			?>
			<div class="col-md-12">
				<div class="col-md-1">
					<label for="exampleInputEmail1">Ação:</label>
					<?php echo($rs1['nr_acao']); ?>
				</div>
				<div class="col-md-2">
					<label for="exampleInputEmail1">Secretaria:</label>
					<?php echo($rs1['txt_secretaria']); ?>
				</div>
				<div class="col-md-2">
					<label for="exampleInputEmail1">Programa:</label>
					<?php echo($rs1['txt_programa_governo']); ?>
				</div>
				<div class="col-md-2">
					<label for="exampleInputEmail1">Projeto/Ação:</label>
					<?php echo($rs1['txt_projeto_acao']); ?>
				</div>
				<div class="actions col-md-1">
					<?php if (permissao_acesso(102)) { ?>
						<a class="btn btn-warning btn-xs" href="complementar_acao.php?id=<?php echo($idPlanoAcao) ?>">Complementar Plano de Ação</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<hr />
		<div id="list" class="row">
			<?php
			try {
				$condicao = " AND LOWER(tpa.txt_escopo_tarefa) LIKE '%" .trim(strtolower($txt_pesquisa)). "%' "; 
				
			}	
			catch(Exception $e) {	
				$condicao = "";					
			}
			$q1 = pg_query("SELECT tpa.*, u.txt_usuario, o.txt_sigla FROM tb_tarefa_plano_acao tpa
			INNER JOIN tb_plano_acao pa ON tpa.cod_plano_acao = pa.cod_plano_acao
			LEFT JOIN tb_fonte_recurso_orcamento fro ON tpa.cod_fonte_recurso_orcamento = fro.cod_fonte_recurso_orcamento
			LEFT JOIN tb_usuario u ON tpa.cod_usuario_responsavel = u.cod_usuario
			LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao WHERE tpa.cod_plano_acao=" . $idPlanoAcao .$condicao. " ORDER BY tpa.cod_tarefa_plano_acao ASC");
			
			
			if (pg_num_rows($q1) > 0) {
			?>
				<div class="table-responsive col-md-12">
					<table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>Tarefa</th>
								<th>Escopo (Tarefa)</th>
								<th>Valor</th>
								<th>Fonte</th>
								<th>Data Inicial</th>
								<th>Data Final</th>
								<th>Data Inauguração</th>
								<th>Status % Execução</th>
								<th>Processo SEI n°</th>
								<th>Reporte / Execução</th>
								<th>Entraves / Riscos</th>
								<th>Desburocratização (Apoio Casa Civil)</th>
								<th>Usuário Responsável</th>
								<th>Área</th>
								<th>Ativo</th>
								<th class="actions">Opções</th>
							</tr>
						</thead>					
						<tbody>
							<?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
								<tr>
									<td title="<?php echo($rs1['txt_tarefa'])?>"><?php echo(limitarTexto($rs1['txt_tarefa'],10))?></td>
									<td title="<?php echo($rs1['txt_escopo_tarefa'])?>"><?php echo(limitarTexto($rs1['txt_escopo_tarefa'],50))?></td>
									<td><?php echo($rs1['nr_valor']) ?></td>
									<td><?php echo($rs1['cod_fonte_recurso_orcamento']) ?></td>
									<td><?php echo(FormataData($rs1['dt_inicial'])) ?></td>
									<td><?php echo(FormataData($rs1['dt_final'])) ?></td>
									<td><?php echo(FormataData($rs1['dt_inauguracao_lancamento'])) ?></td>
									<td><?php echo($rs1['nr_status_percentual_execucao']) ?></td>
									
									<td><?php echo($rs1['nr_processo_sei']) ?></td>
									<td title="<?php echo($rs1['txt_reporte_execucao'])?>"><?php echo(limitarTexto($rs1['txt_reporte_execucao'],50))?></td>
									<td title="<?php echo($rs1['txt_entraves_riscos'])?>"><?php echo(limitarTexto($rs1['txt_entraves_riscos'],50))?></td>
									<td title="<?php echo($rs1['txt_desburocratizacao'])?>"><?php echo(limitarTexto($rs1['txt_desburocratizacao'],50))?></td>


									<td><?php echo($rs1['txt_usuario']) ?></td>
									<td><?php echo($rs1['txt_sigla']) ?></td>
									<td><?php echo(destacar_habilitado($rs1['ind_habilitado'])) ?></td>
									<td class="actions">									
										<?php if (permissao_acesso(102)) { ?>
											<a class="btn btn-warning btn-xs" href="incluir_tarefa.php?id=<?php echo($rs1['cod_tarefa_plano_acao']) ?>&idPlanoAcao=<?php echo($idPlanoAcao) ?>">Editar</a>
										<?php } ?>
										<?php if (permissao_acesso(102)) { ?>											
											<?php if ($rs1['ind_habilitado'] == 'S'){?>
												<a class="btn btn-danger btn-xs" onclick="return Desabilitar(<?php echo($rs1['cod_tarefa_plano_acao']) ?>, <?php echo($rs1['cod_plano_acao']) ?>);" >Dasabilitar</a>
											<?php }else{?>
												<a class="btn btn-success btn-xs" onclick="return Habilitar(<?php echo($rs1['cod_tarefa_plano_acao']) ?>, <?php echo($rs1['cod_plano_acao']) ?>);" >Habilitar</a>
											<?php } ?>
										<?php } ?>

									</td>
								</tr>		
							<?php
							}
							?>											
						</tbody>
					</table>
				</div>
			<?php
			}
			else {
			?>
				<hr>
				<center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
			<?php
			}
			?>			
		</div><!-- /#list -->		
	 </form>
	 <center><a href="default.php" class="btn btn-default">Voltar</a></center>
 </div><!-- /#main -->
 <script src="manter_tarefa.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>
      
