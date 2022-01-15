<?php

    
   
    require "../../config/db_connect.php";
    require "../logic/nastavitve.php";

    

    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        getUserData($ime,$priimek,$ePosta,$tel,$opis,$id,$conn);

        if (isset($_POST["spremembaNastavitev"])) {
           
            $ime = $_POST["ime"];
            $priimek = $_POST["priimek"];
            $tel = $_POST["tel"];
            $opis = $_POST["opis"];

            $sql = "UPDATE Uporabnik
                    SET 
                    ime = '$ime',
                    priimek = '$priimek',
                    telefonska = '$tel',
                    opis = '$opis'
                    WHERE uporabnikID = '$id';";

            if (mysqli_query($conn,$sql)) {
                
            } else {
                
            }
                    
        }


        if (isset($_GET['upload'])) {
            $isSuccess = $_GET['upload'];
            if ($isSuccess == "sucess") {
                $updated = true;
            } else {
                $updated = false;
            }
        }

    } else {
        //not ok
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/nastavitve.css">
    <title>Nastavitve Računa</title>
</head>
<body>
    <?php
        require ("StranskiMeni.php");
    ?>

    <main>
        
        <div class="settings-wrapper">
            <div class="settings">
                <h1 class="heading">Nastavitve računa</h1>

                <?php   

                    $sqlImg = "SELECT * FROM profilka
                            WHERE uporabnikID = $id;";

                            $resultImg = mysqli_query($conn,$sqlImg);
                            if (mysqli_num_rows($resultImg) == 0) {
                                echo "<img src='../../assets/profiledefault.png' class='profilka'>";
                            } else {
                                $rowImg = mysqli_fetch_assoc($resultImg);

                                if ($rowImg["status"] == 0) {
                                    echo "<img src='../../assets/profile".$id.".jpg' class='profilka'>";
                                    
                                } else {
                                    echo "<img src='assets/profiledefault.png' class='profilka'>";
                                }
                            }

                    ?>
                
                    <form action="../logic/upload.php" METHOD="POST" enctype ="multipart/form-data" class="profilka-settings">
                        <input class="hidden" id="files" type="file" name="file">
                        <label for ="files" name="novaProfilka" class="upload-label">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M20.987 16c0-.105-.004-.211-.039-.316l-2-6c-.136-.409-.517-.684-.948-.684h-4v2h3.279l1.667 5h-13.892l1.667-5h3.279v-2h-4c-.431 0-.812.275-.948.684l-2 6c-.035.105-.039.211-.039.316-.013 0-.013 5-.013 5 0 .553.447 1 1 1h16c.553 0 1-.447 1-1 0 0 0-5-.013-5zM16 7.904c.259 0 .518-.095.707-.283.39-.39.39-1.024 0-1.414l-4.707-4.707-4.707 4.707c-.39.39-.39 1.024 0 1.414.189.189.448.283.707.283s.518-.094.707-.283l2.293-2.293v6.672c0 .552.448 1 1 1s1-.448 1-1v-6.672l2.293 2.293c.189.189.448.283.707.283z"></path></svg>
                        </label> 
                        <button type="submit" name="submit" class="upload-file">Posodobi</button>
                    </form>
                    <?php  
                        if (isset($updated)) {
                           
                            if ($updated == true) {
                                echo "<p class='success'>Profilna slika posodobljena uspešno!</p>";
                              } 
                        } 
                    ?>
                    
                
                    <form action="nastavitve.php" METHOD="POST" class="data" style="display: flex; flex-direction: column;">
                        <label>Ime</label>
                        <input type="text" name="ime" value="<?php echo htmlspecialchars($ime); ?>">
                        <label>Priimek</label>
                        <input type="text" name="priimek" value="<?php echo htmlspecialchars($priimek); ?>">
                        <label>Telefonska </label>
                        <input type="text" name="tel" value="<?php echo htmlspecialchars($tel); ?>">
                        <label>Opis</label>
                        <textarea name="opis"><?php echo htmlspecialchars($opis); ?></textarea>
                        <button type="submit" name="spremembaNastavitev" class="upload-file" class="center">Posodobi</button>
                    </form>
                
            </div>
        </div>
    </main>
</body>
</html>