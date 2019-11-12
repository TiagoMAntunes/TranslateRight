-- SQL--

-- 1.
WITH aux AS (
	SELECT inc.item_id, COUNT(inc.anomalia_id) AS count
	FROM proj.incidencia AS inc
	GROUP BY inc.item_id
)

SELECT * 
FROM proj.local_publico AS lp
NATURAL JOIN (
	SELECT latitude, longitude 
	FROM proj.item AS item
	INNER JOIN (
		SELECT item_id, count 
		FROM aux
		WHERE count IN (SELECT MAX(count) FROM aux)
	) AS max 
	ON max.item_id = item.id
) AS coords;


-- 2.
WITH n AS (
	SELECT email, COUNT(anomalia_id) count
	FROM proj.incidencia AS inc
	INNER JOIN ( 
		SELECT id
		FROM proj.anomalia
		NATURAL JOIN proj.anomalia_traducao
		WHERE ts BETWEEN '2019-06-01 00:00:00'::timestamp AND '2019-12-31 23:59:59'
	) AS anom 
	ON inc.anomalia_id = anom.id
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
WHERE yn.n_items_north IN (SELECT * FROM n_north)


-- 4.


