CREATE TABLE sesplan.tb_usuario_orgao
(
	cod_usuario integer NOT NULL,        
	cod_orgao integer NOT NULL,
    PRIMARY KEY (cod_usuario, cod_orgao)
)
WITH (
    OIDS = FALSE
)
ALTER TABLE sesplan.tb_usuario_orgao 
ADD CONSTRAINT fk_tb_usuario_unidade_usu FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);

ALTER TABLE sesplan.tb_usuario_orgao 
ADD CONSTRAINT fk_tb_usuario_unidade_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao);
	
/*------------------------------------------------------------------*/

INSERT INTO sesplan.tb_orgao(cod_orgao, txt_sigla, cod_ativo, cod_exibir_consulta)
VALUES(0, 'SES', 1, 0);

/*------------------------------------------------------------------*/