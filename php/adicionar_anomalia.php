<html>
<body>
    <form action=".anomalia_submit.php" method="post">
    <table>
    <tr>
        <td>Nome</td>
        <td>Valor</td>
    </tr>
    <tr>
        <td>Zona</td>
        <td><input type="number" step="0.01" name="x1" placeholder="x1"></td>
        <td><input type="number" step="0.01" name="y1" placeholder="y1"></td>
        <td><input type="number" step="0.01" name="x2" placeholder="x2"></td>
        <td><input type="number" step="0.01" name="y2" placeholder="y2"></td>
    </tr>
    <tr>
        <td>Imagem</td>
        <td><input type="file" name="imagem"></td>
    </tr>
    <tr>
        <td>Lingua</td>
        <td><input type="text" name="lingua"></td>
    </tr>
    <tr>
        <td>Descrição</td>
        <td><input type="text" name="descricao"></td>
    </tr>
    <tr>
        <td>Tem anomalia na tradução?</td>
        <td><input type="checkbox" name="traducao"></td>
    </tr>
    </table>
    <input type="submit" value="Adicionar">
    </form>
</body>
</html>