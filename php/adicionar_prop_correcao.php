<html>
<body>
    <h1>Translate Right</h1>

    <?php
       	include 'lib/aux.php';
        $db = database_connect();
        $sql = "SELECT * FROM anomalia a LEFT JOIN anomalia_traducao at ON a.id = at.id ORDER BY a.id ASC;";
        $result = $db->prepare($sql);
        $result->execute();
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
                <td><input type="text" name="email" maxlength="120" required></td>
            </tr>
            <tr>
                <td>ID da anomalia a corrigir</td>
                <td><input type="number" step="1" name="id" placeholder="id" required></td>
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
        if (isset($_POST["email"]) && isset($_POST["id"]) && isset($_POST["texto"])) {
            $email = $_POST['email'];
            $id = $_POST['id'];
            $text = $_POST['texto'];
 
            addPropCorrecao($email, $id, $text);
        }
    ?>
</body>
</html>