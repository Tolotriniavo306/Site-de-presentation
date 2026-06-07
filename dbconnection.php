<?php
    $severname = "localhost";
    $username = "root";
    $password = "";
    $db_name = "site_presentation";

    $connection = new mysqli($severname, $username, $password, $db_name);

    // check connection
    if ($connection->connect_error) {
        die("Connexion échoue à cause de ". $connection->connect_error);
    }

    // echo "Connexion reussie";

?>