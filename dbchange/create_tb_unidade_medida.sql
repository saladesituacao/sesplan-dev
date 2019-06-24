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

Date: 2018-03-22 17:26:10
*/


-- ----------------------------
-- Table structure for tb_unidade_medida
-- ----------------------------
DROP TABLE IF EXISTS "sesplan"."tb_unidade_medida";
CREATE TABLE "sesplan"."tb_unidade_medida" (
"cod_unidade_medida" int4 DEFAULT nextval('"sesplan".cod_unidade_medida_seq'::regclass) NOT NULL,
"txt_unidade_medida" varchar(50) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of tb_unidade_medida
-- ----------------------------
INSERT INTO "sesplan"."tb_unidade_medida" VALUES ('1', 'pessoa');
INSERT INTO "sesplan"."tb_unidade_medida" VALUES ('2', 'm2');
INSERT INTO "sesplan"."tb_unidade_medida" VALUES ('3', 'tonelada');
INSERT INTO "sesplan"."tb_unidade_medida" VALUES ('4', 'unidade');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table tb_unidade_medida
-- ----------------------------
ALTER TABLE "sesplan"."tb_unidade_medida" ADD PRIMARY KEY ("cod_unidade_medida");
