<?php

    session_start();
    require ("../../config/db_connect.php");
    if (isset($_POST['sporocilo'])) {
        if (isset($_POST['uporabnik'])) {
            if ($_POST['uporabnik'] != "no_user") {
                $uporabnikID = mysqli_real_escape_string($conn,$_POST['uporabnik']);
                echo "Uporabnik: " . $uporabnikID;
                Header("Location: ../templates/sporocilo.php");
            } else {
                Header("Location: ../templates/prijava.php");

            }
            
        }
    }
    else if (isset($_POST['ogled'])) {
        Header("Location: ../templates/vsiOglasi.php");
    } else {
        Header("Location: ../templates/domov.php");
    }
?>