<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Menu</h2>

        <table>
            <p>Utilizadores:</p>
            <form action="listar_utilizadores.php">
                <input type="submit" value="Listar">
            </form>

            <p>Local:</p>
            <form action="adicionar_local.php">
                <input type="submit" value="Inserir">
            </form>
            <form action="remover_local.php">
                <input type="submit" value="Remover">
            </form>

            <p>Item:</p>
            <form action="adicionar_item.php">
                <input type="submit" value="Inserir">
            </form>
            <form action="remover_item.php">
                <input type="submit" value="Remover">
            </form>

            <p>Anomalia:</p>
            <form action="adicionar_anomalia.php">
                <input type="submit" value="Inserir">
            </form>
            <form action="remover_anomalia.php">
                <input type="submit" value="Remover">
            </form>
            <form action="anomalias_locais.php">
                <input type="submit" value="Listar dados 2 locais">
            </form>
            <form action="listar_ultimas_anomalias.php">
                <input type="submit" value="Listar dos últimos 3 meses">
            </form>

            <p>Proposta de Correção:</p>
            <form action="adicionar_prop_correcao.php">
                <input type="submit" value="Inserir">
            </form>
            <form action="remover_prop_correcao.php">
                <input type="submit" value="Remover">
            </form>
            <form action="editar_prop_correcao.php">
                <input type="submit" value="Editar">
            </form>

            <p>Registar:</p>
            <form action="registar_incidencia.php">
                <input type="submit" value="Incidência">
            </form>
            <form action="registar_duplicados.php">
                <input type="submit" value="Duplicado">
            </form>
        </table>
    </body>
</html>