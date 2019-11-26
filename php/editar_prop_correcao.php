<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Editar Proposta de Correção:</h2>

        <?php
       	 	include 'lib/aux.php';
            $db = database_connect();
            $sql = "SELECT * FROM proposta_de_correcao p ORDER BY p.email ASC, p.nro ASC;";
            $result = $db->prepare($sql);
            $result->execute();
        	displayPropostasCorrecao($result);
        ?>
        <p>Inserir informação da proposta de correção a editar:</p>
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
                <tr>
	        		<td>Novo texto da proposta de correção:</td>
	        		<td><input type="text" name="texto" maxlength="1024" required></td>
	        	</tr>
	        </table>
	        <input type="submit" value="Submeter alterações">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>

        <?php
        	if (isset($_POST['email']) && isset($_POST['nro']) && isset($_POST['texto'])) {
            	editPropCorrecao($_POST['email'], $_POST['nro'], $_POST['texto']);
        	}
        ?>
    </body>
</html>