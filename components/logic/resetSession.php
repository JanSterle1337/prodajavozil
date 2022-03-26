<?php

    session_start();
    if (isset($_SESSION['id'])) {
        unset($_SESSION['id']);
    }
    if (isset($_SESSION['adminID'])) {
        unset($_SESSION['adminID']);
    }
    Header("Location: ../templates/domov.php");

?>