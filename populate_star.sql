-- id_ulizador(id_ulizador, email, tipo)

INSERT INTO d_utilizador(email, tipo)
SELECT email, 'utilizador regular' FROM utilizador_regular;

INSERT INTO d_utilizador(email, tipo)
SELECT email, 'utilizador qualificado' FROM utilizador_qualificado;

/* Emails devem ser apenas os que existem na BD? */


-- id_tempo(id_tempo, dia, dia_da_semana, semana, mes, trimestre, ano)

INSERT INTO d_tempo(dia, dia_da_semana, semana, mes, trimestre, ano)
SELECT DISTINCT extract(DAY FROM tempo), extract(DOW FROM tempo), extract(WEEK FROM tempo),
        extract(MONTH FROM tempo), extract(QUARTER FROM tempo), extract(YEAR FROM tempo) 
FROM GENERATE_SERIES('2019-01-01 00:00'::timestamp, '2029-12-31 23:59'::timestamp, '1 day') as tempo;


-- id_local(id_local, latude, longitude, nome)
-- tem q ser por incidencia
WITH items AS (
    SELECT localizacao, latitude, longitude, i.item_id
    FROM item, incidencia AS i
    WHERE item.id = i.item_id
)
INSERT INTO d_local(latitude, longitude, nome)
SELECT DISTINCT latitude, longitude, localizacao FROM items;

/* Latitude e longitude devem ser todos os valores possíveis? */

-- id_lingua(id_lingua, lingua)

INSERT INTO d_lingua(lingua)
SELECT DISTINCT lingua FROM anomalia;

/* f_anomalia(id_utilizador, id_tempo, id_local, id_lingua, tipo_nomalia, com_proposta)
- id_utilizador: FK(d_ulizador)
- id_tempo: FK(d_tempo)
- id_local: FK (d_local)
- id_lingua: FK(d_lingua)*/

