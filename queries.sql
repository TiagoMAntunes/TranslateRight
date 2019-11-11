-- SQL--

-- 1.
WITH aux AS (
	SELECT inc.item_id, COUNT(inc.anomalia_id) AS count
	FROM proj.incidencia AS inc
	GROUP BY inc.item_id
), max_aux AS (
	SELECT DISTINCT MAX(count) AS max_count
	FROM aux
)
SELECT * 
FROM proj.local_publico AS lp
NATURAL JOIN (
	SELECT latitude, longitude 
	FROM proj.item AS item
	INNER JOIN (
		SELECT item_id, count 
		FROM aux
		WHERE count = (SELECT max_count FROM max_aux)
	) AS max 
	ON max.item_id = item.id
) AS coords;

-- 2.
-- 3.
-- 4.
