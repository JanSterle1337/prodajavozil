<?php

    session_start();
    echo "Moj id trenutno je: " . $_SESSION["id"] . "</br>";

?>




<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/global.css">
    
    <title>Domov</title>
</head>
<body>
    
        <?php require "../templates/StranskiMeni.php "?> 
   
</body>
</html>