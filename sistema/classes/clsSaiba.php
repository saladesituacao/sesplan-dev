<?php
class clsSaiba {
    public $cod_tipo_documento;
    public $txt_arquivo;
    public $cod_usuario;
    public $binario;    
    public $txt_tipo_documento;
    public $cod_ativo;

    public function IncluirArquivo() { 
        $sql = "INSERT INTO tb_saiba(cod_tipo_documento, txt_arquivo, cod_usuario, byte) ";
        $sql .= " VALUES(".$this->cod_tipo_documento.",'".$this->txt_arquivo."', ". $this->cod_usuario.", '".$this->binario."')";
        pg_query($sql);
        Auditoria(158, "", $sql);  
    }

    public function AlterarArquivo() {
        $sql = "UPDATE tb_saiba SET txt_arquivo = '".$this->txt_arquivo."', cod_usuario = ".$this->cod_usuario.", ";
        $sql .= " byte = '".$this->binario."' WHERE cod_tipo_documento = ".$this->cod_tipo_documento;
        pg_query($sql);
        Auditoria(158, "", $sql);
    }

    public function ExcluirArquivo() {
        $sql = "DELETE FROM tb_saiba WHERE cod_tipo_documento = ".$this->cod_tipo_documento;
        pg_query($sql);
        Auditoria(159, "", $sql);
    }

    public function RetornaArquivo($cod_tipo_documento) {
        $sql = "SELECT txt_arquivo FROM tb_saiba WHERE cod_tipo_documento = ".$cod_tipo_documento;
        $q1 = pg_query($sql);        
        if (pg_num_rows($q1) > 0) {
            $rs1 = pg_fetch_array($q1);
            return $rs1['txt_arquivo'];
        } else {
            return "";
        }
    }

    public function IncluirTipodocumento() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_tipo_documento) FROM tb_saiba_tipo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_saiba_tipo(cod_tipo_documento, txt_tipo_documento, cod_ativo) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_tipo_documento)."', ".$this->cod_ativo.")";
        pg_query($sql);

        Auditoria(161, "", $sql);
    }

    public function ExcluirTipodocumento() {
        $rs=pg_fetch_array(pg_query("SELECT txt_tipo_documento FROM tb_saiba_tipo WHERE cod_tipo_documento = ".$this->cod_tipo_documento)); 

        $sql = "DELETE FROM tb_saiba_tipo WHERE cod_tipo_documento = ".$this->cod_tipo_documento;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);            
        } else {
            Auditoria(163, "EXCLUIR TIPO DE DOCUMENTO: ".$rs['txt_tipo_documento'], $sql);
        }     
    }  
    
    public function AlterarTipodocumento() {
        $sql = "UPDATE tb_saiba_tipo SET txt_tipo_documento = '".trim($this->txt_tipo_documento)."', cod_ativo = ".$this->cod_ativo;        
        $sql .= " WHERE cod_tipo_documento = ".$this->cod_tipo_documento;
        pg_query($sql);

        Auditoria(162, "", $sql);
    }

    public function ListarTipodocumento($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_saiba_tipo WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaTipodocumento($cod_tipo_documento) {
        $sql = "SELECT txt_tipo_documento FROM tb_saiba_tipo WHERE cod_tipo_documento = ".$cod_tipo_documento;
        $q1 = pg_query($sql);
        $rs1 = pg_fetch_array($q1);

        return $rs1['txt_tipo_documento'];
    }

}
?>