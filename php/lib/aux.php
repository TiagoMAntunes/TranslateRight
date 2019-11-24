<?php

	function isBetween($a, $x, $y) {
		return $a >= $x and $a <= $y;
	}

	function validCoordinates($lat, $lon) {
		$maxLatitude = 90;
		$minLatitude = -90;
		$maxLongitude = 180;
		$minLongitude = -180;
		return isBetween($lat, $minLatitude, $maxLatitude) && isBetween($lon, $minLongitude, $maxLongitude);
	}

	function addLocal($lat, $lon, $name) {	
		if (validCoordinates($lat, $lon)) {
            try {
                $db = database_connect();
                $sql = "INSERT INTO local_publico(latitude, longitude, nome)
                        VALUES (?, ?, ?);";
                $result = $db->prepare($sql);
                $data = array($lat, $lon, $name);
                $result->execute($data);
                $db = null;

                echo("<p>Local público inserido com êxito!\n</p>");
            }
            catch (PDOException $e) {             
                // if location already exists
                if ($e->getCode() == 23505) {
                    echo("<p>Local público já existente! Tente outra vez.\n</p>");
                }
            }
        }
        else {
        	echo("<p>Coordenadas inválidas. Tente outra vez.\n</p>");
        }
	}

	function hasDuplicates($lat, $lon) {
		$db = database_connect();
		$sql = "SELECT id FROM item WHERE latitude=? AND longitude=? ORDER BY id DESC;";
		$result = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$data = array($lat, $lon);
		$result->execute($data);

		$inserted_id = $result->fetch(PDO::FETCH_NUM)[0];
		while ($row = $result->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$sql = "INSERT INTO duplicado(item1, item2) VALUES(?, ?);";
			$result = $db->prepare($sql);
			$data = array($row[0], $inserted_id);
			$result->execute($data);
		}
		$db = null;
	}

	function addItem($desc, $loc, $lat, $lon) {
		if (validCoordinates($lat, $lon)) {
            try {
                $db = database_connect();
                $sql = "INSERT INTO item(descricao, localizacao, latitude, longitude)
                        VALUES (?, ?, ?, ?);";
                $result = $db->prepare($sql);
                $data = array($desc, $loc, $lat, $lon);
                $result->execute($data);
                $db = null;
                hasDuplicates($lat, $lon);

                echo("<p>Item inserido com êxito!\n</p>");
            }
            catch (PDOException $e) {             
                echo $e->getMessage();
              	// if no corresponding entry in local_publico 
                if ($e->getCode() == 23503) {
                	echo("<p>Não existe nenhum local público nas coordenadas especificadas.\n</p>
                		<p>Tente outra vez!\n</p>");
                }
            }
        }
        else {
        	echo("<p>Coordenadas inválidas. Tente outra vez.\n</p>");
        }
	}
?>