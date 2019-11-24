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

	function formatZona($x1, $y1, $x2, $y2) {
		return '(('.$x1.','.$y1.'),('.$x2.','.$y2.'))';
	}

	function insertAnomalia($db, $zona, $img, $lingua, $desc, $trad) {
		$sql = "INSERT INTO anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
                VALUES (?, ?, ?, ?, ?, ?);";
        $result = $db->prepare($sql);
        $data = array($zona, $img, $lingua, date("Y-m-d H:i:s"), $desc, $trad);
        $result->execute($data);
	}

	function addAnomalia($zona, $img, $lingua, $desc, $trad) {
		try {
	        $db = database_connect();
	        insertAnomalia($db, $zona, $img, $lingua, $desc, $trad);
	        echo("<p>Anomalia de redação adicionada com êxito!</p>\n");
 
	        $db = null;
	    }
	    catch (PDOException $e) {             
	        echo $e->getMessage();
	    }
	}

	function overlap($x1, $y1, $x2, $y2, $x1_2, $y1_2, $x2_2, $y2_2) {
		return !($x1 > $x2_2 || $x1_2 > $x2 || $y1 > $y2_2 || $y1_2 > $y2);
	}

	function addAnomaliaTraducao($zona, $img, $lingua, $desc, $trad, $zona2, $lingua2) {
		try {
			$db = database_connect();
			$db->beginTransaction();
			if ($lingua != $lingua2) {
				if (!overlap($_POST['x1'], $_POST['y1'], $_POST['x2'], $_POST['y2'],
					$_POST['x1_2'], $_POST['y1_2'], $_POST['x2_2'], $_POST['y2_2'])) {
					insertAnomalia($db, $zona, $img, $lingua, $desc, $trad);

			        $sql = "INSERT INTO anomalia_traducao(id, zona2, lingua2)
			                VALUES (?, ?, ?);";

			        $result = $db->prepare($sql);		
			        $data = array($db->lastInsertId("anomalia_id_seq"), $zona2, $lingua2);
			        $result->execute($data);
			        $db->commit(); 

			        echo("<p>Anomalia de tradução adicionada com êxito!</p>\n");
			        $db = null;
				}
				else {
					echo("<p>'Zona' e 'Zona 2' não se devem sobrepor. ");
					echo("Tente outra vez.</p>\n");
				}
			}
			else {
				echo("<p>Os campos 'Língua' e 'Língua 2' devem ser diferentes. ");
				echo("Tente outra vez.</p>\n");
			}
	    }
	    catch (PDOException $e) {
	    	echo $e->getMessage();
	    	$db->rollbak();
	    }

	}
?>