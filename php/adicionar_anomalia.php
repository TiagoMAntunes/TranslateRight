<html>
<body>
    <form action=".anomalia_submit.php" method="post">
    <table>
    <tr>
        <td>Nome</td>
        <td>Valor</td>
    </tr>
    <tr>
        <td>ID</td>
        <td><input id="ID"></td>
    </tr>
    <tr>
        <td>Zona</td>
        <td><input id="zona"></td>
    </tr>
    <tr>
        <td>Imagem</td>
        <td><input type="file" id="imagem"></td>
    </tr>
    <tr>
        <td>Lingua</td>
        <td><input id="lingua"></td>
    </tr>
    <tr>
        <td>Descrição</td>
        <td><input id="Descricao"></td>
    </tr>
    <tr>
        <td>Tem anomalia na tradução?</td>
        <td><input type="checkbox" id="traducao"></td>
    </tr>
    </table>
    <button action="submit">Adicionar</button>
    </form>
</body>
</html>