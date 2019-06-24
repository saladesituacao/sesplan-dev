ALTER TABLE sesplan.tb_indicador DROP cod_eixo;
ALTER TABLE sesplan.tb_indicador DROP cod_perspectiva;
ALTER TABLE sesplan.tb_indicador DROP cod_diretriz;
ALTER TABLE sesplan.tb_indicador DROP cod_modulo;
ALTER TABLE sesplan.tb_indicador ALTER COLUMN cod_indicador TYPE varchar(50);
ALTER TABLE sesplan.tb_indicador ALTER COLUMN cod_orgao DROP NOT NULL;
ALTER TABLE sesplan.tb_indicador ALTER COLUMN cod_meta TYPE varchar(50);
ALTER TABLE sesplan.tb_indicador ALTER COLUMN txt_descricao_meta TYPE text;
ALTER TABLE sesplan.tb_indicador_analise ADD COLUMN cod_numerador varchar(50);
ALTER TABLE sesplan.tb_indicador_analise ADD COLUMN cod_denominador varchar(50);
ALTER TABLE sesplan.tb_indicador_analise ADD COLUMN cod_resultado varchar(50);
/*--------------------------------------------------------------*/

ALTER TABLE sesplan.tb_indicador_analise
    ADD CONSTRAINT fk_tb_indicador_analise_chave FOREIGN KEY (cod_chave)
    REFERENCES sesplan.tb_indicador (cod_chave) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
	
/*--------------------------------------------------------------*/

DROP TABLE sesplan.tb_indicador_detalhe;
/*--------------------------------------------------------------*/

ALTER TABLE sesplan.tb_pas DROP cod_eixo;
ALTER TABLE sesplan.tb_pas DROP cod_perspectiva;
ALTER TABLE sesplan.tb_pas DROP cod_diretriz;
ALTER TABLE sesplan.tb_pas ALTER COLUMN cod_meta TYPE varchar(50);
/*--------------------------------------------------------------*/

ALTER TABLE sesplan.tb_sag DROP cod_eixo;
ALTER TABLE sesplan.tb_sag DROP cod_perspectiva;
ALTER TABLE sesplan.tb_sag DROP cod_diretriz;
/*--------------------------------------------------------------*/

ALTER TABLE sesplan.tb_indicador_analise ADD COLUMN dt_inclusao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE sesplan.tb_pas_consideracao ADD COLUMN dt_inclusao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
/*--------------------------------------------------------------*/



