<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Anomalia:</h2>
        <?php
            include 'lib/aux.php';
            if (isset($_POST['id'])) {
            	removeAnomalia($_POST['id']);
        	}
       	 	
            $db = database_connect();
            $sql = "SELECT a.id, zona, imagem, lingua, ts, descricao, tem_anomalia_traducao, at.zona2, at.lingua2 FROM anomalia a LEFT JOIN anomalia_traducao at ON a.id = at.id ORDER BY a.id ASC;";
            $result = $db->prepare($sql);
            $result->execute();
        	displayAnomalias($result);
        ?>
        <p>Inserir ID da anomalia a remover:</p>
        <form action="" method="post">
        	<table>
	        	<tr>
	        		<td>ID:</td>
	        		<td>
                        <?php
                            $db = database_connect();
                            $sql = "SELECT id FROM anomalia;";
                            $result = $db->prepare($sql);
                            $result->execute();

                            $result = makeArray($result);
                            echo("<select name='id'>\n");
                            foreach ($result as $row) {
                                echo("<option value=".$row['id'].">".$row['id']."</option>\n");
                            }
                            echo("</select>\n");

                            $db = null
                        ?> 
                    </td>
	        	</tr>
	        </table>
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>
    </body>
</html>