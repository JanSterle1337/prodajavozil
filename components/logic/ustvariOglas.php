<?Php 

    session_start();
    require ("../../config/db_connect.php");
    $validation = array(
        "brand" => false,
        "model" => false,
        "letnik" => false,
        "gorivo" => false,
        "VIN" => false,
        "prevozeniKM" => false,
        "opisOglasa" => false,
        "cena" => false,
        "photos" => false,
    );
      
    echo "<br><pre>";
    var_dump($validation);
    echo "</pre></br>";

    $queries = array(
        "errors" => array(
            "brand" => "",
            "model" => "",
            "letnik" => "",
            "gorivo" => "",
            "VIN" => "",
            "prevozeniKM" => "",
            "opisOglasa" => "",
            "cena" => "",
            "photos" => "",
        )
    );

    

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        
        if (isset($_POST['submit'])) {
            
           $brand = isBrandSet($conn,$queries,$validation); 
                
           $model = isModelSet($conn,$queries,$validation);

           $letnik = isLetnikSet($conn,$queries,$validation);
                
           $gorivo =isGorivoSet($conn,$queries,$validation); 
                
           $VIN = isVINSet($conn,$queries,$validation);
                
           $prevozeniKM = isPrevozeniSet($conn,$queries,$validation); 
                
           $opisOglasa = isOpisSet($conn,$queries,$validation);

           $cena = isCenaSet($conn,$queries,$validation);
              
          $photos = checkPhotos($conn,$queries,$validation);

          if (gettype($photos) == "string") {
             echo  "Error pr slikah: " . $photos . "</br>";
             $_SESSION["errorInfo"] = $queries;
             Header("Location: ../templates/ustvari.php");
          } else {
              $validation["photos"] = true;
                 if (checkValidation($validation)) {
               echo "Use je tku k more bt</br>";
               echo "<pre>";
               var_dump($queries["errors"]);
               echo "</pre>";
/*
              $sqlGetModelId = "SELECT modelID from model WHERE imeModela = '$model'";
              $result = mysqli_query($conn,$sqlGetModelId);
              $data = mysqli_fetch_all($result);
              foreach ($data as $modelIDS) {
                  foreach ($modelIDS as $modelID) {
                      $model_id = $modelID;
                  }
              }
         */    

              $currentTime = date('Y-m-d H:i:s');
              echo "Trenutni cas je: " . $currentTime . "</br>";
              $sqlVozilo = "INSERT INTO vozilo
                                  (VIN,prevozeniKm,letnik,znamka,pogon,model, created_at)
                            VALUES('$VIN', '$prevozeniKM', '$letnik','$brand','$gorivo','$model','$currentTime');
                            ";
              if (mysqli_query($conn,$sqlVozilo)) {

                $sqlGetVoziloId = "SELECT voziloID FROM vozilo 
                                  WHERE VIN = '$VIN'
                                  AND created_at = '$currentTime'";

                $result = mysqli_query($conn,$sqlGetVoziloId);
                $data = mysqli_fetch_all($result);
                $vozID = 0;
                foreach ($data as $voziloIDS) {
                    foreach ($voziloIDS as $voziloID) {
                        $vozilo_id = $voziloID;
                        $vozID = $vozilo_id;
                    }
                }




                
                  $sqlOglas = "INSERT INTO Oglas
                               (opis,cena,created_at,voziloID,model,znamka,uporabnikID)
                               VALUES('$opisOglasa',$cena,'$currentTime',$vozID,'$model','$brand',$id);";

                  if (mysqli_query($conn,$sqlOglas)) {
                      $i = 0;
                      $oglasID = mysqli_insert_id($conn);

                      
                      for ($i = 0; $i < count($_FILES['oglasiImages']["tmp_name"]); $i++) {

                        $fileNameNew = "og" . $oglasID . "voz" . $vozID . "up" . $id . "num" . $i . ".jpg";
                        $fileDestination = "../../storage/" . $fileNameNew;
                        move_uploaded_file($_FILES["oglasiImages"]["tmp_name"][$i],$fileDestination);
                        $insertPhoto = "INSERT INTO Slika (imeSlike,oglasID,voziloID,model,znamka,uporabnik_ID)
                                        VALUES('$fileNameNew','$oglasID','$vozID','$model','$brand','$id')";
                        if (mysqli_query($conn,$insertPhoto)) {
                            echo "Uspesno nalozena slika v bazo";
                        }
                        

                      }
                      
                      Header("Location: ../templates/domov.php");
                  } else {
                    
                      echo "Error sending data to database: " . mysqli_error($conn);
                  }
              }


           } else {
               echo "nc nej tku k more bt</br>";
               echo "<pre>";
               var_dump($queries["errors"]);
               $_SESSION["errorInfo"] = $queries;
               Header("Location: ../templates/ustvari.php?upload=failure");
               echo "</pre>";
               
               //header("Location: ../templates/ustvari.php?upload=failure");
           }  
          }
        
        }
    } 
     
    function isBrandSet($conn,&$queries,&$validation) {
        if (!empty($_POST['znamka'])) {
            echo $_POST['znamka'] . "<br>";
            $brand = mysqli_real_escape_string($conn,$_POST['znamka']);
            $validation["brand"] = true;
            return $brand;
        } else {
            $queries["brand"] = "Brand is not set <br>";
            echo $queries["errors"]["brand"];
            $validation["brand"] = false;
            return false;
        }
    }

    function isModelSet($conn,&$queries,&$validation) {
        if (!empty($_POST['model'])) {
            echo $_POST['model'];
           // echo "Model je setannnnnnnnnnnnnnn";
            $validation["model"] = true;
            $model = mysqli_real_escape_string($conn,$_POST['model']);
            echo $model . "<br>";
            return $model;
        } else {
            $queries["errors"]["model"] = "Niste izbrali modela vozila";
            echo $queries["errors"]["model"];
            $validation["model"] = false;
            return false;
        }
    }

    function isLetnikSet($conn,&$queries,&$validation) {
        if (!empty($_POST['letnik'])) {
            echo $_POST['letnik'];
            $validation["letnik"] = true;
            $letnik = mysqli_real_escape_string($conn,$_POST['letnik']);
            echo $letnik . "</br>";
            return $letnik;
        }
    }


    function isGorivoSet($conn,&$queries,&$validation) {
        if (!empty($_POST['gorivo'])) {
          //  echo "Gorivo je Setanu";
          echo $_POST['gorivo'] . "<br>";
          $gorivo = mysqli_real_escape_string($conn,$_POST['gorivo']);
          $validation["gorivo"] = true;
            return $gorivo;
        } else {
            $queries["errors"]["gorivo"] = "Izbrati morate vrsto goriva";
            echo $queries["errors"]["gorivo"];
            $validation["gorivo"] = false;
            return false;
        }
    }

    function isVINSet($conn,&$queries,&$validation) {
        if (!empty($_POST['VIN'])) {
           // echo "VIN je Setanu";
            echo $_POST['VIN'] . "<br>";
            echo "VIN je setan";
            $VIN = mysqli_real_escape_string($conn,$_POST['VIN']);
            $validation["VIN"] = true;
            return $VIN;
        } else {
            $queries["errors"]["VIN"] = "Vpisati morate ustrezno število VIN";
            echo $queries["errors"]["VIN"];
            $validation["VIN"] = false;
            return false;
        }
    }

    function isPrevozeniSet($conn,&$queries,&$validation) {
        if (!empty($_POST['prevozeniKM'])) {
            echo $_POST['prevozeniKM'] . "<br>";
            echo "prevozeni je setan";
            $prevozeniKM = mysqli_real_escape_string($conn,$_POST['prevozeniKM']);
            $validation["prevozeniKM"] = true;
            return $prevozeniKM;
        } else {
            $queries["errors"]["prevozeniKM"] = "Potrebno je vpisati št. prevoženih kilometrov<br>";
            echo $queries["errors"]["prevozeniKM"];
            $validation["prevozeniKM"] = false;
            return false;
        }
    }

    function isOpisSet($conn,&$queries,&$validation) {
        if (!empty($_POST['opisVozila'])) {
           // echo "Vozila je Setanu";
            
            echo "opisVozila je setan";
            echo $_POST['opisVozila'] . "<br>";
            $opisOglasa = mysqli_real_escape_string($conn,$_POST['opisVozila']);
            $validation["opisOglasa"] = true;
            return $opisOglasa;
        } else {
            $queries["errors"]["opisOglasa"] = "Potrebno je ustvari opis vozila";
            
            echo $queries["errors"]["opisOglasa"];
            $validation["opisOglasa"] = false;
            return false;
        }
    }


    function isCenaSet($conn,&$queries,&$validation) {
        if (!empty($_POST['cena'])) {

    
            echo "Cena vozila je setana";
            echo $_POST['cena'];
            $cena = mysqli_real_escape_string($conn,$_POST['cena']);

            if ($cena > 0) {
                $validation['cena'] = true;
                return $cena;
            } else {
              $validation['cena'] = false;
              $queries["errors"]['cena'] = "Cena mora biti večja od 0€";  
              return false;
            }
        } else {
            echo "Cena vozila ni settana </br>";
            $queries["errors"]["cena"] = "Cena je obvezno polje";
            $validation['cena'] = false;
            return false;
        }
    }

    function checkValidation($validation) {
        echo "<pre>";
        var_dump($validation);
        echo "</pre>";

        foreach ($validation as $prop => $value) {
            if ($value === false) {
               // Header("Location: ../templates/ustvari.php?upload=failure");
               return false;
            }
        }
        return true;

      //  Header("Location: ../templates/ustvari.php?upload=sucess");
    }


    function checkPhotos($conn,&$queries,&$validation) {

        $neki = 0;
        $photos = array(
            "fileName" => array(),
            "fileTmpName" => array(),
            "fileSize" => array(),
            "fileError" => array(),
            "fileType" => array(),
        );

        $i = 0;
        $photoNames = array();

        foreach ($_FILES["oglasiImages"]["tmp_name"] as $tempName) {
            if (!file_exists($tempName) || !is_uploaded_file($tempName)) {
                echo "No upload of photos";
                $queries["errors"]["photos"] = "Potrebno je naložiti vsaj 1 sliko vozila";
                $validation["photos"] = false;
                return false;
            } else {
                
                echo "slika je ok: ";
                $photos["fileName"][] = $_FILES["oglasiImages"]["name"][$i];
                $photos["fileTmpName"][] = $_FILES["oglasiImages"]["tmp_name"][$i];
                $photos["fileSize"][] = $_FILES["oglasiImages"]["size"][$i];
                $photos["fileError"][] = $_FILES["oglasiImages"]["error"][$i];
                $photos["fileType"][] = $_FILES["oglasiImages"]["type"][$i];
                echo "TRENUTNI FILE STRUCTURE: </BR>";
                echo "<pre>";
                var_dump($photos);
                echo "</pre>";

                $allowed = array("jpg");
                $stevec = 0;

                $photoValidation = array("photo" => false);

                foreach ($photos as $property => $arr) {
                    
                    if ($property == "fileName") {
                        $fileExt = explode(".",$arr[$i]);
                        $fileActualExt = strtolower(end($fileExt));

                        if (in_array($fileActualExt,$allowed)) {
                            $photoValidation["photo"] = true;
                            $stevec++;
                        } else {
                            $queries["errors"]["photos"] = "Končnica slike je lahko le .jpg";
                            return "Slika $i ima napacno koncnico";
                        }
                    }

                    if ($property == "fileError") {
                        if ($arr[$i] === 0) {
                            $photoValidation["photos"] = true;
                            $stevec++;
                        } else {
                            $queries["errors"]["photos"] = "Napaka v sliki. Naloži drugo sliko";
                            return "Slika $i ima file error";
                        }
                    }


                    if ($property == "fileSize") {
                        if ($arr[$i] < 5000000) {
                            $photoValidation["photos"] = true;
                            $stevec++;
                        } else {
                            $queries["errors"]["photos"] = "Slika ne sme presegati velikosti 5MB";
                            return "Slika $i je prevelika";
                        }
                    }

                    if ($stevec === 3 && $photoValidation["photos"] === true) {
                        $neki = 5;
                       /* $fileNameNew = "oglas";
                        $photoNames[$i] = "slika" . $i . "oglasa " . $fileActualExt; */
                        
                    }

                    
                }


            }
            $i++;
        }

       /* return $photoNames; */
          if ($neki === 5) {
              return true;
          } else {
              $queries["errors"]["photos"] = "Prišlo je do napake. Prosim, poskusite kasneje.";
              return "Prislo je do napake";
          }
    }

    

    
?>