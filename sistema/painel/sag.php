<?php
include_once (__DIR__ . "/../classes/clsSag.php");
include_once (__DIR__ . "/../classes/clsStatus.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");

$clsSag = new clsSag();
$clsStatus = new clsStatus();
$clsUsuario = new clsUsuario();
$clsOrgao = new clsOrgao();

$tabela = "";
//$condicao = " 1 = 1 AND tb_sag_analise.cod_bimestre = (SELECT MAX(j.cod_bimestre) FROM tb_sag_analise j WHERE j.cod_sag = tb_sag.cod_sag) ";
$condicao = " 1 = 1 AND tb_sag_analise.cod_bimestre = ".$_SESSION['cod_bimestre_corrente']; //$clsSag->MesMonitoramentoPainel();
$condicao .= " AND EXTRACT(YEAR from tb_sag.dt_inclusao) = ".$_SESSION['ano_corrente'];
$condicao2 = " 1 = 1 AND tb_sag.cod_sag NOT IN(SELECT cod_sag FROM tb_sag_analise WHERE cod_bimestre = ".$_SESSION['cod_bimestre_corrente'].")";
$condicao2 .= " AND EXTRACT(YEAR from tb_sag.dt_inclusao) = ".$_SESSION['ano_corrente'];

if (!empty($cod_status_array)) {
    $condicao .= " AND tb_sag_analise.cod_status IN (".$cod_status_array.")";
    $condicao2 .= " AND tb_sag_analise.cod_status IN (".$cod_status_array.")";
    $cod_status_array2 = explode(",", trim($cod_status_array));    
}

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

    $condicao .= " AND tb_sag.cod_orgao IN (".$_cod_orgao.") ";
    $condicao2 .= " AND tb_sag.cod_orgao IN (".$_cod_orgao.") ";
}

if (!empty($cod_progr)) {
    foreach ($cod_progr as &$value) {        
        $_cod_progr .= "['".$value."']";
    }
    $_cod_progr = str_replace('][', ',', $_cod_progr);
    $_cod_progr = str_replace(']', '', $_cod_progr);
    $_cod_progr = str_replace('[', '', $_cod_progr);

    $condicao .= " AND tb_sag.cod_programa_trabalho IN (".$_cod_progr.") ";
    $condicao2 .= " AND tb_sag.cod_programa_trabalho IN (".$_cod_progr.") ";
}
if (!empty($cod_etapa_sag)) {
    foreach ($cod_etapa_sag as &$value) {        
        $_cod_etapa_sag .= "['".$value."']";
    }
    $_cod_etapa_sag = str_replace('][', ',', $_cod_etapa_sag);
    $_cod_etapa_sag = str_replace(']', '', $_cod_etapa_sag);
    $_cod_etapa_sag = str_replace('[', '', $_cod_etapa_sag);

    $condicao .= " AND tb_sag.cod_sag IN (".$_cod_etapa_sag.") ";
    $condicao2 .= " AND tb_sag.cod_sag IN (".$_cod_etapa_sag.") ";
}

if (!empty($btn_emenda_parlamentar)) {
    $condicao .= " AND tb_programa_trabalho.cod_emenda = ".$btn_emenda_parlamentar;
    $condicao2 .= " AND tb_programa_trabalho.cod_emenda = ".$btn_emenda_parlamentar;
} else {
    $condicao .= " AND tb_programa_trabalho.cod_emenda IN (0,1)";
    $condicao2 .= " AND tb_programa_trabalho.cod_emenda IN (0,1)";
}
if (!empty($_cod_eixo_array)) {
    $condicao .= " AND tb_sag.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_eixo IN(".$_cod_eixo_array.")) ";    
    $condicao2 .= " AND tb_sag.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_eixo IN(".$_cod_eixo_array.")) ";
}
if (!empty($_cod_perspectiva_array)) {
    $condicao .= " AND tb_sag.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_perspectiva IN(".$_cod_perspectiva_array.")) ";    
    $condicao2 .= " AND tb_sag.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_perspectiva IN(".$_cod_perspectiva_array.")) ";    
}
if (!empty($_cod_diretriz_array)) {
    $condicao .= " AND tb_sag.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_diretriz IN(".$_cod_diretriz_array.")) ";    
    $condicao2 .= " AND tb_sag.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_diretriz IN(".$_cod_diretriz_array.")) ";    
}
if (!empty($_cod_objetivo_array)) {
    $condicao .= " AND tb_sag.cod_objetivo IN(".$_cod_objetivo_array.") ";
    $condicao2 .= " AND tb_sag.cod_objetivo IN(".$_cod_objetivo_array.") ";
}

$campo = " tb_sag.*, tb_sag_analise.cod_usuario, codigo_eixo, txt_eixo, codigo_perspectiva, txt_perspectiva, ";
$campo .= " codigo_diretriz, txt_diretriz, nr_programa_trabalho, cod_emenda ";

$sql = "SELECT ".$campo;
$sql .= " FROM tb_sag INNER JOIN tb_sag_analise ON tb_sag_analise.cod_sag = tb_sag.cod_sag ";
$sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_programa_trabalho = tb_sag.cod_programa_trabalho ";
$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " WHERE ".$condicao;

if (@in_array("24", $cod_status_array2) || empty($cod_status_array)) {       
    $sql .= " UNION ";

    $sql .= "SELECT ".$campo;
    $sql .= " FROM tb_sag LEFT JOIN tb_sag_analise ON tb_sag_analise.cod_sag = tb_sag.cod_sag ";
    $sql .= " INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_programa_trabalho = tb_sag.cod_programa_trabalho ";
    $sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_sag.cod_objetivo ";
    $sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
    $sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
    $sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
    $sql .= " WHERE ".$condicao2;
    
    $sql = str_replace("AND tb_sag_analise.cod_status IN (24)", "", $sql);
    $sql = str_replace("tb_sag_analise.cod_status IN (24)", "", $sql);
    $sql = str_replace(",24", "", $sql);    
}

$q = pg_query($sql);
/*
$sql = str_replace("tb_", "SESPLAN.tb_", $sql);
$sql = str_replace("tab_", "SESPLAN.tab_", $sql);
echo($sql);
*/
?>
<table class="table table-striped" cellspacing="0" cellpadding="0">
    <thead>
        <tr>                                                                    
            <th><div id='div_total_sag_painel'></div></th>                                                                        
        </tr>                                                            
    </thead>    
</table>
<?php
$ct = 0;

if (pg_num_rows($q) > 0) {    
    while ($row = pg_fetch_array($q)) {
        $mostrar = false;
        $empenhado = 0;

        $nr_programa_trabalho = trim($row['nr_programa_trabalho']);
        $nr_1 = substr($nr_programa_trabalho, 0, 2);
        $nr_2 = substr($nr_programa_trabalho, 3, 3);
        $nr_3 = substr($nr_programa_trabalho, 7, 4);
        $nr_4 = substr($nr_programa_trabalho, 12, 4);
        $nr_5 = substr($nr_programa_trabalho, 17, 4);

        $ct_sit = 1;
        while ($ct_sit <= 12) {
            $sql = "SELECT disponivel, empenhado, liquidado, autorizado, contingenciado, bloqueado, data_extracao";
            $sql .= " FROM tab_siggo_sesplan WHERE cofuncao  = '".$nr_1."' ";
            $sql .= " AND cosubfuncao = '".$nr_2."' AND coprograma = '".$nr_3."' ";
            $sql .= " AND coprojeto = '".$nr_4."' AND cosubtitulo = '".$nr_5."'";
            $sql .= " AND CAST(inmes as integer) = ".$ct_sit;                                                                                                                                                                                                                                                          
            $qStage2 = pg_query($sql); 
            if (pg_num_rows($qStage2) > 0) {
                while($rsStage2 = pg_fetch_array($qStage2)) {
                    $empenhado = $empenhado + $rsStage2['empenhado'];                              
                }
            } 
            $ct_sit += 1;
        }        

        if (!empty($btn_empenho)) {            
            if ($empenhado != "0" && !empty($empenhado)) {
                $mostrar = true;
            }
        } else {
            $mostrar = true;
        }
        
        if ($mostrar == true) {
            $sql = "SELECT codigo_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_objetivo = ".$row['cod_objetivo'];                
            $rs = pg_fetch_array(pg_query($sql));        

            $cod_status = $clsSag->RetornaSituacaoSAG($row['cod_sag']);
            $txt_cor = $clsStatus->RetornaCorStatus($cod_status);   
            $txt_ultimo_status = $clsStatus->RetornaStatus($cod_status); 

            ?>   
            <?php if ($ct > 1) { ?>
                <hr /> <?php 
            } ?>
            <div class="row">         
                <div class="col-md-12" align="left">
                    <strong><?php echo($rs['codigo_objetivo']) ?>  <?php echo($rs['txt_objetivo']) ?></strong><br />
                    <b>Etapa SAG:</b>
                    <?php echo($row['nr_etapa_trabalho']) ?>
                    <br />
                    <b>Descrição da Etapa:</b>
                    <?php echo($row['txt_etapa_trabalho']) ?>
                </div>             
            </div> <br />
            <div class="row"> 
                <div class="col-md-5" align="left"> 
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_eixo']) ?>"><?php echo($row['codigo_eixo']) ?></a>&nbsp;
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_perspectiva']) ?>"><?php echo($row['codigo_perspectiva']) ?></a>&nbsp;
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_diretriz']) ?>"><?php echo($row['codigo_diretriz']) ?></a>&nbsp;

                    <?php
                    //PROGRAMAS DE TRABALHO
                    $sql = "SELECT nr_programa_trabalho, txt_programa_trabalho FROM tb_programa_trabalho WHERE cod_programa_trabalho = ".$row['cod_programa_trabalho'];               
                    $q_tag = pg_query($sql);
                    if (pg_num_rows($q_tag) > 0) { ?>
                        <br /> <?php
                        while ($rs_tag = pg_fetch_array($q_tag)) { ?>
                            <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_programa_trabalho']) ?>"><?php echo($rs_tag['nr_programa_trabalho']) ?></a>&nbsp;
                        <?php
                        }
                    }
                    //EMENDA PARLAMENTAR                  
                    ?>                                
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled">Emenda Parlamentar  <?php echo(destacar_ativo2($row['cod_emenda'])) ?></a>&nbsp;
                    <!--EMPENHO-->                               
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled">Empenho  <?php echo(destacar_ativo2($btn_empenho)) ?></a>&nbsp;
                </div>
                <div class="col-md-3" align="left">
                    <strong><?php echo($clsUsuario->ConsultaUsuarioId($row['cod_usuario'])) ?></strong>
                </div>
                <div class="col-md-2" align="left">            
                    <input type="text" class="form-control_custom" name="txt_ultimo_status" style="background-color:<?php echo($txt_cor) ?>;" value="<?php echo($txt_ultimo_status) ?>" disabled="disabled">
                </div>
                <div class="col-md-2" align="left">  
                    <?php
                    if (!empty($row['cod_orgao'])) {
                    ?>
                        <?php echo($clsOrgao->RetornaSigla($row['cod_orgao'])) ?>
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
        }                
    }
} else {
    $ct = 0;
    ?>       
        <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
    <?php
}
?>
<script>
    $(document).ready(function() {    
        $('#div_total_sag_painel').html('<strong>Total: <?php echo($ct) ?></strong>'); 
    });
</script>