<html>
<body>
    <script>
        function showMore() {
            var checkBox = document.getElementById("checkbox");
            var text1 = document.getElementById("zona2");
            var text2 = document.getElementById("lingua2");

            if (checkbox.checked == true) {
                text1.style.display = "table-row";
                text2.style.display = "table-row";
            }
            else {
                text1.style.display = "none";
                text2.style.display = "none";
            }
        }
    </script>
    <?php
        include 'lib/aux.php';
        include 'lib/dbconnect.php';

        if (isset($_POST["imagem"]) && isset($_POST["lingua"]) && isset($_POST["descricao"])) {
            $zona = formatZona($_POST["x1"], $_POST["y1"], $_POST["x2"], $_POST["y2"]);
            $img = $_POST['imagem'];
            $lingua = $_POST['lingua'];
            $desc = $_POST['descricao'];
            $trad = $_POST['traducao'];
            if (!isset($_POST['traducao'])) {
                $trad = 'off';
            }
            if ($trad) {
                $zona2 = formatZona($_POST["x1_2"], $_POST["y1_2"], $_POST["x2_2"], $_POST["y2_2"]);
                $lingua2 = $_POST["lingua2"];
                addAnomaliaTraducao($zona, $img, $lingua, $desc, $trad, $zona2, $lingua2);
            }
            else {
                addAnomalia($zona, $img, $lingua, $desc, $trad);
            }
        }
    ?>
    <form action="" method="post">
    <table>
    <tr>
        <td>Nome</td>
        <td>Valor</td>
    </tr>
    <tr>
        <td>Zona</td>
        <td><input type="number" step="0.01" name="x1" placeholder="x1" required></td>
        <td><input type="number" step="0.01" name="y1" placeholder="y1" required></td>
        <td><input type="number" step="0.01" name="x2" placeholder="x2" required></td>
        <td><input type="number" step="0.01" name="y2" placeholder="y2" required></td>
    </tr>
    <tr>
        <td>Imagem</td>
        <td><input type="file" name="imagem" required></td>
    </tr>
    <tr>
        <td>Lingua</td>
        <td><input type="text" name="lingua" required></td>
    </tr>
    <tr>
        <td>Descrição</td>
        <td><input type="text" name="descricao" required></td>
    </tr>
    <tr>
        <td>Tem anomalia na tradução?</td>
        <td><input type="checkbox" id="checkbox" name="traducao" onclick="showMore()"></td>
    </tr>
    <tr id="zona2" style="display:none">
        <td>Zona 2</td>
        <td><input type='number' step='0.01' name='x1_2' placeholder='x1' required></td>
        <td><input type='number' step='0.01' name='y1_2' placeholder='y1' required></td>
        <td><input type='number' step='0.01' name='x2_2' placeholder='x2' required></td>
        <td><input type='number' step='0.01' name='y2_2' placeholder='y2' required></td>
    </tr>
    <tr id="lingua2" style="display:none">
        <td>Língua 2</td>
        <td><input type='text' name='lingua2' required></td>
    </tr>
    </table>
    <input type="submit" value="Adicionar">
    </form>
    <form action="menu.php">
        <input type="submit" value="Menu"/>
    </form>
</body>
</html>