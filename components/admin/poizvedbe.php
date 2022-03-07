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



?>