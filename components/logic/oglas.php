<?php 

function getOglasInfo($conn,$oglasID) {
    $sql = "SELECT
            og.oglasID,
            og.opis,
            og.status,
            og.created_at,
            og.znamka,
            og.model,
            voz.VIN,
            voz.pogon,
            voz.letnik,
            voz.prevozeniKm,
            og.cena,
            up.uporabnikID
                FROM Oglas og
                INNER JOIN Uporabnik up ON (og.uporabnikID = up.uporabnikID)
                INNER JOIN Vozilo voz ON (og.voziloID = voz.voziloID)
                WHERE og.oglasID = $oglasID";

    if ($result = mysqli_query($conn,$sql)) {
       /* echo "Ured query je";
        echo mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        echo "<pre>";
        var_dump($row);
        echo "</pre>"; */
    } else {
        echo "Ni urjde query";
    }

    return $result;
    
}


function getPhotosInfo($conn,$oglasID) {
    $sql = "SELECT
            slikaID,
            imeSlike,
            created_at,
            oglasID
                FROM Slika  
            WHERE oglasID = $oglasID";
    $result = mysqli_query($conn,$sql);
    return $result;
}


function getSellerInfo($conn,$userID) {
    $sql = "SELECT
            uporabnikID,
            ime,
            priimek,
            ePosta,
            telefonska,
            opis,
            created_at
                FROM Uporabnik
            WHERE uporabnikID = $userID";

     $result = mysqli_query($conn,$sql);
    
   
    return $result;
}

function getProfilkaInfo($conn,$userID) {
    $sql = "SELECT * FROM profilka
            WHERE uporabnikID = $userID";

    $result = mysqli_query($conn,$sql);
    
    return $result;   
}


?>