/*
Navicat PGSQL Data Transfer

Source Server         : Pessoal
Source Server Version : 90605
Source Host           : localhost:5432
Source Database       : sesdf
Source Schema         : sesplan

Target Server Type    : PGSQL
Target Server Version : 90605
File Encoding         : 65001

Date: 2018-03-27 16:49:43
*/


-- ----------------------------
-- Table structure for tb_sag
-- ----------------------------
DROP TABLE IF EXISTS "sesplan"."tb_sag";
CREATE TABLE "sesplan"."tb_sag" (
"cod_sag" int4 DEFAULT nextval('"sesplan".cod_sag_seq'::regclass),
"cod_eixo" int4,
"cod_perspectiva" int4,
"cod_diretriz" int4,
"cod_objetivo" int4,
"cod_objetivo_ppa" int4,
"cod_programa_trabalho" int4,
"nr_etapa_trabalho" int4 NOT NULL,
"txt_etapa_trabalho" varchar(8000) COLLATE "default" NOT NULL,
"cod_produto_etapa" int4 NOT NULL,
"nr_meta" int4 NOT NULL,
"cod_orgao" int4 NOT NULL,
"cod_inicio_previsto" int4 NOT NULL,
"cod_fim_previsto" int4 NOT NULL,
"cod_modulo" int4 NOT NULL,
"cod_parceiro" int4 NOT NULL,
"cod_inicio_efetivo" int4 NOT NULL,
"cod_fim_efetivo" int4 NOT NULL,
"cod_resultado" int4 NOT NULL,
"cod_ativo" int4 DEFAULT 1 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of tb_sag
-- ----------------------------

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------




ALTER TABLE "sesplan"."tb_sag"
ALTER COLUMN "cod_sag" SET NOT NULL,
ALTER COLUMN "cod_eixo" SET NOT NULL,
ALTER COLUMN "cod_perspectiva" SET NOT NULL,
ALTER COLUMN "cod_diretriz" SET NOT NULL,
ALTER COLUMN "cod_objetivo" SET NOT NULL,
ALTER COLUMN "cod_objetivo_ppa" SET NOT NULL,
ALTER COLUMN "cod_programa_trabalho" SET NOT NULL,
ALTER COLUMN "nr_etapa_trabalho" DROP NOT NULL,
ALTER COLUMN "txt_etapa_trabalho" DROP NOT NULL,
ALTER COLUMN "cod_produto_etapa" DROP NOT NULL,
ALTER COLUMN "nr_meta" DROP NOT NULL,
ALTER COLUMN "cod_orgao" DROP NOT NULL,
ALTER COLUMN "cod_inicio_previsto" DROP NOT NULL,
ALTER COLUMN "cod_fim_previsto" DROP NOT NULL,
ALTER COLUMN "cod_modulo" DROP NOT NULL,
ADD PRIMARY KEY ("cod_sag");


ALTER TABLE "sesplan"."tb_sag"
ADD COLUMN "dt_inclusao" date NOT NULL,
ADD COLUMN "dt_alteracao" date;

ALTER TABLE "sesplan"."tb_sag"
ALTER COLUMN "cod_parceiro" DROP NOT NULL;

ALTER TABLE "sesplan"."tb_sag"
ALTER COLUMN "dt_inclusao" SET DEFAULT ('now'::text)::date;


ALTER TABLE "sesplan"."tb_sag"
ALTER COLUMN "cod_inicio_efetivo" DROP NOT NULL,
ALTER COLUMN "cod_fim_efetivo" DROP NOT NULL,
ALTER COLUMN "cod_resultado" DROP NOT NULL;


ALTER TABLE "sesplan"."tb_sag"
ADD COLUMN "cod_unidade_medida" int4;



