<?php
class clsCiclo {
    public $cod_tipo_documento;
    public $txt_arquivo;
    public $cod_usuario;
    public $binario;

    public function IncluirArquivo() { 
        $sql = "INSERT INTO tb_ciclo_planejamento(cod_tipo_documento, txt_arquivo, cod_usuario, byte) ";
        $sql .= " VALUES(".$this->cod_tipo_documento.",'".$this->txt_arquivo."', ". $this->cod_usuario.", '".$this->binario."')";
        pg_query($sql);
        Auditoria(131, "", $sql);  
    }

    public function AlterarArquivo() {
        $sql = "UPDATE tb_ciclo_planejamento SET txt_arquivo = '".$this->txt_arquivo."', cod_usuario = ".$this->cod_usuario.", ";
        $sql .= " byte = '".$this->binario."' WHERE cod_tipo_documento = ".$this->cod_tipo_documento;
        pg_query($sql);
        Auditoria(131, "", $sql);
    }

    public function ExcluirArquivo() {
        $sql = "DELETE FROM tb_ciclo_planejamento WHERE cod_tipo_documento = ".$this->cod_tipo_documento;
        pg_query($sql);
        Auditoria(132, "", $sql);
    }

    public function RetornaArquivo($cod_tipo_documento) {
        $sql = "SELECT txt_arquivo FROM tb_ciclo_planejamento WHERE cod_tipo_documento = ".$cod_tipo_documento;
        $q1 = pg_query($sql);        
        if (pg_num_rows($q1) > 0) {
            $rs1 = pg_fetch_array($q1);
            return $rs1['txt_arquivo'];
        } else {
            return "";
        }
    }
}
?>