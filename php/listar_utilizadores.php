<html>

<body>
	<?php

	include './lib/dbconnect.php';

	try {
		$db = database_connect();
		//Inserir código de manuseamento da base de dados
		echo $db;
	} catch (PDOException $e) {
		echo "<p><b>Error connecting to database:</b> {$e->getMessage()}</p>";
	}

	?>

</body>

</html>