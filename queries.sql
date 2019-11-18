-- SQL--

-- 1.
WITH aux AS (
	SELECT inc.item_id, COUNT(inc.anomalia_id) AS count
	FROM proj.incidencia AS inc
	GROUP BY inc.item_id

), maximos AS (
	SELECT latitude, longitude 
	FROM proj.item AS item
	INNER JOIN (
		SELECT item_id, count 
		FROM aux
		WHERE count IN (SELECT MAX(count) FROM aux)
	) max
	ON max.item_id = item.id
)

SELECT * 
FROM proj.local_publico AS lp
NATURAL JOIN maximos;


-- 2.
WITH aux_anomalias AS (
	SELECT id
	FROM proj.anomalia
	NATURAL JOIN proj.anomalia_traducao
	WHERE ts BETWEEN '2019-06-01 00:00:00'::timestamp AND '2019-12-31 23:59:59'

), n AS (
	SELECT email, COUNT(anomalia_id) count
	FROM proj.incidencia AS inc
	INNER JOIN aux_anomalias
	ON inc.anomalia_id = aux_anomalias.id
	GROUP BY email
)

SELECT *
FROM proj.utilizador u
NATURAL JOIN proj.utilizador_regular ur 
WHERE ur.email IN (
	SELECT n.email 
	FROM n 
	WHERE count IN (SELECT MAX(count) FROM n)
);

-- 3. 
WITH north AS (
	SELECT DISTINCT email, item_id 
	FROM proj.incidencia inc
	INNER JOIN proj.item it
	ON inc.item_id = it.id
	WHERE it.latitude > 39.336775
), year_north AS (
	SELECT DISTINCT email, COUNT(DISTINCT item_id) n_items_north
	FROM proj.incidencia inc
	INNER JOIN proj.anomalia an
	ON inc.anomalia_id = an.id
	NATURAL JOIN north 
	WHERE extract(year from an.ts) = 2019
	GROUP BY email
), n_north AS (
	SELECT COUNT(DISTINCT item_id) count
	FROM north
)
SELECT DISTINCT email, password
FROM proj.utilizador ut
NATURAL JOIN year_north yn
WHERE yn.n_items_north IN (SELECT * FROM n_north);


-- 4.

WITH year_south AS (
	SELECT DISTINCT email, anomalia_id 
	FROM proj.incidencia inc
	INNER JOIN proj.item it
	ON inc.item_id = it.id
	INNER JOIN proj.anomalia an
	ON an.id = inc.anomalia_id
	WHERE it.latitude < 39.336775 AND extract(year from an.ts) = 2019
)
SELECT DISTINCT u.email, u.password/*, ys.anomalia_id ap, c.anomalia_id ac*/
FROM proj.utilizador u
NATURAL JOIN proj.utilizador_qualificado uq
INNER JOIN year_south ys
ON ys.email = uq.email
LEFT JOIN proj.correcao c
ON ys.anomalia_id = c.anomalia_id
WHERE c.anomalia_id is NULL;


