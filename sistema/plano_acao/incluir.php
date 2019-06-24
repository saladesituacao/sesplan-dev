<?php
include_once (__DIR__ . "/../include/conexao.php");



verifica_seguranca();
cabecalho();

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;

if(!empty($id)) {
	permissao_acesso_pagina(98);

    $q1 = pg_query("SELECT * FROM tb_plano_acao WHERE cod_plano_acao = '$id'");
    $rs1 = pg_fetch_array($q1);
    $cod_acao = trim($rs1['nr_acao']);
	$cod_secretaria = trim($rs1['cod_secretaria']);
	$cod_programa_governo = trim($rs1['cod_programa_governo']);
    $txt_projeto = trim($rs1['txt_projeto_acao']);
    $cod_objetivo = trim($rs1['cod_objetivo']);

    $arr_cod_estrategia = array();
    $q1 = pg_query("SELECT cod_estrategia FROM tb_plano_acao_estrategia_vinculada WHERE cod_plano_acao = '$id'");    
    while ($rs1 = pg_fetch_array($q1)) {        
        array_push($arr_cod_estrategia, trim($rs1['cod_estrategia']));
    }             
}	
else 
{
	permissao_acesso_pagina(99);
}

?>
<div id="main" class="container-fluid">
    <?php if(empty($id)) {
    ?>
        <h3 class="page-header">Plano de Ação> Incluir</h3>
    <?php
    } 
    else {
    ?>
        <h3 class="page-header">Plano de Ação > Alterar</h3>
    <?php
    }
    ?>   
    <form id="frm1" action="manter.php">
        <input type="hidden" name="id" id="id" value="<?php echo($id) ?>" />
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
                <label for="exampleInputEmail1">Objetivo:</label>
                <select id="cod_objetivo" name="cod_objetivo" data-placeholder="OBJETIVO" class="chosen-select">
                    <option></option>
                    <?php                        
                    $q = pg_query("SELECT cod_objetivo, txt_objetivo, codigo_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ORDER BY codigo_objetivo");
                    while ($row = pg_fetch_array($q)) 
                    { ?>
                        <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["codigo_objetivo"] ?> - <?=$row["txt_objetivo"] ?></option>
                    <?php	
                    } ?>
                </select>  
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">N.º da Ação:</label>
                <input type="text" class="form-control" id="cod_acao" name="cod_acao" placeholder="Obrigatório" onkeypress="return isNumberKey(event)" value="<?=$cod_acao?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Secretaria:</label>
                <select id="cod_secretaria" name="cod_secretaria" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_secretaria, txt_secretaria FROM tb_secretaria WHERE cod_ativo = 1 ORDER BY txt_secretaria");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_secretaria"]?>"<?php if ($cod_secretaria == $row["cod_secretaria"]) { echo("selected");}?>><?=$row["txt_secretaria"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>	  
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Programa:</label>
                <select id="cod_programa_governo" name="cod_programa_governo" class="chosen-select" data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_programa_governo, txt_programa_governo FROM tb_programa_governo WHERE cod_ativo = 1 ORDER BY txt_programa_governo");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_programa_governo"]?>"<?php if ($cod_programa_governo == $row["cod_programa_governo"]) { echo("selected");}?>><?=$row["txt_programa_governo"] ?></option>
                        <?php	
                        } ?>									
                </select>
            </div>	 
        </div> 
 
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Projeto / Ação:</label>        
                <textarea class="form-control" rows="5" id="txt_projeto" name="txt_projeto" placeholder="Obrigatório"><?=$txt_projeto?></textarea>
            </div>
        </div>   

        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Estratégia Vinculada:</label>        
                <select id="cod_estrategia" name="cod_estrategia[]" class="chosen-select" multiple data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_estrategia, txt_estrategia FROM tb_estrategia_vinculada WHERE cod_ativo = 1 ORDER BY txt_estrategia");
                        while ($row = pg_fetch_array($q)) 
                        {                             
                            if(in_array(strval($row['cod_estrategia']), $arr_cod_estrategia)) {
                                $selected = 'selected';
                            } 
                        ?>
                            <option value="<?=$row["cod_estrategia"]?>"<?php echo($selected); ?>><?=$row["txt_estrategia"] ?></option>
                        <?php	
                            $selected = "";
                        } ?>									
                </select>
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
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>