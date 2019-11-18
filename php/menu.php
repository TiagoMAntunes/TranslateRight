<html>
    <body>
        <?php
            $files = glob("*.php");
            foreach ($files as $file) {
                echo("<h2><a href=\"{$file}\">");
                echo(substr($file,0, -4));
                echo("</a> </h2>\n");
            }
        ?>
    </body>
</html>