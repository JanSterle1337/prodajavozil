<?php 


function getAllTeme($conn) {
    $sql = "SELECT *
            FROM Tema
            ORDER BY created_at DESC";

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


function updateTema($conn,$temaID,$naslov,$opis) {
    $sql = "UPDATE
            Tema
            SET 
            naslov='$naslov',
            razprava='$opis'
            WHERE temaID = '$temaID'";

    if (mysqli_query($conn,$sql)) {
        return true;
    } else {
        return false;
    }
}


function deleteTema($conn,$temaID) {
    $sql = "DELETE
            FROM Tema
            WHERE temaID = '$temaID'";

    if (mysqli_query($conn,$sql)) {
        return true;
    } else {
        return false;
    }
}

function checkNaslov($conn,$naslov,&$errors) {
    if (strlen($naslov) < 4) {
        $errors["naslov"] = "Napaka pri vnosu naslova";
        return false;
    } else {
        $blacklistChars = '"%\'*;<>^`{|}~/\\#=&';
        $pattern = preg_quote($blacklistChars, '/');
        if (preg_match('/[' . $pattern . ']/', $naslov)) {
            //echo "Nej urjde";
            $errors['naslov'] = "Napaka pri vnosu naslova.";
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
    $sql = "SELECT te.temaID,te.naslov,te.razprava,te.uporabnikID,upo.ime,upo.priimek,profilka.profilkaID FROM Tema te
            INNER JOIN Uporabnik upo ON (upo.uporabnikID = te.uporabnikID)
            LEFT JOIN Profilka ON (profilka.uporabnikID = upo.uporabnikID)
                WHERE te.temaID = $temaID";

    if ($result = mysqli_query($conn,$sql)) {
        //echo "Ok";
        return $result;
    } else {
        return false;
    }
}


function checkKomentar($conn,$komentar) {
    if (strlen($komentar) > 0) {
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

function insertReply($conn,$komentarID,$reply,$uporabnikID) {
    $sql = "INSERT INTO Odgovor
            (opis,nested_level,komentarID,uporabnikID)
            VALUES
            ('$reply',1,'$komentarID','$uporabnikID')";
    
    if (mysqli_query($conn,$sql)) {
        return true;
    } else {
        echo "Error: " . mysqli_error($conn);

        return "Napaka pri vnosu odgovora.";
    }
}


function insertReplyReply($conn,$komentarID,$odgovorjenID,$nestedLvl,$opis,$uporabnikID) {
    echo "Insertamo v REPLY REPLY: " . "komentarID $komentarID" . "OdgovorjenID $odgovorjenID" . "nestedLvl $nestedLvl" . "Opis $opis" . "Uporabnik $uporabnikID </br>";
    $sql = "INSERT INTO Odgovor
            (opis,nested_level,komentarID,uporabnikID,odgovorjenID)
            VALUES
            ('$opis',$nestedLvl,'$komentarID','$uporabnikID','$odgovorjenID')";

    if (mysqli_query($conn,$sql)) {
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
            kom.komentarID,
            '$nestedLvl'
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

function numberOfReplyReplies($conn,$komentarID,$odgovorID,$nestedLvl = 1) {
    $sql = "SELECT
            COUNT(odg.odgovorID) AS stReplyov,
            kom.komentarID,
            '$nestedLvl'
            FROM Odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
            WHERE odg.nested_level = '$nestedLvl' AND kom.komentarID = '$komentarID' AND odg.odgovorjenID = '$odgovorID'
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
            upo.uporabnikID,
            kom.komentarID,
            profilka.profilkaID
            FROM odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = odg.uporabnikID)
                LEFT JOIN profilka ON (profilka.uporabnikID = upo.uporabnikID)

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
            odg.created_at,
            upo.uporabnikID,
            upo.ime,
            upo.priimek,
            kom.komentarID,
            profilka.profilkaID
            FROM odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = odg.uporabnikID)
                LEFT JOIN Profilka ON (profilka.uporabnikID = upo.uporabnikID)
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

function formatDate($komentarID,$conn,$isKomentar) {


   if ($isKomentar === true) {
    $sql = "SELECT UNIX_TIMESTAMP(created_at) as seconds
                FROM Komentar
            WHERE komentarID = '$komentarID'";
   } else if ($isKomentar === false) {
    $sql = "SELECT UNIX_TIMESTAMP(created_at) as seconds
                FROM Odgovor
            WHERE odgovorID = '$komentarID'";
   } else if ($isKomentar = "temaUstvarjena") {
    $sql = "SELECT UNIX_TIMESTAMP(created_at) as seconds
                FROM tema
            WHERE temaID = '$komentarID'";
   }
   
    
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


function secondsToTime($inputSeconds) {

    if (empty($inputSeconds)) {
        return 0;
    }

    $secondsInMinute = 60;
    $secondsInAnHour = 60 * $secondsInMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    $days = floor($inputSeconds / $secondsInADay); //extract days


    $hourSeconds = $inputSeconds % $secondsInADay;  //extract hours
    $hours = floor($hourSeconds / $secondsInAnHour);

    
    $minuteSeconds = $hourSeconds % $secondsInAnHour;   //extract minutes
    $minutes = floor($minuteSeconds / $secondsInMinute);


    $remainingSeconds = $minuteSeconds % $secondsInMinute; //extract the remaining seconds
    $seconds = ceil($remainingSeconds);


    $timeParts = [];        //store the data in array format
    $sections = [
        'dni' => (int)$days,
        'ur' => (int)$hours,
        'minut' => (int)$minutes,
        'sekund' => (int)$seconds
    ];

    /*echo "<pre>";
    var_dump($sections);
    echo "</pre>"; */

    return $sections;


}

?>


