<?php
include_once (__DIR__ . "/../include/conexao.php");
verifica_seguranca();
cabecalho();

$cod_modulo = $_POST['cod_modulo'];
$cod_status = $_POST['cod_status'];
$cod_orgao = $_POST['cod_orgao'];
$cod_tag = $_POST['cod_tag'];
$cod_eixo = $_POST['cod_eixo'];
$cod_perspectiva = $_POST['cod_perspectiva'];
$cod_diretriz = $_POST['cod_diretriz'];
$cod_objetivo = $_POST['cod_objetivo'];
$cod_progr = $_POST['cod_progr'];
$btn_emenda_parlamentar = $_POST['btn_emenda_parlamentar'];
$btn_empenho = $_POST['btn_empenho'];
$cod_acao_pas = $_POST['cod_acao_pas'];
$cod_etapa_sag = $_POST['cod_etapa_sag'];

if (!empty($_REQUEST['cod_ano_corrente'])) {
    $_SESSION['ano_corrente'] = $_REQUEST['cod_ano_corrente'];
}
if (!empty($_REQUEST['cod_mes_corrente'])) {
    $_SESSION['mes_corrente'] = $_REQUEST['cod_mes_corrente'];
}
if (!empty($_REQUEST['cod_bimestre_corrente'])) {
    $_SESSION['cod_bimestre_corrente'] = $_REQUEST['cod_bimestre_corrente'];
}
if (!empty($cod_eixo)) {
    $cod_eixo_array = implode('|', $cod_eixo);
    $_cod_eixo_array = implode(',', $cod_eixo);
}
if (!empty($cod_perspectiva)) {
    $cod_perspectiva_array = implode('|', $cod_perspectiva);
    $_cod_perspectiva_array = implode(',', $cod_perspectiva);
}
if (!empty($cod_diretriz)) {
    $cod_diretriz_array = implode('|', $cod_diretriz);
    $_cod_diretriz_array = implode(',', $cod_diretriz);
}
if (!empty($cod_objetivo)) {
    $cod_objetivo_array = implode('|', $cod_objetivo);
    $_cod_objetivo_array = implode(',', $cod_objetivo);
}
if (!empty($cod_status)) {
    $cod_status_array = implode(',', $cod_status);
}
if (!empty($cod_orgao)) {    
    $cod_orgao_array = implode(',', $cod_orgao);
}
if (!empty($cod_tag)) {
    $cod_tag_array = implode(',', $cod_tag);
}
if (!empty($cod_progr)) {
    $cod_progr_array = implode(',', $cod_progr);
}
if (!empty($cod_acao_pas)) {
    $cod_acao_pas_array = implode(',', $cod_acao_pas);
}
if (!empty($cod_etapa_sag)) {
    $cod_etapa_sag_array = implode(',', $cod_etapa_sag);
}

?>
<!-- Estilos Painel -->
<link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/style_painel.css" rel="stylesheet">

<div id="main" class="container-fluid">
    <form id="frm1" method="post" action="pesquisa.php">
        <input type="hidden" name="cod_modulo" value="<?=$cod_modulo?>" />      
        <div class="row">
            <div class="col-md-3"> 
                <div class="jumbotron" style="background-image:url(<?php echo($_SESSION["txt_caminho_aplicacao"]) ?>/include/imagens/fundo_painel.jpg);" class="img-responsive">                                   
                    <div class="row">
                        <div class="col-md-3" align="left">&nbsp;</div>                        
                        <div class="col-md-6" align="left">
                            <center><font color="blue">Pesquisa</font></center><br />
                            <center><font color="blue">Competência</font></center>                            
                            <select id="cod_ano_corrente" name="cod_ano_corrente" class="chosen-select col-md-4">
                                <option value="2019" <?php
                                                if (strval($_SESSION['ano_corrente']) == "2019") {
                                                    echo("selected");
                                                }
                                                ?>>2019</option>
                                <option value="2018" <?php
                                                if (strval($_SESSION['ano_corrente']) == "2018") {
                                                    echo("selected");
                                                }
                                                ?>>2018</option>
                            </select>
                            <div class="row">&nbsp;</div>
                            <?php if ($cod_modulo == 2) { ?>
                                <font color="blue">Bimestre</font><br />
                                <select id="cod_bimestre_corrente" name="cod_bimestre_corrente" class="chosen-select col-md-6">
                                <option value="1" <?php
                                                    if (strval($_SESSION['cod_bimestre_corrente']) == "1") {
                                                        echo("selected");
                                                    }
                                                    ?>>Janeiro/Fevereiro</option>                               
                                <option value="2" <?php
                                                    if (strval($_SESSION['cod_bimestre_corrente']) == "2") {
                                                        echo("selected");
                                                    }
                                                    ?>>Março/Abril</option>                               
                                <option value="3" <?php
                                                    if (strval($_SESSION['cod_bimestre_corrente']) == "3") {
                                                        echo("selected");
                                                    }
                                                    ?>>Maio/Junho</option>                                
                                <option value="4" <?php
                                                    if (strval($_SESSION['cod_bimestre_corrente']) == "4") {
                                                        echo("selected");
                                                    }
                                                    ?>>Julho/Agosto</option>                              
                                <option value="5" <?php
                                                    if (strval($_SESSION['cod_bimestre_corrente']) == "5") {
                                                        echo("selected");
                                                    }
                                                    ?>>Setembro/Outubro</option>                               
                                <option value="6" <?php
                                                    if (strval($_SESSION['cod_bimestre_corrente']) == "6") {
                                                        echo("selected");
                                                    }
                                                    ?>>Novembro/Dezembro</option>                        
                                </select>
                            <?php } ?>
                            <?php if ($cod_modulo == 3) { ?>
                                <font color="blue">Mês</font><br />
                                <select id="cod_mes_corrente" name="cod_mes_corrente" class="chosen-select col-md-6">
                                <option value="1" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "1") {
                                                        echo("selected");
                                                    }
                                                    ?>>Janeiro</option>
                                <option value="2" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "2") {
                                                        echo("selected");
                                                    }
                                                    ?>>Fevereiro</option>
                                <option value="3" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "3") {
                                                        echo("selected");
                                                    }
                                                    ?>>Março</option>
                                <option value="4" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "4") {
                                                        echo("selected");
                                                    }
                                                    ?>>Abril</option>
                                <option value="5" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "5") {
                                                        echo("selected");
                                                    }
                                                    ?>>Maio</option>
                                <option value="6" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "6") {
                                                        echo("selected");
                                                    }
                                                    ?>>Junho</option>
                                <option value="7" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "7") {
                                                        echo("selected");
                                                    }
                                                    ?>>Julho</option>
                                <option value="8" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "8") {
                                                        echo("selected");
                                                    }
                                                    ?>>Agosto</option>
                                <option value="9" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "9") {
                                                        echo("selected");
                                                    }
                                                    ?>>Setembro</option>
                                <option value="10" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "10") {
                                                        echo("selected");
                                                    }
                                                    ?>>Outubro</option>
                                <option value="11" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "11") {
                                                        echo("selected");
                                                    }
                                                    ?>>Novembro</option>
                                <option value="12" <?php
                                                    if (strval($_SESSION['mes_corrente']) == "12") {
                                                        echo("selected");
                                                    }
                                                    ?>>Dezembro</option>
                                </select>
                            <?php } ?>                            
                        </div>
                    </div><br />
                    <div class="row">
                        <div class="col-md-12" align="left">
                            <center><font color="blue">Árvore SES</font></center>
                            <div id="div_eixo"></div>               
                            <div id="div_perspectiva"></div>
                            <div id="div_diretriz"></div> 
                            <div id="div_objetivo"></div> 
                        </div>
                    </div><br />
                    <div class="row">
                        <div class="col-md-12" align="left"><?php 
                            if ($cod_modulo == 1) {?>
                                <div class="row">                                    
                                    <center><font color="blue">Ação</font></center>
                                    <div class="col-md-12" align="left">  
                                        <select id="cod_acao_pas" name="cod_acao_pas[]" data-placeholder="." multiple class="chosen-select">                                  
                                            <option></option>
                                            <?php
                                            $sql = "SELECT cod_pas, txt_acao, codigo_acao FROM tb_pas WHERE cod_ativo = 1 ORDER BY codigo_acao";                                            
                                            $q1 = pg_query($sql);
                                            while ($rs1 = pg_fetch_array($q1)) { 
                                                if (!empty($cod_acao_pas)) {
                                                    if(in_array(strval($rs1['cod_pas']), $cod_acao_pas)) {
                                                        $selected = 'selected';
                                                    }                                                     
                                                }
                                                ?> 
                                                <option value="<?=$rs1['cod_pas']?>"<?php echo($selected); ?>><?=$rs1['codigo_acao']?> - <?=$rs1['txt_acao']?></option>
                                                <?php 
                                                $selected = '';       
                                            } ?>  
                                        </select> 
                                    </div> 
                                </div>
                                <?php

                            }
                            else if ($cod_modulo == 3) { ?>
                                <center><font color="blue">Instrumentos de Planejamento</font></center>
                                <?php
                                $q1 = pg_query("SELECT ds_tag FROM tb_indicador_tag GROUP BY ds_tag");
                                while ($rs1 = pg_fetch_array($q1)) { 
                                    if (!empty($cod_tag)) {
                                        if(in_array(strval($rs1['ds_tag']), $cod_tag)) {
                                            $checked = 'checked';
                                        }
                                    }
                                    ?> 
                                    <div class="col-md-6" align="left">                    
                                        <div class="form-check">  
                                            <input type="checkbox" class="form-check-input" name="cod_tag[]" value="<?=$rs1['ds_tag']?>" <?php echo($checked); ?> /><?=$rs1['ds_tag']?>
                                        </div>              
                                    </div><?php 
                                    $checked = '';       
                                }    
                            } else if ($cod_modulo == 2 || $cod_modulo == 4) { ?>
                                <?php if ($cod_modulo == 2) { ?>
                                    <div class="row">
                                        <center><font color="blue">Emenda Parlamentar</font></center>
                                        <div class="col-md-12" align="left">                    
                                            <select id="btn_emenda_parlamentar" name="btn_emenda_parlamentar" class="form-control">
                                                <option value=""></option>
                                                <option value="0" <?php if (strval($btn_emenda_parlamentar) == "0") { echo("selected");}?>>NÃO</option>
                                                <option value="1"> <?php if (strval($btn_emenda_parlamentar) == "1") { echo("selected");}?>SIM</option>
                                            </select>
                                        </div>
                                    </div><br />
                                    <div class="row">
                                        <center><font color="blue">Empenho</font></center>
                                        <div class="col-md-12" align="left">                    
                                            <select id="btn_empenho" name="btn_empenho" class="form-control">
                                                <option value=""></option>
                                                <option value="0" <?php if (strval($btn_empenho) == "0") { echo("selected");}?>>NÃO</option>                                                    
                                                <option value="1" <?php if (strval($btn_empenho) == "1") { echo("selected");}?>>SIM</option>';
                                            </select>              
                                        </div>
                                    </div><br />
                                    <div class="row">                                    
                                        <center><font color="blue">Etapa</font></center>
                                        <div class="col-md-12" align="left">  
                                            <select id="cod_etapa_sag" name="cod_etapa_sag[]" data-placeholder="." multiple class="chosen-select">                                  
                                                <option></option>
                                                <?php
                                                $sql = "SELECT cod_sag, nr_etapa_trabalho, txt_etapa_trabalho FROM tb_sag WHERE cod_ativo = 1 ORDER BY nr_etapa_trabalho";                                            
                                                $q1 = pg_query($sql);
                                                while ($rs1 = pg_fetch_array($q1)) { 
                                                    if (!empty($cod_etapa_sag)) {
                                                        if(in_array(strval($rs1['cod_sag']), $cod_etapa_sag)) {
                                                            $selected = 'selected';
                                                        }                                                     
                                                    }
                                                    ?> 
                                                    <option value="<?=$rs1['cod_sag']?>"<?php echo($selected); ?>><?=$rs1['nr_etapa_trabalho']?> - <?=$rs1['txt_etapa_trabalho']?></option>
                                                    <?php 
                                                    $selected = '';       
                                                } ?>  
                                            </select> 
                                        </div> 
                                    </div><br />
                                <?php } ?>
                                <div class="row">                                    
                                    <center><font color="blue">Programas de Trabalho</font></center>
                                    <div class="col-md-12" align="left">  
                                        <select id="cod_progr" name="cod_progr[]" data-placeholder="." multiple class="chosen-select">                                  
                                            <option></option>
                                            <?php
                                            $sql = "SELECT tpt.cod_programa_trabalho, tpt.nr_programa_trabalho FROM tb_sag ts ";
                                            $sql .= " INNER JOIN tb_programa_trabalho tpt ON tpt.cod_programa_trabalho = ts.cod_programa_trabalho ";
                                            $sql .= " GROUP BY tpt.cod_programa_trabalho, tpt.nr_programa_trabalho ";
                                            $sql .= " ORDER BY tpt.nr_programa_trabalho ";
                                            $q1 = pg_query($sql);
                                            while ($rs1 = pg_fetch_array($q1)) { 
                                                if (!empty($cod_progr)) {
                                                    if(in_array(strval($rs1['cod_programa_trabalho']), $cod_progr)) {
                                                        $selected = 'selected';
                                                    }                                                     
                                                }
                                                ?> 
                                                <option value="<?=$rs1['cod_programa_trabalho']?>"<?php echo($selected); ?>><?=$rs1['nr_programa_trabalho']?></option>
                                                <!--
                                                <div class="col-md-12" align="left">                    
                                                    <div class="form-check">  
                                                        <input type="checkbox" class="form-check-input" name="cod_progr[]" value="<?=$rs1['cod_programa_trabalho']?>" <?php echo($checked); ?> /><?=$rs1['nr_programa_trabalho']?>
                                                    </div>              
                                                </div>--><?php 
                                                $selected = '';       
                                            } ?>  
                                        </select> 
                                    </div> 
                                </div>
                                <?php
                            } ?>
                        </div>
                    </div><br />                       
                    <div class="row">
                        <div class="col-md-12" align="left">
                            <center><font color="blue">Área Responsável</font></center>
                            <?php                             
                            $q1 = pg_query("SELECT * FROM tb_orgao WHERE cod_exibir_consulta = 1 AND cod_orgao_superior IS NULL AND cod_ativo = 1 AND txt_sigla NOT LIKE '%/%' ORDER BY txt_sigla");                     
                            while ($rs1 = pg_fetch_array($q1)) { 
                                if (!empty($cod_orgao)) {
                                    if(in_array(strval($rs1['cod_orgao']), $cod_orgao)) {
                                        $checked = 'checked';
                                    }
                                }
                                ?>  
                                <div class="col-md-12" align="left">    
                                    <div class="form-check">                                        
                                        <input type="checkbox" class="form-check-input" name="cod_orgao[]" value="<?=$rs1['cod_orgao']?>" <?php echo($checked); ?> /><?=$rs1['txt_sigla']?>
                                        <?php
                                        $sql = "WITH RECURSIVE arvore AS ";
                                        $sql .= " (SELECT t1.cod_orgao, txt_sigla, cod_exibir_consulta, cod_ativo ";
                                        $sql .= " FROM tb_orgao AS t1 ";
                                        $sql .= " WHERE cod_orgao = ".$rs1['cod_orgao'];
                                        $sql .= " UNION ALL SELECT t2.cod_orgao, t2.txt_sigla, t2.cod_exibir_consulta, t2.cod_ativo ";
                                        $sql .= " FROM tb_orgao AS t2 INNER JOIN arvore ON cod_orgao_superior = arvore.cod_orgao) "; 
                                        $sql .= " SELECT arvore.cod_orgao, arvore.txt_sigla, arvore.cod_exibir_consulta FROM arvore ";
                                        $sql .= " WHERE arvore.cod_orgao <> ".$rs1['cod_orgao']." AND cod_ativo = 1 AND arvore.cod_exibir_consulta = 1 ";
                                        $sql .= " AND (SELECT length(txt_sigla) - length(REPLACE(txt_sigla, '/', '')) FROM SESPLAN.tb_orgao WHERE UPPER(txt_sigla) = arvore.txt_sigla) < 4 ";
                                        $sql .= " ORDER BY arvore.txt_sigla ";        
                                        $query = pg_query($sql);  
                                        if(pg_num_rows($query) > 0) {
                                            while ($rs2 = pg_fetch_array($query)) { 
                                                $checked2 = '';
                                                if (!empty($cod_orgao)) {
                                                    if(in_array(strval($rs2['cod_orgao']), $cod_orgao)) {
                                                        $checked2 = 'checked';
                                                    }
                                                }
                                                ?>
                                                <br />
                                                <input type="checkbox" class="form-check-input" name="cod_orgao[]" value="<?=$rs2['cod_orgao']?>" <?php echo($checked2); ?> /><?=$rs2['txt_sigla']?>                                           
                                            <?php
                                            $checked2 = '';
                                            }
                                        }  
                                        ?>
                                    </div>
                                </div><?php
                                $checked = '';
                            } ?>
                        </div>
                    </div><br />                               
                    <div class="row">
                        <div class="col-md-12" align="left">
                            <center><font color="blue">Status</font><center>
                            <?php 
                            $sql = "SELECT tbsm.cod_status, tbs.txt_status FROM tb_status_modulo tbsm ";
                            $sql .= " INNER JOIN tb_status tbs ON tbs.cod_status = tbsm.cod_status ";
                            $sql .= " WHERE tbsm.cod_exibir_consulta = 1 AND tbsm.cod_modulo IN(".$cod_modulo.")";
                            $q1 = pg_query($sql);                     
                            while ($rs1 = pg_fetch_array($q1)) { 
                                if (!empty($cod_status)) {
                                    if(in_array(strval($rs1['cod_status']), $cod_status)) {
                                        $checked = 'checked';
                                    }
                                }
                                ?>  
                                <div class="col-md-6" align="left">    
                                    <div class="form-check">        
                                        <input type="checkbox" class="form-check-input" name="cod_status[]" value="<?=$rs1['cod_status']?>" <?php echo($checked); ?> /><?=$rs1['txt_status']?>
                                    </div>
                                </div><?php
                                $checked = '';
                            } ?>
                        </div>
                    </div><br />   
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="btn_pesquisar" class="btn btn-primary btn-sm">Pesquisar</button>
                            <a href="../index.php" class="btn btn-default">Voltar</a>
                        </div>
                    </div>          
                </div>                                                       
            </div>
            <div class="col-md-9">   
                <div class="row">
                    <div class="col-md-12">
                        <div class="jumbotron" style="background-image:url(<?php echo($_SESSION["txt_caminho_aplicacao"]) ?>/include/imagens/fundo_painel.jpg);" class="img-responsive">
                            <?php
                            switch (strval($cod_modulo)) {
                                case "1":
                                    require('pas.php');
                                    break;
                                case "2":
                                    require('sag.php');
                                    break;
                                case "3":
                                    require('indicador2.php');
                                    break;
                                case "4":
                                    require('execucao_orcamentaria.php');
                                    break;                                
                            }
                            ?>
                        </div>
                    </div>
                </div>                                
            </div>        
        </div>
    </form>
</div>
<script src="painel.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {    
        var arr_eixo = "<?php echo $cod_eixo_array;?>";        
        array_eixo = arr_eixo.split('|');  
        var _cod_eixo; 
        var _cod_perspectiva;  
        var _cod_diretriz;

        for (i in array_eixo) {            
            $('#btn_eixo_' + array_eixo[i]).prop("checked", true);  

            if ($('#btn_eixo_' + array_eixo[i]).prop("checked")) {
                dashboard_perspectiva(array_eixo[i]);
                _cod_eixo = array_eixo[i];
            }            
        }

        var arr_perspectiva = "<?php echo $cod_perspectiva_array;?>";        
        array_perspectiva = arr_perspectiva.split('|');    
        for (i in array_perspectiva) {            
            $('#btn_perspectiva_' + array_perspectiva[i]).prop("checked", true);  

            if ($('#btn_perspectiva_' + array_perspectiva[i]).prop("checked")) {
                dashboard_diretriz(_cod_eixo, array_perspectiva[i]);
                _cod_perspectiva = array_perspectiva[i];
            }            
        }

        var arr_diretriz = "<?php echo $cod_diretriz_array;?>";        
        array_diretriz = arr_diretriz.split('|');    
        for (i in array_diretriz) {            
            $('#btn_diretriz_' + array_diretriz[i]).prop("checked", true); 
            dashboard_objetivo(_cod_eixo, _cod_perspectiva, array_diretriz[i]); 
        }

        var arr_objetivo = "<?php echo $cod_objetivo_array;?>";        
        array_objetivo = arr_objetivo.split('|');    
        for (i in array_objetivo) {            
            $('#btn_objetivo_' + array_objetivo[i]).prop("checked", true);  
        }
    });     
</script>
<?php
rodape($dbcon);
?>