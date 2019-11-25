<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Proposta de Correção:</h2>

        <?php
       	 	include 'lib/aux.php';
            $db = database_connect();
            $sql = "SELECT * FROM proposta_de_correcao p ORDER BY p.email, p.nro;";
            $result = $db->prepare($sql);
            $result->execute();
        	displayPropostasCorrecao($result);
        ?>
        <p>Inserir ID da anomalia a remover:</p>
        <form action="" method="post">
        	<table>
	        	<tr>
	        		<td>Email:</td>
	        		<td><input type="text" name="email" maxlength="120" required></td>
	        	</tr>
                <tr>
	        		<td>Nro:</td>
	        		<td><input type="number" step="1" name="nro" required></td>
	        	</tr>
	        </table>
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>

        <?php
        	if (isset($_POST['email']) && isset($_POST['nro'])) {
            	removePropCorrecao($_POST['email'], $_POST['nro']);
        	}
        ?>
    </body>
</html>