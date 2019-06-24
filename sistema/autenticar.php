<?php
include_once(__DIR__ . "/include/conexao.php");
include_once (__DIR__ . "/classes/clsUsuario.php");
include_once (__DIR__ . "/classes/clsPerfil.php");

$cpf = $_POST['field_login'];
$senha = $_POST['field_password'];

if ($cpf == "" || $senha == "") {
    echo("ERRO AO CONECTAR");
    exit();
}

$clsPerfil = new clsPerfil();

if ($_SESSION["txt_tipo_autenticacao"] == "1") {
    $ldap_server = $_SESSION['ldap_server'];
    $user = trim($cpf).$_SESSION['ldap_dominio'];
    $ldap_pass = $senha;
    $ldapcon = ldap_connect($ldap_server);

    if ($ldapcon) {    
        $bind = @ldap_bind($ldapcon, $_SESSION['ldap_endereco'], $_SESSION['ldap_pass']);
        
        if ($bind) {        
            $bind = @ldap_bind($ldapcon, $user, $ldap_pass);
            ldap_close($ldapcon);
            if ($bind == 1) {
                $clsUsuario = new clsUsuario();
                $q = $clsUsuario->ListarUsuario(" txt_login = '".trim($cpf)."'");            
                if (pg_num_rows($q) > 0) {   
                    $rs1 = pg_fetch_array($q);             
                    if (limpar_comparacao($rs1['cod_ativo']) == 0) {                    
                        js_go("login.php?mensagem=1");
                    } else {
                        $_SESSION["txt_login"] = $rs1['txt_login'];
                        $_SESSION["cod_usuario"] = $rs1['cod_usuario'];
                        $_SESSION["txt_usuario"] = $rs1['txt_usuario'];
                        $_SESSION["cod_perfil"] = $rs1['cod_perfil'];
                        $_SESSION["cod_orgao"] = $rs1['cod_orgao'];

                        Auditoria(1, "Usuário autenticado", "");

                        //API
                        try {
                            $url = $_SESSION["url_api_mgi"]."/auth/login";                    
                            $cabecalho = array(
                                'Content-Type: application/json',
                                'Accept: application/json'
                            );
                            $conteudo = '{"username": "'.trim($cpf).'", "password": "'.$senha.'"}';
                            $ch = curl_init($url);                    
                            curl_setopt($ch, CURLOPT_POST, 1); //SE FOR POST
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $conteudo);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $cabecalho);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                        
                            $resposta = curl_exec($ch);                    
                            curl_close($ch);
        
                            $retorno_array = json_decode($resposta);
                            $_SESSION["token"] = $retorno_array->token;                                            
                            
                        } catch(Exception $e){
                            js_go("login.php?mensagem=5");
                            exit();
                        }
                        
                        if ($_SESSION["token"] != '') {
                            //PLANO DE AÇÃO
                            $clsPerfil->PlanoAcao();  

                            js_go("index.php");
                        } else {
                            js_go("login.php?mensagem=5");
                            exit();
                        }                                              
                    }
                }
                else {                
                    js_go("login.php?mensagem=3");
                }            
            } else {
                js_go("login.php?mensagem=2");            
            }
        } else {
            js_go("login.php?mensagem=4");
            exit();
        }
    }
} else if($_SESSION["txt_tipo_autenticacao"] == "2") {
    try {
        $url = $_SESSION["url_api_mgi"]."/auth/login";                    
        $cabecalho = array(
            'Content-Type: application/json',
            'Accept: application/json'
        );
        $conteudo = '{"username": "'.trim($cpf).'", "password": "'.$senha.'"}';
        $ch = curl_init($url);                    
        curl_setopt($ch, CURLOPT_POST, 1); //SE FOR POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $conteudo);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $cabecalho);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                        
        $resposta = curl_exec($ch);                    
        curl_close($ch);

        $retorno_array = json_decode($resposta);
        $_SESSION["token"] = $retorno_array->token;   

        $clsUsuario = new clsUsuario();
        $q = $clsUsuario->ListarUsuario(" txt_login = '".trim($cpf)."'");

        if (pg_num_rows($q) > 0) {   
            $rs1 = pg_fetch_array($q);             
            if (limpar_comparacao($rs1['cod_ativo']) == 0) {                    
                js_go("login.php?mensagem=1");
            } else {
                $_SESSION["txt_login"] = $rs1['txt_login'];
                $_SESSION["cod_usuario"] = $rs1['cod_usuario'];
                $_SESSION["txt_usuario"] = $rs1['txt_usuario'];
                $_SESSION["cod_perfil"] = $rs1['cod_perfil'];
                $_SESSION["cod_orgao"] = $rs1['cod_orgao'];

                Auditoria(1, "Usuário autenticado", "");
            }
        } else {                
            js_go("login.php?mensagem=3");
            exit();
        } 

        if ($_SESSION["token"] == '') {
            js_go("login.php?mensagem=5");
            exit(); 
        }
        
    } catch(Exception $e){
        js_go("login.php?mensagem=5");
        exit();
    }    
        
    //PLANO DE AÇÃO
    $clsPerfil->PlanoAcao();  

    js_go("index.php");    
} else {
    js_go("login.php?mensagem=6");
    exit();
}


?>