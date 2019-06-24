<?php
class clsMensagem {       
    public $cod_mensagem;
    public $txt_titulo;
    public $cod_ativo;
    public $txt_mensagem;
    public $cod_tipo_mensagem;
    public $cod_dia;

    public function IncluirMensagem() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_mensagem) FROM tb_mensagem"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        if (empty($this->cod_tipo_mensagem)) {
            $this->cod_tipo_mensagem = 'null';
        }
        if (empty($this->cod_dia)) {
            $this->cod_dia = 'null';
        }

        $sql = "INSERT INTO tb_mensagem(cod_mensagem, txt_titulo, cod_ativo, txt_mensagem, cod_tipo_mensagem, cod_dia) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_titulo)."', ".$this->cod_ativo.", '".trim($this->txt_mensagem)."', ".$this->cod_tipo_mensagem.", ".$this->cod_dia.")";
        pg_query($sql);

        Auditoria(150, "", $sql);
    }

    public function ExcluirMensagem() {
        $rs=pg_fetch_array(pg_query("SELECT txt_titulo FROM tb_mensagem WHERE cod_mensagem = ".$this->cod_mensagem)); 

        $sql = "DELETE FROM tb_mensagem WHERE cod_mensagem = ".$this->cod_mensagem;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);            
        } else {
            Auditoria(152, "EXCLUIR MENSAGEM: ".$rs['txt_titulo'], $sql);
        }     
    }    

    public function AlterarMensagem() {
        if (empty($this->cod_tipo_mensagem)) {
            $this->cod_tipo_mensagem = "null";
        }
        if (empty($this->cod_dia)) {
            $this->cod_dia = 'null';
        }

        $sql = "UPDATE tb_mensagem SET txt_titulo = '".trim($this->txt_titulo)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_mensagem = '".trim($this->txt_mensagem)."', cod_tipo_mensagem = ".$this->cod_tipo_mensagem.", ";
        $sql .= " cod_dia = ".$this->cod_dia." WHERE cod_mensagem = ".$this->cod_mensagem;        
        pg_query($sql);

        Auditoria(151, "", $sql);
    }

    public function ListarMensagem($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_mensagem WHERE 1 = 1 " .$condicao;

        return pg_query($sql);
    }

    public function RetornaMensagem($cod_mensagem) {
        $sql = "SELECT txt_titulo FROM tb_mensagem WHERE cod_mensagem = ".$cod_mensagem;
        $q1 = pg_query($sql);
        $rs1 = pg_fetch_array($q1);

        return $rs1['txt_titulo'];
    }
}
?>