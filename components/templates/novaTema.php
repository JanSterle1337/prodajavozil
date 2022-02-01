<?php 

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");

$errors = array(
    "naslov" => "",
    "opis" => "",
    "baza" => ""
);

    if (isset($_SESSION['id'])) {
        $id = mysqli_real_escape_string($conn,$_SESSION['id']);
        if (isset($_POST['ustvariTemo'])) {


            $naslov = mysqli_real_escape_string($conn,$_POST['naslovTema']);
            $opis = mysqli_real_escape_string($conn,$_POST['naslovText']);
            $id = mysqli_real_escape_string($conn,$_SESSION['id']);
            $isNaslovOk = checkNaslov($conn,$naslov,$errors);
            $isOpisOk = checkOpis($conn,$opis,$errors);

            if ($isNaslovOk == true && $isOpisOk == true) {
                $isSent = createTema($conn,$naslov,$opis,$id,$errors);
                if ($isSent == true) {
                    
                } else {
                    
                   
                }
            } else {
                echo $isNaslovOk . " " . "</br>" . $isOpisOk . "</br>";
            }
            

            
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/forum.css">
    <title>Nova Tema</title>
</head>
<body>
    <?php require ("StranskiMeni.php"); ?>
    <main>
        <div class="nova-tema-wrapper">
            <form action="novaTema.php" class="nova-tema-form" METHOD="POST">
                <div class="input-wrapper">
                    <label for="naslovTema">Tukaj vpiši ime svoje teme, oziroma postavi vprašanje ali dilemo</label>
                    <input type="text" name="naslovTema" placeholder="Kateri avto priporočate v letu 2022?"/>
                </div>
                <div class="input-wrapper">
                    <label for="naslovText">
                        Vpiši svoje mnenje, oziroma obrazloži svojo temo
                    </label>
                    <textarea name="naslovText"></textarea>
                </div>

                <div class="input-wrapper">
                <button type="submit" name="ustvariTemo">Ustvari temo</button>
                </div>
            </form>
            <div class="errors">
                <?php
                    foreach ($errors as $error) {
                        echo $error . "</br>";
                    }
                ?>
            </div>
        </div>
    </main>
    <?Php  ?>
</body>
</html>