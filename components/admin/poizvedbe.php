<?php 
/*
function getOglasiData($conn) {
    $sql = "SELECT oglasID,created_at,cena,`status`,model,znamka,COUNT(voziloID) as koliko
            FROM Oglas
            WHERE created_at > ADDDATE(CURDATE(), -30)
            GROUP BY znamka";
           

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }
} */


function numberOfZnamkaLastMonth($conn) {
    $sql = "SELECT `status`,znamka,COUNT(voziloID) as koliko,AVG(cena) as povprecna_cena
            FROM Oglas
            WHERE created_at > ADDDATE(CURDATE(), -30)
            GROUP BY znamka";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }
}

function numberOfModelLastMonth($conn) {
    $sql = "SELECT `status`,znamka,model,COUNT(voziloID) as koliko,AVG(cena) as povprecna_cena
            FROM Oglas
            WHERE created_at > ADDDATE(CURDATE(), -30)
            GROUP BY znamka,model";
    
    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }
}


function averageCenaAvtov($conn) {
    $sql = "SELECT AVG(cena) as povprecna_cena FROM Oglas";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }

}

function averageCenaNaZnamko($conn) {
    $sql = "SELECT AVG(cena) as povprecna_cena,znamka FROM Oglas
            GROUP BY znamka";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }       
}


function najdrazjiAvto($conn) {
    $sql = "SELECT MAX(ogl.cena) as cena,`status`,created_at,model,znamka FROM Oglas ogl";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    } 
}

function najcenejsiAvto($conn) {
    $sql = "SELECT MIN(ogl.cena) as cena,`status`,created_at,model,znamka FROM Oglas ogl";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


function razmerjeMedProdanimiMesec($conn) {
    $sql = "SELECT COUNT(ogl.oglasID) as stVozil FROM Oglas ogl 
            WHERE ogl.status = 'neprodano' AND (ogl.created_at > ADDDATE(CURDATE(), -30))
            
            UNION 

            SELECT COUNT(ogl.oglasID) as stVozil FROM Oglas ogl 
            WHERE ogl.status = 'prodano' AND (ogl.updated_at > ADDDATE(CURDATE(), -30))
            ";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


function getAllUsers($conn) {
    $sql = "SELECT uporabnikID,ime,priimek,created_at FROM uporabnik";
    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


function checkForAlreadyBan($conn,$uporabnikID) {
    $sql = "SELECT uporabnik_karantenaID,zacetek_karantene,konec_karantene,`status` 
    FROM uporabnik_karantena
    WHERE uporabnik_karantenaID = $uporabnikID AND (`status` = 'Uporabnik je bil uspešno banan za nedoločen čas.' OR `status` = 'Vse je vredu')";

    if ($result = mysqli_query($conn,$sql)) {
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function insertAndBan($conn,$uporabnikID) {
    $sql = "INSERT INTO uporabnik_karantena
            (uporabnik_karantenaID,`status`)
            VALUES ($uporabnikID,'Uporabnik je bil uspešno banan za nedoločen čas.')";

    if (mysqli_query($conn,$sql)) {
        return "Uporabnik je bil uspešno banan za nedoločen čas.";
    } else {
        return "Napaka pri vnosu uporabnikovega bana za nedoločen čas";
    }  
}


function updateAndBan($conn,$uporabnikID) {
    $sql = "UPDATE uporabnik_karantena
            SET `status` = 'Uporabnik je bil uspešno banan za nedoločen čas.'
            WHERE uporabnik_karantenaID = $uporabnikID AND `status`='Vse je vredu'";

    if (mysqli_query($conn,$sql)) {
        return "Uporabnik je bil uspešno banan za nedoločen čas.";
    } else {
        echo "Error: " . mysqli_error($conn);
        return "Napaka pri posodabljanju uporabnikovega bana za nedoločen čas";
    }
}

function updateAndUnban($conn,$uporabnikID) {
    $sql = "UPDATE uporabnik_karantena
    SET `status` = 'Vse je vredu'
    WHERE uporabnik_karantenaID = $uporabnikID";

    if (mysqli_query($conn,$sql)) {
        return "Uporabnik je bil uspešno banan za nedoločen čas.";
    } else {
        return "Napaka pri posodabljanju uporabnikovega bana za nedoločen čas";
    }
   
}


function checkIsBanned($conn,$uporabnikID) {
    $sql = "SELECT uporabnik_karantenaID FROM uporabnik_karantena
            WHERE uporabnik_karantenaID = $uporabnikID 
                AND `status` = 'Uporabnik je bil uspešno banan za nedoločen čas.'";

    if ($result = mysqli_query($conn,$sql)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getAllOglasi($conn) {
    $sql = "SELECT  
            og.oglasID,
            og.cena,
            og.voziloID,
            og.model,
            og.znamka,
            `status`,
            sl.slikaID,
            sl.imeSlike 
                FROM Oglas og
            INNER JOIN Vozilo voz ON    (og.voziloID = voz.voziloID)
            INNER JOIN Slika sl ON      (og.oglasID = sl.oglasID)
            INNER JOIN Uporabnik upo ON (og.uporabnikID = upo.uporabnikID)
                WHERE 
            sl.imeSlike LIKE '%num0%'
            AND og.oglasID NOT IN (
                SELECT karantena_oglasID FROM oglas_karantena
            )";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo mysqli_error($conn);
    }
            
}

function getOdstranjeniOglasi($conn) {
    $sql = "SELECT  
            og.oglasID,
            og.cena,
            og.voziloID,
            og.model,
            og.znamka,
            `status`,
            sl.slikaID,
            sl.imeSlike 
                FROM Oglas og
            INNER JOIN Vozilo voz ON    (og.voziloID = voz.voziloID)
            INNER JOIN Slika sl ON      (og.oglasID = sl.oglasID)
            INNER JOIN Uporabnik upo ON (og.uporabnikID = upo.uporabnikID)
                WHERE 
            sl.imeSlike LIKE '%num0%'
            AND og.oglasID IN (
                SELECT 
                karantena_oglasID
                FROM oglas_karantena	
            )";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo mysqli_error($conn);
    }
            
}

function odstraniOglas($conn) {

}

function isAlreadyOdstranjen($conn,$oglasID) {
    $sql = "SELECT karantena_oglasID,`status` FROM karantena_oglas
            WHERE $oglasID = 'karantena_oglasID'";

    if ($result = mysqli_query($conn,$sql)) {
        if (mysqli_num_rows($result) === 0) {
            return false;
        } else {
            return `status`;
        }
    } else {
        return false;
    }
}


function insertAndOdstrani($conn,$oglasID) {
    $sql = "INSERT INTO oglas_karantena (karantena_OglasID,`status`)
            VALUES($oglasID,'Oglas je odstranjen')";
        
    if (mysqli_query($conn,$sql)) {
        return true;
    } else {
       echo "Error: " . mysqli_error($conn);
    }
}


function deleteAndOdstrani($conn,$oglasID) {
    $sql = "DELETE FROM oglas_karantena
            WHERE karantena_oglasID = $oglasID";

    if (mysqli_query($conn,$sql)) {
        return true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}




?>