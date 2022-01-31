<?php 

    session_start();
    require("../../config/db_connect.php");
    require("../logic/oglas.php");


    if (isset($_SESSION['id']) && isset($_SESSION['sellerID']) && isset($_SESSION['oglasID'])) {
        $oglasID = mysqli_real_escape_string($conn,$_SESSION['oglasID']);
        $sellerID = mysqli_real_escape_string($conn,$_SESSION['sellerID']);
        unset($_SESSION['oglasID']);
        unset($_SESSION['sellerID']);
    } else {
        Header("Location: domov.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <?php   require ("StranskiMeni.php"); 
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];    
            
            $oglasData = getOglasInfo($conn,$oglasID);

            while ($row = mysqli_fetch_assoc($oglasData)) {
                echo "<pre style='margin-left: 100px;'>";
                var_dump($row);
                echo "</pre>";
                $oglasID = $row['oglasID'];
                $opis = $row['opis'];
                $status = $row['status'];
                $created_at = $row['created_at'];
                $znamka = $row['znamka'];
                $model = $row['model'];
                $VIN = $row['VIN'];
                $pogon = $row['pogon'];
                $letnik = $row['letnik'];
                $prevozeniKm = $row['prevozeniKm'];
                $cena = $row['cena'];
                $uporabnikID = $row['uporabnikID'];
            }
                
                ?>
                <main>
                    <div class="create-ads-wrapper">
                    <h1>Posodobi svoj oglas</h1>
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
                                            if ($brand[0] == $znamka) {
                                                echo "<option class='brand-option' value='$znamka' selected='selected'>$znamka</option>";
                                            } else {
                                                echo "<option class='brand-option' value='$brand[0]'>$brand[0]</option>";
                                            }
                                        } 
                                    ?>
                                    </select> 

                                

                                    <div id='poll'>
                                        <select style=' width: 15rem; height: 3rem; font-size: 1.5rem;padding: 5px;'>
                                            <option value="<?php echo htmlspecialchars($model) ?>"><?php echo htmlspecialchars($model); ?></option>
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
                                    <input type="text" id="VIN" name="VIN" class="data-input" value="<?Php echo htmlspecialchars($VIN) ?>"/>
                                <label for="prevozeniKM" class="data-label">Prevoženi Kilometri</label>
                                    <input type="number" name="prevozeniKM" id="prevozeniKM" class="data-input" value="<?php echo htmlspecialchars($prevozeniKm) ?>"/>
                                <label for="cena" class="data-label" class="data-input">Cena vozila</label>
                                    <input type="number" name="cena" class="data-input" value="<?Php echo htmlspecialchars($cena) ?>"/>
                                </div>

                                <div class="bottom">
                                    <label class="opis">Opis vozila oz. oglasa</label>
                                        <textarea name="opisVozila" id="opisVozila"><?php echo htmlspecialchars($opis) ?></textarea>
                                </div>
                            </div>

                            <div class="submit-wrapper">
                                <button type="submit" name="submit" class="ustvari">Ustvari oglas</button>
                            </div>
                            
                                            
                        </form>
                    </div>
                </main>
    <?php   } ?>
</body>
</html>