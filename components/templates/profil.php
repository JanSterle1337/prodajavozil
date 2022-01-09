<?php

session_start();

if (isset($_SESSION['id'])) {
    //ok
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/profil.css">
    <title>Uporabniški profil</title>
</head>
<body>
    <?php
        require ("StranskiMeni.php");
    ?>

<main style="margin-bottom: 60px;">

<?php
    if (isset($_SESSION["id"])) {  ?>

<div class="profile-wrapper">

        <div class="upper-wrapper">
            <div class="left">
                
                <div class="profile-picture-wrapper">
                    
                    <img src="../../assets/profiledefault.png" class="profile-picture">
                    <a class="settings" href="nastavitve.php">Nastavitve računa</a>
                </div>
            </div>
            <div class="right">
                <div class="personal-wrapper">
                    <p class="personal-info">Jan Sterle</p>
                    <p class="personal-info">jan.sterle123@gmail.com</p>
                    <p class="about-info">Tvoj profil še nima opisaTvoj profil še nima opisa
                    Tvoj profil še nima opisaTvoj profil še nima opisaTvoj profil še nima opisa
                    </p>
                </div>
            </div>
        </div>
        <div class="lower-wrapper">
            <div class="advert-heading">
               <h1 class="heading">Tvoji oglasi</h1>
            </div>
            <div class="oglas-wrapper">
                <div class="oglas">
                    <img class="advert-photo" src="../../assets/golf2.jpg">
                    <p class="cena">$ 7.200</p>
                    <p class="ime-oglasa">Golf 4 MK 2.0 Diesel</p>
                </div>
                <div class="oglas">
                    <img class="advert-photo" src="../../assets/golf2.jpg">
                    <p class="cena">$ 7.200</p>
                    <p class="ime-oglasa">Golf 4 MK 2.0 Diesel</p>
                </div>
                <div class="oglas">
                    <img class="advert-photo" src="../../assets/golf2.jpg">
                    <p class="cena">$ 7.200</p>
                    <p class="ime-oglasa">Golf 4 MK 2.0 Diesel</p>
                </div>
            </div>
        </div>
    </div>

<?php    } ?>


    

  </main>
</body>
</html>