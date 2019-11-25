<?php
	include_once 'lib/dbconnect.php';

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

	function makeArray($info) {
		$final = array();
		$i = 0;
		foreach ($info as $row) {
			$final[$i] = $row;
			$i = $i + 1;
		}
		return $final;
	}

	function displayLocais() {
    	$db = database_connect();
    	$sql = "SELECT * FROM local_publico;";
    	$result = $db->prepare($sql);
    	$result->execute();

    	echo("<p>Locais Públicos:</p>\n");
    	echo("<table border=\"1\">\n");
    	echo("<tr>\n
    			<td>Latitude</td>\n
    			<td>Longitude</td>\n
    			<td>Nome</td>\n
    		  </tr>\n");
    	foreach ($result as $row) {
    		echo("<tr>\n
        			<td>{$row['latitude']}</td>\n
        			<td>{$row['longitude']}</td>\n
        			<td>{$row['nome']}</td>\n
        		  </tr>\n");
    	}
    	echo("</table>");
    	$db = null;
	}

	function displayItems() {
    	$db = database_connect();
    	$sql = "SELECT * FROM item;";
    	$result = $db->prepare($sql);
    	$result->execute();

    	echo("<p>Items:</p>\n");
    	echo("<table border=\"1\">\n");
    	echo("<tr>\n
    			<td>ID</td>\n
    			<td>Descrição</td>\n
    			<td>Localização</td>\n
                <td>Latitude</td>\n
                <td>Longitude</td>\n
    		  </tr>\n");
    	foreach ($result as $row) {
    		echo("<tr>\n
                    <td>{$row['id']}</td>\n
                    <td>{$row['descricao']}</td>\n
                    <td>{$row['localizacao']}</td>\n
        			<td>{$row['latitude']}</td>\n
        			<td>{$row['longitude']}</td>\n
        		  </tr>\n");
    	}
    	echo("</table>");
        $db = null;
	}

	function displayAnomalias($result) {
		if ($result->rowCount() == 0) {
			echo("<p>Não há anomalias nas condições referidas.</p>\n");
		}
		else {
	    	echo("<p>Anomalias:</p>\n");
	    	echo("<table border=\"1\">\n");
	    	echo("<tr>\n
	    			<td>ID</td>\n
	    			<td>Zona</td>\n
	    			<td>Imagem</td>\n
	                <td>Língua</td>\n
	                <td>Timestamp</td>\n
	                <td>Descrição</td>\n
	                <td>Anomalia de Tradução?</td>\n
	                <td>Zona 2</td>\n
	                <td>Língua 2</td>\n
	    		  </tr>\n");

	    	foreach ($result as $row) {
	    		echo("<tr>\n
	                    <td>{$row['id']}</td>\n
	                    <td>{$row['zona']}</td>\n
	                    <td>{$row['imagem']}</td>\n
	                    <td>{$row['lingua']}</td>\n
	        			<td>{$row['ts']}</td>\n
	        			<td>{$row['descricao']}</td>\n");

	        	if ($row['tem_anomalia_traducao']) {

	        		echo("<td>SIM</td>\n
	        			  <td>{$row['zona2']}</td>\n
	        			  <td>{$row['lingua2']}</td>\n");
	        	}
	        	else {
	        		echo("<td>NÃO</td>\n");
	        	}

	        	echo("</tr>\n");
	    	}
	    	echo("</table>");
	        $db = null;
	    }
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

	function removeLocal($lat, $lon) {
		if (validCoordinates($lat, $lon)) {
			try {
                $db = database_connect();
                $sql = "DELETE FROM local_publico WHERE latitude = ? AND longitude = ?;";
                $result = $db->prepare($sql);
                $data = array($lat, $lon);
                $result->execute($data);
                $db = null;

                if ($result->rowCount() == 0) {
                	echo("<p>Não existe nenhum local com as coordenadas (".$lat.", ".$lon.").</p>\n");
                }
                else {
                	echo("<p>Local público removido com êxito!\n</p>");
                } 
            }
            catch (PDOException $e) {             
                // if location already exists
                echo($e->getMessage());
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
                //hasDuplicates($lat, $lon);

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

	function removeItem($id) {
		try {
			$db = database_connect();
			$sql = "DELETE FROM item WHERE id = ?;";
			$result = $db->prepare($sql);
			$data = array($id);
			$result->execute($data);

			if ($result->rowCount() == 0) {
				echo("<p>ID inválido.</p>\n");
			}
			else {
				echo("<p>Item removido com êxito.</p>\n");
			}
		}
		catch(PDOException $e) {
			echo($e->getMessage());
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

	function removeAnomalia($id) {
		try {
			$db = database_connect();
			$sql = "DELETE FROM anomalia WHERE id = ?;";
			$result = $db->prepare($sql);
			$data = array($id);
			$result->execute($data);
			$db = null;

			if ($result->rowCount() == 0) {
				echo("<p>ID inválido.</p>\n");
			}
			else {
				echo("<p>Anomalia removida com êxito.</p>\n");
			}
		}
		catch(PDOException $e) {
			echo($e->getMessage());
		}
	}

	function listarAnomaliasRecentes($lat, $lon) {
		try {
			$db = database_connect();
			$sql = "WITH anoms_aux AS (
				      SELECT * FROM anomalia
				      NATURAL JOIN incidencia inc 
				      NATURAL JOIN item it
				      WHERE (latitude = ? AND longitude = ?) OR
				      (latitude = ? AND longitude = ?) OR
				      (latitude = ? AND longitude = ?) OR
				      (latitude = ? AND longitude = ?)
					)
					SELECT * FROM anoms_aux
					LEFT JOIN anomalia_traducao
					ON anoms_aux.id = anomalia_traducao.id
					WHERE DATE(ts) > CURRENT_DATE - INTERVAL '3 months'
					ORDER BY anoms_aux.id ASC;";

			$result = $db->prepare($sql);
			$data = array($lat, $lon, $lat, -$lon, -$lat, $lon, -$lat, -$lon);
			$result->execute($data);

			displayAnomalias($result);
			$db = null;
		}
		catch (PDOException $e) {
			echo($e->getMessage());
		}

	}
?>