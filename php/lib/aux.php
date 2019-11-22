<?php

	function isBetween($a, $x, $y) {
		return $a >= $x and $a <= $y;
	}

	function addLocal($lat, $lon, $name) {
		$maxLatitude = 90;
		$minLatitude = -90;
		$maxLongitude = 180;
		$minLongitude = -180;
		if (isBetween($lat, $minLatitude, $maxLatitude) && isBetween($lon, -180, 180)) {
            try {
                $db = database_connect();
                $sql = "INSERT INTO local_publico(latitude, longitude, nome)
                        VALUES ($lat, $lon, '$name');";
                $result = $db->prepare($sql);
                $result->execute();
                $db = null;

                echo("<p>Local público inserido com êxito!\n</p>");
            }
            catch (PDOException $e) {
                //echo "<p><b>Error connecting to database:</b> {$e->getMessage()}</p>";
                
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
?>