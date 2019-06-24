<?php

include_once (__DIR__ . "/../classes/clsExecucaoOrcamentaria.php");
include_once (__DIR__ . "/../classes/clsStatus.php");
include_once (__DIR__ . "/../classes/clsUsuario.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");

$clsExecucaoOrcamentaria = new clsExecucaoOrcamentaria();
$clsStatus = new clsStatus();
$clsUsuario = new clsUsuario();
$clsOrgao = new clsOrgao();

$r = pg_fetch_array(pg_query("SELECT DATE_PART('YEAR', CURRENT_TIMESTAMP) AS ANO"));

$condicao = " 1 = 1 AND tab_siggo_sesplan.inmes = (SELECT MAX(t.inmes) FROM tab_siggo_sesplan t WHERE ";
$condicao .= " t.cofuncao = tab_siggo_sesplan.cofuncao AND t.cosubfuncao = tab_siggo_sesplan.cosubfuncao " ;
$condicao .= " AND t.coprograma = tab_siggo_sesplan.coprograma AND t.coprojeto = tab_siggo_sesplan.coprojeto ";
$condicao .= " AND t.cosubtitulo = tab_siggo_sesplan.cosubtitulo) ";
$condicao .= " AND substring(tab_siggo_sesplan.data_extracao from 1 for 4) = '".$r['ano']."'";

if (!empty($cod_status_array)) {
    $a_cod_status_array = explode(',', $cod_status_array);
    foreach ($a_cod_status_array as &$value) {
        if ($value != '') {
            $_txt_status_array .= '[' .strtoupper($clsStatus->RetornaStatus($value)). ']'; 
        }
    }
    if (!empty($_txt_status_array)) {
        $_txt_status_array = str_replace('][', ',', $_txt_status_array);
        $_txt_status_array = str_replace('[', '', $_txt_status_array);
        $_txt_status_array = str_replace(']', '', $_txt_status_array);

        $a_txt_status_array = explode(',', $_txt_status_array);        
    } else {
        $_txt_status_array = '[]';
    }
} else {
    $_txt_status_array = '[]';
}

if (!empty($cod_progr)) {
    foreach ($cod_progr as &$value) {        
        $_cod_progr .= "['".$value."']";
    }
    $_cod_progr = str_replace('][', ',', $_cod_progr);
    $_cod_progr = str_replace(']', '', $_cod_progr);
    $_cod_progr = str_replace('[', '', $_cod_progr);

    $condicao .= " AND tb_programa_trabalho.cod_programa_trabalho IN (".$_cod_progr.") ";
}

if (!empty($_cod_eixo_array)) {
    $condicao .= " AND tb_programa_trabalho.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_eixo IN(".$_cod_eixo_array.")) ";        
}
if (!empty($_cod_perspectiva_array)) {
    $condicao .= " AND tb_programa_trabalho.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_perspectiva IN(".$_cod_perspectiva_array.")) ";        
}
if (!empty($_cod_diretriz_array)) {
    $condicao .= " AND tb_programa_trabalho.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_diretriz IN(".$_cod_diretriz_array.")) ";        
}
if (!empty($_cod_objetivo_array)) {
    $condicao .= " AND tb_programa_trabalho.cod_objetivo IN(".$_cod_objetivo_array.") ";    
}

$campo = " DISTINCT tb_programa_trabalho.cod_eixo, codigo_eixo, txt_eixo, tb_programa_trabalho.cod_perspectiva, codigo_perspectiva, txt_perspectiva, ";
$campo .= " tb_programa_trabalho.cod_diretriz, codigo_diretriz, txt_diretriz, tb_programa_trabalho.cod_objetivo, codigo_objetivo, txt_objetivo, nr_programa_trabalho, ";
$campo .= " tb_programa_trabalho.cod_programa_trabalho, txt_programa_trabalho, txt_titulo_programa, inmes ";

$sql = "SELECT ".$campo;
$sql .= " FROM tab_siggo_sesplan INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.nr_programa_trabalho = ";
$sql .= " (SELECT y.nr_programa_trabalho FROM tb_programa_trabalho y WHERE y.nr_programa_trabalho = "; 
$sql .= " cofuncao || '.' || cosubfuncao || '.' || coprograma || '.' || coprojeto || '.' || cosubtitulo) ";
$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_programa_trabalho.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_programa_trabalho.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_programa_trabalho.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_programa_trabalho.cod_diretriz ";
$sql .= " WHERE ".$condicao;
$q = pg_query($sql);
?>
<table class="table table-striped" cellspacing="0" cellpadding="0">
    <thead>
        <tr>                                                                    
            <th><div id="div_total"></div></th>                                                                        
        </tr>                                                            
    </thead>    
</table>
<?php
if (pg_num_rows($q) > 0) {
    $ct = 1;
    $mostrar = false;
    $total_query = pg_num_rows($q);

    while ($row = pg_fetch_array($q)) {                        
        $nr_programa_trabalho = trim($row['nr_programa_trabalho']);                                                            
        $nr_1 = substr($nr_programa_trabalho, 0, 2);
        $nr_2 = substr($nr_programa_trabalho, 3, 3);
        $nr_3 = substr($nr_programa_trabalho, 7, 4);
        $nr_4 = substr($nr_programa_trabalho, 12, 4);
        $nr_5 = substr($nr_programa_trabalho, 17, 4);

        $sql = "SELECT SUM(cast(cast(LEI as text) as integer)) AS lei FROM tab_siggo_sesplan WHERE cofuncao  = '".$nr_1."' ";
        $sql .= " AND cosubfuncao = '".$nr_2."' AND coprograma = '".$nr_3."' ";
        $sql .= " AND coprojeto = '".$nr_4."' AND cosubtitulo = '".$nr_5."'";                                                                                                                                                                                                                                
        $qStage = pg_query($sql); 
        while ($rsStage = pg_fetch_array($qStage)) {
            $lei = $rsStage['lei'];
        }

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
                    $autorizado = $autorizado + $rsStage2['autorizado'];
                    $disponivel = $disponivel + $rsStage2['disponivel'];
                    $empenhado = $empenhado + $rsStage2['empenhado'];
                    $liquidado = $liquidado + $rsStage2['liquidado'];
                    $contingenciado = $contingenciado + $rsStage2['contingenciado'];
                    $bloqueado = $bloqueado + $rsStage2['bloqueado'];  
                    
                    $empenhado_autorizado = $clsExecucaoOrcamentaria->RecursoEmpenhadoAutorizado($empenhado, $autorizado);
                    $liquidado_empenhado = $clsExecucaoOrcamentaria->RecursoLiquidadoEmpenhado($liquidado, $empenhado);
    
                    $situacao_execucao = $clsExecucaoOrcamentaria->Situacao($empenhado_autorizado, $ct_sit);
                    $a_situacao_execucao = explode("|", $situacao_execucao);  
                    
                    $data_extracao = formatarDataBrasil($rsStage2['data_extracao']);
                }
            }

            $ct_sit += 1;
        }
       
        ?>   
        <?php if ($ct > 1) { ?>
            <hr /> <?php 
        } 
        
        if ($_txt_status_array == '[]') {
            $mostrar = true;
        } 
        if (!$mostrar) {
            if (in_array(strtoupper($a_situacao_execucao[1]), $a_txt_status_array)) {                 
                $mostrar = true;
            }
        }

        if ($mostrar) { 
            $cod_total = "OK";
            ?>
            <div class="row">         
                <div class="col-md-12" align="left">
                    <strong><?php echo($row['codigo_objetivo']) ?> <?php echo($row['txt_objetivo']) ?></strong><br />
                    <?php echo($row['nr_programa_trabalho']) ?>  - <?php echo($row['txt_titulo_programa']) ?><br />   
                    Lei (Dotado)R$ <?php echo(number_format($lei, 2, ',', '.')); ?>
                </div>             
            </div><br />
            <div class="row"> 
                <div class="col-md-4" align="left"> 
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_eixo']) ?>"><?php echo($row['codigo_eixo']) ?></a>&nbsp;
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_perspectiva']) ?>"><?php echo($row['codigo_perspectiva']) ?></a>&nbsp;
                    <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_diretriz']) ?>"><?php echo($row['codigo_diretriz']) ?></a>&nbsp;
                    
                </div>   
                <div class="col-md-2" align="left">            
                    <input type="text" class="form-control_custom" name="txt_ultimo_status" style="background-color:<?php echo($a_situacao_execucao[0]) ?>;" value="<?php echo($a_situacao_execucao[1]) ?>" disabled="disabled">
                </div>      
                <div class="col-md-4" align="left">
                    <strong>Data Extração:</strong> <?php echo($data_extracao); ?>
                </div>   
            </div>

            <div class="row"> 
                &nbsp;
            </div> <?php
        }
        ?>        
        <?php
        $ct += 1; 
        $mostrar = false;
    }

    if ($cod_total != "OK") {
        ?>       
        <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
        <script>
            $(document).ready(function() {
                $('#div_total').html('<strong>Total: 0</strong>');                
            })
        </script>
        <?php
    } else {
        ?>               
        <script>
            $(document).ready(function() {
                $('#div_total').html('<strong>Total: ' + <?php echo($total_query); ?> + '</strong>');
            })
        </script>
        <?php
    }

} else {
    ?>       
        <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
    <?php
}

?>