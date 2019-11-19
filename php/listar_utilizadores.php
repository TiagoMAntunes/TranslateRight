<html>
<body>
	<?php
		try {
			$host = "yyyyyyyyy"; // db name
	        $user = "xxxxxxx";
	        $password = "xxxxxxxx";
	        $dbname = $user;
	    
	        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
	        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	        $sql = "SELECT email FROM proj.utilizador;";
	        $result = $db->prepare($sql);
        	$result->execute();

        	echo("<table border=\"1\">\n");
        	echo("<tr><td>email</td></tr>\n"\n)
        	foreach($result as $row) {
        		echo("<tr>"\n)
        		echo("<td>{$row['email']}</td>\n");
        		echo("</tr>"\n)
        	}
        	echo("</table>\n")

        	$db = null;
	    }
	    catch (PDOException $e) {
	        echo("<p>ERROR: {$e->getMessage()}</p>");
	    }

    ?>

</body>
</html>