<?Php 

    session_start();
    require ("../../config/db_connect.php");
    $validation = [
        "brand" => false,
        "model" => false,
        "gorivo" => false,
        "VIN" => false,
        "prevozeniKM" => false,
        "opisOglasa" => false,
    ];

    $errors = [
        "brand" => "",
        "model" => "",
        "gorivo" => "",
        "VIN" => "",
        "prevozeniKM" => "",
        "opisOglasa" => "",
    ];

    if (isset($_SESSION['id'])) {
        if (isset($_POST['submit'])) {
            
            if (isBrandSet($conn)) {
                $brand = mysqli_real_escape_string($conn,$_POST['brand']);
            /* echo "jaoooooooooooooooooooo" . $brand; */
            }

            if (isModelSet($conn)) {
                $model = mysqli_real_escape_string($conn,$_POST['model']);
                //echo $model;
            }

            if (isGorivoSet($conn)) {
                $gorivo = mysqli_real_escape_string($conn,$_POST['gorivo']);
            }

            if (isVINSet($conn)) {
                $VIN = mysqli_real_escape_string($conn,$_POST['VIN']);
            }

            if (isPrevozeniSet($conn)) {
                $prevozeniKM = mysqli_real_escape_string($conn,$_POST['prevozeniKM']);
            }

            if (isOpisSet($conn)) {
                $opisOglasa = mysqli_real_escape_string($conn,$_POST['opisVozila']);
            }

            echo "Podatki: " . "$brand $model $gorivo $VIN $prevozeniKM $opisOglasa" . "</br>";
        }
    }
    
    function isBrandSet($conn) {
        if (isset($_POST['brand'])) {
            echo "Brand je setannnnnnnnnnnnnnnnnnnnnnnn";
           return true;
        } else {
            return false;
        }
    }

    function isModelSet($conn) {
        if (isset($_POST['model'])) {
            echo "Model je setannnnnnnnnnnnnnn";
            return true;
        } else {
            return false;
        }
    }

    function isGorivoSet($conn) {
        if (isset($_POST['gorivo'])) {
            echo "Gorivo je Setanu";
            return true;
        } else {
            return false;
        }
    }

    function isVINSet($conn) {
        if (isset($_POST['VIN'])) {
            echo "VIN je Setanu";
            return true;
        } else {
            return false;
        }
    }

    function isPrevozeniSet($conn) {
        if (isset($_POST['prevozeniKM'])) {
            echo "prevozeniKM je Setanu";
            return true;
        } else {
            return false;
        }
    }

    function isOpisSet($conn) {
        if (isset($_POST['opisVozila'])) {
            echo "Vozila je Setanu";
            return true;
        } else {
            return false;
        }
    }

    

    
?>