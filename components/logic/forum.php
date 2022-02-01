<?php 


function getAllTeme($conn) {
    $sql = "SELECT *
            FROM Tema";

    if ($result = mysqli_query($conn,$sql)) {
        //echo "Ok";
        return $result;
    } else {
        //echo "Error: " . mysqli_error($conn);
    }
}


function createTema($conn,$naslov,$opis,$uporabnikID,&$errors) {
    $sql = "INSERT INTO Tema
            (naslov,razprava,uporabnikID)
            VALUES
            ('$naslov','$opis',$uporabnikID);";

    if (mysqli_query($conn,$sql)) {
        //echo "Uspesno";
        $errors["baza"] = "";
        return true;
    } else {
        //echo "Error: " . mysqli_error($conn);
        $errors["baza"] = "Napaka pri ustvarjanju nove teme";
        return false;
    }
}


function checkNaslov($conn,$naslov,&$errors) {
    if (strlen($naslov) < 4) {
        $errors["naslov"] = "Prekratek naslov";
        return false;
    } else {
        $blacklistChars = '"%\'*;<>^`{|}~/\\#=&';
        $pattern = preg_quote($blacklistChars, '/');
        if (preg_match('/[' . $pattern . ']/', $naslov)) {
            //echo "Nej urjde";
            $errors['naslov'] = "Vsebuje čudne črke";
            return false;
        } else {
            //echo "Je urjde";
            $errors["naslov"] = "";
            return true;
        }
    }
}

function checkOpis($conn,$opis,&$errors) {
    if (strlen($opis) < 10) {
        $errors["opis"] = "Prekratek opis oglasa";
        return false;
    } else {
        $blacklistChars = '"%\'*;<>?^`{|}~/\\#=&';
        $pattern = preg_quote($blacklistChars, '/');
        if (preg_match('/[' . $pattern . ']/', $opis)) {
            ///echo "Nej urjde";
            $errors["opis"] = "String vsebuje čudne črke";
            return false;
            } else {
            //echo "Je urjde";
            $errors["opis"] = "";
            return true;
        }
    }
}


function getSingleTema($conn,$temaID) {
    $sql = "SELECT * FROM Tema
            WHERE temaID = $temaID";

    if ($result = mysqli_query($conn,$sql)) {
        //echo "Ok";
        return $result;
    } else {
        return false;
    }
}


function checkKomentar($conn,$komentar) {
    if (strlen($komentar) > 1) {
        return true;
    } else {
        return false;
    }
}


function insertKomentar($conn,$komentar,$uporabnikID,$temaID) {
    $sql = "INSERT INTO Komentar
            (opis,uporabnikID,temaID)
            VALUES
            ('$komentar',$uporabnikID,$temaID)";

    if (mysqli_query($conn,$sql)) {
        echo "Dela query";
        return true;
    } else {
        echo "Error: " . mysqli_error($conn);
       return false;
    }
}

function allKomentarji($conn,$temaID) {
    $sql = "SELECT *
            FROM Komentar
            WHERE
                (temaID = $temaID)";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
        return false;
    }
}

?>