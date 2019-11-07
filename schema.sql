--DROP DATABASE translate_right;
--CREATE DATABASE translate_right;

DROP SCHEMA proj CASCADE;
CREATE SCHEMA  IF NOT EXISTS proj 
	AUTHORIZATION ist189504; -- change to respective username
	
CREATE TABLE proj.local_publico (
	latitude numeric(8, 6) NOT NULL 
		CHECK(latitude >= -90 AND latitude <= 90),		
	longitude numeric(9, 6) NOT NULL 
		CHECK(longitude <= 180 AND longitude >= -180),
	nome char(50) NOT NULL, 
	PRIMARY KEY(latitude, longitude)
);

CREATE TABLE proj.item (
	id serial,
	descricao char(180) NOT NULL,
	localizacao char(30) NOT NULL,	-- <- TODO verify
	latitude numeric(8, 6) NOT NULL
		CHECK(latitude >= -90 AND latitude <= 90),
	longitude numeric(9, 6) NOT NULL
		CHECK (longitude <= 180 AND longitude >= -180), 

	FOREIGN KEY(latitude, longitude)
		REFERENCES proj.local_publico
		ON DELETE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE proj.anomalia (
	id serial, 
	zona box NOT NULL, 	
	imagem	char(100) NOT NULL,		-- link to image
	lingua char(15) NOT NULL,
	ts TIMESTAMP NOT NULL,
	descricao char(180) NOT NULL,
	tem_anomalia_redacao BOOLEAN NOT NULL,	
	PRIMARY KEY(id)
);

CREATE TABLE proj.anomalia_traducao (	-- Beware of IC_1 and IC_2
	id serial,
	zona2 box NOT NULL, 
	lingua2 char(15) NOT NULL,

	FOREIGN KEY(id)
		REFERENCES proj.anomalia
		ON DELETE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE proj.duplicado (	-- Beware of IC_3
	item1 integer NOT NULL,	
	item2 integer NOT NULL, 

	FOREIGN KEY(item1)
		REFERENCES proj.item
		ON DELETE CASCADE,
	FOREIGN KEY(item2)
		REFERENCES proj.item
		ON DELETE CASCADE,
	PRIMARY KEY(item1, item2)
);

CREATE TABLE proj.utilizador (	-- Beware of IC_4
	email char(50),
	password char(25) NOT NULL,
	PRIMARY KEY(email)
);

CREATE TABLE proj.utilizador_qualificado (	-- Beware of IC_5
	email char(50) NOT NULL,

	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
);

CREATE TABLE proj.utilizador_regular ( 	-- Beware of IC_6
	email char(50) NOT NULL,

	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
);

CREATE TABLE proj.incidencia (
	anomalia_id integer NOT NULL, 
	item_id integer NOT NULL,
	email char(50) NOT NULL,

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
	email char(50) NOT NULL,
	nro integer NOT NULL
		CHECK(nro >= 0),
	data_hora TIMESTAMP NOT NULL,
	texto VARCHAR(180) NOT NULL, 	-- It's possible to edit

	FOREIGN KEY(email)
		REFERENCES proj.utilizador
		ON DELETE SET NULL,		-- <- verify
	PRIMARY KEY(email, nro)
);

CREATE TABLE proj.correcao (
	email char(50) NOT NULL,
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
