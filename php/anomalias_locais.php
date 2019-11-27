<html>
<body>
    <h1>Translate Right</h1>
    <p>Selecione os 2 locais pretendidos:</p>

    <?php
        include 'lib/aux.php';
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
                echo "<option value='{ \"lat\": ".$row['latitude'].", \"lon\": ".$row['longitude'], "}'>(".$row['latitude'].", ".$row['longitude'].") | ".$row['nome']."</option>";
            }
            echo '</select>';

            echo '<select name="localB">';
            foreach ($locals as $row) {
                echo "<option value='{ \"lat\": ".$row['latitude'].", \"lon\": ".$row['longitude'], "}'>(".$row['latitude'].", ".$row['longitude'].") | ".$row['nome']."</option>";
            }
            echo '</select>';

            echo '<button action="submit" >Listar</button>';
            echo '</form>';

        } else {
            //List all the problems
            $localA = json_decode($_POST['localA'], true);
            $localB = json_decode($_POST['localB'], true);

            $minLat = $localA['lat'];
            $maxLat = $localB['lat'];
            if ($minLat > $maxLat) {
                $auxLat = $maxLat;
                $maxLat = $minLat;
                $minLat = $auxLat;
            }

            $minLon = $localA['lon'];
            $maxLon = $localB['lon'];
             if ($minLon > $maxLon) {
                $auxLon = $maxLon;
                $maxLon = $minLon;
                $minLon = $auxLon;
            }

            $db->beginTransaction();
            $sql = "WITH placesBetween AS (
                        SELECT latitude, longitude
                        FROM local_publico 
                        WHERE latitude BETWEEN ? AND ? AND longitude BETWEEN ? AND ?
                    ), itemsBetween AS (
                        SELECT id
                        FROM item 
                        NATURAL JOIN placesBetween
                    )
                    SELECT a.id, a.zona, a.imagem, a.lingua, a.ts, a.descricao, a.tem_anomalia_traducao, at. zona2, at.lingua2
                    FROM anomalia a
                    LEFT JOIN anomalia_traducao at
                    ON a.id = at.id
                    INNER JOIN incidencia inc 
                    ON a.id = inc.anomalia_id
                    WHERE inc.item_id IN (SELECT id FROM itemsBetween);";

            $result = $db->prepare($sql);
            $result->execute(array($minLat, $maxLat, $minLon, $maxLon));
            
            displayAnomalias($result);
        }
    ?>
    <p></p>
    <form action="menu.php">
        <input type="submit" value="Menu"/>
    </form>
</body>

</html>