<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
verifica_seguranca();
cabecalho();

$idPlanoAcao = isset($_REQUEST["idPlanoAcao"]) ? $_REQUEST["idPlanoAcao"] : null;
$idAtividadePlanoAcao = isset($_REQUEST["idAtividadePlanoAcao"]) ? $_REQUEST["idAtividadePlanoAcao"] : null;




$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;


$clsOrgao = new clsOrgao();
$clsUsuario = new clsUsuario();



if(!empty($id)) {
	permissao_acesso_pagina(98);

    $q1 = pg_query("SELECT * FROM tb_tarefa_atividade WHERE cod_tarefa_atividade = '$id'");
    $rs1 = pg_fetch_array($q1);

    $nr_tarefa = trim($rs1['nr_tarefa']);
    $txt_tarefa = trim($rs1['txt_tarefa']);

    $nr_prazo = trim($rs1['nr_prazo']);
    $cod_unidade_prazo = trim($rs1['cod_unidade_prazo']);
    

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
}	
else 
{
	permissao_acesso_pagina(99);
}

if ($nr_valor == '0.00'){
    $nr_valor = '0,00';
}

?>
<div id="main" class="container-fluid">
    <?php if(empty($id)) {
    ?>
        <h3 class="page-header">Tarefa > Incluir</h3>
    <?php
    } 
    else {
    ?>
        <h3 class="page-header">Tarefa > Alterar</h3>
    <?php
    }
    ?>   
    <form id="frm1" action="manter_tarefa.php">
        <input type="hidden" name="id" id="id" value="<?php echo($id) ?>" />
        <input type="hidden" name="idPlanoAcao" id="idPlanoAcao" value="<?php echo($idPlanoAcao) ?>" />
        <input type="hidden" name="idAtividadePlanoAcao" id="idAtividadePlanoAcao" value="<?php echo($idAtividadePlanoAcao) ?>" />
        <?php if(empty($id)) {
        ?>
            <input type="hidden" name="acao" id="acao" value="incluir" />
        <?php
        } 
        else {
        ?>
            <input type="hidden" name="acao" id="acao" value="alterar" />
        <?php
        }
        ?>   
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Nome/Número da Tarefa:</label>
                <input type="text" class="form-control" id="nr_tarefa" name="nr_tarefa" placeholder="Obrigatório" value="<?=$nr_tarefa?>">
            </div>
        </div>
 
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Escopo (Tarefa):</label>
                <textarea class="form-control" rows="5" id="txt_tarefa" name="txt_tarefa" placeholder="Obrigatório"><?=$txt_tarefa?></textarea>
            </div>	 
            
        </div>   

        <div class="row">
            
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Valor:</label>
                <input type="text" class="form-control" id="nr_valor" name="nr_valor" onkeypress="return isNumberKey(event)" value="<?=$nr_valor?>">
            </div>
            
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Fonte de Recurso:</label>
                <select id="cod_fonte_recurso" name="cod_fonte_recurso" class="chosen-select" data-placeholder="Fonte de Recurso" onchange="fn_fonte_recurso(this.value);">
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
            <div class="form-group col-md-1">
                <label for="exampleInputEmail1">Prazo:</label>                
                <input type="text" class="form-control" id="nr_prazo" name="nr_prazo" onKeyPress="mask(this,'000',1, event)"  value="<?=$nr_prazo?>">
            </div>
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Unidade:</label>                
                <select id="cod_unidade_prazo" name="cod_unidade_prazo" class="chosen-select" data-placeholder="Unidade">
                    <option></option>                            
                    <?php                                                    
                    $sql = "SELECT cod_unidade_prazo, txt_unidade_prazo FROM tb_unidade_prazo";
                    $q = pg_query($sql);
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_unidade_prazo"]?>"<?php if ($cod_unidade_prazo == $row["cod_unidade_prazo"]) { echo("selected");}?>><?=$row["txt_unidade_prazo"] ?></option>
                    <?php	
                    } ?>
                </select>    
            </div>
            <div class="form-group col-md-3">
                <label for="exampleInputEmail1">Data Inicial:</label>
                <div class='input-group date'>
                    <input type="text" class="form-control" id="dt_inicial" name='dt_inicial' autocomplete="off" value="<?=$dt_inicial?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>  
                </div>  
            </div>
            <div class="form-group col-md-3">
                <label for="exampleInputEmail1">Data Final:</label>
                <div class='input-group date'>
                    <input type="text" class="form-control" id="dt_final" name='dt_final' autocomplete="off" value="<?=$dt_final?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>  
                </div>  
            </div>
            <div class="form-group col-md-3">
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
                <input type="text" class="form-control" id="nr_status_percentual_execucao" name="nr_status_percentual_execucao"  onKeyPress="mask(this,'000',1, event)" value="<?=$nr_status_percentual_execucao?>">
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Processo SEI n°:</label>
                <input type="text" class="form-control" id="nr_processo_sei" name="nr_processo_sei" onKeyPress="mask(this,'00000-00000000/0000-00',1, event)"  value="<?=$nr_processo_sei?>">
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
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Lotação:</label>                            
                <select id="cod_orgao" name="cod_orgao" class="chosen-select" data-placeholder="Obrigatório" onchange="fn_usuario_orgao(this.value);">
                    <option></option>                            
                    <?php                                                    
                    $sql = "cod_ativo = 1 ORDER BY txt_sigla";
                    $q = $clsOrgao->ListarOrgao($sql);
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_orgao"]?>"<?php if ($cod_orgao == $row["cod_orgao"]) { echo("selected");}?>><?=$row["txt_sigla"] ?></option>
                    <?php	
                    } ?>
                </select>
            </div>              
            <div class="form-group col-md-4">
                <label for="exampleInputEmail1">Usuário Responsável:</label>
                <div id="div_usuario"></div>                                                                                  
            </div>




        </div>   

 
        

        <div class="row">
            <div class="col-md-5">&nbsp;</div>
            <div class="col-md-6">                        
                <?php if(empty($id)) {
                ?>
                    <button type="button" id="btn_incluir" class="btn btn-primary">Incluir</button>
                <?php
                } 
                else {
                ?>
                    <button type="button" id="btn_salvar" class="btn btn-primary">Salvar</button>
                <?php
                }
                ?>                  	  	
                <a href="listar_tarefa.php?id=<?php echo $idAtividadePlanoAcao ?> &idPlanoAcao=<?php echo $idPlanoAcao ?>" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>
</div>
<script src="manter_tarefa.js" type="text/javascript"></script>
<script src="recurso.js" type="text/javascript"></script>
<script src="usuario.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>

<script type="text/javascript">
  $( function() {
    $( "#dt_inicial" ).datepicker();
    $( "#dt_final" ).datepicker();
    $( "#dt_inauguracao_lancamento" ).datepicker();
  });


  $(document).ready(function() {        
        if ($("#cod_orgao").val() != '') {
            fn_usuario_orgao($("#cod_orgao").val()); 
            $("#cod_usuario_responsavel").val('<?php echo($cod_usuario_responsavel) ?>');
        }    
        if ($("#cod_fonte_recurso").val() != '') {
            fn_fonte_recurso($("#cod_fonte_recurso").val()); 
            $("#cod_fonte_recurso_orcamento").val('<?php echo($cod_fonte_recurso_orcamento) ?>');
        }           
    });  
</script>