<?php
include_once (__DIR__ . "/../include/conexao.php");
include_once (__DIR__ . "/../classes/clsSag.php");

verifica_seguranca();
cabecalho();
permissao_acesso_pagina(80);

if (empty($_REQUEST['log'])) {
    Auditoria(120, "Listar Período de Atualização SAG", "");
}

?>

<div id="main" class="container-fluid" style="margin-top: 50px">
    <form id="frm1">
        <input type="hidden" name="log" id="log" value="1" />
        <input type="hidden" name="acao" id="acao" value="incluir_periodo_atualizacao" />
        <div id="top" class="row">
            <div class="col-sm-12">
                <h2>SAG > Período de Atualização</h2>
            </div>			
        </div> <!-- /#top -->
        <br />
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
                                <option value="<?=$row["cod_ano"]?>"><?=$row["cod_ano"] ?></option>
                            <?php	
                            } ?>									
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="exampleInputEmail1">Data Início:</label> 
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type="text" class="form-control" id="dt_inicio" name='dt_inicio' autocomplete="off" value="<?=$dt_inicio?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>  
                        </div>                                           
                    </div>                    
                </div>
                <div class="col-md-4">
                    <label for="exampleInputEmail1">Data Fim:</label>
                    <div class="form-group">
                        <div class='input-group date' >
                            <input type='text' class="form-control" id='dt_fim' name='dt_fim' autocomplete="off" value="<?=$dt_fim?>" placeholder='DD/MM/AAAA' onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>                                                                              
            </div>        
            <br />
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="btn_salvar" class="btn btn-primary" onclick="return Salvar();">Salvar</button>                    
                </div><!--col-md-12-->         
            </div>            
        </div>   
        <br />
        <div class="row">
            <?php         
            $sql = "SELECT tbip.*, tbu.txt_usuario ";
            $sql .= " FROM tb_sag_periodo tbip ";
            $sql .= " INNER JOIN tb_usuario tbu ON tbu.cod_usuario = tbip.cod_usuario ";            
            $sql .= " ORDER BY tbip.cod_ano DESC";
            $q1 = pg_query($sql);
            if (pg_num_rows($q1) > 0) {
            ?>
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Competência</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>								
                                <th>Usuário</th>                                
                                <th>&nbsp;</th>
                            </tr>                        
                        </thead>
                        <tbody>
                            <?php												
							while ($rs1 = pg_fetch_array($q1)) {
							?>
                                <tr>
                                    <td><?php echo($rs1['cod_ano']); ?></td>
                                    <td><?php echo(FormataData($rs1['dt_inicio'])); ?></td>
                                    <td><?php echo(FormataData($rs1['dt_fim'])); ?></td>                                    
                                    <td><?php echo($rs1['txt_usuario']); ?></td>                                           
                                    <td class="actions">                                                                      
                                        <a class="btn btn-danger btn-xs" onclick="return Excluir(<?php echo($rs1['cod_periodo']) ?>);" >Excluir</a>                                        
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
<script src="periodo.js" type="text/javascript"></script>
<?php
rodape($dbcon);
?>