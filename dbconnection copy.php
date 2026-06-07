<?php
    $severname = "sql208.infinityfree.com";
    $username = "if0_42103720";
    $password = "DY5s2026";
    $db_name = "if0_42103720_site_presentation";

    $connection = new mysqli($severname, $username, $password, $db_name);

    // check connection
    if ($connection->connect_error) {
        die("Connexion échoue à cause de ". $connection->connect_error);
    }

    // echo "Connexion reussie";

?>