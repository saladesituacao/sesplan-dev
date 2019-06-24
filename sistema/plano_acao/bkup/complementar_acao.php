<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
verifica_seguranca();
cabecalho();

$idPlanoAcao = isset($_REQUEST["idPlanoAcao"]) ? $_REQUEST["idPlanoAcao"] : null;

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;


$clsOrgao = new clsOrgao();
$clsUsuario = new clsUsuario();



if(!empty($id)) {
	permissao_acesso_pagina(102);

    $q1 = pg_query("SELECT tb_plano_acao.*, txt_secretaria, txt_programa_governo, txt_usuario FROM tb_plano_acao  
    INNER JOIN tb_secretaria ON tb_secretaria.cod_secretaria = tb_plano_acao.cod_secretaria
    INNER JOIN tb_programa_governo ON tb_programa_governo.cod_programa_governo = tb_plano_acao.cod_programa_governo 
    LEFT JOIN tb_usuario ON tb_usuario.cod_usuario = tb_plano_acao.cod_usuario_responsavel
    WHERE cod_plano_acao = ".$id);

    $rs1 = pg_fetch_array($q1);
    $cod_acao = trim($rs1['nr_acao']);
	$cod_secretaria = trim($rs1['cod_secretaria']);
	$cod_programa_governo = trim($rs1['cod_programa_governo']);
	$txt_projeto = trim($rs1['txt_projeto_acao']);
    $txt_escopo = trim($rs1['txt_escopo_atividade']);   
    $txt_secretaria = trim($rs1['txt_secretaria']);   
    $txt_programa_governo = trim($rs1['txt_programa_governo']); 
    $nr_valor = trim($rs1['nr_valor']); 
    $cod_fonte_recurso = trim($rs1['cod_fonte_recurso']); 
    $cod_fonte_recurso_orcamento = trim($rs1['cod_fonte_recurso_orcamento']); 
    $dt_inicial = FormataData(trim($rs1['dt_inicial'])); 
    $dt_final = FormataData(trim($rs1['dt_final'])); 
    $dt_inauguracao_lancamento = FormataData(trim($rs1['dt_inauguracao_lancamento'])); 
    $nr_status_percentual_execucao = trim($rs1['nr_status_percentual_execucao']); 
    $nr_processo_sei = trim($rs1['nr_processo_sei']); 
    $txt_reporte_execucao = trim($rs1['txt_reporte_execucao']); 
    $txt_entraves_riscos = trim($rs1['txt_entraves_riscos']); 
    $txt_desburocratizacao = trim($rs1['txt_desburocratizacao']); 
    $cod_orgao = trim($rs1['cod_orgao']); 
    $cod_usuario_responsavel = trim($rs1['cod_usuario_responsavel']); 
    $txt_usuario = trim($rs1['txt_usuario']);
}	

?>
<div id="main" class="container-fluid">
    
    <h3 class="page-header">Plano de Ação > Complementar Dados</h3>
    
    <form id="frm1" action="manter.php">
        <input type="hidden" name="id" id="id" value="<?php echo($id) ?>" />
        <input type="hidden" name="acao" id="acao" value="complementrar_acao" />
    
        
        <div class="row">
            <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Ação:</label>
                <input type="text" class="form-control" id="cod_acao" name="cod_acao" value="<?=$cod_acao?>" readonly="readonly">
            </div>
        </div>


        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Secretaria:</label>
                <input type="text" class="form-control" id="txt_secretaria" name="txt_secretaria" value="<?=$txt_secretaria?>" readonly="readonly">  
            </div>	  
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Programa:</label>
                <input type="text" class="form-control" id="txt_programa_governo" name="txt_programa_governo" value="<?=$txt_programa_governo?>" readonly="readonly">                  
            </div>	 
        </div> 

        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Projeto / Ação:</label>        
                <textarea class="form-control" rows="5" id="txt_projeto" name="txt_projeto" readonly="readonly"><?=$txt_projeto?></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Escopo (Atividade):</label>
                <textarea class="form-control" rows="5" id="txt_escopo" name="txt_escopo" readonly="readonly"><?=$txt_escopo?></textarea>
            </div>	 
        </div>   
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Usuário Responsável:</label>
                <input type="text" class="form-control" id="txt_usuario" name="txt_usuario" value="<?=$txt_usuario?>" readonly="readonly">                  
            </div>
        </div>
        <div class="row">
            
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Valor:</label>
                <input type="text" class="dinheiro form-control" id="nr_valor" name="nr_valor" placeholder="Obrigatório" value="<?=$nr_valor?>">
            </div>
            
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Fonte de Recurso:</label>
                <select id="cod_fonte_recurso" name="cod_fonte_recurso" class="chosen-select" data-placeholder="Obrigatório" onchange="fn_fonte_recurso(this.value);">
                    <option></option>                            
                    <?php                                                    
                    $sql = "SELECT cod_fonte_recurso, txt_fonte_recurso FROM tb_fonte_recurso ORDER BY txt_fonte_recurso";
                    $q = pg_query($sql);
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_fonte_recurso"]?>"<?php if ($cod_fonte_recurso == $row["cod_fonte_recurso"]) { echo("selected");}?>><?=$row["txt_fonte_recurso"] ?></option>
                    <?php	
                    } ?>
                </select>                
            </div>	  
            <div class="form-group col-md-4">                              
                <label for="exampleInputEmail1">Especificação:</label> 
                <div id="div_fonte_recurso"></div>                                
            </div>	 
        </div> 

        <div class="row">
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Data Inicial:</label>
                <div class='input-group date'>
                    <input type="text" class="form-control" id="dt_inicial" name='dt_inicial' autocomplete="off" value="<?=$dt_inicial?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>  
                </div>  
            </div>
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Data Final:</label>
                <div class='input-group date'>
                    <input type="text" class="form-control" id="dt_final" name='dt_final' autocomplete="off" value="<?=$dt_final?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>  
                </div>  
            </div>
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Data Inauguração/Lançamento:</label>
                <div class='input-group date'>
                    <input type="text" class="form-control" id="dt_inauguracao_lancamento" name='dt_inauguracao_lancamento' autocomplete="off" value="<?=$dt_inauguracao_lancamento?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>  
                </div>  
            </div>
        </div> 


         <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Status % Execução:</label>                
                <input type="text" class="form-control" id="nr_status_percentual_execucao" name="nr_status_percentual_execucao" value="<?=$nr_status_percentual_execucao?>">
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Processo SEI n°:</label>
                <input type="text" class="form-control" id="nr_processo_sei" name="nr_processo_sei" value="<?=$nr_processo_sei?>">
            </div>
        </div> 


        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Reporte / Execução:</label>        
                <textarea class="form-control" rows="5" id="txt_reporte_execucao" name="txt_reporte_execucao"><?=$txt_reporte_execucao?></textarea>
            </div>	 
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Entraves / Riscos:</label>        
                <textarea class="form-control" rows="5" id="txt_entraves_riscos" name="txt_entraves_riscos"><?=$txt_entraves_riscos?></textarea>
            </div>	 
        </div> 


        <div class="row">
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Desburocratização (Apoio Casa Civil):</label>        
                <textarea class="form-control" rows="5" id="txt_desburocratizacao" name="txt_desburocratizacao"><?=$txt_desburocratizacao?></textarea>
            </div>	              
        </div>           

        <div class="row">
            <div class="col-md-5">&nbsp;</div>
            <div class="col-md-6">                        
                <button type="button" id="btn_complementar" class="btn btn-primary">Salvar</button>  	  	
                <a href="listar_tarefa.php?id=<?php echo $id ?>" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>

<script type="text/javascript">
    $( function() {
        $( "#dt_inicial" ).datepicker();
        $( "#dt_final" ).datepicker();
        $( "#dt_inauguracao_lancamento" ).datepicker();        
    });     
</script>