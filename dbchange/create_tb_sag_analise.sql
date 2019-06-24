CREATE SEQUENCE "sesplan"."cod_sag_analise_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;


CREATE TABLE "sesplan"."tb_sag_analise" (
"cod_sag_analise" int4 DEFAULT nextval('"sesplan".cod_sag_analise_seq'::regclass) NOT NULL,
"cod_sag" int4 NOT NULL,
"nr_meta_analise" int4 NOT NULL,
"cod_bimestre" int4 NOT NULL,
"nr_mes_1" int4,
"nr_mes_2" int4,
"txt_analise" varchar(8000),
PRIMARY KEY ("cod_sag_analise")
)
WITH (OIDS=FALSE)
;


ALTER TABLE "sesplan"."tb_sag_analise"
ADD COLUMN "dt_inclusao" date DEFAULT ('now'::text)::date;