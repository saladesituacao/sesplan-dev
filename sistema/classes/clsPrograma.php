<?php
class clsPrograma {       
    public $cod_programa_governo;
    public $txt_programa_governo;
    public $cod_ativo;
    public $txt_descricao;
    public $cod_orgao;

    public function IncluirPrograma() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_programa_governo) FROM tb_programa_governo"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $sql = "INSERT INTO tb_programa_governo(cod_programa_governo, txt_programa_governo, cod_ativo, txt_descricao) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_programa_governo)."', ".$this->cod_ativo.", '".trim($this->txt_descricao)."')";
        pg_query($sql);
        Auditoria(154, "", $sql);

        foreach($this->cod_orgao as $i) {
            $sql = "INSERT INTO tb_programa_governo_orgao(cod_orgao, cod_programa_governo) VALUES(".$i.", ".$id.")";
            pg_query($sql);
            Auditoria(154, "", $sql);
        }	
    }

    public function ExcluirPrograma() {
        $rs=pg_fetch_array(pg_query("SELECT COUNT(*) FROM tb_plano_acao WHERE cod_programa_governo = ".$this->cod_programa_governo));
        if (limpar_comparacao($rs[0]) == 0) {
            $rs=pg_fetch_array(pg_query("SELECT txt_programa_governo FROM tb_programa_governo WHERE cod_programa_governo = ".$this->cod_programa_governo)); 

            $sql = "DELETE FROM tb_programa_governo_orgao WHERE cod_programa_governo = ".$this->cod_programa_governo;
            $resultado = @pg_query($sql); 
            if (!$resultado) {            
                echo($sql);            
            } else {
                Auditoria(155, "EXCLUIR PROGRAMA: ".$rs['txt_programa_governo'], $sql);
            }   
    
            $sql = "DELETE FROM tb_programa_governo WHERE cod_programa_governo = ".$this->cod_programa_governo;               
            $resultado = @pg_query($sql);  
            if (!$resultado) {            
                echo($sql);            
            } else {
                Auditoria(155, "EXCLUIR PROGRAMA: ".$rs['txt_programa_governo'], $sql);
            } 
        } else {
            echo("erro"); 
        }            
    }    

    public function AlterarPrograma() {
        $sql = "UPDATE tb_programa_governo SET txt_programa_governo = '".trim($this->txt_programa_governo)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_descricao = '".trim($this->txt_descricao)."'";
        $sql .= " WHERE cod_programa_governo = ".$this->cod_programa_governo;
        pg_query($sql);
        Auditoria(156, "", $sql);

        $sql = "DELETE FROM tb_programa_governo_orgao WHERE cod_programa_governo = ".$this->cod_programa_governo;
        pg_query($sql);
        Auditoria(156, "", $sql);

        foreach($this->cod_orgao as $i) {
            $sql = "INSERT INTO tb_programa_governo_orgao(cod_orgao, cod_programa_governo) VALUES(".$i.", ".$this->cod_programa_governo.")";
            pg_query($sql);
            Auditoria(156, "", $sql);
        }
    }

    public function ListarPrograma($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_programa_governo WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaPrograma($cod_programa_governo) {
        $sql = "SELECT txt_programa_governo FROM tb_programa_governo WHERE cod_programa_governo = ".$cod_programa_governo;
        $q1 = pg_query($sql);
        $rs1 = pg_fetch_array($q1);

        return $rs1['txt_programa_governo'];
    }
}
?>