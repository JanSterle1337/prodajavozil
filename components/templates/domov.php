<?php

    session_start();
    require ("../../config/db_connect.php");
    require ("../logic/domov.php");

    if (isset($_SESSION['adminID'])) {
      unset($_SESSION['adminID']);
    }

    if (isset($_SESSION["id"])) {
      /*  echo "<pre style='margin-left: 100px;'>";
        var_dump($_SESSION);
        echo "</pre>";
        $sessionID = $_SESSION["id"];
        echo "<span style='text-align: center;'>$sessionID</span>"; */
    }

    if (isset($_SESSION['errorInfo'])) {
      unset($_SESSION['errorInfo']);
    }


    if (isset($_POST['iskanje'])) {
      $znamka = mysqli_real_escape_string($conn,$_POST['znamka']);
      $model = mysqli_real_escape_string($conn,$_POST['model']);
      $cenaOd = mysqli_real_escape_string($conn,$_POST['cena-od']);
      $cenaDo = mysqli_real_escape_string($conn,$_POST['cena-do']);
      $letnikOd = mysqli_real_escape_string($conn,$_POST['letnik-od']);
      $letnikDo = mysqli_real_escape_string($conn,$_POST['letnik-do']);
      $kilometrovDo = mysqli_real_escape_string($conn,$_POST['kilometrov-do']);
      $gorivo = mysqli_real_escape_string($conn,$_POST['gorivo']);
    }

?>




<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/global.css">
    <link type="text/css" rel="stylesheet" href="../../style/domov.css">
    <title>Domov</title>

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
    
  <?php require "../templates/StranskiMeni.php "?> 

  <main style="margin-bottom: 60px;">
  <div class='close-wrapper'>
        
  </div>
    <h1 class="heading">Hitro iskanje osebnih vozil</h1>
    <div class="domov-wrapper">
      <form class="hitro-iskanje-wrapper" METHOD="POST">
        <div class="top">

          <div class="znamka-model-wrapper odmik">
            <select id="SelectA" name="znamka" onchange="my_fun(this.value);"> 
              <?Php 
                $sqlBrand = "SELECT znamka from Znamka";
                $result = mysqli_query($conn,$sqlBrand);
                $brands = mysqli_fetch_all($result);
                  echo "<option>Vse znamke</option>";                  
                foreach ($brands as $brand) {
                  echo "<option class='brand-option' value='$brand[0]'>$brand[0]</option>";
                } 
              ?>
            </select> 

            <div id='poll'>
              <select name="model">
                <option>Vsi modeli</option>
              </select>
            </div>
          </div>
          <div class="cena-letnik-wrapper odmik">
                <div class="cena-od-do-wrapper">
                  <select name="cena-od">
                    <option value="Cena od">Cena od</option>
                    <?php 
                      generateCena(true);
                    ?>
                  </select>

                  <select name="cena-do">
                  <option value="Cena do">Cena do</option>
                  <?php 
                    generateCena(false);
                  ?>
                  </select>
                </div>
                
                <div class="cena-od-do-wrapper">
                  <select name="letnik-od">
                    <option>Letnik od</option>
                    <?php
                      generateLetnik(true);
                    ?>
                  </select>

                  <select name="letnik-do">
                    <option>Letnik do<option>
                    <?php
                      generateLetnik(false);
                    ?>
                  </select>
                </div>
          </div>
          <div class="km-gorivo-wrapper odmik">
            <div class="do-km-wrapper">
                <select name="kilometrov-do">
                  <option value="Kilometrov do">Kilometrov do</option>
                  <?php 
                    generateKm();
                  ?>
                </select>
            </div>

            <div>
              <select name="gorivo">
                <option value="gorivo">Gorivo</option>
                <option value="bencin">bencin</option>
                <option value="diesel">diesel</option>
                <option value="e-pogon">e-pogon</option>
                <option value="hibrid">hibridni pogon</option>
                <option value="LPG avtoplin">LPG avtoplin</option>
                <option value="zemeljski plin">zemeljski plin</option>
              </select>
            </div>
          </div>

        </div>

        <?php 

        if (isset($_POST['iskanje'])) {
          echo "<h2 class='para-heading'>Trenutno vklopljeni filtri</h2>";
          echo "<div class='filter-wrapper'>";
            echo "<div class='filter-div'>";
              echo "<p class='filter'>$znamka</p>";
              echo "<p class='filter'>$model</p>";
            echo "</div>";

            echo "<div class='filter-div'>";
              echo "<p class='filter'>$cenaOd</p>";
              echo "<p class='filter'>$cenaDo</p>";
            echo "</div>";

            echo "<div class='filter-div'>";
              echo "<p class='filter'>$letnikOd</p>";
              echo "<p class='filter'>$letnikDo</p>";
            echo "</div>";

            echo "<div class='filter-div'>";
              echo "<p class='filter'>$kilometrovDo</p>";
              echo "<p class='filter'>$gorivo</p>";
            echo "</div>";
          echo "</div>";
        }
        
        ?>
        
        <div class="bottom">
             <button type="submit" name="iskanje" class="hitro-iskanje">Hitro iskanje</button> 
        </div>
  </form>
      <div class="oglasi-wrapper">
            <?Php if (isset($_POST['iskanje'])) { 
                  $sql = generateSearchQuery($conn);
                  /*
                  echo "<pre>";
                  echo $sql;
                  echo "</pre>";
                  */
                  if ($result = mysqli_query($conn,$sql))  {
                    
                  } else {
                    echo "Error: " . mysqli_error($conn);
                  }?>

                  <div class="advert-heading">
                      <h1 class="heading">Današnja izbira</h1>
                    </div>

                    <div class="oglas-wrapper">
                    
                    <?php while ($row = mysqli_fetch_assoc($result)) { 
                     /* echo "<pre>";
                      var_dump($row);
                      echo "</pre>";  */
                        
                        ?>

                        <a href="oglas.php?id=<?php echo $row["oglasID"] ?>">
                        <div class="oglas">
                            <img class="advert-photo" src="../../storage/<?php echo htmlspecialchars($row["imeSlike"]) ?>"> 
                            <p class="cena"><?php echo htmlspecialchars($row["cena"] . " €"); ?></p>
                            <p class="ime-oglasa"><?php echo htmlspecialchars($row["znamka"] . " " . $row["model"])  ?></p>
                        </div>
                        </a>
                 <?php  }  ?>
                      
                     </div>

 <?php               } else {  
                    $sql = "SELECT DISTINCT og.oglasID,og.cena,og.voziloID,og.model,og.znamka,`status`,sl.slikaID,sl.imeSlike FROM Oglas og
                            INNER JOIN Vozilo voz ON (og.voziloID = voz.voziloID)
                            INNER JOIN Slika sl ON   (og.oglasID = sl.oglasID)
                            WHERE 
                            og.status = 'neprodano' AND sl.imeSlike LIKE '%num0%';";
                    
                     /*$result = mysqli_query($conn,$sql) or die("Napaka pri nalaganju podatkov"); ?> */
                       $result = mysqli_query($conn,$sql);
                       /*$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
                        echo "<pre>";
                        var_dump($data); 
                        echo "</pre>";  */ ?>

                    <div class="advert-heading">
                      <h1 class="heading">Današnja izbira</h1>
                    </div>

                    <div class="oglas-wrapper">
                  
                    <?php while ($row = mysqli_fetch_assoc($result)) { 
                      /*echo "<pre>";
                      var_dump($row);
                      echo "</pre>"; */
                      
                              ?>
                        <a href="oglas.php?id=<?php echo $row["oglasID"] ?>">
                        <div class="oglas">
                            <img class="advert-photo" src="../../storage/<?php echo htmlspecialchars($row["imeSlike"]) ?>"> 
                            <p class="cena"><?php echo htmlspecialchars($row["cena"] . " €"); ?></p>
                            <p class="ime-oglasa"><?php echo htmlspecialchars($row["znamka"] . " " . $row["model"])  ?></p>
                        </div>
                        </a>
                 <?php  }  ?>
                     </div>
                     
              <?php } ?>
            </div>
      </div>
    </div>
  </main>
   
</body>
</html>