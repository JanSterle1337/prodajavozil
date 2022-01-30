<?php 
session_start();
require ("../../config/db_connect.php");

if (isset($_SESSION['errorInfo'])) {
    echo "<pre>";
    var_dump($_SESSION['errorInfo']);
    echo "</pre>";
    unset($_SESSION['errorInfo']);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/ustvari.css">
    <title>Nov oglas</title>
    <script>
        function my_fun(str) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("poll").innerHTML = this.responseText;
                }
            }   
            xmlhttp.open("GET", "../logic/ustvari.php?value="+str,true);
            xmlhttp.send();
        }
    </script>
</head>
<body>
    <?php require ("StranskiMeni.php"); 

          if (isset($_SESSION['id'])) {
              $id = $_SESSION['id']; ?>

              <main>
                <div class="create-ads-wrapper">
                    <h1>Ustvari nov oglas</h1>
                        <form class="create-ads-form" action="../logic/ustvariOglas.php" enctype="multipart/form-data" METHOD="POST">
                            <h2>Osnovni podatki o vozilu</h2>
                                <div class="brand-selection-wrapper">
                                    <select id="SelectA" name="znamka" onchange="my_fun(this.value);"> 
                                    <?Php 
                                        $sqlBrand = "SELECT znamka from Znamka";
                                        $result = mysqli_query($conn,$sqlBrand);
                                        $brands = mysqli_fetch_all($result);
                                    /* echo "<pre>";
                                        var_dump($brands);
                                        echo "</pre>"; */

                                        foreach ($brands as $brand) {
                                            echo "<option class='brand-option' value='$brand[0]'>$brand[0]</option>";
                                        } 
                                    ?>
                                    </select> 

                                

                                    <div id='poll'>
                                        <select style=' width: 15rem; height: 3rem; font-size: 1.5rem;padding: 5px;'>
                                            <option>Izberi model</option>
                                        </select>
                                    </div>

                                    <div>
                                        <select name="letnik" id="SelectA">  
                                            <?php for ($i = 2022; $i > 1971; $i--) {  
                                                echo "<option value='$i'>$i</option>";
                                                } ?>
                                        </select>
                                    </div>
                                </div>
                            <div class="pogon-wrapper">
                                <h2>Izberi gorivo</h2>
                                    <div class="flex">
                                        <label for="bencin" class="gorivo-label">bencin</label>
                                            <input type="radio" name="gorivo" id="bencin" value="bencin" class="gorivo-input">
                                    </div>
                                    <div class="flex">
                                        <label for="diesel" class="gorivo-label">dizel</label>
                                            <input type="radio" name="gorivo" id="diesel"  value="diesel" class="gorivo-input">
                                    </div>
                                    <div class="flex">
                                        <label for="hibrid" class="gorivo-label">hibridni pogon</label>
                                            <input type="radio" name="gorivo" id="hibrid"  value="hibrid" class="gorivo-input">
                                    </div>
                                    <div class="flex">
                                        <label for="e-pogon" class="gorivo-label">e-pogon</label>
                                            <input type="radio" name="gorivo" id="e-pogon"  value="e-pogon" class="gorivo-input">
                                    </div>
                                    <div class="flex">
                                        <label for="LPG" class="gorivo-label">LPG avtoplin</label>
                                            <input type="radio" name="gorivo" id="LPG"  value="LPG avtoplin" class="gorivo-input">
                                    </div>
                                    <div class="flex">
                                        <label for="CNG" class="gorivo-label">zemeljski plin</label>
                                            <input type="radio" name="gorivo" id="CNG"  value="zemeljski plin" class="gorivo-input">
                                    </div>
                                
                            </div>
                                            
                            <div class="top-bottom-wrapper">
                               <div class="top"> 
                                <label for="VIN" class="data-label">VIN številka</label>
                                    <input type="text" id="VIN" name="VIN" class="data-input"/>
                                <label for="prevozeniKM" class="data-label">Prevoženi Kilometri</label>
                                    <input type="number" name="prevozeniKM" id="prevozeniKM" class="data-input"/>
                                <label for="cena" class="data-label" class="data-input">Cena vozila</label>
                                    <input type="number" name="cena" class="data-input"/>
                                </div>

                                <div class="bottom">
                                    <label class="opis">Opis vozila oz. oglasa</label>
                                        <textarea name="opisVozila" id="opisVozila"></textarea>
                                </div>
                            </div>

                            <div class="add-photo-wrapper">
                                <h2 class="dodaj-slike">Dodaj slike</h2>
                                <input type="file" id="oglasneSlike" name="oglasiImages[]" multiple class="hidden">
                                <label for="oglasneSlike">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M20.987 16c0-.105-.004-.211-.039-.316l-2-6c-.136-.409-.517-.684-.948-.684h-4v2h3.279l1.667 5h-13.892l1.667-5h3.279v-2h-4c-.431 0-.812.275-.948.684l-2 6c-.035.105-.039.211-.039.316-.013 0-.013 5-.013 5 0 .553.447 1 1 1h16c.553 0 1-.447 1-1 0 0 0-5-.013-5zM16 7.904c.259 0 .518-.095.707-.283.39-.39.39-1.024 0-1.414l-4.707-4.707-4.707 4.707c-.39.39-.39 1.024 0 1.414.189.189.448.283.707.283s.518-.094.707-.283l2.293-2.293v6.672c0 .552.448 1 1 1s1-.448 1-1v-6.672l2.293 2.293c.189.189.448.283.707.283z"></path></svg>
                                </label>

                                <button type="submit" name="submit" class="ustvari">Ustvari oglas</button>
                            </div>
                            
                                            
                        </form>
                </div>
            </main>


    <?php   } else { ?>
            <main>
                <h1>Prosim prijavi se v svoj račun</h1>
            </main>
               
    <?php   } ?>

    
</body>
</html>