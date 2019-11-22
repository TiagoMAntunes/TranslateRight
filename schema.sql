DROP TABLE IF EXISTS
	local_publico,
	item,
	anomalia,
	anomalia_traducao,
	duplicado,
	utilizador,
	utilizador_regular,
	utilizador_qualificado,
	incidencia,
	correcao,
	proposta_de_correcao;


CREATE TABLE local_publico (
	latitude numeric(8, 6) NOT NULL,
	longitude numeric(9, 6) NOT NULL, 
	nome varchar(120) NOT NULL,
	CHECK(latitude >= -90 AND latitude <= 90),	
	CHECK(longitude <= 180 AND longitude >= -180),
	PRIMARY KEY(latitude, longitude)
);

CREATE TABLE item (
	id serial,
	descricao varchar(1024) NOT NULL,
	localizacao varchar(1024) NOT NULL,	-- <- TODO verify
	latitude numeric(8, 6) NOT NULL,
	longitude numeric(9, 6) NOT NULL,
	CHECK(latitude >= -90 AND latitude <= 90),
	CHECK (longitude <= 180 AND longitude >= -180), 

	FOREIGN KEY(latitude, longitude)
		REFERENCES local_publico
		ON DELETE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE anomalia (
	id serial, 
	zona box NOT NULL, 	
	imagem bytea NOT NULL,		-- link to image
	lingua varchar(120) NOT NULL,
	ts timestamp NOT NULL,
	descricao varchar(1024) NOT NULL,
	tem_anomalia_traducao boolean NOT NULL,	
	PRIMARY KEY(id)
);


CREATE TABLE anomalia_traducao (	-- Beware of IC_1 and IC_2
	id serial,	
	zona2 box NOT NULL, 
	lingua2 varchar(120) NOT NULL,

	FOREIGN KEY(id)
		REFERENCES anomalia
		ON DELETE CASCADE,
	PRIMARY KEY(id)
);

CREATE TABLE duplicado (	-- Beware of IC_3
	item1 integer NOT NULL,	
	item2 integer NOT NULL, 
	CHECK (item1 < item2),
	
	FOREIGN KEY(item1)
		REFERENCES item
		ON DELETE CASCADE,
	FOREIGN KEY(item2)
		REFERENCES item
		ON DELETE CASCADE,
	PRIMARY KEY(item1, item2)
);

CREATE TABLE utilizador (	-- Beware of IC_4
	email varchar(120),
	password varchar(30) NOT NULL,
	PRIMARY KEY(email)
);

CREATE TABLE utilizador_qualificado (	-- Beware of IC_5
	email varchar(120) NOT NULL,

	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
);

CREATE TABLE utilizador_regular ( 	-- Beware of IC_6
	email varchar(120) NOT NULL,

	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(email)
);

CREATE TABLE incidencia (
	anomalia_id integer NOT NULL, 
	item_id integer NOT NULL,
	email varchar(120) NOT NULL,

	FOREIGN KEY(anomalia_id)
		REFERENCES anomalia
		ON DELETE CASCADE,
	FOREIGN KEY(item_id)
		REFERENCES item
		ON DELETE CASCADE,
	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE CASCADE,
	PRIMARY KEY(anomalia_id)
);

CREATE TABLE proposta_de_correcao (		-- Beware of IC_7
	email varchar(120) NOT NULL,
	nro integer NOT NULL,
	data_hora timestamp NOT NULL,
	texto varchar(1024) NOT NULL, 	-- It's possible to edit
	CHECK(nro >= 0),
	
	FOREIGN KEY(email)
		REFERENCES utilizador
		ON DELETE SET NULL,		-- <- verify
	PRIMARY KEY(email, nro)
);

CREATE TABLE correcao (
	email varchar(120) NOT NULL,
	nro integer NOT NULL,
	anomalia_id integer NOT NULL,
	
	FOREIGN KEY(email, nro)
		REFERENCES proposta_de_correcao
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY(anomalia_id)
		REFERENCES incidencia
		ON DELETE CASCADE,
	PRIMARY KEY(email, nro, anomalia_id)
);

ALTER SEQUENCE item_id_seq START WITH 1;
ALTER SEQUENCE anomalia_id_seq START WITH 1;
