<?php 

   
    echo "Smo nazacetku";
    require ("../../config/db_connect.php");
    require ("ustvariOglas.php");
    echo "Neki";

    if (isset($_POST['posodobi']) && isset($_SESSION['id'])) {
        
           $voziloID = mysqli_real_escape_string($conn,$_POST['voziloID']);
           $oglasID = mysqli_real_escape_string($conn,$_POST['oglasID']);
           $uporabnikID = mysqli_real_escape_string($conn,$_SESSION['id']);

           $brand = isBrandSet($conn,$queries,$validation); 
                
           $model = isModelSet($conn,$queries,$validation);

           $letnik = isLetnikSet($conn,$queries,$validation);
                
           $gorivo =isGorivoSet($conn,$queries,$validation); 
                
           $VIN = isVINSet($conn,$queries,$validation);
                
           $prevozeniKM = isPrevozeniSet($conn,$queries,$validation); 
                
           $opisOglasa = isOpisSet($conn,$queries,$validation);

           $cena = isCenaSet($conn,$queries,$validation);

           $validation["photos"] = true;
           if (checkValidation($validation)) {
            echo "Use je tku k more bt</br>";
            echo "<pre>";
            var_dump($queries["errors"]);
            echo "</pre>";


            $currentTime = date('Y-m-d H:i:s');
            echo "Trenutni cas je: " . $currentTime . "</br>";

            $sqlVozilo = "UPDATE Vozilo
                          SET
                          VIN = '$VIN',
                          prevozeniKm = $prevozeniKM,
                          letnik = $letnik,
                          znamka = '$brand',
                          pogon = '$gorivo',
                          model = '$model',
                          created_at = '$currentTime'
                          WHERE voziloID = $voziloID";


            if (mysqli_query($conn,$sqlVozilo)) {
                echo "Vozilo posodobljeno";


                $sqlOglas = "UPDATE Oglas
                             SET
                             opis = '$opisOglasa',
                             cena = $cena,
                             created_at = '$currentTime',
                             voziloID = $voziloID,
                             model = '$model',
                             znamka = '$brand'
                             WHERE
                             uporabnikID = $uporabnikID
                             AND
                             oglasID = $oglasID";

                if (mysqli_query($conn,$sqlOglas)) {
                    echo "Oglas posodobljen";
                } else {
                    echo "Error oglas: " . mysqli_error($conn);
                }

            } else {
                echo "Error vozilo: " . mysqli_error($conn);
            }

           }
    }

           

?>

