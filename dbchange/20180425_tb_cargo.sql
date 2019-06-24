CREATE TABLE sesplan.tb_cargo
(
	cod_cargo integer NOT NULL,        
	txt_cargo varchar(255) NOT NULL,
	txt_descricao varchar(255),	
	cod_ativo integer NOT NULL,
    PRIMARY KEY (cod_cargo)
)
WITH (
    OIDS = FALSE
)
ALTER TABLE sesplan.tb_cargo ALTER COLUMN cod_ativo SET DEFAULT 1;
CREATE UNIQUE INDEX UQ_tb_cargo ON sesplan.tb_cargo(txt_cargo);

/*------------------------------------------------------------------*/

ALTER TABLE sesplan.tb_usuario ADD COLUMN cod_cargo INTEGER;

ALTER TABLE sesplan.tb_usuario
ADD CONSTRAINT fk_tb_usuario_cargo FOREIGN KEY (cod_cargo) REFERENCES sesplan.tb_cargo(cod_cargo);
/*------------------------------------------------------------------*/