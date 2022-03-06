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



?>