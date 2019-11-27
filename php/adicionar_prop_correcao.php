<html>
<body>
    <h1>Translate Right</h1>

    <?php
       	include 'lib/aux.php';
        $db = database_connect();
        $sql_aux = "SELECT anomalia_id from incidencia";
        $sql = "SELECT * FROM anomalia a 
                LEFT JOIN anomalia_traducao at 
                ON a.id = at.id 
                WHERE a.id IN ($sql_aux)
                ORDER BY a.id ASC;";
        $result = $db->prepare($sql);
        $result->execute();
        $db = null;
    	displayAnomalias($result);

    ?>

    <h2>Inserir Proposta de Correção:</h2>
    <form action="" method="post">
        <table>
            <tr>
                <td>Nome</td>
                <td>Valor</td>
            </tr>
            <tr>
                <td>Email do utilizador</td>
                <td>
                    <?php
                        $db = database_connect();
                        $sql = "SELECT email FROM utilizador_qualificado ORDER BY email ASC;";
                        $result = $db->prepare($sql);
                        $result->execute();
                        $db = null;

                        $emails = makeArray($result);
                        echo("<select name='email'>\n");
                        foreach ($emails as $row) {
                            echo("<option value='{ \"email\": \"".$row['email']."\"}'>".$row['email']."</option>\n");
                        }
                        echo("</select>\n");

                    ?>
                </td>
            </tr>
            <tr>
                <td>ID da anomalia a corrigir</td>
                <td>
                    <?php
                        $db = database_connect();
                        $sql = "SELECT id, ts FROM anomalia ORDER BY id ASC;";
                        $result = $db->prepare($sql);
                        $result->execute();
                        $db = null;

                        $anoms = makeArray($result);
                        echo("<select name='anom'>\n");
                        foreach ($anoms as $row) {
                            echo("<option value='{ \"id\": ".$row['id']."}'>".$row['id']." | ".$row['ts']."</option>\n");
                        }
                        echo("</select>\n");
                    ?>
                </td>
            </tr>
            <tr>
                <td>Texto da correção</td>
                <td><input type="text" name="texto" maxlength="1024" required></td>
            </tr>
        </table>
        <input type="submit" value="Inserir">
    </form>
    <form action="menu.php">
        <input type="submit" value="Menu"/>
    </form>

    <?php
        if (isset($_POST["email"]) && isset($_POST["anom"]) && isset($_POST["texto"])) {
            $email = json_decode($_POST['email'], true)['email'];
            $anom = json_decode($_POST['anom'], true)['id'];
            $text = $_POST['texto'];
 
            addPropCorrecao($email, $anom, $text);
        }
    ?>
</body>
</html>