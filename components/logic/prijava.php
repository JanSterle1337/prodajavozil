<?php

    require "../../config/db_connect.php";
    
    $error = "";


    function checkLogin($email,$geslo,$conn, &$error) {
        echo "v funkciji";
        $sql = "SELECT uporabnikID,ePosta,geslo FROM Uporabnik;";

        $result = mysqli_query($conn,$sql);
        
        if (mysqli_num_rows($result) === 0) {
            echo "ce ni nic v bazi";
            $error = "Napačni ePoštni naslov ali geslo.";
            return false;
        } else {
            $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
            foreach ($users as $user) {
                echo "V foreach loopu";
                if ($email === $user['ePosta'] && password_verify($geslo,$user["geslo"]) == 1) {
                    $_SESSION["id"] = $user['uporabnikID'];
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    $error = "";
                    return true;
                } else {
                    $error = "Napačni ePoštni naslov ali geslo";
                }
            }
            $error = "Napačni ePoštni naslov ali geslo.";
            echo "zunej foreacha";
            return false;
        }
    }

?>