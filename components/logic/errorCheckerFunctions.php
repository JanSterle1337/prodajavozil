<?php 

$validation = array(
    "brand" => false,
    "model" => false,
    "letnik" => false,
    "gorivo" => false,
    "VIN" => false,
    "prevozeniKM" => false,
    "opisOglasa" => false,
    "cena" => false,
    
);
  


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
        
    )
);


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
            $queries["errors"]["opisOglasa"] = "Potrebno je ustvariti opis vozila";
            
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
        /*echo "<pre>";
        var_dump($validation);
        echo "</pre>"; */

        foreach ($validation as $prop => $value) {
            if ($value === false) {
               // Header("Location: ../templates/ustvari.php?upload=failure");
               return false;
            }
        }
        return true;

      //  Header("Location: ../templates/ustvari.php?upload=sucess");
    }

    ?>