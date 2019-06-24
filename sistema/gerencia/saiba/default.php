<?php
include_once (__DIR__ . "/../../include/conexao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(115);

if (empty($_REQUEST['log'])) {    
	Auditoria(157, "Listar Ciclo do Planejamento", "");
}

?>

<div id="main" class="container" style="margin-top: 50px">    
    <form id="frm1"> 
        <input type="hidden" name="log" id="log" value="1" />       
        <div class="row">
            <div class="col-md-12">
                <h3>Saiba +</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?php if (permissao_acesso(116)) { ?>
                    <a href="incluir.php" class="btn btn-primary pull-right h2">Incluir Arquivos</a>
                <?php } ?>							
            </div>
            <div class="col-md-2">
                <?php if (permissao_acesso(118)) { ?>
                    <a href="tipo_documento/default.php" class="btn btn-primary pull-right h2">Tipos de Documentos</a>
                <?php } ?>		
            </div>
        </div>
        <br />  
        <div class="row">
            <div class="col-md-12">                
                <?php
                $sql = "SELECT tb_saiba.*, txt_usuario, txt_tipo_documento FROM tb_saiba ";
                $sql .= " INNER JOIN tb_usuario ON tb_usuario.cod_usuario = tb_saiba.cod_usuario ";
                $sql .= " INNER JOIN tb_saiba_tipo ON tb_saiba_tipo.cod_tipo_documento = tb_saiba.cod_tipo_documento ";
                $sql .= " ORDER BY txt_tipo_documento";
                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) {
                ?>
                    <div class="table-responsive col-md-12">
                        <table id="dtBasicExample" class="table table-striped" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Arquivo</th>
                                    <th>Usuário</th>
                                    <th>Inclusão</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php												
                                while ($rs1 = pg_fetch_array($q1)) {
                                ?>
                                    <tr>
                                        <td><?php echo($rs1['txt_tipo_documento']) ?></td>
                                        <td>
                                            <a href="ver_arquivo.php?cod_tipo_documento=<?php echo($rs1['cod_tipo_documento']) ?>">
                                                <?php echo(substr($rs1['txt_arquivo'], 35)) ?>
                                            </a>
                                        </td>
                                        <td><?php echo($rs1['txt_usuario']) ?></td>
                                        <td><?php echo(formatarDataBrasil($rs1['dt_inclusao'])) ?></td>                                    
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
    </form>      
</div>

<?php
rodape($dbcon);
?>