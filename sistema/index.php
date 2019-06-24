<?php
include_once(__DIR__ . "/include/conexao.php");  
verifica_seguranca();
cabecalho();

if (empty($_SESSION['ano_corrente'])) {  
  $sql = "SELECT DATE_PART('YEAR', CURRENT_TIMESTAMP) AS ano";
  $rs = pg_fetch_array(pg_query($sql));  
  //$_SESSION['ano_corrente'] = $rs['ano'];
  $_SESSION['ano_corrente'] = "2018";
  
  if (empty($_SESSION['mes_corrente']) && intval($_SESSION['ano_corrente']) < intval($rs['ano'])) {
    $_SESSION['mes_corrente'] = "12";
    $_SESSION['cod_bimestre_corrente'] = "6";
  }
}

if (empty($_SESSION['mes_corrente'])) {
  $sql = "SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS mes ";
  $rs = pg_fetch_array(pg_query($sql)); 
  $_SESSION['mes_corrente'] = $rs['mes'];
}

if (empty($_SESSION['cod_bimestre_corrente'])) {
  $sql = "SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS mes ";
  $rs = pg_fetch_array(pg_query($sql));   
  switch(strval(strtolower($rs['mes']))) {
    case '1':
      $_SESSION['cod_bimestre_corrente'] = 1;
      break;
    case '2':
      $_SESSION['cod_bimestre_corrente'] = 1;
      break;
    case '3':
      $_SESSION['cod_bimestre_corrente'] = 2;
      break;
    case '4':
      $_SESSION['cod_bimestre_corrente'] = 2;
      break;
    case '5':
      $_SESSION['cod_bimestre_corrente'] = 3;
      break;
    case '6':
      $_SESSION['cod_bimestre_corrente'] = 3;
      break;
    case '7':
      $_SESSION['cod_bimestre_corrente'] = 4;
      break;
    case '8':
      $_SESSION['cod_bimestre_corrente'] = 4;
      break;
    case '9':
      $_SESSION['cod_bimestre_corrente'] = 5;
      break;
    case '10':
      $_SESSION['cod_bimestre_corrente'] = 5;
      break;
    case '11':
      $_SESSION['cod_bimestre_corrente'] = 6;
      break;
    case '12':
      $_SESSION['cod_bimestre_corrente'] = 6;
      break;
  }
}

//js_alert(phpversion());
?>
<!-- Estilos Painel -->
<link href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/css/style_painel.css" rel="stylesheet">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/bower_components/font-awesome/css/font-awesome.min.css">

<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

<script type="text/javascript" src="<?php echo($_SESSION["txt_caminho_aplicacao"]); ?>/include/js/gauge.js"></script>

<div id="main" class="container-fluid" >
  <form id="frm1" method="post" action="painel/pesquisa.php">
    <input type="hidden" name="condicao_query" id="condicao_query" value="" />
    <div class="row">&nbsp;</div><!--row--> 
    <div class="row">
      <div class="col-md-12">                    
        <div class="funkyradio">                      
          <?php 
          $q1 = pg_query("SELECT * FROM tb_modulo WHERE cod_exibir_consulta = 1 AND cod_ordem IS NOT NULL ORDER BY cod_ordem");            
            while ($rs1 = pg_fetch_array($q1)) { ?> 
              <div class="col-md-3">                    
                <div class="funkyradio-success">     
                  <input type="radio" id="cod_modulo_<?=$rs1['cod_modulo']?>" name="cod_modulo" value="<?=$rs1['cod_modulo']?>" onclick="tabelaStatus(this.value);">
                  <label for="cod_modulo_<?=$rs1['cod_modulo']?>" title="<?=$rs1['txt_descricao']?>"><?=$rs1['txt_modulo']?></label>
                  <input type="hidden" name="cod_modulo_marcado" id="cod_modulo_marcado" value="" />
                </div><!--funkyradio-success-->                
              </div><!--col-md-3-->
            <?php        
            } ?>                                      
        </div><!--funkyradio-->                 
      </div><!--col-md-12--> 
    </div><!--row--> 
    <hr />   
    <div class="row">
      <div class="col-md-9"> 
        <div id="div_princ_sag">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">
                <div id='div_normal_result'></div> 
                <canvas id="div_normal" width="100" height="50" onmouseover="fn_total_status_sag(9)"></canvas> 
                <input type="hidden" name="hidden_normal_result" id="hidden_normal_result" value="" />
              </div>
              <div class="col-md-4">
                <div id='div_critico_sag_result'></div> 
                <canvas id="div_critico_sag" width="100" height="50" onmouseover="fn_total_status_sag(18)"></canvas> 
                <input type="hidden" name="hidden_critico_sag_result" id="hidden_critico_sag_result" value="" />
              </div>
              <div class="col-md-4">
                <div id='div_alerta_sag_result'></div> 
                <canvas id="div_alerta_sag" width="100" height="50" onmouseover="fn_total_status_sag(16)"></canvas> 
                <input type="hidden" name="hidden_alerta_sag_result" id="hidden_alerta_sag_result" value="" />                
              </div>
              <div class="col-md-4">
                <div id='div_nao_analisado_sag_result'></div> 
                <canvas id="div_nao_analisado_sag" width="100" height="50" onmouseover="fn_total_status_sag(24)"></canvas> 
                <input type="hidden" name="hidden_nao_analisado_sag_result" id="hidden_nao_analisado_sag_result" value="" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                
                <div id="div_total_sag"></div>
              </div>
            </div>
          </div>
        </div>
        <div id="div_princ_pas">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">
                <div id='div_cancelada_result'></div> 
                <canvas id="div_cancelada" width="100" height="50" onmouseover="fn_total_status_pas(6)"></canvas> 
                <input type="hidden" name="hidden_cancelada_result" id="hidden_cancelada_result" value="" />
              </div>
              <div class="col-md-4">
                <div id='div_concluida_result'></div> 
                <canvas id="div_concluida" width="100" height="50" onmouseover="fn_total_status_pas(4)"></canvas> 
                <input type="hidden" name="hidden_concluida_result" id="hidden_concluida_result" value="" />
              </div>
              <!--<div class="col-md-4">
                <div id='div_pendente_result'></div> 
                <canvas id="div_pendente" width="100" height="50" onmouseover="fn_total_status_pas(21)"></canvas> 
                <input type="hidden" name="hidden_pendente_result" id="hidden_pendente_result" value="" />
              </div>-->
              <!--<div class="col-md-4">
                <div id='div_prorrogada_result'></div> 
                <canvas id="div_prorrogada" width="100" height="50" onmouseover="fn_total_status_pas(22)"></canvas> 
                <input type="hidden" name="hidden_prorrogada_result" id="hidden_prorrogada_result" value="" />
              </div>-->
              <div class="col-md-4">
                <div id='div_atrasada_result'></div> 
                <canvas id="div_atrasada" width="100" height="50" onmouseover="fn_total_status_pas(5)"></canvas> 
                <input type="hidden" name="hidden_atrasada_result" id="hidden_atrasada_result" value="" />
              </div>
              <!--<div class="col-md-4">
                <div id='div_iniciada_result'></div> 
                <canvas id="div_iniciada" width="100" height="50" onmouseover="fn_total_status_pas(1)"></canvas> 
                <input type="hidden" name="hidden_iniciada_result" id="hidden_iniciada_result" value="" />
              </div>-->
              <div class="col-md-4">
                <div id='div_andamento_result'></div> 
                <canvas id="div_andamento" width="100" height="50" onmouseover="fn_total_status_pas(2)"></canvas> 
                <input type="hidden" name="hidden_andamento_result" id="hidden_andamento_result" value="" />
              </div>
              <div class="col-md-4">
                <div id='div_prazo_result'></div> 
                <canvas id="div_prazo" width="100" height="50" onmouseover="fn_total_status_pas(3)"></canvas> 
                <input type="hidden" name="hidden_prazo_result" id="hidden_prazo_result" value="" />
              </div>
              <!--<div class="col-md-4">
                <div id='div_postergada_result'></div> 
                <canvas id="div_postergada" width="100" height="50" onmouseover="fn_total_status_pas(15)"></canvas> 
                <input type="hidden" name="hidden_postergada_result" id="hidden_postergada_result" value="" />                
              </div>--> 
              <div class="col-md-4">
                <div id='div_nao_concluida_result'></div> 
                <canvas id="div_nao_concluida" width="100" height="50" onmouseover="fn_total_status_pas(25)"></canvas> 
                <input type="hidden" name="hidden_nao_concluida_result" id="hidden_nao_concluida_result" value="" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                
                <div id="div_total_pas"></div>
              </div>            
            </div>
          </div>
        </div>
        <div id="div_princ">
          <div class="col-md-12">          
            <div id="div_meta_acao_etapa"></div> 
            <div class="row">
              <div class="col-md-4">  
                <div id='div_alerta_result'></div>                                          
                <canvas id="div_alerta" width="100" height="50" onmouseover="fn_total_status(16)"></canvas> 
                <input type="hidden" name="hidden_alerta_result" id="hidden_alerta_result" value="" />
              </div>
              <div class="col-md-4">  
                <div id='div_muito_critico_result'></div>             
                <canvas id="div_muito_critico" width="100" height="50" onmouseover="fn_total_status(17)"></canvas> 
                <input type="hidden" name="hidden_muito_critico_result" id="hidden_muito_critico_result" value="" />
              </div>
              <div class="col-md-4">    
                <div id='div_critico_result'></div>           
                <canvas id="div_critico" width="100" height="50" onmouseover="fn_total_status(18)"></canvas>
                <input type="hidden" name="hidden_critico_result" id="hidden_critico_result" value="" />
              </div>
            </div>   
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="row">
              <div class="col-md-4">
                <div id='div_esperado_result'></div>
                <canvas id="div_esperado" width="100" height="50" onmouseover="fn_total_status(19)"></canvas>                
                <input type="hidden" name="hidden_esperado_result" id="hidden_esperado_result" value="" />
              </div>              
              <div class="col-md-4">
                <div id='div_superado_result'></div>
                <canvas id="div_superado" width="100" height="50" onmouseover="fn_total_status(20)"></canvas>                
                <input type="hidden" name="hidden_superado_result" id="hidden_superado_result" value="" />
              </div>  
              <div class="col-md-4">
                <div id='div_nao_analisado_result'></div>
                <canvas id="div_nao_analisado" width="100" height="50" onmouseover="fn_total_status(0)"></canvas>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                
                <div id="div_total_indicadores"></div>
              </div>                          
            </div>            
          </div><!--jumbotron-->  
        </div>                                                   

        <div id="div_espaco"></div>  
            
        <div class="row">                                    
          <div id="div_complemento"></div>
          <input type="hidden" name="cod_exibir_meta_complemento" id="cod_exibir_meta_complemento" value="0" />           
        </div>
        
        <div class="row">
          <div class="col-md-12">  
            <div class="jumbotron" style="background-image:url(<?php echo($_SESSION["txt_caminho_aplicacao"]) ?>/include/imagens/fundo_painel.jpg);" class="img-responsive">          
              <p>            
                <!--<center><font color="blue">ÁRVORE SES</font></center>-->
                <div class="row">
                  <div id="div_eixo"></div>               
                </div>
                <div class="row">
                  <div id="div_perspectiva"></div>
                </div>
                <div class="row">
                  <div id="div_diretriz"></div> 
                </div>
                <div class="row">
                  <div id="div_objetivo"></div>  
                </div>
              </p>
            </div> 
          </div>    
        </div>
      </div><!--col-md-9-->
      <div class="col-md-3">
        <div class="">
          <div align="left" style="text-align:left">
            <font color="blue">Competência</font><br />
            <select id="cod_ano_corrente" name="cod_ano_corrente" class="chosen-select col-md-3" onchange="AnoCorrente(this.value);">
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
          </div>
          <div class="row">&nbsp;</div>
          <div id="div_mes">
            <font color="blue">Mês</font><br />
            <select id="cod_mes" name="cod_mes" class="chosen-select col-md-4" onchange="MesCorrente(this.value);">
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
          </div>
          <div id="div_bimestre">
            <font color="blue">Bimestre</font><br />
            <select id="cod_bimestre_corrente" name="cod_bimestre_corrente" class="chosen-select col-md-4" onchange="BimestreCorrente(this.value);">
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
          </div>
          <div class="row">&nbsp;</div>          
          <div align="left" style="text-align:left">
            <font color="blue">Área Responsável</font>
          </div>
          <div align="left" style="text-align:left">
            <?php 
            $q1 = pg_query("SELECT * FROM tb_orgao WHERE cod_exibir_consulta = 1 AND cod_orgao_superior IS NULL AND cod_ativo = 1 AND txt_sigla NOT LIKE '%/%' ORDER BY txt_sigla");                     
              while ($rs1 = pg_fetch_array($q1)) { ?>     
                <div class="form-check">  
                  <div class="row col-md-12">                        
                    <input type="checkbox" class="form-check-input" id="cod_orgao_<?=$rs1['cod_orgao']?>" name="cod_orgao[]" value="<?=$rs1['cod_orgao']?>">&nbsp;<?=$rs1['txt_sigla']?>&nbsp;
                    <a class="btn btn btn-xs" id="btn_cod_orgao_<?=$rs1['cod_orgao']?>" onclick="Unidades(<?=$rs1['cod_orgao']?>);">+</a>
                  </div>                  
                  <div id="div_cod_orgao_<?=$rs1['cod_orgao']?>"></div>                 
                </div><!--form-check--> <?php
              } ?>            
          </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <div class="">  
          <div align="left" style="text-align:left"><font color="blue">Status</font></div>
          <div id="div_status" align="left"></div>
          <br />
          <div align="left"><button type="submit" id="btn_pesquisar" class="btn btn-primary btn-sm">Pesquisar</button><div>          
        </div>
      </div><!--col-md-3-->
    </div><!--row-->      
    <div class="row">  
      <div class="col-md-12">
       
      </div><!--col-md-12-->            
    </div><!--row-->    
  </form>
</div><!--main-->
     
<script src="include/js/painel.js" type="text/javascript"></script>     
<script type="application/javascript">
  $(document).ready(function() {
    tabelaStatus(3);  

    document.getElementById('cod_modulo_3').checked = true;        
  });  
</script> 
<?php
rodape($dbcon);
?>   