<?php 

function fetchAllUsers($conn,$uporabnikID) {
    $sql = "SELECT uporabnik.uporabnikID,ime,priimek,ePosta,telefonska,opis,profilkaID,`status`
            FROM Uporabnik
            LEFT JOIN Profilka ON (profilka.uporabnikID = uporabnik.uporabnikID)
            WHERE uporabnik.uporabnikID != $uporabnikID";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


function fetchAllUsersSingleMessage($conn,$uporabnikID) {

}

function fetchMyData($conn,$uporabnikID) {
    $sql = "SELECT uporabnik.uporabnikID,ime,priimek,ePosta,telefonska,opis,profilkaID,`status`
                FROM Uporabnik
            LEFT JOIN Profilka ON (profilka.uporabnikID = uporabnik.uporabnikID)
                WHERE uporabnik.uporabnikID = $uporabnikID";
        
    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function fetchHisData($conn,$uporabnikID) {
    $sql = "SELECT uporabnik.uporabnikID,ime,priimek,ePosta,telefonska,opis,profilkaID,`status`
    FROM Uporabnik
        LEFT JOIN Profilka ON (profilka.uporabnikID = uporabnik.uporabnikID)
    WHERE uporabnik.uporabnikID = $uporabnikID";

    if ($result = mysqli_query($conn,$sql)) {
        return $result;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


function checkMessage($message) {
    if (strlen($message) > 0) {
        return true;
    } else {
        return false;
    }
}

function insertMessage($conn,$message,$posiljateljID,$prejemnikID) {
    $sql = "INSERT INTO Sporočilo 
            (opis,posiljateljID,prejemnikID)
            VALUES('$message',$posiljateljID,$prejemnikID)";
    if (mysqli_query($conn,$sql)){
        return true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


function checkPrejemnikID(&$prejemnikID) {

    if (preg_match('/^[1-9]+[0-9]*$/',$prejemnikID)) {
        return true;
    } else {
        return false;
    }
   
}
?>