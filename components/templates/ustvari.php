<?php 
session_start();
require ("../../config/db_connect.php");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/ustvari.css">
    <title>Nov oglas</title>
</head>
<body>
    <?php require ("StranskiMeni.php"); 
          if (isset($_SESSION['id'])) {
              $id = $_SESSION['id']; ?>

              <main>
                <div class="create-wrapper">
                    <h1>Ustvarimo nov oglas</h1>
                    <div class="base-data-wrapper">
                        <h2>Izberite osnovne podatke o vozilu</h2>
                        <div class="base-data">

                        <?php 

                        $sqlBrand = "SELECT * FROM znamka";
                        $resultBrand = mysqli_query($conn,$sqlBrand);
                        $brands = mysqli_fetch_all($resultBrand);
                        echo "<pre>";
                        var_dump($brands);
                        echo "</pre>";


                        $sqlModel = "SELECT * FROM model";
                        $resultModel = mysqli_query($conn,$sqlModel);
                        $models = mysqli_fetch_all($resultModel);

                        $selected = "";

                        ?>


                            <form action="ustvari.php" METHOD="POST">
                                <select name="brand" id="brand"> 
                                   <?php foreach ($brands as $brand) { 
                                
                                    echo "<option selected='selected' value=$brand[0]>$brand[0]</option>";

                                   } ?>
                                </select>

                                <select>
                                    <?php foreach ($models as $model) { 
                                
                                        echo "<option value=$model[1]>$model[1]</option>";
                                    
                                    } ?>  
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
              </main>
    <?php   } else { ?>
                <h1>Prosim prijavi se v svoj račun</h1>
    <?php   } ?>

    
</body>
</html>