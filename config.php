<?php
    $dbhost = "localhost";
    $dbuser = "postgres";
    $dbpass = "1";
    $port = "5432";
    $dbname = "sbdt_app";

    $conn = new PDO("pgsql:dbname=$dbname;host=$dbhost", $dbuser, $dbpass);

    if ($conn) {
        // echo "Berhasil";
    } else {
        echo "Gagal";
    }
?>