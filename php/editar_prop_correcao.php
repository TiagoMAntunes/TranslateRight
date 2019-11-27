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
                    <td>Email e nro:</td>
                    <td>
                        <?php
                            $db = database_connect();
                            $sql = "SELECT email, nro FROM proposta_de_correcao ORDER BY email, nro ASC;";
                            $result = $db->prepare($sql);
                            $result->execute();
                            $db = null;

                            $info = makeArray($result);
                            echo("<select name='info'>\n");
                            foreach ($info as $row) {
                                $info = json_encode(array("email" => $row['email'], "nro" => $row['nro']));
                                echo("<option value=".$info.">".$row['email']." --> ".$row['nro']."</option>\n");
                            }
                            echo("</select>\n"); 
                        ?> 
                    </td>       
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
        	if (isset($_POST['info']) && isset($_POST['texto'])) {
                $email = json_decode($_POST['info'], true)['email'];
                $nro = json_decode($_POST['info'], true)['nro'];
            	editPropCorrecao($email, $nro, $_POST['texto']);
        	}
        ?>
    </body>
</html>