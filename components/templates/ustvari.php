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
                                        echo "<option value='$brand[0]'>$brand[0]</option>";
                                    } 
                                ?>
                                </select> 

                            

                                <div id="poll">
                                    <select>
                                        <option>Izberi model</option>
                                    </select>
                                </div>

                                <div>
                                    <select name="letnik">  
                                        <?php for ($i = 2022; $i > 1971; $i--) {  
                                            echo "<option value='$i'>$i</option>";
                                            } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="pogon-wrapper">
                                <label for="bencin">bencin</label>
                                    <input type="radio" name="gorivo" id="bencin" value="bencin">
                                <label for="diesel">Dizel</label>
                                    <input type="radio" name="gorivo" id="diesel"  value="diesel">
                                <label for="hibrid">hibridni pogon</label>
                                    <input type="radio" name="gorivo" id="hibrid"  value="hibrid">
                                <label for="e-pogon">e-pogon</label>
                                    <input type="radio" name="gorivo" id="e-pogon"  value="e-pogon">
                                <label for="LPG">LPG avtoplin</label>
                                    <input type="radio" name="gorivo" id="LPG"  value="LPG avtoplin">
                                <label for="CNG">zemeljski plin</label>
                                    <input type="radio" name="gorivo" id="CNG"  value="zemeljski plin">
                                
                            </div>
                                            
                            <div>
                                <label for="VIN">VIN številka</label>
                                    <input type="text" id="VIN" name="VIN"/>
                                <label for="prevozeniKM">Prevoženi Kilometri</label>
                                    <input type="number" name="prevozeniKM" id="prevozeniKM"/>
                                <label>Opis vozila oz. oglasa</label>
                                    <textarea name="opisVozila" id="opisVozila"></textarea>
                                <label for="cena">Cena vozila</label>
                                    <input type="number" name="cena"/>
                                
                            </div>

                            <div>
                                <h1>Dodaj slike</h1>
                                <input type="file" name="oglasiImages[]" multiple>
                            </div>
                            <button type="submit" name="submit">Ustvari oglas</button>
                                            
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