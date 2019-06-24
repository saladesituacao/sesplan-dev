<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
verifica_seguranca();
cabecalho();
permissao_acesso_pagina(97);

if (empty($_REQUEST['log'])) {
	Auditoria(139, "Listar Planos de Ação", "");
}

$clsUsuario = new clsUsuario();
$clsUsuario->cod_usuario = $_SESSION["cod_usuario"];

$txt_pesquisa = isset($_REQUEST["txt_pesquisa"]) ? $_REQUEST["txt_pesquisa"] : null;
?>
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
				if (!empty($txt_pesquisa)) {
					$condicao = " AND LOWER(pa.txt_projeto_acao) LIKE '%" .trim(strtolower($txt_pesquisa)). "%' "; 
					$condicao .= " OR LOWER(pa.nr_acao) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
					$condicao .= " OR LOWER(pa.txt_escopo_atividade) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
					$condicao .= " OR LOWER(ob.txt_objetivo) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
					$condicao .= " OR LOWER(s.txt_secretaria) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
					$condicao .= " OR LOWER(pg.txt_programa_governo) LIKE '%" .trim(strtolower($txt_pesquisa)). "%'";
				}				
			}	
			catch(Exception $e) {	
				$condicao = "";					
			}

			//PERFIL ADMINISTRADOR PODE VER TUDO DE QUALQUER ÁREA
			if (limpar_comparacao($_SESSION['cod_perfil']) != 1) {
				$condicao .= " AND pg.cod_programa_governo IN (SELECT t.cod_programa_governo FROM tb_programa_governo_orgao t
				WHERE t.cod_orgao IN(".$clsUsuario->RetornaUnidadesUsuario().")) ";
			}

			$sql = "SELECT pa.*, s.txt_secretaria, pg.txt_programa_governo, u.txt_usuario, o.txt_sigla, ob.txt_objetivo 
			FROM tb_plano_acao pa
			INNER JOIN tb_secretaria s ON pa.cod_secretaria = s.cod_secretaria
			INNER JOIN tb_programa_governo pg ON pa.cod_programa_governo = pg.cod_programa_governo
			LEFT JOIN tb_objetivo ob ON ob.cod_objetivo = pa.cod_objetivo
			LEFT JOIN tb_usuario u ON pa.cod_usuario_responsavel = u.cod_usuario
			LEFT JOIN tb_orgao o ON u.cod_orgao = o.cod_orgao WHERE 1 = 1 " .$condicao. " ORDER BY pa.nr_acao ASC";
			//echo($sql);
			$q1 = pg_query($sql);
			if (pg_num_rows($q1) > 0) {
			?>
				<div class="table-responsive col-md-12">
					<table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>N.º da Ação</th>
								<th>Ação</th>
								<th>Secretaria</th>
								<th>Programa</th>
								<th>Estratégia Vinculada</th>
								<th>Objetivo</th>
								
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
										<input type="button" id="btn_atividade_<?php echo($rs1['cod_plano_acao']) ?>" onclick="fn_listar_atividades(<?php echo($rs1['cod_plano_acao']) ?>);" class="btn btn-default" value="+" title='Exibir atividades'/>
										<input type="hidden" name="btn_atividade_hidden_<?php echo($rs1['cod_plano_acao']) ?>" id="btn_atividade_hidden_<?php echo($rs1['cod_plano_acao']) ?>" value="" />
											
										<?php echo($rs1['nr_acao']) ?>
										
									</td>
									
									<td><?php echo($rs1['txt_projeto_acao']) ?></td>
									<td><?php echo($rs1['txt_secretaria']) ?></td>
									<td><?php echo($rs1['txt_programa_governo']) ?></td>
									
									<td><?php 
									$q2 = pg_query( 
									"SELECT txt_estrategia 
									FROM 
									tb_estrategia_vinculada ev
									INNER JOIN tb_plano_acao_estrategia_vinculada paev
										ON ev.cod_estrategia = paev.cod_estrategia
									INNER JOIN tb_plano_acao pa
										ON paev.cod_plano_acao = pa.cod_plano_acao
									WHERE  pa.cod_plano_acao = 
										" .$rs1['cod_plano_acao']);
									
									if (pg_num_rows($q2) > 0) {

										while ($rs2 = pg_fetch_array($q2)) {
											
											echo $rs2['txt_estrategia'] . " <BR> ";

										}
									}
										?>
									</td>


									<td>	<?php 
											if ($rs1['txt_objetivo'] != ''){
												echo($rs1['txt_objetivo']) ;
											}else{
												echo ('Sem objetivo vinculado');
											}
											?>
									</td>
									
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
											<a class="btn btn-info btn-xs" href="listar_atividade.php?id=<?php echo($rs1['cod_plano_acao']) ?>">Atividades</a>
										<?php } ?>										
									</td>									
								</tr>	
								<tr>									
									<td colspan="7">
										<div id="div_atividades_<?php echo($rs1['cod_plano_acao']) ?>"></div>
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
 </div><!-- /#main -->
 <script src="manter.js" type="text/javascript"></script>
 <script src="manter_atividade_tarefa.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>
      
