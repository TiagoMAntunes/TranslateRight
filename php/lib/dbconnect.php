<?php

    function database_connect() {
        include 'login.php'; // gets $user and $pass varying from each pc
        $host = "db.ist.utl.pt";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
?>