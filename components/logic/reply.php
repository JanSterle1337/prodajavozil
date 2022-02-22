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