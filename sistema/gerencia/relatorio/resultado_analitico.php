<?php
include_once (__DIR__ . "/../../include/conexao.php");
include_once (__DIR__ . "/../../classes/clsIndicador.php");

verifica_seguranca();
cabecalho();

$cod_ano = $_POST['cod_ano'];
$cod_eixo = $_POST['cod_eixo'];
$cod_perspectiva = $_POST['cod_perspectiva'];
$cod_diretriz = $_POST['cod_diretriz'];
$cod_objetivo = $_POST['cod_objetivo'];

$clsIndicador = new clsIndicador();

if (!empty($cod_eixo)) {    
    $condicao_objetivo .= " AND tb_objetivo.cod_eixo = ".$cod_eixo;   
} 
if (!empty($cod_perspectiva)) {
    $condicao_objetivo .= " AND tb_objetivo.cod_perspectiva = ".$cod_perspectiva; 
} 
if (!empty($cod_diretriz)) {
    $condicao_objetivo = " AND tb_objetivo.cod_diretriz = ".$cod_diretriz;        
} 
if (!empty($cod_objetivo)) {
    $condicao_objetivo .= " AND tb_objetivo.cod_objetivo = ".$cod_objetivo;
} 

?>
<br />
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-md-12"> 
            <label for="exampleInputEmail1">Competência: <?php echo($cod_ano); ?></label>
        </div>
    </div>
    <?php
    //EIXO
    $sql = "SELECT DISTINCT(txt_eixo) AS txt_eixo, tb_objetivo.cod_eixo, codigo_eixo FROM tb_objetivo     
            INNER JOIN tb_eixo ON tb_eixo.cod_eixo = tb_objetivo.cod_eixo WHERE tb_eixo.cod_ativo = 1 ".$condicao_objetivo."
            AND tb_eixo.cod_ativo = 1 AND tb_objetivo.cod_ativo = 1 AND (
                tb_objetivo.cod_objetivo IN (SELECT cod_objetivo FROM tb_indicador) OR tb_objetivo.cod_objetivo IN(SELECT cod_objetivo FROM tb_pas)
                )
            ORDER BY codigo_eixo";
    $q1 = pg_query($sql);
    if (pg_num_rows($q1) > 0) { ?>
        <p align="justify">
            <?php
            while ($rs1 = pg_fetch_array($q1)) { ?>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <strong><?php echo($rs1['codigo_eixo']) ?> - <?php echo($rs1['txt_eixo']) ?></strong>
                    </div>
                </div>                
                <?php
                //PERSPECTIVA
                $sql = "SELECT DISTINCT(txt_perspectiva) AS txt_perspectiva, tb_objetivo.cod_perspectiva, codigo_perspectiva FROM tb_objetivo                
                INNER JOIN tb_perspectiva ON tb_perspectiva.cod_perspectiva = tb_objetivo.cod_perspectiva
                WHERE 1 = 1 AND tb_perspectiva.cod_eixo = ".$rs1['cod_eixo']." AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo']. " ".$condicao_objetivo." 
                AND tb_objetivo.cod_ativo = 1 AND tb_perspectiva.cod_ativo = 1 
                ORDER BY codigo_perspectiva";                
                $qPerspectiva = pg_query($sql);
                if (pg_num_rows($qPerspectiva) > 0) {
                    while ($rsPerspectiva = pg_fetch_array($qPerspectiva)) { ?>                        
                        <div class="row">                            
                            <div class="col-md-10">
                                <strong><?php echo($rsPerspectiva['codigo_perspectiva']) ?> - <?php echo($rsPerspectiva['txt_perspectiva']) ?></strong>
                            </div>
                        </div> 
                        <?php
                        //DIRETRIZ
                        $sql = "SELECT DISTINCT(txt_diretriz) AS txt_diretriz, tb_objetivo.cod_diretriz, codigo_diretriz FROM tb_objetivo                
                        INNER JOIN tb_diretriz ON tb_diretriz.cod_diretriz = tb_objetivo.cod_diretriz
                        WHERE 1 = 1 AND tb_diretriz.cod_eixo = ".$rs1['cod_eixo']." AND tb_diretriz.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva']." 
                        AND tb_objetivo.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva']. " ".$condicao_objetivo." 
                        AND tb_objetivo.cod_ativo = 1 AND tb_diretriz.cod_ativo = 1 
                        ORDER BY codigo_diretriz";  
                        $qDiretriz = pg_query($sql);
                        if (pg_num_rows($qDiretriz) > 0) {
                            while ($rsDiretriz = pg_fetch_array($qDiretriz)) { ?>                                
                                <div class="row">                            
                                    <div class="col-md-10">
                                        <strong><?php echo($rsDiretriz['codigo_diretriz']) ?> - <?php echo($rsDiretriz['txt_diretriz']) ?></strong>
                                    </div>
                                </div> 
                                <?php
                                //OBJETIVO
                                $sql = "SELECT DISTINCT(txt_objetivo) AS txt_objetivo, cod_objetivo, 
                                codigo_objetivo, CAST(Replace(substring(codigo_objetivo,4,6), '.', '') AS INT) AS T FROM tb_objetivo                                                
                                WHERE 1 = 1 AND tb_objetivo.cod_eixo = ".$rs1['cod_eixo']." AND tb_objetivo.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva']." 
                                AND tb_objetivo.cod_diretriz = ".$rsDiretriz['cod_diretriz']. " ".$condicao_objetivo." AND tb_objetivo.cod_ativo = 1 ORDER BY T"; 
                                $qObjetivo = pg_query($sql);
                                if (pg_num_rows($qObjetivo) > 0) {
                                    while($rsObjetivo = pg_fetch_array($qObjetivo)) { ?>                                        
                                        <div class="row">                            
                                            <div class="col-md-10">
                                                <strong><?php echo($rsObjetivo['codigo_objetivo']) ?> - <?php echo($rsObjetivo['txt_objetivo']) ?></strong>
                                            </div>
                                        </div> 
                                        <br />
                                        <div class="row">                            
                                            <div class="col-md-10">
                                                <strong>Indicadores</strong>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <?php
                                            $sql = "SELECT tb_indicador.cod_indicador, tb_indicador.cod_chave
                                                FROM tb_indicador
                                                INNER JOIN tb_objetivo ON tb_objetivo.cod_objetivo = tb_indicador.cod_objetivo
                                                WHERE tb_objetivo.cod_eixo = ".$rs1['cod_eixo']."
                                                AND tb_objetivo.cod_perspectiva = ".$rsPerspectiva['cod_perspectiva']."
                                                AND tb_objetivo.cod_diretriz = ".$rsDiretriz['cod_diretriz']."
                                                AND tb_indicador.cod_objetivo = ".$rsObjetivo['cod_objetivo']."                                                            
                                                AND EXTRACT(YEAR from tb_indicador.dt_inclusao) = ".$cod_ano;
                                                $qIndicador = pg_query($sql);                                                
                                                if (pg_num_rows($qIndicador) > 0) {
                                                    while($rsIndicador = pg_fetch_array($qIndicador)) { 
                                                        $retorno_array_indicador = $clsIndicador->ConsultaIndicador($rsIndicador['cod_indicador']);

                                                        while($rsIndicador = pg_fetch_array($qIndicador)) { 
                                                            $retorno_array_indicador = $clsIndicador->ConsultaIndicador($rsIndicador['cod_indicador']);  ?>

                                                            <div class="table-responsive col-md-12">
                                                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nome do indicador</th>                                                                                                                               
                                                                        </tr>                                                                        
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>																                                                                        
                                                                            <td>
                                                                                <?php																																
                                                                                echo("<span title='".$retorno_array_indicador->descricao."'>".$retorno_array_indicador->titulo."<span>");
                                                                                ?>
                                                                            </td>	
                                                                        </tr>  
                                                                    </tbody>
                                                                </table>
                                                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Análise do resultado</th>                                                                                                                               
                                                                        </tr>                                                                        
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>																                                                                        
                                                                            <td>
                                                                                <table class="table table-striped" cellspacing="0" cellpadding="0">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <?php 
                                                                                            $ct_mes = 1;
                                                                                            while($ct_mes <= 12) { ?>
                                                                                                <th><?php echo(RetornaTextoMes($ct_mes)); ?></th> 
                                                                                            <?php
                                                                                                $ct_mes += 1;
                                                                                            } ?>                                                                                                                                                                                                                          
                                                                                        </tr>                                                                        
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>																                                                                        
                                                                                        <?php 
                                                                                            $ct_mes = 1;
                                                                                            while($ct_mes <= 12) { ?>
                                                                                                <td><?php echo($clsIndicador->RetornaTextoAnalise($rsIndicador['cod_chave'], $ct_mes)); ?></td> 
                                                                                            <?php
                                                                                                $ct_mes += 1;
                                                                                            }                                                                                                
                                                                                        ?>  	
                                                                                        </tr>  
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>	
                                                                        </tr>  
                                                                    </tbody>
                                                                </table>
                                                            </div>                                                                 
                                                        <?php 
                                                        }                                                                                                                                                                                                                                                                                                           
                                                    }                                                       
                                                }
                                            ?>                                                
                                            </div>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
        </p> <?php
    } ?>
</div>

<?php
rodape($dbcon);
?>