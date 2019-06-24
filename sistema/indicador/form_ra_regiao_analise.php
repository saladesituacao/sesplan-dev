<div class="row">
    <div class="table-responsive col-md-12">
        <center><b><?php echo($txt_regiao) ?></b><center>
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Região Administrativa</th>
                    <th>Numerador:</th>
                    <th>Denominador:</th>
                    <th>Resultado:</th>                                            
                    <th>Data Extração:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_regiao = "SELECT tb_regiao_administrativa.* FROM tb_regiao_administrativa ";
                $sql_regiao .= " INNER JOIN tb_regiao ON tb_regiao.cod_regiao = tb_regiao_administrativa.cod_regiao ";
                $sql_regiao .= " WHERE tb_regiao_administrativa.cod_ativo = 1 ORDER BY txt_regiao, cod_ra";
                $q = pg_query($sql_regiao);
                $cod_ra_qtd = 0;                                                

                $txt_resultado_valor_numerador_ra_total = 0;
                $txt_resultado_valor_denominador_ra_total = 0;
                $txt_resultado_valor_resultado_ra_total = 0;

                while ($rs1 = pg_fetch_array($q)) { 
                    $cod_ra = $rs1['cod_ra'];
                    $txt_ra = $rs1['txt_ra'];
                    $cod_regiao_ra = $rs1['cod_regiao'];                                                                                                        

                    if ($cod_ra_qtd == 0 || limpar_comparacao($cod_regiao_ra) != limpar_comparacao($cod_regiao_ra_anterior)) {
                        $sql_2 = "SELECT txt_regiao FROM tb_regiao WHERE cod_regiao = ".$cod_regiao_ra;
                        $q_2 = pg_query($sql_2);
                        $rs1_2 = pg_fetch_array($q_2);  
                        
                        $sql_3 = "SELECT MAX(cod_ra) AS cod_ra FROM tb_regiao_administrativa WHERE cod_regiao = ".$cod_regiao_ra." AND cod_ativo = 1";
                        $q_3 = pg_query($sql_3);
                        $rs1_3 = pg_fetch_array($q_3);
                        $cod_ra_total = $rs1_3['cod_ra'];
                    ?>
                        <tr>
                            <td colspan="5">
                                <center><b>Região <?php echo($rs1_2['txt_regiao']) ?></b><center>
                            </td>
                        </tr>
                    <?php
                    }
                    //NUMERADOR
                    $valor_numerador_ra = $clsIndicador->RetornaValorNumeradorRA($id, $ct_mes, $cod_regiao, $cod_ra);
                    $valor_denominador_ra = $clsIndicador->RetornaValorDenominadorRA($id, $ct_mes, $cod_regiao, $cod_ra);
                    $valor_resultado_ra = $clsIndicador->RetornaValorResultadoRA($id, $ct_mes, $cod_regiao, $cod_ra);                                                                                                    
                    
                    $valor_numerador_ra_total = str_replace(".", "", (string)$valor_numerador_ra);
                    $valor_numerador_ra_total = str_replace(",", ".", (string)$valor_numerador_ra_total);
                    if (empty($valor_numerador_ra_total)) {
                        $valor_numerador_ra_total = 0;
                    }                                                    
                    $txt_resultado_valor_numerador_ra_total = $txt_resultado_valor_numerador_ra_total + $valor_numerador_ra_total;                                                                                                        
                                                                        
                    //DENOMINADOR
                    $valor_denominador_ra_total = str_replace(".", "", (string)$valor_denominador_ra);
                    $valor_denominador_ra_total = str_replace(",", ".", (string)$valor_denominador_ra_total);
                    if (empty($valor_denominador_ra_total)) {
                        $valor_denominador_ra_total = 0;
                    }
                    $txt_resultado_valor_denominador_ra_total = $txt_resultado_valor_denominador_ra_total + $valor_denominador_ra_total;                                                                                                        

                    //RESULTADO
                    $valor_resultado_ra_total = str_replace(".", "", (string)$valor_resultado_ra);
                    $valor_resultado_ra_total = str_replace(",", ".", (string)$valor_resultado_ra_total);                                                    
                    if (empty($valor_resultado_ra_total)) {
                        $valor_resultado_ra_total = 0;
                    }                                                    
                    
                    $txt_resultado_valor_resultado_ra_total = str_replace(".", "", (string)$txt_resultado_valor_resultado_ra_total);
                    $txt_resultado_valor_resultado_ra_total = str_replace(",", ".", (string)$txt_resultado_valor_resultado_ra_total);

                    if (!empty($polaridade)) {                                                         
                        if($absoluto != 'SIM') {
                            $txt_resultado_valor_resultado_ra_total = $clsIndicador->CalcularResultado($id, trim($txt_resultado_valor_numerador_ra_total), trim($txt_resultado_valor_denominador_ra_total));
                        }            
                        else {
                            $txt_resultado_valor_resultado_ra_total = $txt_resultado_valor_numerador_ra_total;                                                                                                                                                                    
                        }   

                        $txt_resultado_valor_resultado_ra_total = @number_format($txt_resultado_valor_resultado_ra_total, 2, ",", ".");
                    } 
                    ?>                                                    
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="cod_ra<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_ra?>" disabled="disabled">
                            <input type="hidden" id="cod_ra<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$cod_ra?>" />    
                        </td>
                        <td><input type="text" class="form-control" id="ra_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$valor_numerador_ra?>" <?php echo($disabled) ?>></td>
                        <td><input type="text" class="form-control" id="ra_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$valor_denominador_ra?>" <?php echo($bloquear_denominador) ?>></td>
                        <td><input type="text" class="form-control" id="ra_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$valor_resultado_ra?>" disabled="disabled"></td>                                            
                        <td><input type="text" class="form-control" id="ra_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$clsIndicador->RetornaValorExtracaoRA($id, $ct_mes, $cod_regiao, $cod_ra)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>                                                         
                    </tr> <?php                                                     
                    $cod_ra_qtd += 1;
                    $cod_regiao_ra_anterior = $cod_regiao_ra;
                    
                    if(limpar_comparacao($cod_ra) == limpar_comparacao($cod_ra_total)) {
                    ?>
                        <tr>
                            <td>
                                <center><strong>Total</strong><center>
                            </td>
                            <td><input type="text" class="form-control" id="ra_cod_numerador_regiao_total<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_resultado_valor_numerador_ra_total?>" disabled="disabled"></td>
                            <td><input type="text" class="form-control" id="ra_cod_denominador_regiao_total<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_resultado_valor_denominador_ra_total?>" disabled="disabled"></td>
                            <td><input type="text" class="form-control" id="ra_cod_resultado_regiao_total<?=$ct_mes?>_<?=$cod_ra?>" value="<?=$txt_resultado_valor_resultado_ra_total?>" disabled="disabled"></td>                                                                                                        
                        </tr>
                    <?php
                        $txt_resultado_valor_numerador_ra_total = 0;
                        $txt_resultado_valor_denominador_ra_total = 0;
                        $txt_resultado_valor_resultado_ra_total = 0;
                    }                                                                                                        
                }
                ?>                                                
            </tbody>
        </table>  
        <input type="hidden" id="cod_ra_qtd" value="<?=$cod_ra_qtd?>" />                                     
    </div> 
</div>