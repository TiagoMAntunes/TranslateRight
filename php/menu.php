<html>
    <body>
        <?php
            try {
                $host = "yyyyyyyy" //db name
                $user = "xxxxxxx"
                $password = "xxxxxxx"
                $dbname = $user

                $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $files = glob("*.php");
                foreach ($files as $file) {
                    echo("<h2><a href=\"{$file}\">");
                    echo(substr($file,0, -4));
                    echo("</a> </h2>\n");
                }
            }
            catch(PDOException $e) {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>
    </body>
</html>