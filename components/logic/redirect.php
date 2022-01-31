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
        if (isset($_POST['seller'])) {
            $prodajalecID = mysqli_real_escape_string($conn,$_POST['seller']);
            Header("Location: ../templates/vsiOglasi.php?prodajalecID=$prodajalecID");
        }
        
    } else if (isset($_POST['izbrisi']))  {
        if ($_POST['userID'] == $_POST['sellerID']) {
            $_SESSION['sellerID'] = mysqli_real_escape_string($conn,$_POST['sellerID']);
            $_SESSION['oglasID'] = mysqli_real_escape_string($conn,$_POST['oglasID']);
            Header("Location: izbrisiOglas.php");
        } else {
            Header ("Location: izbrisiOglas.php?delete=failure");
        }
    } else if (isset($_POST['posodobi'])) {
        if ($_POST['userID'] == $_POST['sellerID']) {
            $_SESSION['sellerID'] =  mysqli_real_escape_string($conn,$_POST['sellerID']);
            $_SESSION['oglasID'] = mysqli_real_escape_string($conn,$_POST['oglasID']);
            Header("Location: ../templates/posodobiOglas.php");
        } else {
            Header("Location: ../templates/posodobiOglas.php?posodobi=failure");
        }
    }
    
    else {
        Header("Location: ../templates/domov.php");
    }
?>