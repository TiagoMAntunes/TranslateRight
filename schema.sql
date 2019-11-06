--DROP DATABASE translate_right;

CREATE DATABASE translate_right;

CREATE TABLE local_publico (
	latitude numeric(8, 6),		-- [-90, 90]  	%.6
	longitude numeric(9, 6),	-- [-180, 180]	%.6
	nome char(50) NOT NULL, 
	PRIMARY KEY(latitude, longitude)
)

CREATE TABLE item (
	id integer,
	descricao char(180) NOT NULL,
	localizacao char(30) NOT NULL,	-- <- TODO verify
	latitude numeric(8, 6),
	longitude numeric(9, 6), 
	FOREIGN KEY(latitude, longitude)
		REFERENCES local_publico
		ON DELETE CASCADE,
	PRIMARY KEY(id)
)

CREATE TABLE anomalia (
	id integer, 
	zona char(40) NOT NULL, 	
	imagem	integer NOT NULL,	
	lingua char(15) NOT NULL,
	ts TIMESTAMP NOT NULL,
	descricao char(180) NOT NULL,
	tem_anomalia_redacao BOOLEAN NOT NULL,	
	PRIMARY KEY(id)
)

CREATE TABLE anomalia_traducao (	-- Beware of IC_1 and IC_2
	id integer,
	zona2 char(40) NOT NULL, 
	lingua2 char(15) NOT NULL,
	FOREIGN KEY(id)
		REFERENCES anomalia
		ON DELETE CASCADE,
	PRIMARY KEY(id)
)

CREATE TABLE duplicado (	-- Beware of IC_3
	item1 integer,	
	item2 integer, 			
	FOREIGN KEY(item1)
		REFERENCES item
		ON DELETE CASCADE,
	FOREIGN KEY(item2)
		REFERENCES item
		ON DELETE CASCADE,
	PRIMARY KEY(item1, item2)
)

CREATE TABLE utilizador (	-- Beware of IC_4
	email char(50),
	password char(25), NOT NULL,
	PRIMARY KEY(email)
)

CREATE TABLE utilizador_qualificado (	-- Beware of IC_5
	email char(50),
	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
)

CREATE TABLE utilizador_regular ( 	-- Beware of IC_6
	email char(50),
	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
)

CREATE TABLE incidencia (
	anomalia_id integer, 
	item_id, integer NOT NULL,
	email char(50) NOT NULL,
	FOREIGN KEY(anomlia_id)
		REFERENCES anomalia
		ON DELETE CASCADE,
	FOREIGN KEY(item_id)
		REFERENCES item
		ON DELETE CASCADE,
	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(anomalia_id)
)

CREATE TABLE proposta_de_correcao (		-- Beware of IC_7
	email char(50),
	nro integer,
	data_hora DATETIME NOT NULL,
	texto VARCHAR(180) NOT NULL, 	-- It's possible to edit
	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE SET NULL,		-- <- verify
	PRIMARY KEY(email, nro)
)

CREATE TABLE correcao (
	email char(50),
	nro integer,
	anomalia_id integer,
	FOREIGN KEY(email, nro)
		REFERENCES proposta_de_correcao
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY(anomalia_id)
		REFERENCES incidencia
		ON DELETE CASCADE
	PRIMARY KEY(email, nro, anomalia_id)
)
