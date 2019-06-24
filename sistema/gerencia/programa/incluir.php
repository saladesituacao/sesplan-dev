<?php
include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(112);

    $q1 = pg_query("SELECT * FROM tb_programa_governo WHERE cod_programa_governo = '$id'");
	$rs1 = pg_fetch_array($q1);
	$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
	$txt_programa_governo = $rs1['txt_programa_governo'];
    $txt_descricao = $rs1['txt_descricao'];
    
    $arr_cod_orgao = array();
    $q1 = pg_query("SELECT cod_orgao FROM tb_programa_governo_orgao WHERE cod_programa_governo = '$id'");    
    while ($rs1 = pg_fetch_array($q1)) {        
        array_push($arr_cod_orgao, trim($rs1['cod_orgao']));
    }  
}
else {
    permissao_acesso_pagina(104);

    $cod_ativo = $_REQUEST['cod_ativo'];
    $txt_descricao = $_REQUEST['txt_descricao'];   
    $txt_programa_governo = $_REQUEST['txt_programa_governo'];   
    
    if(empty($verificado)) {
        $cod_ativo = 1;        
    }
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Programa > Incluir</h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="status" id="status" value="<?=$_REQUEST['status']?>" />
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Programa:</label>
                <input type="text" class="form-control" id="txt_programa_governo" name="txt_programa_governo" value="<?=$txt_programa_governo?>" placeholder="Obrigatório">
            </div><!--form-group-->
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Descrição:</label>			
                <textarea class="form-control" rows="5" id="txt_descricao" name="txt_descricao"><?=$rs1['txt_descricao']?></textarea>
            </div><!--form-group-->	 
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Área Responsável:</label>        
                <select id="cod_orgao" name="cod_orgao[]" class="chosen-select" multiple data-placeholder="Obrigatório">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_orgao, txt_sigla FROM tb_orgao WHERE cod_ativo = 1 ORDER BY txt_sigla");
                        while ($row = pg_fetch_array($q)) 
                        {                             
                            if(in_array(strval($row['cod_orgao']), $arr_cod_orgao)) {
                                $selected = 'selected';
                            } 
                        ?>
                            <option value="<?=$row["cod_orgao"]?>"<?php echo($selected); ?>><?=$row["txt_sigla"] ?></option>
                        <?php	
                            $selected = "";
                        } ?>									
                </select>
            </div>
        </div>   	
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Ativo:</label>			
                <select id="cod_ativo" name="cod_ativo" class="form-control">
                    <option value="1" <?php
                                        if ($cod_ativo == 1) {
                                            echo("selected");
                                        }
                                        ?>>SIM</option>			
                    <option value="0"<?php
                                        if ($cod_ativo == 0) {
                                            echo("selected");
                                        }
                                        ?>>NÃO</option>
                </select>
            </div><!--form-group-->	 
        </div><!--row-->
        <div class="row">
            <div class="col-md-12">
                <?php if(empty($id)) {
                ?>
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                <?php
                } 
                else {
                ?>
                    <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return ValidarAlterar();">Salvar</button>
                <?php
                }
                ?>  	  	
                <a href="default.php" class="btn btn-default">Voltar</a>
            </div><!--col-md-12-->
        </div><!--row-->
    </form>
</div><!--main-->

<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>