<html>
	<body>
		<h1>Translate Right</h1>
		<h2>Registar Incidência:</h2>

		<?php
        include_once 'lib/dbconnect.php';
        include_once 'lib/aux.php';
        try {
	        $db = database_connect();

	        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	            //First time requesting, create options menu

	            $sql = "SELECT email FROM utilizador ORDER BY email ASC;";
	            $resultA = $db->prepare($sql);
	            $resultA->execute();

	            $sql = "SELECT id, latitude, longitude FROM item ORDER BY id ASC;";
	            $resultB = $db->prepare($sql);
	            $resultB->execute();

	            $aux_sql = "SELECT anomalia_id FROM incidencia";
	            $sql = "SELECT id, ts FROM anomalia WHERE id NOT IN ($aux_sql) ORDER BY id ASC;";
	            $resultC = $db->prepare($sql);
	            $resultC->execute();

	            $emails = makeArray($resultA);
	            $items = makeArray($resultB);
	            $anoms = makeArray($resultC);
	            
	            echo("<form action='' method='post'>\n");
	            echo("<table>\n
	            		<tr>\n
	            			<td>Email</td>\n 
	            			<td>Item</td>\n
	            			<td>Anomalia</td>\n
	            		</tr>\n");

	            //List user mails
	            echo("<tr>\n");
	            echo("<td>\n");
	            echo("<select name='email'>\n");
	            foreach ($emails as $row) {
	                echo("<option value='{ \"email\": \"".$row['email']."\"}'>".$row['email']."</option>\n");
	            }
	            echo("</select>\n");
	        	echo("</td>\n");

	        	// List items
	        	echo("<td>\n");
	            echo("<select name='item'>\n");
	            foreach ($items as $row) {
	            	echo("<option value='{ \"id\": ".$row['id'].", \"lat\": ".$row['latitude'].", \"lon\": ".$row['longitude']."}'>".$row['id']." | (".$row['latitude'].", ".$row['longitude'].")</option>");
	            }
	            echo("</select>\n");
	            echo("</td>\n");

	            // list anomalies
	            echo("<td>\n");
	            echo("<select name='anom'>\n");
	            foreach ($anoms as $row) {
	                echo("<option value='{ \"id\": ".$row['id']."}'>".$row['id']." | ".$row['ts']."</option>\n");
	            }
	            echo("</select>\n");
	            echo("</td>\n");

	            // submit answer
	            echo("<tr>\n");
	            echo("<td><input type='submit' value='Registar'></td>\n");
	            echo("</tr>\n");

	            echo("</table>\n");
	            echo("</form>\n");

	            $db = null;

	        } else {
	            //List all the problems
	            $db = database_connect();

	            $email = json_decode($_POST['email'], true);
	            $item = json_decode($_POST['item'], true);
				$anom = json_decode($_POST['anom'], true);
				
				if($email != null && $item != null && $anom != null){
					$sql = "INSERT INTO incidencia(anomalia_id, item_id, email) VALUES (?, ?, ?);";
					
					$result = $db->prepare($sql);
	       			$data = array($anom['id'], $item['id'], $email['email']);
					$result->execute($data);
					
					echo("<p>Incidência inserida com êxito.</p>\n");
				}
	            
	      		else{
					echo("<p>Impossível registar incidência com campos em falta.</p>\n");
				}

	       		$db = null;

	       	}
	    }
       	catch (PDOException $e) {
       		echo($e->getMessage());
       	}
        
    ?>
    <p></p>
    <form action="menu.php">
        <input type="submit" value="Menu"/>
    </form>


	</body>
</html>