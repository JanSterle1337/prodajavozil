<?php 

require ("../../config/db_connect.php");
session_start();

$ime = $priimek = $email = $tel = $opis = "";


if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
}

function retrieveUserData($id,$conn) {
    $sql = "SELECT ime,
    priimek,
    ePosta,
    telefonska,
    opis 
    FROM Uporabnik
    WHERE uporabnikID = '$id'";

$result = mysqli_query($conn,$sql);

$users = mysqli_fetch_all($result,MYSQLI_ASSOC);
return $users;
}



function getUserData(&$ime, &$priimek,&$email,&$tel,&$opis,&$id,&$conn) {
    $users = retrieveUserData($id,$conn);


    foreach ($users as $user) {
        foreach ($user as $lastnost => $vrednost) {
            if ($lastnost == "ime") {
                $ime = $vrednost;
            }

            if ($lastnost == "priimek") {
                $priimek = $vrednost;
            }

            if ($lastnost == "ePosta") {
                $email = $vrednost;
            }

            if ($lastnost == "telefonska") {
                $tel = $vrednost;
            }

            if ($lastnost == "opis") {
                $opis = $vrednost;
            }

        }
    } 
}

?>