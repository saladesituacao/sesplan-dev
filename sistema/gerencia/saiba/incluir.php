<?php
include_once (__DIR__ . "/../../include/conexao.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(116);

?>

<div id="main" class="container-fluid">
    <h3 class="page-header">Saiba + > Incluir</h3>
    <form action="incluir_arquivo2.php" method="post" enctype="multipart/form-data" name="form1" id="form1">   
        <div class="row">
            <div class="col-md-4">                        
            </div>
            <div class="col-md-4">
                <center><label for="exampleInputEmail1">Documento:</label></center>    
                <select id="cod_tipo_documento" name="cod_tipo_documento" class="form-control">
                    <option></option>
                    <?php                        
                        $q = pg_query("SELECT cod_tipo_documento, txt_tipo_documento FROM tb_saiba_tipo WHERE cod_ativo = 1 ORDER BY txt_tipo_documento");
                        while ($row = pg_fetch_array($q)) 
                        { ?>
                            <option value="<?=$row["cod_tipo_documento"]?>"><?=$row["txt_tipo_documento"] ?></option>
                        <?php	
                        } ?>									
                </select>             
            </div>
        </div>   
        <br />
        <div class="row">
            <div class="col-md-4">                        
            </div>
            <div class="col-md-4">
                <center><label for="exampleInputEmail1">Arquivo:</label></center>    
                <input type="file" id="txt_arquivo" name="txt_arquivo" value="<? echo isset($txt_arquivo) ? $txt_arquivo : null; ?>" size="50" class="form-control" onchange="verificaExtensao(this)">
            </div>
        </div>          
        <br />
        <div class="row">
            <div class="col-md-4">                        
            </div>
            <div class="col-md-4">
                <center>
                    <button type="submit" id="btn_incluir" class="btn btn-primary" onclick="return ValidarIncluir();">Incluir</button>
                    <a href="default.php" class="btn btn-default">Voltar</a>
                </center>
            </div>
        </div><br />
        <div class="row">
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
                                <th class="actions">Ações</th>
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
                                    <td class="actions">									                                    
                                        <?php if (permissao_acesso(117)) { ?>
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
    </form>
</div>

<script src="manter.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>