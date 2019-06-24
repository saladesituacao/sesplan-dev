<?php
class clsUsuario { 
    public $cod_usuario;
    public $txt_usuario;
    public $txt_cpf;
    public $txt_email;
    public $cod_perfil;
    public $cod_ativo;
    public $txt_login;
    public $txt_matricula;
    public $cod_orgao;
    public $cod_cargo;
    public $cod_notificacao;
    public $cod_regiao;
    public $cod_hospital;

    public function ConsultaUsuarioId($cod_usuario) {
        if (!empty($cod_usuario)) {
            $sql = "SELECT txt_usuario FROM tb_usuario WHERE cod_usuario = " .$cod_usuario;
            $q = pg_query($sql);
            if (pg_num_rows($q) > 0)
            {
                $rs1 = pg_fetch_array($q);

                return $rs1["txt_usuario"];
            }
            else {
                return "";
            }
        }
        else {
            return "";
        }                                
    }

    public function ListarUsuario($condicao) {
        if (!empty($condicao)) {
            $condicao = " AND ".$condicao;
        }
        $sql = "SELECT * FROM tb_usuario WHERE 1 = 1 " .$condicao;        
        return pg_query($sql);
    }

    public function IncluirUsuario() {
        $rs=pg_fetch_array(pg_query("SELECT MAX(cod_usuario) FROM tb_usuario"));
        if (!isset($rs[0])) {
            $id = 1;
        } else {
            $id = intval($rs[0]) + 1;
        }

        $this->txt_usuario = str_replace("'", "''", $this->txt_usuario);

        if (empty($this->cod_regiao)) {
            $this->cod_regiao = "null";
        }

        if (empty($this->cod_hospital)) {
            $this->cod_hospital = "null";
        }

        $sql = "INSERT INTO tb_usuario(cod_usuario, txt_usuario, txt_cpf, txt_email, cod_perfil, cod_ativo, txt_login, txt_matricula, cod_cargo, cod_orgao, cod_notificacao, cod_regiao, cod_hospital) ";
        $sql .= " VALUES(".$id.", '".trim($this->txt_usuario)."', '".preg_replace('/\W+/u', '', trim($this->txt_cpf))."', '".trim($this->txt_email)."', ".$this->cod_perfil.", ".$this->cod_ativo.", '".trim($this->txt_login)."', '".trim($this->txt_matricula)."', ".$this->cod_cargo.", ".$this->cod_orgao.", ".$this->cod_notificacao.", ".$this->cod_regiao.", ".$this->cod_hospital.")";
        pg_query($sql);
        Auditoria(36, "", $sql);
    
        $clsUsuario = new clsUsuario;
        $clsUsuario->cod_usuario = $id; 
        $clsUsuario->cod_orgao = $this->cod_orgao;
        $clsUsuario->IncluirUnidade();                 
    }
  
    public function AlterarUsuario() {
        $this->txt_usuario = str_replace("'", "''", $this->txt_usuario); 

        if (empty($this->cod_regiao)) {
            $this->cod_regiao = "null";
        }

        if (empty($this->cod_hospital)) {
            $this->cod_hospital = "null";
        }

        $sql = "UPDATE tb_usuario SET txt_usuario = '".trim($this->txt_usuario)."', cod_ativo = ".$this->cod_ativo;
        $sql .= " , txt_email = '".trim($this->txt_email)."', cod_perfil = ".$this->cod_perfil. ", txt_cpf = '".preg_replace('/\W+/u', '', trim($this->txt_cpf))."', ";
        $sql .= " txt_login = '".trim($this->txt_login)."', txt_matricula = '".trim($this->txt_matricula)."', cod_cargo = ".$this->cod_cargo.", cod_orgao = ".$this->cod_orgao.", cod_notificacao = ".$this->cod_notificacao." , cod_regiao = ".$this->cod_regiao.", cod_hospital = ".$this->cod_hospital." WHERE cod_usuario = ".$this->cod_usuario;
        pg_query($sql);
//echo $sql;exit;

        Auditoria(38, "", $sql);

        $sql = "SELECT cod_orgao FROM tb_usuario_orgao WHERE cod_usuario = " .$this->cod_usuario. " AND cod_orgao = " .$this->cod_orgao;
        $q = pg_query($sql);
        if (pg_num_rows($q) == 0) {
            $clsUsuario = new clsUsuario;
            $clsUsuario->cod_usuario = $this->cod_usuario;
            $clsUsuario->cod_orgao = $this->cod_orgao;
            $clsUsuario->IncluirUnidade();  
        }
    }

    public function ExcluirUsuario() {
        $rs=pg_fetch_array(pg_query("SELECT txt_usuario FROM tb_usuario WHERE cod_usuario = ".$this->cod_usuario));

        $sql = "DELETE FROM tb_usuario WHERE cod_usuario = ".$this->cod_usuario;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(40, "EXCLUIR USUÁRIO: ".$rs['txt_usuario'], $sql);
        }         
    }
    
    public function ListaUsuarioOrgao($id) {
        $sql = "SELECT tb_usuario_orgao.*, txt_sigla, txt_usuario FROM tb_usuario_orgao "; 
        $sql .=  " INNER JOIN tb_usuario ON tb_usuario.cod_usuario = tb_usuario_orgao.cod_usuario ";
        $sql .=  " INNER JOIN tb_orgao ON tb_orgao.cod_orgao = tb_usuario_orgao.cod_orgao ";
        $sql .= " WHERE tb_usuario_orgao.cod_usuario = " .$id. " ORDER BY txt_sigla";
        return pg_query($sql);
    }

    public function IncluirUnidade() {
        $sql = "INSERT INTO tb_usuario_orgao(cod_usuario, cod_orgao) VALUES(".$this->cod_usuario.", ".$this->cod_orgao.")";
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            return $sql;
        }     
        else {
            Auditoria(37, "", $sql);

            return "";
        }
    }

    public function ExcluirUnidade() {
        $sql = "DELETE FROM tb_usuario_orgao WHERE cod_usuario = ".$this->cod_usuario." AND cod_orgao = ".$this->cod_orgao;               
        $resultado = @pg_query($sql);  
        if (!$resultado) {            
            echo($sql);
        } else {
            Auditoria(39, "", $sql);
        }
    }

    public function RetornaUnidadesUsuario() {
        $retorno = "";
        if (!empty($this->cod_usuario)) {
            $sql = "SELECT cod_orgao FROM tb_usuario_orgao WHERE cod_usuario = ".$this->cod_usuario;
            $q = pg_query($sql);
            if (pg_num_rows($q) > 0) {
                while ($rs1 = pg_fetch_array($q)) {
                    $a_cod_orgao = $a_cod_orgao."[".$rs1['cod_orgao']."]";

                    //UNIDADES FILHAS
                    $sql = "WITH RECURSIVE arvore AS ";
                    $sql .= " (SELECT t1.cod_orgao, txt_sigla ";
                    $sql .= " FROM tb_orgao AS t1 ";
                    $sql .= " WHERE cod_orgao = ".$rs1['cod_orgao'];
                    $sql .= " UNION ALL SELECT t2.cod_orgao, t2.txt_sigla ";
                    $sql .= " FROM tb_orgao AS t2 INNER JOIN arvore ON cod_orgao_superior = arvore.cod_orgao ) "; 
                    $sql .= " SELECT arvore.cod_orgao, arvore.txt_sigla FROM arvore ORDER BY arvore.txt_sigla ";
                    $q1 = pg_query($sql);
                    while ($row = pg_fetch_array($q1)) {
                        $a_cod_orgao = $a_cod_orgao."[".$row['cod_orgao']."]";                         
                    }
                } 
                
                $a_cod_orgao = str_replace("][", ",", $a_cod_orgao);
                $a_cod_orgao = str_replace("]", "", $a_cod_orgao);
                $a_cod_orgao = str_replace("[", "", $a_cod_orgao);

                $retorno = $a_cod_orgao;
            }
        }        

        return $retorno;
    }
}
?>