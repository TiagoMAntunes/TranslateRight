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

	function propCorrecaoExists($db, $email, $nro){
		$sql = "SELECT * FROM proposta_de_correcao
				WHERE email=? AND nro=?;";
		$result = $db->prepare($sql);
		$data = array($email, $nro);
		$result->execute($data);

		return $result->rowCount() > 0;
	}

	function getNro($db, $email){
		$sql = "SELECT email
				FROM proposta_de_correcao
				WHERE email=?;";
		$result = $db->prepare($sql);
		$data = array($email);
		$result->execute($data);

		return $result->rowCount() + 1;
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

	function displayPropostasCorrecao() {
    	$db = database_connect();
    	$sql = "SELECT * FROM proposta_de_correcao;";
    	$result = $db->prepare($sql);
    	$result->execute();

    	echo("<p>Propostas de Correção:</p>\n");
    	echo("<table border=\"1\">\n");
    	echo("<tr>\n
    			<td>Email</td>\n
    			<td>Nro</td>\n
    			<td>Timestamp</td>\n
                <td>Texto</td>\n
    		  </tr>\n");
    	foreach ($result as $row) {
    		echo("<tr>\n
                    <td>{$row['email']}</td>\n
                    <td>{$row['nro']}</td>\n
                    <td>{$row['data_hora']}</td>\n
        			<td>{$row['texto']}</td>\n
        		  </tr>\n");
    	}
    	echo("</table>");
        $db = null;
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

	function listarAnomaliasRecentes($lat, $lon, $dlat, $dlon) {
		try {
			$db = database_connect();
			$sql = "WITH anoms_aux AS (
					  SELECT anom.id, zona, imagem, lingua, ts, anom.descricao, tem_anomalia_traducao
					  FROM anomalia anom
					  INNER JOIN incidencia inc 
					  ON anom.id = inc.anomalia_id
					  INNER JOIN item it
					  ON it.id = inc.item_id
				      WHERE (latitude BETWEEN ? AND ?) AND 
				      (longitude BETWEEN ? AND ?)
					)
					SELECT * FROM anoms_aux aa
					LEFT JOIN anomalia_traducao at
					ON aa.id = at.id
					WHERE DATE(ts) > CURRENT_DATE - INTERVAL '3 months'
					ORDER BY aa.id ASC;";

			$result = $db->prepare($sql);
			$data = array($lat - $dlat, $lat + $dlat, $lon - $dlon, $lon + $dlon);
			$result->execute($data);

			displayAnomalias($result);
			$db = null;
		}
		catch (PDOException $e) {
			echo($e->getMessage());
		}

	}

	function addPropCorrecao($email, $id, $text){
		try {
			$db = database_connect();
			$db->beginTransaction();
			$count = getNro($db, $email);

			insertPropCorrecao($db, $email, $count, $id, $text);

			$db->commit();
			$db = null;
		}
		catch (PDOException $e) {
			echo($e->getMessage());
		}
	}

	function insertPropCorrecao($db, $email, $count, $id, $text){
		$sql = "INSERT INTO proposta_de_correcao(email, nro, data_hora, texto)
				VALUES (?, ?, ?, ?);";
		$result = $db->prepare($sql);
		$data = array($email, $count, date("Y-m-d H:i:s"), $text);
		$result->execute($data);
			
		$sql = "INSERT INTO correcao(email, nro, anomalia_id)
				VALUES (?, ?, ?);";
		$result = $db->prepare($sql);
		$data = array($email, $count, $id);
		$result->execute($data);

		echo("<p>Proposta de correção adicionada com êxito!\n</p>");
	}

	function removePropCorrecao($email, $nro){
		try {
			$db = database_connect();
			$db->beginTransaction();
			$sql = "DELETE FROM proposta_de_correcao 
					WHERE email = ? AND nro = ?;";
			$result = $db->prepare($sql);
			$data = array($email, $nro);
			$result->execute($data);
			
			refreshNros($db, $email);
			echo("<p>Proposta de Correção removida com êxito.</p>\n");

			$db->commit();
			$db = null;
		}
		catch(PDOException $e) {
			echo($e->getMessage());
		}
	}

	function refreshNros($db, $email){
		$count = getNro($db, $email);
		$i = 1;
		$nro = 1;
		echo($count);
		while($i <= $count){
			if(propCorrecaoExists($db, $email, $i)){
				$sql = "UPDATE proposta_de_correcao 
						SET nro = ?
						WHERE email = ? AND nro = ?;";
				$result = $db->prepare($sql);
				$data = array($nro, $email, $i);
				$result->execute($data);

				$nro = $nro + 1;
			}
			$i = $i + 1;
		}
	}

	function editPropCorrecao($email, $nro, $text){
		try{
			$db = database_connect();

			if (!propCorrecaoExists($db, $email, $nro)) {
				echo("<p>Não existe nenhuma Proposta de Correção com o email ".$email." e o nro ".$nro.".</p>\n");
			}

			else{
				$sql = "UPDATE proposta_de_correcao 
						SET texto = ?, data_hora = ?
						WHERE email = ? AND nro = ?;";
				$result = $db->prepare($sql);
				$data = array($text, date("Y-m-d H:i:s"), $email, $nro);
				$result->execute($data);

				echo("<p>Proposta de Correção editada com êxito.</p>\n");
			}

			$db = null;
		}
		catch(PDOException $e) {
			echo($e->getMessage());
		}
	}
?>