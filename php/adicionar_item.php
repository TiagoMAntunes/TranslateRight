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
                <td>Latitude</td>
                <td><input type="number" step="0.000001" name="latitude" required></td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td><input type="number" step="0.000001" name="longitude" required></td>
            </tr>
        </table>
        <input type="submit" value="Inserir">
    </form>
    <form action="menu.php">
        <input type="submit" value="Menu"/>
    </form>
    
    <?php
        include 'lib/aux.php';
        include 'lib/dbconnect.php';

        if (isset($_POST["latitude"]) && isset($_POST["longitude"]) && isset($_POST["descricao"]) && isset($_POST['localizacao'])) {
            $lat = sprintf("%.6f", $_POST["latitude"]);
            $lon = sprintf("%.6f", $_POST["longitude"]);
            $desc = $_POST["descricao"];
            $loc = $_POST["localizacao"];

            addItem($desc, $loc, $lat, $lon);
        } 
    ?>
</body>
</html>