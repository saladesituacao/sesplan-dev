<?php
include_once (__DIR__ . "/../classes/clsPas.php");
include_once (__DIR__ . "/../classes/clsOrgao.php");
include_once (__DIR__ . "/../classes/clsStatus.php");

$clsPas = new clsPas();
$clsOrgao = new clsOrgao();
$clsStatus = new clsStatus();

$condicao = " 1 = 1 AND EXTRACT(YEAR from tb_pas.dt_inclusao) = ".$_SESSION['ano_corrente'];

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
    
    $condicao .= " AND tb_pas.cod_orgao IN (".$_cod_orgao.") ";    
}
if (!empty($_cod_eixo_array)) {
    $condicao .= " AND tb_pas.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_eixo IN(".$_cod_eixo_array.")) ";    
}
if (!empty($_cod_perspectiva_array)) {
    $condicao .= " AND tb_pas.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_perspectiva IN(".$_cod_perspectiva_array.")) ";    
}
if (!empty($_cod_diretriz_array)) {
    $condicao .= " AND tb_pas.cod_objetivo IN(SELECT cod_objetivo FROM tb_objetivo WHERE cod_diretriz IN(".$_cod_diretriz_array.")) ";    
}
if (!empty($_cod_objetivo_array)) {
    $condicao .= " AND tb_pas.cod_objetivo IN(".$_cod_objetivo_array.") ";
}
if (!empty($cod_acao_pas)) {
    foreach ($cod_acao_pas as &$value) {        
        $_cod_acao_pas .= "['".$value."']";
    }
    $_cod_acao_pas = str_replace('][', ',', $_cod_acao_pas);
    $_cod_acao_pas = str_replace(']', '', $_cod_acao_pas);
    $_cod_acao_pas = str_replace('[', '', $_cod_acao_pas);

    $condicao .= " AND tb_pas.cod_pas IN (".$_cod_acao_pas.") ";
}

$campo = " tb_pas.*, codigo_eixo, txt_eixo, codigo_perspectiva, txt_perspectiva, codigo_diretriz, txt_diretriz ";

$sql = "SELECT ".$campo;
$sql .= " FROM tb_pas ";
$sql .= " INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_pas.cod_objetivo ";
$sql .= " INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo ";
$sql .= " INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva ";
$sql .= " INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz ";
$sql .= " WHERE ".$condicao;
$q = pg_query($sql);

if (!empty($cod_status_array)) {
    $a_cod_status_array = explode(',', $cod_status_array);
    $a_cod_pas = "";
    while ($row = pg_fetch_array($q)) {
        $_cod_status_painel = $clsPas->SituacaoPAS($row['cod_pas']);
        if (in_array($_cod_status_painel, $a_cod_status_array)) { 
            $a_cod_pas .= '['.$row['cod_pas'].']';                              
        }        
    }
    if ($a_cod_pas != "") {
        $a_cod_pas = str_replace('][', ',', $a_cod_pas);
        $a_cod_pas = str_replace(']', '', $a_cod_pas);
        $a_cod_pas = str_replace('[', '', $a_cod_pas);

        $sql .= " AND tb_pas.cod_pas IN(".$a_cod_pas.") ";               
    } else {
        $sql .= " AND tb_pas.cod_pas = 0 ";
    }
    $q = pg_query($sql);    
} 
?>
<table class="table table-striped" cellspacing="0" cellpadding="0">
    <thead>
        <tr>                                                                    
            <th><strong>Total: <?php echo(pg_num_rows($q)); ?></strong></th>                                                                        
        </tr>                                                            
    </thead>    
</table>
<?php
if (pg_num_rows($q) > 0) { 
    $ct = 1;
    while ($row = pg_fetch_array($q)) {
        $sql = "SELECT codigo_objetivo, txt_objetivo FROM tb_objetivo WHERE cod_objetivo = ".$row['cod_objetivo'];                
        $rs = pg_fetch_array(pg_query($sql)); 

        $_cod_status_painel = $clsPas->SituacaoPAS($row['cod_pas']);                                                                                                                                                                                             
        if ($_cod_status_painel != '') {
            $txt_cor = $clsStatus->RetornaCorStatus($_cod_status_painel);                                                                        
            $txt_ultimo_status = $clsStatus->RetornaStatus($_cod_status_painel);                                                                        
        } else {
            $txt_cor = "";
            $txt_ultimo_status = "";
        }  
        ?>
         <?php if ($ct > 1) { ?>
            <hr /> <?php 
        } ?>      
        <div class="row">         
            <div class="col-md-12" align="left">                
                <strong><?php echo($rs['codigo_objetivo']) ?>  <?php echo($rs['txt_objetivo']) ?></strong><br />
                <b>Ação PAS:</b>
                <?php echo($row['codigo_acao']) ?> - <?php echo($row['txt_acao']) ?>
            </div>             
        </div> <br />  
        <div class="row">   
            <div class="col-md-4" align="left">                
                <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_eixo']) ?>"><?php echo($row['codigo_eixo']) ?></a>&nbsp;
                <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_perspectiva']) ?>"><?php echo($row['codigo_perspectiva']) ?></a>&nbsp;
                <a class="btn_painel btn-primary btn-xs" disabled="disabled" title="<?php echo($row['txt_diretriz']) ?>"><?php echo($row['codigo_diretriz']) ?></a>&nbsp;                               
            </div>
            <div class="col-md-3" align="left">            
                <input type="text" class="form-control_custom" name="txt_ultimo_status" style="background-color:<?php echo($txt_cor) ?>;" value="<?php echo($txt_ultimo_status) ?>" disabled="disabled">                
            </div>
            <div class="col-md-2" align="left">
                <?php
                $sql = "SELECT txt_controle FROM tb_pas         
                INNER JOIN tb_pas_controle ON tb_pas_controle.cod_controle = tb_pas.cod_controle                            
                WHERE tb_pas.cod_pas = ".$row['cod_pas'];
                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) {
                    $rs1 = pg_fetch_array($q1);
                    echo($rs1['txt_controle']);
                }
                ?>
            </div>
            <div class="col-md-3" align="left">  
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
        </div> <?php
        $ct += 1;
    }       
} else {
    ?>       
        <center><h4>NÃO EXISTEM REGISTROS CADASTRADOS.</h4></center>
    <?php
}
?>