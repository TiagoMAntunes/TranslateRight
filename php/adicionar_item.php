<html>
<body>
    <h1>Translate Right</h1>
    <h2>Inserir Item:</h2>

    <form action="" method="post">
        <table>
            <tr>
                <td>Nome</td>
                <td>Valor</td>
            </tr>
            <tr>
                <td>Descrição</td>
                <td><input type="text"  name="descricao" required></td>
            </tr>
            <tr>
                <td>Localização</td>
                <td><input type="text"  name="localizacao" required></td>
            </tr>
            <tr>
                <td>Local</td>
                <td>
                    <?php
                        include "lib/aux.php";
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
                </td>
            </tr>
        </table>
        <input type="submit" value="Inserir">
    </form>
    <form action="menu.php">
        <input type="submit" value="Menu"/>
    </form>
    
    <?php
        if (isset($_POST["info"]) && isset($_POST["descricao"]) && isset($_POST['localizacao'])) {
            $info = json_decode($_POST['info'], true);
            $lat = sprintf("%.6f", $info['lat']);
            $lon = sprintf("%.6f", $info['lon']);
            $desc = $_POST["descricao"];
            $loc = $_POST["localizacao"];

            addItem($desc, $loc, $lat, $lon);
        } 
    ?>
</body>
</html>