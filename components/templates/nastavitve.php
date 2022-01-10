<?php

    session_start();
    if (isset($_SESSION["id"])) {
        //ok
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
                <h1>Nastavitve računa</h1>
                <img class="profilka" src="../../assets/profiledefault.png">
                    <form action="upload.php" METHOD="POST" enctype ="multipart/form-data" class="profilka-settings">

                        <input class="hidden" id="files" type="file" name="novaProfilka">
                        <label for ="files" name="novaProfilka" class="upload-label">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M20.987 16c0-.105-.004-.211-.039-.316l-2-6c-.136-.409-.517-.684-.948-.684h-4v2h3.279l1.667 5h-13.892l1.667-5h3.279v-2h-4c-.431 0-.812.275-.948.684l-2 6c-.035.105-.039.211-.039.316-.013 0-.013 5-.013 5 0 .553.447 1 1 1h16c.553 0 1-.447 1-1 0 0 0-5-.013-5zM16 7.904c.259 0 .518-.095.707-.283.39-.39.39-1.024 0-1.414l-4.707-4.707-4.707 4.707c-.39.39-.39 1.024 0 1.414.189.189.448.283.707.283s.518-.094.707-.283l2.293-2.293v6.672c0 .552.448 1 1 1s1-.448 1-1v-6.672l2.293 2.293c.189.189.448.283.707.283z"></path></svg>
                        </label> 
                        <button type="submit" name="submit" class="upload-file">Posodobi</button>

                    </form>
                <label >Ime</label>
                <input type="text" name="ime" value="Jan">
                <label>Priimek</label>
                <input type="text" name="priimek" value="Sterle">
                <label>Telefonska </label>
                <input type="text" name="tel" value="070766355">
                <label>Opis</label>
                <textarea>nfrporf</textarea>
                <button type="submit" name="spremembaNastavitev">Posodobi</button>
            </div>
        </div>
    </main>
</body>
</html>