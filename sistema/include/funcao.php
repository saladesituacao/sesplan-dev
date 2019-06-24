<?php

function js_alert($mensagem)
{
    print "<script language=javascript> alert('$mensagem');</script>";
}

function js_go($txt_pagina)
{
    echo("<script language=javascript>self.location.href='$txt_pagina';</script>");
}

function js_go_back($mensagem)
{ 
    echo("<script language=javascript>alert('$mensagem');history.go(-1);</script>");
}

function destacar_ativo($valor) {
    if ($valor == "1") {
        return "<font color=\"green\"><b>SIM</b></font>";
    } else {
        return "<font color=\"red\"><b>NÃO</b></font>";
    }
}

function destacar_habilitado($valor) {
    if ($valor == "S") {
        return "<font color=\"green\"><b>SIM</b></font>";
    } else {
        return "<font color=\"red\"><b>NÃO</b></font>";
    }
}

function destacar_ativo2($valor) {
    if ($valor == "1") {
        return "SIM";
    } else {
        return "NÃO";
    }
}

function limpar_comparacao($texto) {
	if ($texto!="") {
		$texto=trim($texto);
		if (is_numeric($texto)) {
			$texto=intval($texto);
		}
	}
	return $texto;
}

function RetornaTextoMes($cod_mes) {
    switch ($cod_mes) { 
        case "1":
            $txt_mes = "Janeiro";
            break;
        case "2":
            $txt_mes = "Fevereiro";
            break;
        case "3":
            $txt_mes = "Março";
            break;
        case "4":
            $txt_mes = "Abril";
            break;
        case "5":
            $txt_mes = "Maio";
            break;
        case "6":
            $txt_mes = "Junho";
            break;
        case "7":
            $txt_mes = "Julho";
            break;
        case "8":
            $txt_mes = "Agosto";
            break;
        case "9":
            $txt_mes = "Setembro";
            break;
        case "10":
            $txt_mes = "Outubro";
            break;
        case "11":
            $txt_mes = "Novembro";
            break;
        case "12":
            $txt_mes = "Dezembro";
            break;
    }

    return $txt_mes;
}

function RetornaTextoMesPAS($cod_mes) {
    switch ($cod_mes) { 
        case "1":
            $txt_mes = "Janeiro/Fevereiro";
            break;       
        case "2":
            $txt_mes = "Março/Abril";
            break;       
        case "3":
            $txt_mes = "Maio/Junho";
            break;      
        case "4":
            $txt_mes = "Julho/Agosto";
            break;
        case "5":
            $txt_mes = "Setembro/Outubro";
            break;      
        case "6":
            $txt_mes = "Novembro/Dezembro";
            break;       
    }

    return $txt_mes;
}

function MascaraCPF($cpf) {
    $parte_um     = substr($cpf, 0, 3);
    $parte_dois   = substr($cpf, 3, 3);
    $parte_tres   = substr($cpf, 6, 3);
    $parte_quatro = substr($cpf, 9, 2);

    return $parte_um.".".$parte_dois.".".$parte_tres."-".$parte_quatro;
}

function FormataData($data) {
    if (!empty($data)) {
        return date("d/m/Y", strtotime($data));
    } else {
        return '';
    }    
}

function DataBanco($dateSql){
    $ano= substr($dateSql, 6);
    $mes= substr($dateSql, 3,-5);
    $dia= substr($dateSql, 0,-8);
    return $ano."-".$mes."-".$dia;    
}

function formatarDataBrasil($data){    
    $ano = substr($data,0,4);
    $mes = substr($data,5,2);
    $dia = substr($data,8,2);

    return $dia . "/" . $mes . "/" . $ano;
}

function ObjetoData($data) {
    $retorno = new DateTime($data, new DateTimeZone( 'America/Sao_Paulo'));
    $retorno = $retorno->format("d/m/Y");

    return $retorno;
}

function remove_acento($textos) {
	if (isset($textos)) {
		$textos=str_replace("á", "a",$textos);
		$textos=str_replace("â", "a",$textos);
		$textos=str_replace("ã", "a",$textos);
		$textos=str_replace("à", "a",$textos);
		$textos=str_replace("ä", "a",$textos);
		$textos=str_replace("Â", "A",$textos);
		$textos=str_replace("À", "A",$textos);
		$textos=str_replace("Á", "A",$textos);
		$textos=str_replace("Ä", "A",$textos);
		$textos=str_replace("Ã", "A",$textos);
		$textos=str_replace("Ê", "E",$textos);
		$textos=str_replace("È", "E",$textos);
		$textos=str_replace("É", "E",$textos);
		$textos=str_replace("Ë", "E",$textos);
		$textos=str_replace("é", "e",$textos);
		$textos=str_replace("ê", "e",$textos);
		$textos=str_replace("è", "e",$textos);
		$textos=str_replace("ë", "e",$textos);
		$textos=str_replace("í", "i",$textos);
		$textos=str_replace("ì", "i",$textos);
		$textos=str_replace("ï", "i",$textos);
		$textos=str_replace("î", "i",$textos);
		$textos=str_replace("Í", "I",$textos);
		$textos=str_replace("Ì", "I",$textos);
		$textos=str_replace("Ï", "I",$textos);
		$textos=str_replace("Î", "I",$textos);
		$textos=str_replace("ó", "o",$textos);
		$textos=str_replace("ò", "o",$textos);
		$textos=str_replace("ô", "o",$textos);
		$textos=str_replace("õ", "o",$textos);
		$textos=str_replace("ö", "o",$textos);
		$textos=str_replace("Ó", "O",$textos);
		$textos=str_replace("Ô", "O",$textos);
		$textos=str_replace("Ò", "O",$textos);
		$textos=str_replace("Õ", "O",$textos);
		$textos=str_replace("Ö", "O",$textos);
		$textos=str_replace("ú", "u",$textos);
		$textos=str_replace("ù", "u",$textos);
		$textos=str_replace("û", "u",$textos);
		$textos=str_replace("ü", "u",$textos);
		$textos=str_replace("Ú", "U",$textos);
		$textos=str_replace("Ù", "U",$textos);
		$textos=str_replace("Ü", "U",$textos);
		$textos=str_replace("Û", "U",$textos);
		$textos=str_replace("ç", "c",$textos);
		$textos=str_replace("Ç", "C",$textos);
		$textos=str_replace(" ", "_",$textos);
		$textos=str_replace("!", "_",$textos);
		$textos=str_replace("@", "_",$textos);
		$textos=str_replace("#", "_",$textos);
		$textos=str_replace("$", "_",$textos);
		$textos=str_replace("%", "_",$textos);
		$textos=str_replace("¨", "_",$textos);
		$textos=str_replace("&", "_",$textos);
		$textos=str_replace("*", "_",$textos);
		$textos=str_replace("(", "_",$textos);
		$textos=str_replace(")", "_",$textos);
		$textos=str_replace("-", "_",$textos);
		$textos=str_replace("+", "_",$textos);
		$textos=str_replace("=", "_",$textos);
		$textos=str_replace("§", "_",$textos);
		$textos=str_replace("'", "_",$textos);
		$textos=str_replace("´", "_",$textos);
		$textos=str_replace("`", "_",$textos);
		$textos=str_replace("{", "_",$textos);
		$textos=str_replace("}", "_",$textos);
		$textos=str_replace("[", "_",$textos);
		$textos=str_replace("]", "_",$textos);
		$textos=str_replace("ª", "_",$textos);
		$textos=str_replace("º", "_",$textos);
		$textos=str_replace("°", "_",$textos);
		$textos=str_replace("|", "_",$textos);
		$textos=str_replace(",", "_",$textos);
		$textos=str_replace(":", "_",$textos);
		$textos=str_replace(";", "_",$textos);
		$textos=str_replace("^", "_",$textos);
		$textos=str_replace("~", "_",$textos);
		$textos=str_replace(",", "_",$textos);
		$textos=str_replace(chr(166), "_",$textos);
		$textos=str_replace(chr(167), "_",$textos);
		$textos=str_replace(chr(248), "_",$textos);
		$textos=str_replace(chr(176), "_",$textos);
		$textos=str_replace(chr(186), "_",$textos);
    }
    return $textos ;
}

function fn_owner($sql) {
    return str_replace('tb_', 'SESPLAN.tb_', $sql);
}


function limitarTexto($texto, $limite){
    $contador = strlen($texto);
    if ( $contador >= $limite ) {
        $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
        return $texto;
    }
    else{
      return $texto;
    }
  }

?>