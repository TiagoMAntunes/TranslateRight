<html>
	<body>
		<h1>Translate Right</h1>
		<h2>Registar Duplicados</h2>

		<?php
			include "lib/aux.php"; 
			displayItems();
		?>
		<p>Selecione os items que pretende registar como duplicados:</p>

		<?php
	        include_once 'lib/dbconnect.php';
	        try {
		        $db = database_connect();

		        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		            //First time requesting, create options menu

		            $sql = "SELECT id FROM item ORDER BY id ASC;";
		            $resultA = $db->prepare($sql);
		            $resultA->execute();

		            $sql = "SELECT id FROM item ORDER BY id ASC;";
		            $resultB = $db->prepare($sql);
		            $resultB->execute();

		            $itemsA = makeArray($resultA);
		            $itemsB = makeArray($resultB);
		            
		            echo("<form action='' method='post'>\n");
		            echo("<table>\n
		            		<tr>\n
		            			<td>Item 1</td>\n 
		            			<td>Item 2</td>\n
		            		</tr>\n");

		            //List user mails
		            echo("<tr>\n");
		            echo("<td>\n");
		            echo("<select name='itemA'>\n");
		            foreach ($itemsA as $row) {
		                echo("<option value='{ \"id\": \"".$row['id']."\"}'>".$row['id']."</option>\n");
		            }
		            echo("</select>\n");
		        	echo("</td>\n");

		        	// List items
		        	echo("<td>\n");
		            echo("<select name='itemB'>\n");
		            foreach ($itemsB as $row) {
		            	echo("<option value='{ \"id\": \"".$row['id']."\"}'>".$row['id']."</option>\n");
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
		        	$db = database_connect();
		        	$item1 = json_decode($_POST['itemA'], true);
		        	$item2 = json_decode($_POST['itemB'], true);

		        	$minID = $item1['id'];
		        	$maxID = $item2['id'];

		        	if ($maxID < $minID) {
		        		$aux = $minID;
		        		$minID = $maxID;
		        		$maxID = $aux;
		        	}

					if ($minID == null || $maxID == null) {
		        		echo("<p>Impossível registar duplicado com campos em falta.</p>\n");
					}

		        	else if ($minID == $maxID) {
		        		echo("<p>Um item não pode ser duplicado de si prório. Tente outra vez.</p>\n");
					}
					
					
		        	else {
		        		$sql = "INSERT INTO duplicado(item1, item2)
		        				VALUES (?, ?);";

		        		$result = $db->prepare($sql);
		        		$result->execute(array($minID, $maxID));
		        		$db = null;

		        		echo("<p>Duplicados inseridos com êxito.</p>\n");
		        	}

		        }
		    }
		    catch (PDOException $e) {
		    	if ($e->getCode() == 23505) {
		    		echo("<p>A duplicação referida já tinha sido registada.</p>");
		    	}
		    	else {
		    		echo($e->getMessage());
		    	}
		    }
	    ?>
	    <p></p>
	    <form action="menu.php">
	        <input type="submit" value="Menu"/>
	    </form>
	</body>
</html>	