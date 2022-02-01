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

?>