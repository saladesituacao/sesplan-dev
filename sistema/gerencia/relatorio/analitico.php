<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../include/auditoria.php");

verifica_seguranca();
cabecalho();

if (empty($_REQUEST['log'])) {
	Auditoria(164, "Acessar Relatório Analítico", "");
}
 
?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Relatórios > Analítico</h3>
    <form id="frm1" method="post" action="resultado_analitico.php">
        <input type="hidden" name="log" id="log" value="1" />   
        <div align="center">
            <div class="row">
                <div class="col-md-4">  
                    <label for="exampleInputEmail1">Competência:</label>
                    <select id="cod_ano" name="cod_ano" class="chosen-select" data-placeholder="Obrigatório">
                        <option></option>
                        <?php                        
                            $q = pg_query("SELECT * FROM tb_ano ORDER BY cod_ano");
                            while ($row = pg_fetch_array($q)) 
                            { ?>
                                <option value="<?=$row["cod_ano"]?>" <?php
                                if (strval($_SESSION['ano_corrente']) == strval($row["cod_ano"])) {
                                    echo("selected");
                                }
                                ?>><?=$row["cod_ano"] ?></option>                                
                            <?php	
                            } ?>									
                    </select>
                </div>
            </div>
            <br />
            <div class="row">                
                <div class="col-md-6"> 
                    <label for="exampleInputEmail1">Eixo:</label>
                    <select id="cod_eixo" name="cod_eixo" class="chosen-select" data-placeholder="Eixo">
                        <option></option>
                        <?php $q = pg_query("SELECT cod_eixo, txt_eixo FROM tb_eixo WHERE cod_ativo = 1 ORDER BY txt_eixo");
                            while ($row = pg_fetch_array($q)) 
                            { ?>
                                <option value="<?=$row["cod_eixo"]?>"<?php if ($cod_eixo == $row["cod_eixo"]) { echo("selected");}?>><?=$row["txt_eixo"] ?></option>
                            <?php	
                            } ?>									
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Perspectiva:</label>                
                    <select id="cod_perspectiva" name="cod_perspectiva" class="chosen-select" data-placeholder="Perspectiva">
                        <option></option>
                        <?php                        
                        $q = pg_query("SELECT cod_perspectiva, txt_perspectiva FROM tb_perspectiva WHERE cod_ativo = 1 ORDER BY txt_perspectiva");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_perspectiva"]?>"<?php if ($cod_perspectiva == $row["cod_perspectiva"]) { echo("selected");}?>><?=$row["txt_perspectiva"] ?></option>
                        <?php	
                        } ?>									
                    </select>
                </div>
            </div> 
            <br />
            <div class="row">
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Diretriz:</label>                
                    <select id="cod_diretriz" name="cod_diretriz" class="chosen-select" data-placeholder="Diretriz">
                        <option></option>
                        <?php                            
                            $q = pg_query("SELECT cod_diretriz, txt_diretriz FROM tb_diretriz WHERE cod_ativo = 1 ORDER BY txt_diretriz");
                            while ($row = pg_fetch_array($q)) 
                            { ?>
                                <option value="<?=$row["cod_diretriz"]?>"<?php if ($cod_diretriz == $row["cod_diretriz"]) { echo("selected");}?>><?=$row["txt_diretriz"] ?></option>
                            <?php	
                            } ?>									
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Objetivo:</label>                
                    <select id="cod_objetivo" name="cod_objetivo" class="chosen-select" data-placeholder="Objetivo">
                        <option></option>
                        <?php                            
                            $q = pg_query("SELECT cod_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_ativo = 1 ORDER BY txt_objetivo");
                            while ($row = pg_fetch_array($q)) 
                            { ?>
                                <option value="<?=$row["cod_objetivo"]?>"<?php if ($cod_objetivo == $row["cod_objetivo"]) { echo("selected");}?>><?=$row["txt_objetivo"] ?></option>
                            <?php	
                            } ?>									
                    </select>
                </div>
            </div>
            <br />            
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="btn_pesquisar" name="acao" value="pesquisar" class="btn btn-primary">Pesquisar</button>
                    <a href="analitico.php" class="btn btn-default">Limpar</a>
                </div><!--col-md-12-->
            </div><!--row-->
        </div>        
    </form>
</div>

<?php
rodape($dbcon);
?>