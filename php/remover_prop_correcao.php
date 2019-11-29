<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Proposta de Correção:</h2>

        <?php
       	 	include 'lib/aux.php';
            $db = database_connect();
            $sql = "SELECT * FROM proposta_de_correcao p ORDER BY p.email ASC, p.nro ASC;";
            $result = $db->prepare($sql);
            $result->execute();
        	displayPropostasCorrecao($result);
            $db = null;
        ?>
        <p>Inserir email e nro da proposta de correção a remover:</p>
        <form action="" method="post">
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
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>

        <?php
        	if (isset($_POST['info'])) {
                $info = json_decode($_POST['info'], true);
            	removePropCorrecao($info['email'], $info['nro']);
            }
        ?>
    </body>
</html>