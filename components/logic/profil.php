<?php  

require ("../../config/db_connect.php");


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

$ime = $priimek = $ePosta = $opis = $tel = "";

function retrieveUsers($id,$conn,&$ime,&$priimek,&$ePosta,&$tel,&$opis) {

    $sql = "SELECT  ime,priimek,ePosta,telefonska,opis FROM Uporabnik 
    WHERE uporabnikID = '$id'";

    $result = mysqli_query($conn,$sql);

    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);

    foreach ($users as $user) {
        $ime = $user['ime'];
        $priimek = $user['priimek'];
        $ePosta = $user['ePosta'];
        $opis = $user['opis'];
        $tel = $user['telefonska'];
    } 

}

?>