ALTER TABLE sesplan.tb_status ADD txt_descricao varchar(255);
ALTER TABLE sesplan.tb_status ADD cod_ativo INTEGER NOT NULL DEFAULT 1;
CREATE UNIQUE INDEX UQ_tb_status ON sesplan.tb_status(txt_status);
ALTER TABLE sesplan.tb_status ADD txt_cor varchar(255);	
/*------------------------------------------------------------------*/

