<div class="row">
    <div class="table-responsive col-md-12">
        <center><b>Hospitais</b><center>
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
                $sql_regiao = "SELECT tb_hospital.* FROM tb_hospital INNER JOIN tb_indicador_hospital ON tb_indicador_hospital.cod_hospital =   
                            tb_hospital.cod_hospital WHERE tb_hospital.cod_tipo = 1 AND tb_hospital.cod_ativo = 1 AND tb_indicador_hospital.cod_chave = ".$id."  
                            ORDER BY tb_hospital.cod_hospital";
                $q = pg_query($sql_regiao);
                $cod_hosp_qtd = 0;
                while ($rs1 = pg_fetch_array($q)) { 
                    $cod_hospital = $rs1['cod_hospital'];
                    $txt_hospital = $rs1['txt_hospital'];
                    $txt_sigla_hospital = $rs1['txt_sigla_hospital'];
                    ?>
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="cod_hospital<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$txt_sigla_hospital?>" title="<?=$txt_hospital?>" disabled="disabled">
                            <input type="hidden" id="cod_hospital<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$cod_hospital?>" />    
                        </td>
                        <td><input type="text" class="form-control" id="hosp_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorNumeradorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($disabled) ?>></td>
                        <td><input type="text" class="form-control" id="hosp_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorDenominadorHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" <?php echo($bloquear_denominador) ?>></td>
                        <td><input type="text" class="form-control" id="hosp_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorResultadoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" disabled="disabled"></td>                                            
                        <td><input type="text" class="form-control" id="hosp_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_hospital?>" value="<?=$clsIndicador->RetornaValorExtracaoHosp($id, $ct_mes, $cod_regiao, $cod_hospital)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>                                                          
                    </tr> <?php
                    $cod_hosp_qtd += 1;  
                    $cod_hosp_ind .= "[".$cod_hospital."]";                                                                                          
                }
                $cod_hosp_ind = str_replace('][', ',', $cod_hosp_ind);
                $cod_hosp_ind = str_replace(']', '', $cod_hosp_ind);
                $cod_hosp_ind = str_replace('[', '', $cod_hosp_ind);
                ?>    
                <input type="hidden" id="cod_hosp_qtd" value="<?=$cod_hosp_qtd?>" />  
                <input type="hidden" id="cod_hosp_ind<?=$ct_mes?>" value="<?=$cod_hosp_ind?>" />  
                <?php  
                $cod_hosp_ind = "";
                ?>                                              
            </tbody>
        </table>                                        
    </div> 
</div>