<html>
	<body>
		<h1>Translate Right</h1>
        <h2>Listar Anomalias Recentes</h2>

        <p>Insira a variação da latitude e da longitude (em graus decimais):</p>
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
        	<input type="submit" value="Inserir">
    	</form>

	    <form action="menu.php">
	        <input type="submit" value="Menu"/>
	    </form>
	    <?php
	    	include "lib/aux.php";
	    	if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
	    		$lat = sprintf("%.6f", $_POST["latitude"]);
            	$lon = sprintf("%.6f", $_POST["longitude"]);
            	listarAnomaliasRecentes($lat, $lon);
	    	}
	    ?>
	</body>
</html>