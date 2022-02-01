<?php 

function getOglasInfo($conn,$oglasID) {
    $sql = "SELECT
            og.oglasID,
            og.opis,
            og.status,
            og.created_at,
            og.znamka,
            og.model,
            voz.voziloID,
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

function allSellerOglasi($conn,$userID) {
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
            og.status = 'neprodano' AND 
            sl.imeSlike LIKE '%num0%' AND
            upo.uporabnikID = $userID;";

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


function deleteOglas($conn,$oglasID) {
    $sql = "UPDATE Oglas SET `status` = 'prodano'
            WHERE oglasID = $oglasID";

    if (mysqli_query($conn,$sql)) {

        echo "Success";
    } else {
        "Error: " . mysqli_error($conn);
    }
}


?>