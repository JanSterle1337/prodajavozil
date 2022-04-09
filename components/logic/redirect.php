<?php
    session_start();
    echo "Je settan ogled";
    require ("../../config/db_connect.php");
    if (isset($_POST['sporocilo'])) {
        if (isset($_POST['uporabnik'])) {
            if ($_POST['uporabnik'] != "no_user") {
                $uporabnikID = mysqli_real_escape_string($conn,$_POST['uporabnik']);
                $sellerID = mysqli_real_escape_string($conn,$_POST['sellerID']);
                echo "Seller: " . $sellerID;
                echo "Uporabnik: " . $uporabnikID;
                Header("Location: ../templates/sporocilo.php?chatID=$sellerID");
            } else {
                Header("Location: ../templates/prijava.php");

            }
            
        }
    }
    else if (isset($_POST['ogled'])) {
        echo "Je settan ogled";
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        if (isset($_POST['sellerID'])) {
            
            $prodajalecID = mysqli_real_escape_string($conn,$_POST['sellerID']);
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