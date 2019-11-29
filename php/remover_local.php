<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Local:</h2>

        <?php
                include 'lib/aux.php';
                if (isset($_POST['info'])) {
                    $info = json_decode($_POST['info'], true);
                    $lat = sprintf("%.6f", $info['lat']);
                    $lon = sprintf("%.6f", $info['lon']);
    
                    removeLocal($lat, $lon);
                }
        	displayLocais();
        ?>
        <p>Inserir coordenadas de local a remover:</p>
        <form action="" method="post">
        	<?php
                $db = database_connect();
                $sql = "SELECT * FROM local_publico;";
                $result = $db->prepare($sql);
                $result->execute();

                $result = makeArray($result);
                echo("<select name='info'>\n");
                foreach ($result as $row) {
                    $info = json_encode(array("lat" => $row['latitude'], "lon" => $row['longitude']));
                    echo("<option value=".$info.">(".$row['latitude'].", ".$row['longitude'].") | ".$row['nome']."</option>\n");
                }
                echo("</select>\n");

                $db = null;
            ?>
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>
    </body>
</html>