<?php 

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");

$errors = array(
    "naslov" => "",
    "besedilo" => "",

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
                if ($isSent === true) {
                    
                    $errors['naslov'] = "";
                    $errors['besedilo'] = "";
                   Header("Location: forum.php");

                } else {
                    echo "Error: " . mysqli_error($conn);
                } 

            } else {
                if($isNaslovOk === false) {
                    $errors['naslov'] = "Napaka pri vpisu naslova.";   
                }
                if ($isOpisOk === false) {
                    $errors['besedilo'] = "Napaka pri vpisu besedila.";
                }
             
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
        <div class='whole-page-wrapper'>
            <div>
                <div class='close-wrapper'>
                    <a href="forum.php" class='middle-center'>
                        <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                    </a>
                </div>
            </div>
            <div class="nova-tema-wrapper">
                <form action="novaTema.php" class="nova-tema-form" METHOD="POST">
                    <div class="input-wrapper">
                        <label for="naslovTema" class='naslov-tema'>Postavi vprašanje ali dilemo</label>
                        <input type="text" name="naslovTema" class='input-tema-naslov' placeholder="Kateri avto priporočate v letu 2022?"/>
                    </div>
                    <div class="input-wrapper">
                        <label for="naslovText" class='naslov-tema'>
                            Vpiši svoje mnenje, oziroma obrazloži svojo temo
                        </label>
                        <textarea name="naslovText" class='text-tema'></textarea>
                    </div>

                    <div class="errors">
                        <?php
                            echo "<p class='notOk'>" . htmlspecialchars($errors['naslov']) . "</p>" . "</br>";
                            echo "<p class='notOk'>" . htmlspecialchars($errors['besedilo']) . "</p>";
                        ?>
                    </div>

                    <div class="input-wrapper">
                    <button type="submit" name="ustvariTemo"  class='objavi-komentar padding'>Ustvari temo</button>
                    </div>
                </form>
                
            </div>
        </div>
    </main>
    <?Php  ?>
</body>
</html>