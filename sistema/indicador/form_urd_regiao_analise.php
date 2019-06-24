<div class="row">
    <div class="table-responsive col-md-12">
        <center><b>URD</b><center>
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>URD</th>
                    <th>Numerador:</th>
                    <th>Denominador:</th>
                    <th>Resultado:</th>                                            
                    <th>Data Extração:</th>
                </tr>
            </thead>
            <tbody>
                <?php                                                
                $sql_regiao = "SELECT * FROM tb_urd WHERE cod_ativo = 1 ORDER BY cod_urd";
                $q = pg_query($sql_regiao);
                $cod_urd_qtd = 0;
                while ($rs1 = pg_fetch_array($q)) { 
                    $cod_urd = $rs1['cod_urd'];
                    $txt_urd = $rs1['txt_urd']; 
                    $txt_sigla_urd = $rs1['txt_sigla'];                                                                                            
                    ?>
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="cod_urd<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$txt_sigla_urd?>" title="<?=$txt_urd?>" disabled="disabled">
                            <input type="hidden" id="cod_urd<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$cod_urd?>" />    
                        </td>
                        <td><input type="text" class="form-control" id="urd_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorNumeradorUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" <?php echo($disabled) ?>></td>
                        <td><input type="text" class="form-control" id="urd_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorDenominadorUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" <?php echo($bloquear_denominador) ?>></td>
                        <td><input type="text" class="form-control" id="urd_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorResultadoUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" disabled="disabled"></td>                                            
                        <td><input type="text" class="form-control" id="urd_dt_extracao_regiao<?=$ct_mes?>_<?=$cod_urd?>" value="<?=$clsIndicador->RetornaValorExtracaoUrd($id, $ct_mes, $cod_regiao, $cod_urd)?>" onkeydown="FormataData(this, event)" onkeypress="return isNumberKey(event)" <?php echo($disabled) ?>></td>  

                        <script type="text/javascript">
                            /*
                            jQuery(function($){                    
                                $('#urd_cod_numerador_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                $('#urd_cod_denominador_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                                $('#urd_cod_resultado_regiao<?=$ct_mes?>_<?=$cod_urd?>').maskMoney({ prefix: '', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false });           
                            });
                            */
                        </script>
                    </tr> <?php
                    $cod_urd_qtd += 1;
                }
                ?>                                                
            </tbody>
        </table>     
        <input type="hidden" id="cod_urd_qtd" value="<?=$cod_urd_qtd?>" />                                    
    </div>                                  
</div>