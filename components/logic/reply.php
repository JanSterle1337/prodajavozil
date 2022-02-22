<?php 


function retrieveComment($conn,$temaID,$komentarID) {
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
                (temaID = $temaID) AND ko.komentarID = '$komentarID'";

    if ($result = mysqli_query($conn,$sql)) {

        return $result;
    } else {
        return false;
    }
}

function getTema($conn,$komentarID) {
    $sql = "SELECT
            temaID
            FROM Komentar
            WHERE komentarID ='$komentarID'";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }
} 


function retrieveReply($conn,$nestedLvl,$replyID) {
    $sql = "SELECT 
            odg.odgovorID,
            odg.opis,
            odg.komentarID,
            odg.nested_level,
            upo.uporabnikID,
            upo.ime,
            upo.priimek,
            odg.created_at,
            upo.uporabnikID,
            profilka.profilkaID
            FROM Odgovor odg
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = odg.uporabnikID)

                LEFT JOIN profilka ON (profilka.uporabnikID = upo.uporabnikID)
            WHERE odg.odgovorID = '$replyID'";

    if ($result = mysqli_query($conn,$sql)) {
       
    
        return $result;

    } else {
        echo "Error: " . mysqli_error($conn);
        return false;
    }        
                
}


function retrieveMyData($conn,$uporabnikID) {
    $sql = "SELECT
            upo.uporabnikID,
            upo.ime,
            upo.priimek,
            profilka.profilkaID
            FROM Uporabnik upo
                LEFT JOIN profilka ON (profilka.uporabnikID = upo.uporabnikID)
            WHERE upo.uporabnikID = '$uporabnikID'";
    
    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        return false;
    }
}



?>