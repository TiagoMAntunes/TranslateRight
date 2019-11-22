<html>

<body>
	<?php

	include './lib/dbconnect.php';

	try {
		$db = database_connect();
		//Inserir código de manuseamento da base de dados
		$sql = "SELECT email FROM utilizador;";
		$result = $db->prepare($sql);
		$result->execute();
		$db = null;


		echo ("<table border=\"1\">\n");
		echo ("<tr><td>email</td></tr>\n");
		foreach ($result as $row) {
			echo ("<tr>\n");
			echo ("<td>{$row['email']}</td>\n");
			echo ("</tr>\n");
		}
		echo ("</table>\n");
	} catch (PDOException $e) {
		echo "<p><b>Error connecting to database:</b> {$e->getMessage()}</p>";
	}

	?>

</body>

</html>