--DROP SCHEMA proj CASCADE;
CREATE SCHEMA IF NOT EXISTS proj;
/*
DROP TABLE IF EXISTS
	proj.local_publico,
	proj.item,
	proj.anomalia,
	proj.anomalia_traducao,
	proj.duplicado,
	proj.utilizador,
	proj.utilizador_regular,
	proj.utilizador_qualificado,
	proj.incidencia,
	proj.correcao,
	proj.proposta_de_correcao;
*/

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA proj TO 
	ist189504, ist189545, ist189469;

CREATE TABLE proj.local_publico (
	latitude numeric(8, 6) NOT NULL,
	longitude numeric(9, 6) NOT NULL, 
	nome varchar(120) NOT NULL,
	CHECK(latitude >= -90 AND latitude <= 90),	
	CHECK(longitude <= 180 AND longitude >= -180),
	PRIMARY KEY(latitude, longitude)
);

CREATE TABLE proj.item (
	id serial,
	descricao varchar(1024) NOT NULL,
	localizacao varchar(1024) NOT NULL,	-- <- TODO verify
	latitude numeric(8, 6) NOT NULL,
	longitude numeric(9, 6) NOT NULL,
	CHECK(latitude >= -90 AND latitude <= 90),
	CHECK (longitude <= 180 AND longitude >= -180), 

	FOREIGN KEY(latitude, longitude)
		REFERENCES proj.local_publico
		ON DELETE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE proj.anomalia (
	id serial, 
	zona box NOT NULL, 	
	imagem bytea NOT NULL,		-- link to image
	lingua varchar(120) NOT NULL,
	ts timestamp NOT NULL,
	descricao varchar(1024) NOT NULL,
	tem_anomalia_traducao boolean NOT NULL,	
	PRIMARY KEY(id)
);


CREATE TABLE proj.anomalia_traducao (	-- Beware of IC_1 and IC_2
	id serial,	
	zona2 box NOT NULL, 
	lingua2 varchar(120) NOT NULL,

	FOREIGN KEY(id)
		REFERENCES proj.anomalia
		ON DELETE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE proj.duplicado (	-- Beware of IC_3
	item1 integer NOT NULL,	
	item2 integer NOT NULL, 
	CHECK (item1 < item2),
	
	FOREIGN KEY(item1)
		REFERENCES proj.item
		ON DELETE CASCADE,
	FOREIGN KEY(item2)
		REFERENCES proj.item
		ON DELETE CASCADE,
	PRIMARY KEY(item1, item2)
);

CREATE TABLE proj.utilizador (	-- Beware of IC_4
	email varchar(120),
	password varchar(30) NOT NULL,
	PRIMARY KEY(email)
);

CREATE TABLE proj.utilizador_qualificado (	-- Beware of IC_5
	email varchar(120) NOT NULL,

	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
);

CREATE TABLE proj.utilizador_regular ( 	-- Beware of IC_6
	email varchar(120) NOT NULL,

	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
);

CREATE TABLE proj.incidencia (
	anomalia_id integer NOT NULL, 
	item_id integer NOT NULL,
	email varchar(120) NOT NULL,

	FOREIGN KEY(anomalia_id)
		REFERENCES proj.anomalia
		ON DELETE CASCADE,
	FOREIGN KEY(item_id)
		REFERENCES proj.item
		ON DELETE CASCADE,
	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(anomalia_id)
);

CREATE TABLE proj.proposta_de_correcao (		-- Beware of IC_7
	email varchar(120) NOT NULL,
	nro integer NOT NULL,
	data_hora timestamp NOT NULL,
	texto varchar(1024) NOT NULL, 	-- It's possible to edit
	CHECK(nro >= 0),
	
	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE SET NULL,		-- <- verify
	PRIMARY KEY(email, nro)
);

CREATE TABLE proj.correcao (
	email varchar(120) NOT NULL,
	nro integer NOT NULL,
	anomalia_id integer NOT NULL,
	
	FOREIGN KEY(email, nro)
		REFERENCES proj.proposta_de_correcao
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY(anomalia_id)
		REFERENCES proj.incidencia
		ON DELETE CASCADE,
	PRIMARY KEY(email, nro, anomalia_id)
);

ALTER SEQUENCE proj.item_id_seq START WITH 1;
ALTER SEQUENCE proj.anomalia_id_seq START WITH 1;