<?php

    session_start();
    unset($_SESSION['id']);
    Header("Location: ../templates/domov.php");

?>