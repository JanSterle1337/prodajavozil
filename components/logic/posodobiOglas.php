<?php 
    session_start();
    
    echo "Smo nazacetku";
    require ("../../config/db_connect.php");
    require ("errorCheckerFunctions.php");
    echo "Neki";

    if (isset($_SESSION['id'])) {
        echo "Id uporabnika je setan";
        if (isset($_POST['posodobi'])) {
            echo "posodobi je setan session id pa tut";
            
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

            
            if (checkValidation($validation) === true) {
                echo "Use je tku k more bt</br>";
                echo "<pre>";
                echo "V ifu";
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
                        unset($_SESSION['oglasID']);
                        unset($_SESSION['sellerID']);
                        unset($_SESSION['errorInfo']);
                        //Header("Location: ../templates/domov.php");
                        
                        echo "Oglas posodobljen";
                    } else {
                        Header("Location: ../templates/posodobiOglas.php?upload=failure");
                        echo "Error oglas: " . mysqli_error($conn);
                    }

                } else {
                    echo "Error vozilo: " . mysqli_error($conn);
                    Header("Location: ../templates/posodobiOglas.php?upload=failure");
                }

            } else {
                
                $_SESSION['errorInfo'] = $queries['errors'];
                echo "<pre>";
                echo "V elsu errorInfo";
                var_dump($_SESSION['errorInfo']);
                echo "</pre>";
                Header("Location: ../templates/posodobiOglas.php?upload=failure");
            }
        } else {
           echo "Posodobi ni settan"; 
        }
    } else {
            echo "Ne id ni settan";
    }

           

?>

