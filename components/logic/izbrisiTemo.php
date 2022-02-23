<?php

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");

if (isset($_SESSION['id'])) {
    $uporabnikID = mysqli_real_escape_string($conn,$_SESSION['id']);
    if (isset($_GET['temaID'])) {
        $temaID = mysqli_real_escape_string($conn,$_GET['temaID']);
        $result = getSingleTema($conn,$temaID);

        $podatki = mysqli_fetch_all($result,MYSQLI_ASSOC);

        $temaPodatki = $podatki[0];

        if ($uporabnikID !== $temaPodatki['uporabnikID']) {
            Header("Location: ../templates/forum.php");
            
           
        } else {
          $isDeleted = deleteTema($conn,$temaID);
          if ($isDeleted === true) {
              Header("Location: ../templates/forum.php");
          } else {
            
              Header("Location: ../templates/forum.php");
            
          }
        }
    } else {
        Header("Location: ../templates/forum.php");
       
    }
} else {
    Header("Location: ../templates/forum.php");
  
   
}


?>