<?php

    require "../../config/db_connect.php";
    
    $error = "";


    function checkLogin($email,$geslo,$conn, &$error) {
        echo "v funkciji";
       /* $sql = "SELECT uporabnikID,ePosta,geslo FROM Uporabnik
                WHERE uporabnikID NOT IN 
                (SELECT uporabnik_karantenaID FROM uporabnik_karantena
                        WHERE `status` = 'Uporabnik je bil uspešno banan za nedoločen čas.')"; */
          $sql = "SELECT uporabnikID,ePosta,geslo FROM Uporabnik";

        $result = mysqli_query($conn,$sql);
        
        if (mysqli_num_rows($result) === 0) {
            echo "ce ni nic v bazi";
            $error = "Napačni ePoštni naslov ali geslo.";
            return false;
        } else {
            $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
            /*echo "<pre>";
            var_dump($users);
            echo "</pre>";*/
            foreach ($users as $user) {
                /*echo "<pre>";
                var_dump($user);
                echo "</pre>";
                echo "V foreach loopu za uporabnika";
                echo $user['ePosta'] . "</br>";
                echo $user['geslo'] . "</br>"; */
                if ($email === $user['ePosta'] && password_verify($geslo,$user["geslo"]) == 1) {
                    $_SESSION["id"] = $user['uporabnikID'];
                    /*echo "TRENUTEN SESSIONID JE: " . $_SESSION["id"] . "</br>"; */
                    
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    $error = "";
                    return true;
                }
            } 

                    $sql2 = "SELECT adminID,ePosta,geslo FROM `Admin`";
                    $result2 = mysqli_query($conn,$sql2);
                    $error = "Napačni ePoštni naslov ali geslo";
                    if (mysqli_num_rows($result2) === 0) {
                        echo "ce ni nic v bazi";
                        $error = "Napačni ePoštni naslov ali geslo.";
                        return false;
                    } else {
                        $users = mysqli_fetch_all($result2,MYSQLI_ASSOC);
                        foreach ($users as $user) {
                            echo "V foreach loopu za admina";
                            if ($email === $user['ePosta'] && password_verify($geslo,$user["geslo"]) == 1) {
                                $_SESSION["adminID"] = $user['adminID'];
                                mysqli_free_result($result2);
                                mysqli_close($conn);
                                $error = "";
                                echo "bomo redirectal na dashboard";
                                Header("Location: ../admin/dashboard.php"); 
                              /* return true; */
                            } {
                                return false;
                            }
                    }
                }
            
            $error = "Napačni ePoštni naslov ali geslo.";
            echo "zunej foreacha";
            return false;
        }
    
}
?>