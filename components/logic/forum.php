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
    $sql = "SELECT te.temaID,te.naslov,te.razprava,te.uporabnikID,upo.ime,upo.priimek FROM Tema te
            INNER JOIN Uporabnik upo ON (upo.uporabnikID = te.uporabnikID)
            WHERE te.temaID = $temaID";

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
    $sql = "SELECT 
            ko.komentarID,
            ko.opis,
            upo.uporabnikID,
            upo.ime,
            upo.priimek,
            ko.temaID,
            ko.created_at,
            profilka.profilkaID
            FROM Komentar ko
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = ko.uporabnikID)
                LEFT JOIN profilka ON (profilka.uporabnikID = upo.uporabnikID)
            WHERE
                (temaID = $temaID)";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
        return false;
    }
}



function numberOfReplys($conn,$komentarID,$nestedLvl = 1) {
    $sql = "SELECT
            COUNT(odg.odgovorID) AS stReplyov,
            kom.komentarID
            FROM Odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
            WHERE odg.nested_level = '$nestedLvl' AND kom.komentarID = '$komentarID'
                GROUP BY kom.komentarID
            HAVING stReplyov > 0";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
       
    } else {
        return false;
        echo "Error: " . mysqli_error($conn);
    }

}

function retrieveKomentarReplys($conn,$komentarID,$nestedLvl = 1) {
    $sql = "SELECT
            odg.opis AS reply,
            odg.nested_level,
            odg.odgovorjenID,
            odg.odgovorID,
            upo.ime,
            upo.priimek,
            kom.komentarID
            FROM odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = odg.uporabnikID)
            WHERE 
                odg.nested_level = '$nestedLvl' AND
                kom.komentarID = '$komentarID'";
    
    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    

/*    return $result; */
}


function retrieveReplyReplys($conn,$komentarID,$odgovorjenID,$nestedLvl = 1) {
    $sql = "SELECT
            odg.opis AS reply,
            odg.nested_level,
            odg.odgovorjenID,
            odg.odgovorID,
            upo.ime,
            upo.priimek,
            kom.komentarID
            FROM odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = odg.uporabnikID)
            WHERE 
                odg.nested_level = '$nestedLvl' AND
                kom.komentarID = '$komentarID' AND
                odg.odgovorjenID = '$odgovorjenID'";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function formatDate($komentarID,$conn) {
   $sql = "SELECT UNIX_TIMESTAMP(created_at) as seconds
                FROM Komentar
            WHERE komentarID = '$komentarID'";
    
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $dateSeconds = $data[0]['seconds'];

    $sql2 = "SELECT UNIX_TIMESTAMP(NOW()) as current_seconds";
    if ($result2 = mysqli_query($conn,$sql2)) {
        $data2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
        $dateNow = $data2[0]['current_seconds'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    $seconds = $dateNow - $dateSeconds;
    
    return $seconds;
}

?>


