<?php
include_once (__DIR__ . "/../../../include/conexao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(118);

if (empty($_REQUEST['log'])) {    
	Auditoria(160, "Listar Tipos de Documentos", "");
}
?>

<div id="main" class="container" style="margin-top: 50px">  
    <form id="frm1"> 
        <input type="hidden" name="log" id="log" value="1" />       
        <div class="row">
            <div class="col-md-12">
                <h3>Tipos de Documentos</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1">
                <?php if (permissao_acesso(119)) { ?>
                    <a href="incluir.php" class="btn btn-primary pull-right h2">Incluir</a>
                <?php } ?>							
            </div>            
        </div>
        <br /> 
        <div class="row">
            <div class="col-md-12">
                <?php
                $sql = "SELECT * FROM tb_saiba_tipo ORDER BY txt_tipo_documento";               
                $q1 = pg_query($sql);  
                if (pg_num_rows($q1) > 0) {              
                ?>
                    <div class="table-responsive col-md-12">
                        <table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Documento</th>								                                    
                                    <th>Ativo</th>
                                    <th class="actions">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php												
                                while ($rs1 = pg_fetch_array($q1)) {
                                ?>
                                    <tr>
                                        <td><?php echo($rs1['cod_tipo_documento']) ?></td>
                                        <td><?php echo($rs1['txt_tipo_documento']) ?></td>				                                        				
                                        <td><?php echo(destacar_ativo($rs1['cod_ativo'])) ?></td>                                    
                                        <td class="actions">
                                            <?php if (permissao_acesso(120)) { ?>
                                                <a class="btn btn-warning btn-xs" href="incluir.php?id=<?php echo($rs1['cod_tipo_documento']) ?>">Editar</a>
                                            <?php } ?>
                                            <?php if (permissao_acesso(121)) { ?>
                                                <a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rs1['cod_tipo_documento']) ?>);" >Excluir</a>
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
                ?>
            </div> 
        </div> 
        <div class="row">            
            <div class="col-md-4">
                <a href="../default.php" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>
</div>
<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>