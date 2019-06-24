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

Date: 2018-03-22 17:26:46
*/


-- ----------------------------
-- Table structure for tb_produto_etapa
-- ----------------------------
DROP TABLE IF EXISTS "sesplan"."tb_produto_etapa";
CREATE TABLE "sesplan"."tb_produto_etapa" (
"cod_produto_etapa" int4 DEFAULT nextval('"sesplan".cod_produto_etapa_seq'::regclass) NOT NULL,
"txt_produto_etapa" varchar(100) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of tb_produto_etapa
-- ----------------------------
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('1', 'atendimento realizado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('2', 'unidade mantida');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('3', 'adolescente assistido');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('4', 'pessoa assistida');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('5', 'internação realizada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('6', 'internação realizada (produto ficha)');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('7', 'procedimento médico realizado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('8', 'consulta odontológica realizada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('9', 'procedimento médico realizado (informado pela área, dado de pessoa e não procedimento)');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('10', 'órtese/prótese fornecida');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('11', 'unidade gerida ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('12', 'unidade beneficiada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('13', 'ação realizada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('14', 'ação realizada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('15', 'consulta realizada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('16', 'atendimento realizado (Dado informado pela área)');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('17', 'Bolsa Concedida');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('18', 'unidade implantada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('19', 'Consulta realizada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('20', 'atendimento realizado ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('21', 'Consulta realizada (Informado pela área) ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('22', 'vacina aplicada  ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('23', 'notificação realizada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('24', 'inspeção realizada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('25', 'visita realizada (Informado pela área)');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('26', 'exame');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('27', 'ensaio');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('28', 'análise realizada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('29', 'unidade beneficiada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('30', 'publicidade e propaganda realizada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('31', 'pessoa capacitada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('32', 'prédio construído');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('33', 'servidor remunerado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('34', 'benefício concedido');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('35', 'não se aplica ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('36', 'servidor capacitado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('37', 'bolsa concedida - médicas');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('38', 'bolsa concedida - não médicas');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('39', 'medicamento adquirido');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('40', 'medicamento adquirido (Produto real: Pessoa atendida)');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('41', 'refeição fornecida');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('42', 'resíduo tratado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('43', 'equipamento adquirido');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('44', 'projeto elaborado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('45', 'unidade construída');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('46', 'unidade reformada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('47', 'unidade ampliada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('48', 'obra realizada');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('49', 'centro construído');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('50', 'unidade reformada ');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('51', 'equipamento mantido');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('52', 'sistema melhorado');
INSERT INTO "sesplan"."tb_produto_etapa" VALUES ('53', 'ação implementada');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table tb_produto_etapa
-- ----------------------------
ALTER TABLE "sesplan"."tb_produto_etapa" ADD PRIMARY KEY ("cod_produto_etapa");
