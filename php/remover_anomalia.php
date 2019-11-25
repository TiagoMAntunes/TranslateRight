<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Anomalia:</h2>

        <?php
       	 	include 'lib/aux.php';
            $db = database_connect();
            $sql = "SELECT * FROM anomalia a LEFT JOIN anomalia_traducao at ON a.id = at.id ORDER BY a.id ASC;";
            $result = $db->prepare($sql);
            $result->execute();
        	displayAnomalias($result);
        ?>
        <p>Inserir ID da anomalia a remover:</p>
        <form action="" method="post">
        	<table>
	        	<tr>
	        		<td>ID:</td>
	        		<td><input type="number" step="1" name="id" required></td>
	        	</tr>
	        </table>
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>

        <?php
        	if (isset($_POST['id'])) {
            	removeAnomalia($_POST['id']);
        	}
        ?>
    </body>
</html>