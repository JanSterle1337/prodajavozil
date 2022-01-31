<?php 


    session_start();
    require ("../../config/db_connect.php");
    require ("../logic/oglas.php");


    if (isset($_GET['delete'])) {
        Header("Location: ../templates/domov.php");
    }

    if (isset($_SESSION['id']) && isset($_SESSION['sellerID']) && isset($_SESSION['oglasID'])) {
        echo "Ok zdej lahk brisem oglas";
        $oglasID = mysqli_real_escape_string($conn,$_SESSION['oglasID']);
        deleteOglas($conn,$oglasID);
        unset($_SESSION['sellerID']);
        unset($_SESSION['oglasID']);



    } else {
        Header("Location: ../templates/domov.php");
    }

    echo "Izbrisi oglas";

?>