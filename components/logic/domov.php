<?php 


require "../../config/db_connect.php";


/*generateSearchQuery($conn); */



function generateSearchQuery($conn) {

    $validation = array(
        "znamka" => false,
        "model" =>  false,
        "cenaOd" => false,
        "cenaDo" => false,
        "letnikOd" => false,
        "letnikDo" => false,
        "kilometrovDo" => false,
        "gorivo" => false,
    );

    if (isset($_POST['iskanje'])) {
        $znamka = mysqli_real_escape_string($conn,$_POST['znamka']);
        $model = mysqli_real_escape_string($conn,$_POST['model']);
        $cenaOd = mysqli_real_escape_string($conn,$_POST['cena-od']);
        $cenaDo = mysqli_real_escape_string($conn,$_POST['cena-do']);
        $letnikOd = mysqli_real_escape_string($conn,$_POST['letnik-od']);
        $letnikDo = mysqli_real_escape_string($conn,$_POST['letnik-do']);
        $kilometrovDo = mysqli_real_escape_string($conn,$_POST['kilometrov-do']);
        $gorivo = mysqli_real_escape_string($conn,$_POST['gorivo']);

       /* echo "Znamka pa model:" . $znamka . " " . $model . $cenaOd . $cenaDo . $letnikOd . $letnikDo . $kilometrovDo . $gorivo . "Oke"; */

        $sql = "SELECT DISTINCT og.oglasID,
                                og.cena,
                                og.voziloID,
                                og.model,
                                og.znamka,
                                voz.letnik,
                                voz.prevozeniKm,
                                voz.pogon,
                                `status`,
                                sl.slikaID,
                                sl.imeSlike 
                                
                                FROM Oglas og
                                    INNER JOIN Vozilo voz ON (og.voziloID = voz.voziloID)
                                    INNER JOIN Slika sl ON   (og.oglasID = sl.oglasID)
                                    WHERE 
                                    og.status = 'neprodano' AND 
                                    sl.imeSlike LIKE '%num0%'";


        if ($znamka == "Vse znamke") {
            $znamka = "";
            $validation["znamka"] = true;
            
        } else {
            $validation["znamka"] = " AND og.znamka = '$znamka'";
            $sql = $sql . $validation["znamka"];
        }

        if ($model == "Vsi modeli") {
            $model = "";
            $validation["model"] = true;
            
        } else {
            $validation["model"] = " AND og.model = '$model'";
            $sql = $sql . $validation["model"];
        }

        if ($cenaOd == "Cena od") {
            $cenaOd = "";
            $validation["model"] = true;
            
        } else {
            $validation["cenaOd"] = " AND og.cena >= $cenaOd";
            $sql = $sql . $validation["cenaOd"];
        }

        if ($cenaDo == "Cena do") {
            $cenaDo = "";
            $validation["cenaOd"] = true;
        } else {
            $validation["cenaDo"] = " AND og.cena <= $cenaDo";
            $sql = $sql . $validation["cenaDo"];
        }

        if ($letnikOd == "Letnik od") {
            $letnikOd = "";
            $validation["letnikOd"]= true;
        } else {
            $validation["letnikOd"]= " AND voz.letnik >= $letnikOd";
            $sql = $sql . $validation["letnikOd"];
        }

        if ($letnikDo  == "Letnik do") {
            $letnikDo = "";
            $validation["letnikDo"]= true;
        } else {
            $validation["letnikDo"]= " AND voz.letnik <= $letnikDo";
            $sql = $sql . $validation["letnikDo"];
        }

        if ($kilometrovDo == "Kilometrov do") {
            $kilometrovDo = "";
            $validation["kilometrovDo"] = true;
        } else {
            $validation["kilometrovDo"] = " AND voz.prevozeniKm <= $kilometrovDo";
            $sql = $sql  . $validation["kilometrovDo"];
        }

        if ($gorivo == "gorivo") {
            $gorivo = "";
            $validation["gorivo"] = true;
        } else {
            $validation["gorivo"] = " AND voz.pogon = '$gorivo'";
            $sql = $sql . $validation["gorivo"];
        }

/*
        echo "<pre>";
        echo $sql;
        echo "</pre>"; */
        return $sql;

    }
}


function generateCena($izbira) {

    if ($izbira == true) {
        $povecaj = 500;

        for ($i = 0; $i <= 100000; $i+= $povecaj)  {
            echo "<option value='$i'>od $i EUR</option>";
                        
            if ($i === 5000) {
                $povecaj = 1000;
            }
    
            if ($i === 20000) {
                $povecaj = 5000;
            }
    
            if ($i === 50000) {
                $povecaj = 25000;
            }
        }
    } else if ($izbira == false) {
        $povecaj = 500;

        for ($i = 500; $i <= 100000; $i+= $povecaj)  {
            echo "<option value='$i'>do $i EUR</option>";
                        
            if ($i === 5000) {
                $povecaj = 1000;
            }
    
            if ($i === 20000) {
                $povecaj = 5000;
            }
    
            if ($i === 50000) {
                $povecaj = 25000;
            }
        }
    }
       
}



function generateLetnik($izbira) {
    if ($izbira === true) {
        for ($i =  1950; $i <= 2022; $i++) {
            echo "<option value='$i'>od $i</option>";
        }
    } else if ($izbira === false) {
        for ($i =  1950; $i <= 2022; $i++) {
            echo "<option value='$i'>do $i</option>";
        }
    }
   
}


function generateKm() {
    $povecaj = 500;

        for ($i = 500; $i <= 1000000; $i+= $povecaj)  {
            echo "<option value='$i'>do $i  km</option>";
                        
            if ($i >= 2000) {
                $povecaj = 2500;
            }
    
            if ($i >= 10000 ) {
                $povecaj = 25000;
            }
    
            if ($i >= 100000) {
                $povecaj = 50000;
            }

            if ($i >= 200000) {
                $povecaj = 350000;
            }
        }
}

?>