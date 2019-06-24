ALTER TABLE sesplan.tb_indicador_analise DROP txt_ponto_forte;
ALTER TABLE sesplan.tb_indicador_analise DROP txt_ponto_melhorar;
ALTER TABLE sesplan.tb_indicador_analise DROP cod_orgao;
ALTER TABLE sesplan.tb_indicador_analise ADD COLUMN cod_usuario INTEGER;
ALTER TABLE sesplan.tb_indicador_analise ADD COLUMN txt_encaminhamento TEXT;

/*------------------------------------------------------------------*/

ALTER TABLE sesplan.tb_indicador_analise
    ADD CONSTRAINT fk_tb_indicador_analise_usuario FOREIGN KEY (cod_usuario)
    REFERENCES sesplan.tb_usuario (cod_usuario) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
	
/*------------------------------------------------------------------*/