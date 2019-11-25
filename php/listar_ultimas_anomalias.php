<html>
	<body>
		<h1>Translate Right</h1>
        <h2>Listar Anomalias Recentes</h2>

        <p>Insira a latitude e a longitude e respetivas variações (em graus decimais):</p>
        <form action="" method="post">
        	<table>
        		<tr>
        			<td>Latitude:</td>
        			<td><input type="number" step="0.000001" name="latitude" required></td>
        			<td>Variação:</td>
        			<td><input type="number" step="0.000001" min="0" name="deltaLat" required></td>
        		</tr>	
        		<tr>
        			<td>Longitude:</td>
        			<td><input type="number" step="0.000001" name="longitude" required></td>
        			<td>Variação:</td>
        			<td><input type="number" step="0.000001" min="0" name="deltaLon" required></td>
        		</tr>
        	</table>
        	<input type="submit" value="Inserir">
    	</form>

	    <form action="menu.php">
	        <input type="submit" value="Menu"/>
	    </form>
	    <?php
	    	include "lib/aux.php";
	    	if (isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['deltaLat']) && isset($_POST['deltaLon'])) {
	    		$lat = sprintf("%.6f", $_POST["latitude"]);
            	$lon = sprintf("%.6f", $_POST["longitude"]);
            	$dlat = sprintf("%.6f", $_POST["deltaLat"]);
            	$dlon = sprintf("%.6f", $_POST["deltaLon"]);

            	listarAnomaliasRecentes($lat, $lon, $dlat, $dlon);
	    	}
	    ?>
	</body>
</html>