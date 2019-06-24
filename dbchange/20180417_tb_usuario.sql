CREATE TABLE sesplan.tb_usuario
(
	cod_usuario integer NOT NULL,        
	txt_usuario varchar(255) NOT NULL,
	txt_cpf varchar(11) NOT NULL,
	txt_email varchar(255) NOT NULL,
	cod_perfil integer NOT NULL,
	cod_ativo integer NOT NULL,
    PRIMARY KEY (cod_usuario)
)
WITH (
    OIDS = FALSE
)
ALTER TABLE sesplan.tb_usuario ADD CONSTRAINT fk_tb_usuario_perfil FOREIGN KEY (cod_perfil) REFERENCES sesplan.tb_perfil(cod_perfil);
ALTER TABLE sesplan.tb_usuario ALTER COLUMN cod_ativo SET DEFAULT 1;
CREATE UNIQUE INDEX UQ_tb_usuario ON sesplan.tb_usuario(txt_cpf);

ALTER TABLE sesplan.tb_usuario ADD txt_login varchar(255);
ALTER TABLE sesplan.tb_usuario ADD txt_matricula varchar(255);

ALTER TABLE sesplan.tb_usuario ADD cod_orgao integer;
ALTER TABLE sesplan.tb_usuario ADD CONSTRAINT fk_tb_usuario_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao); 

/*------------------------------------------------------------------*/