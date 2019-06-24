<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(97);

if (empty($_REQUEST['log'])) {
	Auditoria(139, "Listar Planos de Ação", "");
}

$txt_pesquisa = isset($_REQUEST["txt_pesquisa"]) ? $_REQUEST["txt_pesquisa"] : null;
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
				<h2>Projeto/Ação</h2>
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
				<?php if (permissao_acesso(98)) { ?>
					<a href="incluir.php" class="btn btn-primary pull-right h2">Novo Plano de Ação</a>
				<?php } ?>							
			</div>
		</div> <!-- /#top -->
		<hr />
		<div id="list" class="row">
			<?php
			try {
				$condicao = " WHERE LOWER(pa.txt_projeto_acao) LIKE '%" .trim(strtolower($txt_pesquisa)). "%' "; 
				$condicao .= " OR LOWER(pa.nr_acao) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(pa.txt_escopo_atividade) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(s.txt_secretaria) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				$condicao .= " OR LOWER(pg.txt_programa_governo) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
			}	
			catch(Exception $e) {	
				$condicao = "";					
			}
			$q1 = pg_query("SELECT pa.*, s.txt_secretaria, pg.txt_programa_governo, u.txt_usuario, o.txt_sigla FROM tb_plano_acao pa
			INNER JOIN tb_secretaria s ON pa.cod_secretaria = s.cod_secretaria
			INNER JOIN tb_programa_governo pg ON pa.cod_programa_governo = pg.cod_programa_governo
			LEFT JOIN tb_usuario u ON pa.cod_usuario_responsavel = u.cod_usuario
			LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao " .$condicao. " ORDER BY pa.nr_acao ASC");
			if (pg_num_rows($q1) > 0) {
			?>
				<div class="table-responsive col-md-12">
					<table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>Ação</th>
								<th>Secretaria</th>
								<th>Plano de Ação</th>
								<th>Ação</th>
								<th>Atividade</th>
								<th>Data Inicial</th>
								<th>Data Final</th>
								<th>Usuário Responsável</th>
								<th>Área</th>
								<th>Habilitado</th>
								<th class="actions">Opções</th>
							</tr>
						</thead>					
						<tbody>
							<?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
								<tr>
									<td>
										<input type="button" id="btn_tarefa_<?php echo($rs1['cod_plano_acao']) ?>" onclick="fn_listar_tarefas(<?php echo($rs1['cod_plano_acao']) ?>);" class="btn btn-default" value="+" title='Exibir tarefas'/>										
										<input type="hidden" name="btn_tarefa_hidden_<?php echo($rs1['cod_plano_acao']) ?>" id="btn_tarefa_hidden_<?php echo($rs1['cod_plano_acao']) ?>" value="" />
										<?php echo($rs1['nr_acao']) ?>
									</td>
									<td><?php echo($rs1['txt_secretaria']) ?></td>
									<td><?php echo($rs1['txt_programa_governo']) ?></td>
									<td><?php echo($rs1['txt_projeto_acao']) ?></td>
									<td><?php echo($rs1['txt_escopo_atividade']) ?></td>
									<td><?php echo(FormataData($rs1['dt_inicial'])) ?></td>
									<td><?php echo(FormataData($rs1['dt_final'])) ?></td>
									<td><?php echo($rs1['txt_usuario']) ?></td>
									<td><?php echo($rs1['txt_sigla']) ?></td>
									<td><?php echo(destacar_habilitado($rs1['ind_habilitado'])) ?></td>
									<td class="actions">									
										<?php if (permissao_acesso(99) && $rs1['ind_habilitado'] == 'S') { ?>
											<a class="btn btn-warning btn-xs" href="incluir.php?id=<?php echo($rs1['cod_plano_acao']) ?>">Editar</a>
										<?php } ?>
										<?php if ($rs1['ind_habilitado'] == 'S'){?>
											<?php if (permissao_acesso(100)) { ?>	
												<a class="btn btn-danger btn-xs" onclick="return Desabilitar(<?php echo($rs1['cod_plano_acao']) ?>);" >Dasabilitar</a>
											<?php } ?>
										<?php }else{?>
											<?php if (permissao_acesso(101)) { ?>	
												<a class="btn btn-success btn-xs" onclick="return Habilitar(<?php echo($rs1['cod_plano_acao']) ?>);" >Habilitar</a>
											<?php } ?>
										<?php } ?>																																								
										<?php if (permissao_acesso(102) && $rs1['ind_habilitado'] == 'S') { ?>
											<a class="btn btn-info btn-xs" href="listar_tarefa.php?id=<?php echo($rs1['cod_plano_acao']) ?>">Tarefas</a>
										<?php } ?>										
									</td>
									<tr>
										<td>&nbsp;</td>
										<td colspan="9">
											<div id="div_tarefas_<?php echo($rs1['cod_plano_acao']) ?>"></div>
										</td>										
									</tr>
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
 </div><!-- /#main -->
 <script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>
      
