<?php
include_once (__DIR__ . "/../../include/conexao.php");
verifica_seguranca();
cabecalho();

$id = $_REQUEST['id'];
$verificado = $_REQUEST['verificado'];

if (empty($verificado) && !empty($id)) {
    permissao_acesso_pagina(109);

    $q1 = pg_query("SELECT * FROM tb_mensagem WHERE cod_mensagem = '$id'");
	$rs1 = pg_fetch_array($q1);
	$cod_ativo = limpar_comparacao($rs1['cod_ativo']);
	$txt_titulo = $rs1['txt_titulo'];
    $txt_mensagem = $rs1['txt_mensagem'];
    $cod_tipo_mensagem = limpar_comparacao($rs1['cod_tipo_mensagem']);
    $cod_dia = limpar_comparacao($rs1['cod_dia']);
}
else {
    permissao_acesso_pagina(108);

    $cod_tipo_mensagem = $_REQUEST['cod_tipo_mensagem'];
    $cod_ativo = $_REQUEST['cod_ativo'];
    $txt_mensagem = $_REQUEST['txt_mensagem'];   
    $txt_titulo = $_REQUEST['txt_titulo'];   
    $cod_dia = $_REQUEST['cod_dia'];
    
    if(empty($verificado)) {
        $cod_ativo = 1;        
    }
}
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Modelo de Mensagem > Incluir</h3>
    <form id="frm1">
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="verificado" id="verificado" value="1" />
        <input type="hidden" name="acao" id="acao" value="" />
        <input type="hidden" name="status" id="status" value="<?=$_REQUEST['status']?>" />
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Tipo de Mensagem:</label>			
                <select id="cod_tipo_mensagem" name="cod_tipo_mensagem" class="form-control">
                    <option></option>
                    <?php $q = pg_query("SELECT cod_tipo_mensagem, txt_tipo_mensagem FROM tb_tipo_mensagem WHERE cod_ativo = 1 ORDER BY txt_tipo_mensagem");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_tipo_mensagem"]?>"<?php if ($cod_tipo_mensagem == $row["cod_tipo_mensagem"]) { echo("selected");}?>><?=$row["txt_tipo_mensagem"] ?></option>
                        <?php	
                        } ?>
                </select>
            </div><!--form-group-->	 
        </div><!--row-->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Título:</label>
                <input type="text" class="form-control" id="txt_titulo" name="txt_titulo" value="<?=$txt_titulo?>" placeholder="Obrigatório">
            </div><!--form-group-->
        </div><!--row-->   
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Mensagem:</label>			
                <textarea class="form-control" rows="5" id="txt_mensagem" name="txt_mensagem"><?=$rs1['txt_mensagem']?></textarea>
            </div><!--form-group-->	 
        </div><!--row-->             	
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Dias:</label>
                <input type="text" class="form-control" id="cod_dia" name='cod_dia' value="<?=$cod_dia?>" onkeypress="return isNumberKey(event)"/>			                
            </div><!--form-group-->
            <div class="form-group col-md-6">
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