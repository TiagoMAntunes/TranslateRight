<html>
    <body>
        <h1>Translate Right</h1>
        <h2>Remover Item:</h2>

        <?php
            include 'lib/aux.php';
        	displayItems();
        ?>
        <p>Inserir ID do item a remover:</p>
        <form action="" method="post">
        	<table>
	        	<tr>
	        		<td>ID:</td>
	        		<td><input type="number" step="1" name="id" required></td>
	        	</tr>
	        </table>
	        <input type="submit" value="Remover">
		</form>
        <form action="menu.php">
        	<input type="submit" value="Menu">
        </form>

        <?php
        	include 'lib/aux.php';

        	if (isset($_POST['id'])) {
            	removeItem($_POST['id']);
        	}
        ?>

    </body>
</html>