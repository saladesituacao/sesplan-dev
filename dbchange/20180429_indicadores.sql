ALTER TABLE sesplan.tb_indicador ADD cod_dados_mgi integer;
ALTER TABLE sesplan.tb_indicador ADD txt_monitoramento varchar(255);

/*------------------------------------------------------------------*/

CREATE TABLE sesplan.tb_indicador_meta
(
	cod_indicador integer NOT NULL,        
	campo_1 varchar(255),
	campo_2 varchar(255),
	campo_3 varchar(255),
	campo_4 varchar(255),
	campo_5 varchar(255),
	campo_6 varchar(255),
	campo_7 varchar(255),
	campo_8 varchar(255),
	campo_9 varchar(255),
	campo_10 varchar(255),
	campo_11 varchar(255),
	campo_12 varchar(255),
    PRIMARY KEY (cod_indicador)
)
WITH (
    OIDS = FALSE
)
ALTER TABLE sesplan.tb_indicador_meta ADD CONSTRAINT fk_tb_indicador_meta_indicador FOREIGN KEY (cod_indicador) REFERENCES sesplan.tb_indicador(cod_chave);

/*------------------------------------------------------------------*/