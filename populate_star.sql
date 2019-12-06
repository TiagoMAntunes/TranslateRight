-- d_ulizador(id_ulizador, tipo)

INSERT INTO d_utilizador(tipo)
SELECT 'utilizador regular' from utilizador_regular;

INSERT INTO d_utilizador(tipo)
SELECT 'utilizador qualificado' from utilizador_qualificado;

-- d_tempo(id_tempo, dia, dia_da_semana, semana, mes, trimestre, ano)

INSERT INTO d_tempo(dia, dia_da_semana, semana, mes, trimestre, ano)
SELECT extract(DAY FROM ts), extract(DOW FROM ts), extract(WEEK FROM ts),
        extract(MONTH FROM ts), extract(QUARTER FROM ts), extract(YEAR FROM ts) FROM anomalia;


-- d_local(id_local, latude, longitude, nome)
-- anomalias n têm estas caracteriscaaaaas
/*INSERT INTO d_local(latitude, longitude, nome)
SELECT */

-- d_lingua(id_lingua, lingua, país)

INSERT INTO d_lingua(lingua)
SELECT lingua from anomalia; -- missing pais porque... onde e q isso ta lmao