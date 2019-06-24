<?php
include_once (__DIR__ . "/../classes/clsIndicador.php");
include_once (__DIR__ . "/../classes/clsStatus.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");

$c_t = 0;

$clsIndicador = new clsIndicador();
$clsStatus = new clsStatus();
$clsUsuario = new clsUsuario();
$clsOrgao = new clsOrgao();

$condicao = " 1 = 1 ";
$condicao2 = " 1 = 1 ";

if (!empty($cod_orgao_array)) {
    $sql_orgao = "WITH RECURSIVE arvore AS ";
    $sql_orgao .= " (SELECT t1.cod_orgao, txt_sigla ";
    $sql_orgao .= " FROM tb_orgao AS t1 ";
    $sql_orgao .= " WHERE cod_orgao IN(".$cod_orgao_array.") ";
    $sql_orgao .= " UNION ALL SELECT t2.cod_orgao, t2.txt_sigla ";
    $sql_orgao .= " FROM tb_orgao AS t2 INNER JOIN arvore ON cod_orgao_superior = arvore.cod_orgao ) "; 
    $sql_orgao .= " SELECT arvore.cod_orgao, arvore.txt_sigla FROM arvore ORDER BY arvore.txt_sigla ";
    $q = pg_query($sql_orgao);
    while ($row = pg_fetch_array($q)) {
        $_cod_orgao .= "[" .$row['cod_orgao']. "]"; 
    }
    $_cod_orgao = str_replace('][', ',', $_cod_orgao);
    $_cod_orgao = str_replace(']', '', $_cod_orgao);
    $_cod_orgao = str_replace('[', '', $_cod_orgao);

    $condicao .= " AND ( ";
    $condicao .= " tb_indicador.cod_responsavel_tecnico IN (".$_cod_orgao.") OR ";
    $condicao .= " tb_indicador.cod_responsavel_tecnico_2 IN(".$_cod_orgao.") ) ";

    $condicao2 .= " AND ( ";
    $condicao2 .= " tb_indicador.cod_responsavel_tecnico IN (".$_cod_orgao.") OR ";
    $condicao2 .= " tb_indicador.cod_responsavel_tecnico_2 IN(".$_cod_orgao.") ) ";
}

if (!empty($cod_tag)) {
    foreach ($cod_tag as &$value) {        
        $_cod_tag .= "['".$value."']";
    }
    $_cod_tag = str_replace('][', ',', $_cod_tag);
    $_cod_tag = str_replace(']', '', $_cod_tag);
    $_cod_tag = str_replace('[', '', $_cod_tag);

    $condicao .= " AND tb_indicador.cod_indicador IN (SELECT co_indicador FROM tb_indicador_tag WHERE ";
    $condicao .= " tb_indicador_tag.ds_tag IN (".$_cod_tag.")) "; 
    
    $condicao2 .= " AND tb_indicador.cod_indicador IN (SELECT co_indicador FROM tb_indicador_tag WHERE ";
    $condicao2 .= " tb_indicador_tag.ds_tag IN (".$_cod_tag.")) "; 
}

if (!empty($_cod_eixo_array)) {
    $condicao .= " AND tb_indicador.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_eixo IN(".$_cod_eixo_array.")) ";    
    $condicao2 .= " AND tb_indicador.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_eixo IN(".$_cod_eixo_array.")) ";    
}
if (!empty($_cod_perspectiva_array)) {
    $condicao .= " AND tb_indicador.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_perspectiva IN(".$_cod_perspectiva_array.")) ";    
    $condicao2 .= " AND tb_indicador.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_perspectiva IN(".$_cod_perspectiva_array.")) ";    
}
if (!empty($_cod_diretriz_array)) {
    $condicao .= " AND tb_indicador.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_diretriz IN(".$_cod_diretriz_array.")) ";    
    $condicao2 .= " AND tb_indicador.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_diretriz IN(".$_cod_diretriz_array.")) ";    
}
if (!empty($_cod_objetivo_array)) {
    $condicao .= " AND tb_indicador.cod_objetivo IN(".$_cod_objetivo_array.") ";
    $condicao2 .= " AND tb_indicador.cod_objetivo IN(".$_cod_objetivo_array.") ";
}

$sql = "SELECT cod_chave, cod_indicador, ds_periodicidade FROM tb_indicador ";
$sql .= " INNER JOIN tb_indicador_tag ON tb_indicador_tag.co_indicador = tb_indicador.cod_indicador ";
$sql .= " WHERE EXTRACT(YEAR from tb_indicador.dt_inclusao) = ".$_SESSION['ano_corrente'];
$sql .= " AND ". $condicao;
$sql .= " GROUP BY cod_chave, cod_indicador, ds_periodicidade ";
//$sql .= " LIMIT 1 ";
//echo(fn_owner($sql));
$q1 = pg_query($sql);
if (pg_num_rows($q1) > 0) {
    $c = 0;
    while ($r = pg_fetch_array($q1)) {        
        $cod_mes_monitoramento = $clsIndicador->MesMonitoramentoPainel($r['ds_periodicidade']);                        
        if ($cod_mes_monitoramento != "") {
            if (intval($cod_mes_monitoramento) <= intval($_SESSION['mes_corrente'])) {
                $condicao_periodo = " AND tb_indicador_analise.cod_periodo = ".$cod_mes_monitoramento;

                if (!empty($cod_status_array)) {
                    $condicao .= " AND tb_indicador_analise.cod_status IN (".$cod_status_array.")";
                    $cod_status_array2 = explode(",", trim($cod_status_array));
                }                                

                $campo = " tb_indicador.cod_chave, tb_indicador.cod_indicador, tb_indicador.cod_objetivo, ";
                $campo .= " tb_indicador_analise.cod_usuario, codigo_eixo, txt_eixo, codigo_perspectiva, txt_perspectiva, ";
                $campo .= " codigo_diretriz, txt_diretriz, (SELECT DISTINCT ds_periodicidade FROM tb_indicador_tag WHERE co_indicador = tb_indicador.cod_indicador) AS ds_periodicidade, ";
                $campo .= " tb_indicador_analise.cod_status ";            

                $sql = "SELECT ".$campo;
                $sql .= " FROM tb_indicador INNER JOIN tb_indicador_analise ON tb_indicador_analise.cod_chave = tb_indicador.cod_chave ";
                $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
                $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
                $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
                $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
                $sql .= " WHERE ".$condicao.$condicao_periodo. " AND tb_indicador_analise.cod_chave = ".$r['cod_chave'];
                
                if (@in_array("24", $cod_status_array2) || empty($cod_status_array)) {
                    $campo = str_replace("tb_indicador_analise.cod_usuario", "NULL", $campo);
                    $campo = str_replace("tb_indicador_analise.cod_status", "24", $campo);

                    $sql .= " UNION ";

                    $sql .= "SELECT ".$campo;
                    $sql .= " FROM tb_indicador ";
                    $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo ";
                    $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
                    $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
                    $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
                    $sql .= " WHERE tb_indicador.cod_chave NOT IN(SELECT u.cod_chave FROM tb_indicador_analise u ";
                    $sql .= " WHERE u.cod_periodo = ".$cod_mes_monitoramento.") ";
                    $sql .= " AND ".$condicao2." AND tb_indicador.cod_chave = ".$r['cod_chave'];
                }
                //$sql .= " LIMIT 1 ";
                //echo(fn_owner($sql));
                //echo("<br />");              
                $q = pg_query($sql);
                if ($c_t == 0) {
                ?>
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>                                                                    
                                <th><div id='div_total_ind_painel'></div></th>
                            </tr>                                                            
                        </thead>    
                    </table>
                <?php
                    $c_t = $c_t + 1;
                }

                if (pg_num_rows($q) > 0) {
                    $ct = 0;
                    while ($row = pg_fetch_array($q)) {                   
                        $sql = "SELECT codigo_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_objetivo = ".$row['cod_objetivo'];                
                        $rs = pg_fetch_array(pg_query($sql));

                        $txt_ultimo_status = $clsStatus->RetornaStatus($row['cod_status']);			
                        $txt_cor = $clsStatus->RetornaCorStatus($row['cod_status']);
                        ?>   
                        <?php if ($ct > 0) { ?>
                            <hr /> <?php 
                        } ?>
                        <div class="row">         
                            <div class="col-md-12" align="left">
                                <strong><?php echo($rs['codigo_objetivo']) ?>  <?php echo($rs['txt_objetivo']) ?></strong><br />
                                <?php echo($row['txt_descricao_meta']) ?>.<br />
                                <?php
                                $sql = "SELECT ds_titulo FROM tb_indicador_tag WHERE co_indicador = '".$row['cod_indicador']."'";
                                $q_ind = pg_query($sql);
                                if (pg_num_rows($q_ind) > 0) {
                                    $rs_ind = pg_fetch_array($q_ind);
                                    echo($rs_ind['ds_titulo']);
                                    //echo($row['cod_chave']);
                                }   
                                ?>
                            </div>             
                        </div> <br /> 
                        <div class="row">   
                            <div class="col-md-4" align="left">                
                                <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_eixo']) ?>"><?php echo($row['codigo_eixo']) ?></a>&nbsp;
                                <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_perspectiva']) ?>"><?php echo($row['codigo_perspectiva']) ?></a>&nbsp;
                                <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_diretriz']) ?>"><?php echo($row['codigo_diretriz']) ?></a>&nbsp;
                                
                                <?php
                                //INSTRUMENTOS DE PLANEJAMENTO
                                $sql = "SELECT ds_tag FROM tb_indicador_tag WHERE co_indicador = '".$row['cod_indicador']."'";
                                $q_tag = pg_query($sql);
                                if (pg_num_rows($q_tag) > 0) { ?>
                                    <br /> <?php
                                    while ($rs_tag = pg_fetch_array($q_tag)) { ?>
                                        <a class="btn_painel btn-primary btn-xs" disabled="disabled"><?php echo($rs_tag['ds_tag']) ?></a>&nbsp;
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-md-3" align="left">
                                <strong><?php echo($clsUsuario->ConsultaUsuarioId($row['cod_usuario'])) ?></strong>
                            </div>
                            <div class="col-md-2" align="left">   
                                <?php if (strval($row['cod_status']) == "24") { ?>
                                    <input type="text" class="form-control" name="txt_ultimo_status" style="background-color:<?php echo($txt_cor) ?>;" value="<?php echo($txt_ultimo_status) ?>" title="<?php echo($txt_ultimo_status) ?>" disabled="disabled">
                                <?php } else { ?>
                                    <input type="text" class="form-control_custom" name="txt_ultimo_status" style="background-color:<?php echo($txt_cor) ?>;" value="<?php echo($txt_ultimo_status) ?>" title="<?php echo($txt_ultimo_status) ?>" disabled="disabled">
                                <?php } ?>
                            </div>
                            <div class="col-md-3" align="left">  
                                <?php
                                if (!empty($row['cod_responsavel_tecnico'])) {
                                ?>
                                    <?php echo($clsOrgao->RetornaSigla($row['cod_responsavel_tecnico'])) ?>
                                <?php
                                }  
                                if (!empty($row['cod_responsavel_tecnico_2'])) { 
                                ?>
                                    <?php echo($clsOrgao->RetornaSigla($row['cod_responsavel_tecnico_2'])) ?>
                                <?php
                                }  
                                ?>          
                            </div>
                        </div>
                        <div class="row"> 
                            &nbsp;
                        </div>                        
                        <?php                    
                        $ct += 1;
                        $c = $c + 1;
                    }
                }
            }             
        }        
    }
    if ($c == 0) {       
        ?>       
            <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
        <?php
    }
} else {
    $c = 0;
    ?>       
        <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
    <?php
}
?>
<script>
    $(document).ready(function() {    
        $('#div_total_ind_painel').html('<strong>Total: <?php echo($c) ?></strong>'); 
    });
</script>