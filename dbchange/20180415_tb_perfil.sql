CREATE TABLE sesplan.tb_perfil
(
	cod_perfil integer NOT NULL,        
	txt_perfil varchar(255) NOT NULL,
	txt_descricao varchar(255),	
	cod_ativo integer NOT NULL,
    PRIMARY KEY (cod_perfil)
)
WITH (
    OIDS = FALSE
)
ALTER TABLE sesplan.tb_perfil ALTER COLUMN cod_ativo SET DEFAULT 1;
CREATE UNIQUE INDEX UQ_tb_perfil ON sesplan.tb_perfil(txt_perfil);

/*------------------------------------------------------------------*/