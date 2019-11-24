<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Local:</h2>

        <?php
        	include 'lib/dbconnect.php';
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
        	echo("</table>")
        ?>
        <p>Inserir coordenadas de local a remover:</p>
        <form action="" method="post">
        	<table>
	        	<tr>
	        		<td>Latitude:</td>
	        		<td><input type="number" step="0.000001" name="latitude" required></td>
	        	</tr>
	        	<tr>
	        		<td>Longitude:</td>
	        		<td><input type="number" step="0.000001" name="longitude" required></td>
	        	</tr>
	        </table>
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>

        <?php
        	include 'lib/aux.php';

        	if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
        		$lat = sprintf("%.6f", $_POST["latitude"]);
            	$lon = sprintf("%.6f", $_POST["longitude"]);

            	removeLocal($lat, $lon);
        	}
        ?>
    </body>
</html>