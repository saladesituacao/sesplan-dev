<?php
class clsEstrategiaVinculada {       
    public $cod_estrategia;
    public $txt_estrategia;
    public $cod_ativo;
    public $txt_descricao;

    public function IncluirEstrategia() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_estrategia) FROM tb_estrategia_vinculada"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_estrategia_vinculada(cod_estrategia, txt_estrategia, cod_ativo, txt_descricao) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_estrategia)."', ".$this->cod_ativo.", '".trim($this->txt_descricao)."')";
        pg_query($sql);

        Auditoria(146, "", $sql);
    }

    public function ExcluirEstrategia() {
        $rs=pg_fetch_array(pg_query("SELECT txt_estrategia FROM tb_estrategia_vinculada WHERE cod_estrategia = ".$this->cod_estrategia)); 

        $sql = "DELETE FROM tb_estrategia_vinculada WHERE cod_estrategia = ".$this->cod_estrategia;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);            
        } else {
            Auditoria(147, "EXCLUIR ESTRATÉGIA VINCULADA: ".$rs['txt_estrategia'], $sql);
        }     
    }    

    public function AlterarEstrategia() {
        $sql = "UPDATE tb_estrategia_vinculada SET txt_estrategia = '".trim($this->txt_estrategia)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_descricao = '".trim($this->txt_descricao)."'";
        $sql .= " WHERE cod_estrategia = ".$this->cod_estrategia;
        pg_query($sql);

        Auditoria(148, "", $sql);
    }

    public function ListarEstrategia($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_estrategia_vinculada WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaEstrategia($cod_estrategia) {
        $sql = "SELECT txt_estrategia FROM tb_estrategia_vinculada WHERE cod_estrategia = ".$cod_estrategia;
        $q1 = pg_query($sql);
        $rs1 = pg_fetch_array($q1);

        return $rs1['txt_estrategia'];
    }
}
?>