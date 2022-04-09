<?php 

require ("../../config/db_connect.php");

$errors = array("email" => "", "ime" => "","priimek" => "", "geslo" => "", "tel" => "");
$validation = array ("email" => false, "ime" => false, "priimek" => false, "geslo" => false, "tel" => false);


function checkEmail($email, &$errors, &$conn, &$validation) {




    if (empty($email)) {
        $errors["email"] = "Vpisati moraš svoj E-potšni račun.";
        return false;
    } 

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "E-poštni račun mora biti pravilno vnesen.";
        return false;
    }

    else {
        $sql = "SELECT ePosta from Uporabnik";
        $result = mysqli_query($conn,$sql);
        
        if (mysqli_num_rows($result) === 0) {
            return true;
        } else {
            $userEmails = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($userEmails as $Email) {

                if ($Email['ePosta'] === $email) {
                    $validation["email"] = false;
                    $errors["email"] = "Uporabnik s takim E-računom že obstaja.";
                    return false;
                } else {
                   // $validation["email"] = true;
                    return true;
                }
            }
        }
    }

    return false;
} 


function checkIme($ime,&$errors,&$conn,&$validation) {
    if (empty($ime)) {
        $errors["ime"] = "Polje z imenom, nesme biti prazno.";
        $validation["ime"] = false;
        return false;
    }
    else {
        return true;
    }
}

function checkPriimek($priimek,&$errors, &$conn,&$validation) {
    if (empty($priimek))  {
        $errors["priimek"] = "Polje s priimkom, nesme biti prazno";
        return false;
    } else {
        return true;
    }
    
}


function checkGeslo(&$geslo, &$errors, &$conn, &$validation) {
    if (empty($geslo)) {
        $errors["geslo"] = "Potrebno je vpisat geslo";
        return false;
    }
    else if (strlen($geslo) < 8) {
        $errors["geslo"] = "Geslo mora biti dolgo vsaj 8 znakov.";
        return false;
    }
    else {
        $geslo = password_hash($geslo, PASSWORD_DEFAULT);
        return true;
    }
    return false;
}

function checkTel($tel, &$errors, &$conn, &$validation) {
    if (!empty($tel)) {
        return true;
    } else {
        $errors["tel"] = "Telefonska številka ni v pravem formatu.";
        return false;
    }
    return false;
}




?>