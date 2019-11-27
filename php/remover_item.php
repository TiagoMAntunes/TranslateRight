<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Item:</h2>

        <?php
            include 'lib/aux.php';
        	displayItems();
        ?>
        <p>Inserir ID do item a remover:</p>
        <form action="" method="post">
        	<table>
	        	<tr>
	        		<td>ID:</td>
	        		<td>
                        <?php
                            $db = database_connect();
                            $sql = "SELECT id FROM item;";
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

        <?php
        	if (isset($_POST['id'])) {
            	removeItem($_POST['id']);
        	}
        ?>

    </body>
</html>