DROP TABLE IF EXISTS
    f_anomalia,
	d_utilizador, 
    d_tempo, 
    d_local, 
    d_lingua;

-- d_ulizador(id_ulizador, po)

CREATE TABLE d_utilizador (
	id_utilizador serial,
	tipo varchar(50) NOT NULL,
	PRIMARY KEY(id_utilizador)
);

-- d_tempo(id_tempo, dia, dia_da_semana, semana, mes, trimestre, ano)

CREATE TABLE d_tempo (
    id_tempo serial,
    dia integer NOT NULL,
    dia_da_semana integer NOT NULL,
    semana integer NOT NULL,
    mes integer NOT NULL,
    trimestre integer NOT NULL,
    ano integer NOT NULL,
    PRIMARY KEY(id_tempo)
);

-- d_local(id_local, latude, longitude, nome)

CREATE TABLE d_local (
    id_local serial,
    latitude numeric(8, 6) NOT NULL,
	longitude numeric(9, 6) NOT NULL,
    nome varchar(1024) NOT NULL,
    PRIMARY KEY(id_local)
);

-- d_lingua(id_lingua, lingua, país)

CREATE TABLE d_lingua (
    id_lingua serial,
    lingua varchar(120),
    pais varchar(120),
    PRIMARY KEY(id_lingua)
);

/* f_anomalia(id_ulizador, id_tempo, id_local, id_lingua, po_nomalia, com_proposta)
- id_ulizador: FK(d_ulizador)
- id_tempo: FK(d_tempo)
- id_local: FK (d_local)
- id_lingua: FK(d_lingua)*/

CREATE TABLE f_anomalia(
    id_utilizador integer NOT NULL, 
    id_tempo integer NOT NULL,
    id_local integer NOT NULL,
    id_lingua integer NOT NULL,

    FOREIGN KEY(id_utilizador)
		REFERENCES d_utilizador
		ON DELETE CASCADE,
	FOREIGN KEY(id_tempo)
		REFERENCES d_tempo
		ON DELETE CASCADE,
    FOREIGN KEY(id_local)
		REFERENCES d_local
		ON DELETE CASCADE,
    FOREIGN KEY(id_lingua)
		REFERENCES d_lingua
		ON DELETE CASCADE,

	PRIMARY KEY(id_utilizador, id_tempo, id_local, id_lingua)
);