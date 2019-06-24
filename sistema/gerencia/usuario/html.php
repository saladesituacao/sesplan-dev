<?php
include_once (__DIR__ . "/../../include/conexao.php");

if(isset($_REQUEST["acao"])) 
{
    $acao = utf8_decode($_REQUEST["acao"]);
  
    if($acao == "div_hospital")
    {        
        $cod_regiao = $_REQUEST["cod_regiao"];        

        if(empty($cod_regiao)) {
            $html = "SELECIONE A REGIÃO";
        }
        else {            
            $q=pg_query("SELECT cod_hospital, txt_hospital FROM tb_hospital WHERE cod_regiao = " .$cod_regiao. " AND cod_ativo = 1");        
            $html = "<select id='cod_hospital' name='cod_hospital' class='chosen-select' data-placeholder='---'">";
            $html .= "<option></option>";  
            if (pg_num_rows($q) > 0) {                
                while ($row = pg_fetch_array($q)) {                                              
                    $html .= "<option value='".$row['cod_hospital']."'>".$row['txt_hospital']."</option>";            
                }
            } 
            $html .= "</select>";
        }       
        
        echo($html);        
    }    
}
    
?>