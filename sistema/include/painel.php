<?php
include_once (__DIR__ . "/conexao.php");
include_once (__DIR__ . "/../classes/clsIndicador.php");
include_once (__DIR__ . "/../classes/clsPas.php");
include_once (__DIR__ . "/../classes/clsSag.php");

$clsIndicador = new clsIndicador();
$clsPas = new clsPas();
$clsSag = new clsSag();

$acao = $_REQUEST['acao'];
$cod_modulo = $_REQUEST['cod_modulo'];
$cod_eixo = $_REQUEST['cod_eixo'];
$cod_perspectiva = $_REQUEST['cod_perspectiva'];
$cod_diretriz = $_REQUEST['cod_diretriz'];
$cod_orgao = $_REQUEST['cod_orgao'];
$cod_status = $_REQUEST['cod_status'];

switch ($acao) {
    case 'tabela_status':
        $sql = "SELECT tbsm.cod_status, tbs.txt_status FROM tb_status_modulo tbsm ";
        $sql .= " INNER JOIN tb_status tbs ON tbs.cod_status = tbsm.cod_status ";
        $sql .= " WHERE tbsm.cod_exibir_consulta = 1 AND tbsm.cod_modulo = ".$cod_modulo;

        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tabela_eixo':
        $sql = "SELECT * FROM tb_eixo WHERE cod_ativo = 1 ORDER BY cod_eixo";
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tabela_perspectiva':
        $sql = "SELECT * FROM tb_perspectiva WHERE cod_eixo = ".$cod_eixo." AND cod_ativo = 1 ORDER BY cod_perspectiva";
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;
    
    case 'tabela_diretriz':
        $sql = "SELECT * FROM tb_diretriz WHERE cod_eixo = ".$cod_eixo." AND cod_perspectiva = ".$cod_perspectiva;
        $sql .= " AND cod_ativo = 1 ORDER BY cod_diretriz";        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tabela_objetivo':
        $sql = "SELECT * FROM tb_objetivo WHERE cod_eixo = ".$cod_eixo." AND cod_perspectiva = ".$cod_perspectiva;
        $sql .= " AND cod_diretriz = ".$cod_diretriz." AND cod_ativo = 1 ORDER BY cod_objetivo";        
        $query = pg_query($sql);        
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'tag_indicador':
        $sql = "SELECT ds_tag, (SELECT COUNT(ds_tag) FROM tb_indicador_tag) AS qtd FROM tb_indicador_tag GROUP BY ds_tag ORDER BY ds_tag";
        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;
    
    case 'programa_trabalho':
        $sql = "SELECT tpt.cod_programa_trabalho, tpt.nr_programa_trabalho FROM tb_sag ts ";
        $sql .= " INNER JOIN tb_programa_trabalho tpt ON tpt.cod_programa_trabalho = ts.cod_programa_trabalho ";
        $sql .= " GROUP BY tpt.cod_programa_trabalho, tpt.nr_programa_trabalho ";
        $sql .= " ORDER BY tpt.nr_programa_trabalho ";        
        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;  
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'unidades_filhas':
        /*$sql = "WITH RECURSIVE arvore AS ";
        $sql .= " (SELECT t1.cod_orgao, txt_sigla, cod_exibir_consulta ";
        $sql .= " FROM tb_orgao AS t1 ";
        $sql .= " WHERE cod_orgao = ".$cod_orgao;
        $sql .= " UNION ALL SELECT t2.cod_orgao, t2.txt_sigla, t2.cod_exibir_consulta ";
        $sql .= " FROM tb_orgao AS t2 INNER JOIN arvore ON cod_orgao_superior = arvore.cod_orgao) "; 
        $sql .= " SELECT arvore.cod_orgao, arvore.txt_sigla, arvore.cod_exibir_consulta FROM arvore ";
        $sql .= " WHERE arvore.cod_orgao <> ".$cod_orgao." AND arvore.cod_exibir_consulta = 1 ORDER BY arvore.txt_sigla ";*/
        
        $sql = "SELECT * FROM tb_orgao WHERE cod_exibir_consulta = 1 AND cod_orgao_superior = ".$cod_orgao." AND cod_ativo = 1 ORDER BY txt_sigla";        
        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;            
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'sigla_unidade':
        $sql = "SELECT txt_sigla FROM tb_orgao WHERE cod_orgao = ".$cod_orgao;;

        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;            
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'acao_pas':
        $sql = "SELECT cod_pas, txt_acao, codigo_acao FROM tb_pas WHERE cod_ativo = 1 ORDER BY codigo_acao";
        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;            
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'etapa_sag':
        $sql = "SELECT cod_sag, txt_etapa_trabalho, nr_etapa_trabalho FROM tb_sag WHERE cod_ativo = 1 ORDER BY nr_etapa_trabalho";
        $query = pg_query($sql);    
        $arr = array();

        if(pg_num_rows($query) > 0) {
            while($row = pg_fetch_assoc($query)) {
                $arr[] = $row;            
            } 
        }                
        echo(json_encode($arr));
        break;

    case 'porcentagem_pas':
        $qtd_total_pas = qtd_total_pas();
        if($qtd_total_pas > 0) {
            $total = $qtd_total_pas;

            $sql = "SELECT cod_pas FROM tb_pas WHERE EXTRACT(YEAR from tb_pas.dt_inclusao) = ".$_SESSION['ano_corrente'];
            $q1 = pg_query($sql);
            if (pg_num_rows($q1) > 0) {
                $total_status = 0;
                while ($r = pg_fetch_array($q1)) {
                    $_cod_status_painel = $clsPas->SituacaoPAS($r['cod_pas']);
                    if (strval($_cod_status_painel) == strval($cod_status)) {
                        $total_status = $total_status + 1;
                    }
                }

                $resultado = $total_status * 100;
                $resultado = $resultado / $total;
                $resultado = @number_format($resultado, 2, ',', '.');

                if (substr($resultado, -3) == ',00') {
                    $resultado = trim(str_replace(substr($resultado, -3), "", $resultado));  
                }

                echo($resultado."|".$total_status);
            } else {
                echo("0|0");
            }
        } else {
            echo("0|0");
        }
        break;

    case 'porcentagem_sag':
        $qtd_total_sag = qtd_total_sag();        
        if($qtd_total_sag > 0) {
            $total = $qtd_total_sag;
            $cod_mes_monitoramento = $clsSag->MesMonitoramentoPainel();             
            
            if(strval($cod_status) == "24") {
                $condicao_sag = " AND cod_sag NOT IN(SELECT cod_sag FROM tb_sag_analise WHERE cod_bimestre = ".$cod_mes_monitoramento.")";   
            } else {
                $condicao_sag = " AND cod_sag IN(SELECT cod_sag FROM tb_sag_analise WHERE cod_bimestre = ".$cod_mes_monitoramento." AND cod_status = ".$cod_status.")";   
            }

            $sql = "SELECT COUNT(cod_sag) AS qtd FROM tb_sag INNER JOIN tb_programa_trabalho ON tb_programa_trabalho.cod_programa_trabalho = tb_sag.cod_programa_trabalho 
                    WHERE EXTRACT(YEAR from tb_sag.dt_inclusao) = ".$_SESSION['ano_corrente']." AND tb_programa_trabalho.cod_emenda IN (0,1)".$condicao_sag;                        
                       
            $q1 = pg_query($sql);
            if (pg_num_rows($q1) > 0) {                
                $r = pg_fetch_array($q1);
                $total_status = $r['qtd'];                

                $resultado = $total_status * 100;
                $resultado = $resultado / $total;
                $resultado = @number_format($resultado, 2, ',', '.');

                if (substr($resultado, -3) == ',00') {
                    $resultado = trim(str_replace(substr($resultado, -3), "", $resultado));  
                }

                echo($resultado."|".$total_status);
            } else {
                echo("0|0");
            }
        } else {
            echo("0|0");
        }
    break;

    case 'porcentagem_indicador':
        if ($cod_status != '0') {
            $qtd_total_indicadores = qtd_total_indicadores();
            if($qtd_total_indicadores > 0) {
                $total = $qtd_total_indicadores;                                  
                
                $sql = "SELECT cod_chave, cod_indicador, ds_periodicidade FROM tb_indicador ";
                $sql .= " INNER JOIN tb_indicador_tag ON tb_indicador_tag.co_indicador = tb_indicador.cod_indicador ";
                $sql .= " WHERE EXTRACT(YEAR from tb_indicador.dt_inclusao) = ".$_SESSION['ano_corrente'];                
                $sql .= " GROUP BY cod_chave, cod_indicador, ds_periodicidade ";

                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) {
                    $total_status = 0;
                    while ($r = pg_fetch_array($q1)) {
                        $cod_mes_monitoramento = $clsIndicador->MesMonitoramentoPainel($r['ds_periodicidade']);

                        if ($cod_mes_monitoramento != "") {  
                            if (intval($cod_mes_monitoramento) <= intval($_SESSION['mes_corrente'])) {
                                $sql = "SELECT COUNT(tb.cod_chave) AS qtd FROM tb_indicador_analise tb ";
                                $sql .= " WHERE tb.cod_chave = ".$r['cod_chave']." AND tb.cod_periodo = ".$cod_mes_monitoramento;
                                $sql .= " AND tb.cod_status = ".$cod_status;
                                $query = pg_query($sql);
                                $row = pg_fetch_assoc($query);
                                $total_status = $total_status + $row['qtd'];                                                                
                            }                                                                                                              
                        }
                    }                                             
                    $resultado = $total_status * 100;
                    $resultado = $resultado / $total;
                    $resultado = @number_format($resultado, 2, ',', '.');

                    if (substr($resultado, -3) == ',00') {
                        $resultado = trim(str_replace(substr($resultado, -3), "", $resultado));  
                    }

                    echo($resultado."|".$total_status);
                } else {                    
                    echo("0|0");
                }                
            } else {                              
                echo("0|0");
            }    
        } else {
            $qtd_total_indicadores = qtd_total_indicadores();

            if($qtd_total_indicadores > 0) {
                $total = $qtd_total_indicadores;
                
                $sql = "SELECT ds_periodicidade FROM tb_indicador ";
                $sql .= " INNER JOIN tb_indicador_tag ON tb_indicador_tag.co_indicador = tb_indicador.cod_indicador ";
                $sql .= " WHERE EXTRACT(YEAR from tb_indicador.dt_inclusao) = ".$_SESSION['ano_corrente'];
                $sql .= " GROUP BY ds_periodicidade ";

                $sql = "SELECT cod_chave, cod_indicador, ds_periodicidade FROM tb_indicador ";
                $sql .= " INNER JOIN tb_indicador_tag ON tb_indicador_tag.co_indicador = tb_indicador.cod_indicador ";
                $sql .= " WHERE EXTRACT(YEAR from tb_indicador.dt_inclusao) = ".$_SESSION['ano_corrente'];                
                $sql .= " GROUP BY cod_chave, cod_indicador, ds_periodicidade ";

                $q1 = pg_query($sql);
                if (pg_num_rows($q1) > 0) {
                    $total_status = 0;
                    while ($r = pg_fetch_array($q1)) {
                        $cod_mes_monitoramento = $clsIndicador->MesMonitoramentoPainel($r['ds_periodicidade']);
    
                        if ($cod_mes_monitoramento != "") {  
                            if (intval($cod_mes_monitoramento) <= intval($_SESSION['mes_corrente'])) {
                                $sql = "SELECT COUNT(tb.cod_chave) AS qtd ";
                                $sql .= " FROM tb_indicador tb ";                      
                                $sql .= " WHERE tb.cod_chave = ".$r['cod_chave']." AND tb.cod_chave NOT IN( ";
                                $sql .= " SELECT u.cod_chave FROM tb_indicador_analise u WHERE u.cod_periodo = ".$cod_mes_monitoramento.") ";
                                $query = pg_query($sql);
                                $row = pg_fetch_assoc($query);
                                $total_status = $total_status + $row['qtd'];
                            }                                                                                                              
                        }                        
                    }
    
                    $resultado = $total_status * 100;
                    $resultado = $resultado / $total;
                    $resultado = @number_format($resultado, 2, ',', '.');
    
                    if (substr($resultado, -3) == ',00') {
                        $resultado = trim(str_replace(substr($resultado, -3), "", $resultado));  
                    }
                    
                    echo($resultado."|".$total_status);
                } else {                    
                    echo("0|0");
                }  
            } else {                               
                echo("0|0");
            }                                
        }        

        break;            

    case 'qtd_total_indicadores':        
        echo(qtd_total_indicadores());
        break;

    case 'qtd_total_pas':        
        echo(qtd_total_pas());
        break;

    case 'qtd_total_sag':
        echo(qtd_total_sag());
        break;

    case 'ano_corrente':
        $_SESSION['ano_corrente'] = $_REQUEST['cod_ano_corrente'];
        echo($_SESSION['ano_corrente']);
        break;

    case 'mes_corrente':
        $_SESSION['mes_corrente'] = $_REQUEST['cod_mes_corrente'];
        echo($_SESSION['mes_corrente']);
        break;    

    case 'bimestre_corrente':
        $_SESSION['cod_bimestre_corrente'] = $_REQUEST['cod_bimestre_corrente'];
        echo($_SESSION['cod_bimestre_corrente']);
        break;
}

function qtd_total_indicadores() {
    $sql = "SELECT COUNT(cod_chave) AS qtd FROM tb_indicador ";
    $sql .= " WHERE EXTRACT(YEAR from dt_inclusao) = ".$_SESSION['ano_corrente'];
    $query = pg_query($sql);
    $row = pg_fetch_assoc($query);

    return $row['qtd'];
}

function qtd_total_pas() {
    $sql = "SELECT COUNT(cod_pas) AS qtd FROM tb_pas ";
    $sql .= " WHERE EXTRACT(YEAR from dt_inclusao) = ".$_SESSION['ano_corrente'];
    $query = pg_query($sql);
    $row = pg_fetch_assoc($query);

    return $row['qtd'];
}

function qtd_total_sag() {
    $sql = "SELECT COUNT(cod_sag) AS qtd FROM tb_sag WHERE EXTRACT(YEAR from dt_inclusao) = ".$_SESSION['ano_corrente'];   
    $query = pg_query($sql);
    $row = pg_fetch_assoc($query);

    return $row['qtd'];
}
?>