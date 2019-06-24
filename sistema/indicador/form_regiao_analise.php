<div class="row">
    <div class="table-responsive col-md-12">
        <center><strong>Região</strong><center>
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Região de Saúde</th>
                    <th>Numerador:</th>
                    <th>Denominador:</th>
                    <th>Resultado:</th>                                            
                    <th>Data Extração:</th>
                </tr>
            </thead>
            <tbody>
                <?php                                                
                $sql_regiao = "SELECT * FROM tb_regiao WHERE cod_ativo = 1 ORDER BY cod_regiao";
                $q = pg_query($sql_regiao);
                $cod_reg_qtd = 0;
                while ($rs1 = pg_fetch_array($q)) { 
                    $cod_regiao_saude = $rs1['cod_regiao'];
                    $txt_regiao = $rs1['txt_regiao'];                                                    
                    ?>
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="cod_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$txt_regiao?>" disabled="disabled">
                            <input type="hidden" id="cod_regiao_saude<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$cod_regiao_saude?>" />    
                        </td>
                        <td><input type="text" class="form-control" id="reg_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorNumeradorReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" <?php echo($disabled) ?>></td>
                        <td><input type="text" class="form-control" id="reg_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorDenominadorReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" <?php echo($bloquear_denominador) ?>></td>
                        <td><input type="text" class="form-control" id="reg_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorResultadoReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" disabled="disabled"></td>                                            
                        <td><input type="text" class="form-control" id="reg_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>" value="<?=$clsIndicador->RetornaValorExtracaoReg($id, $ct_mes, $cod_regiao, $cod_regiao_saude)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>  

                        <script type="text/javascript">
                            /*
                            jQuery(function($){                    
                                $('#reg_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                $('#reg_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                $('#reg_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_regiao_saude?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                            });
                            */
                        </script>
                    </tr> <?php
                    $cod_reg_qtd += 1;
                }
                ?>                                                                                                                                                
            </tbody>
        </table> 
        <input type="hidden" id="cod_reg_qtd" value="<?=$cod_reg_qtd?>" />                                       
    </div>                                    
</div>