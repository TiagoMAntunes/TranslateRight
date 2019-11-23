<html>

<body>
        <?php
        include 'lib/dbconnect.php';
        $db = database_connect();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            //First time requesting, create options menu

            $sql = "SELECT * FROM local_publico;";
            $result = $db->prepare($sql);
            $result->execute();
            $db = null;

            $locals = array();
            $i = 0;
            //Save places in array
            foreach ($result as $row) {
                $locals[$i] = $row;
                $i = $i + 1;
            }
            echo '<form action="" method="post">';
            //Using JSON encoding
            echo '<select name="localA">';
            foreach ($locals as $row) {
                echo "<option value='{ \"lat\": ", $row['latitude'], ", \"lon\": ", $row['longitude'], "}'>", $row['nome'], "</option>";
            }
            echo '</select>';

            echo '<select name="localB">';
            foreach ($locals as $row) {
                echo "<option value='{ \"lat\": ", $row['latitude'], ", \"lon\": ", $row['longitude'], "}'>", $row['nome'], "</option>";
            }
            echo '</select>';

            echo '<button action="submit" >Listar</button>';
            echo '</form>';
        } else {
            //List all the problems
            echo "<p>A: ", $_POST['localA'], "</p>";
            echo "<p>B: ", $_POST['localB'], "</p>";

            $localA = json_decode($_POST['localA'], true);
            $localB = json_decode($_POST['localB'], true);

            $sql = "SELECT * FROM local_publico WHERE latitude BETWEEN :latA AND :latB AND longitude BETWEEN :lonA AND :lonB;";
            $result = $db->prepare($sql);
            $result->execute(array(':latA' => $localA['lat'], ':latB' => $localB['lat'], ':lonA' => $localA['lon'], 'lonB' => $localB['lon']));
            
            echo ("<table border=\"1\">\n");
            echo ("<tr><td>Nome</td></tr>\n");
            foreach ($result as $row) {
                echo ("<tr>\n");
                echo ("<td>{$row['nome']}</td>\n");
                echo ("</tr>\n");
            }
            echo ("</table>\n");
        }
        ?>
</body>

</html>