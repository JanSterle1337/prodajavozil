<?php 

    require ("../logic/registracija.php");
    session_start();
    if (isset($_SESSION['id'])) {
        unset($_SESSION['id']);
    }
    $email = $ime = $priimek = $geslo = $tel = "";
    

    if (isset($_POST["registracija"])) {

        $email = mysqli_real_escape_string($conn,$_POST["eposta"]);
        $ime = mysqli_real_escape_string($conn,$_POST["ime"]);
        $priimek = mysqli_real_escape_string($conn,$_POST["priimek"]);
        $geslo = mysqli_real_escape_string($conn,$_POST["geslo"]);
        $tel = mysqli_real_escape_string($conn,$_POST["tel"]);

        if (checkEmail($email,$errors,$conn,$validation)) {
            $validation["email"] = true;
        } else {
            $validation["email"] = false;
           // echo "email false";
        }

        if (checkIme($ime,$errors,$conn,$validation)) {
            $validation["ime"] = true;
        } else {
            $validation["ime"] = false;
           // echo "ime false";
        }

        if (checkPriimek($priimek,$errors,$conn,$validation)) {
            $validation["priimek"] = true;
        } else {
            $validation["priimek"] = false;
            //echo "priimek false";
        }

        if (checkGeslo($geslo,$errors, $conn, $validation)) {
            $validation["geslo"] = true;
        } else {
            $validation["geslo"] = false;
            //echo "geslo false";
        }

        if (checkTel($tel,$errors,$conn,$validation)) {
            $validation["tel"] = true;
        } else {
            $validation["tel"] = false;
           // echo "tel false";
        }

        $checker = false;
        foreach ($validation as $key => $value) {
            if ($value === false) {
                $checker = false;
                break;
            }
            $checker = true;
        }


        if ($checker === true) {
            $sql = "INSERT INTO 
            Uporabnik(ime,priimek,ePosta,geslo,telefonska)
            VALUES('$ime','$priimek','$email','$geslo','$tel');";

            if (mysqli_query($conn,$sql)) {

                $sql2 = "SELECT uporabnikID FROM Uporabnik WHERE ePosta = '$email';";
                $result2 = mysqli_query($conn,$sql2);
               
                $data = mysqli_fetch_all($result2,MYSQLI_ASSOC);

                
                foreach ($data as $ids) {
                    foreach ($ids as $id) {
                        $_SESSION['id'] = $id;
                        Header("Location: domov.php");
                    }
                }

               // header("Location: domov.php");
            } else {
                echo "Query error: " . mysqli_error($conn);
            }
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../style/registracija.css" rel="stylesheet">     
    <title>Registracija</title>
</head>
<body>
    <div class="registracija">
        <div class="registracija-wrapper">
            <div class="left">
                <div class="left-content">
                    <h1 class="left-header">Pozdravljen!</h1>
                    <p class="left-content-para">Če še nimaš računa se registriraj,
                        če ne pa se prijavi.
                    </p>
                    <form style="display: flex; flex-direction: column; align-items: center;" action="prijava.php">
                        <button type="submit" class="prijava">prijava</button>
                    </form>  
                </div>
            </div>
            <div class="right">
                
                <div class="form-wrapper">
                    <h1 class="register-heading">Registriraj svoj račun</h1>
                    <form class="form" action="registracija.php" method="POST">
                       
                        <input type="text" name="ime" placeholder="ime" class="input" value="<?php echo $ime ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["ime"]) ?></p>
                        
                        <input type="text" name="priimek" placeholder="priimek" class="input" value="<?php echo $priimek ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["priimek"]) ?></p>

                        <input type="email" name="eposta" placeholder="E-racun" class="input" value="<?php echo $email ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["email"]) ?></p>

                        <input type="password" name="geslo" placeholder="geslo" class="input" value="<?php echo $geslo ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["geslo"]) ?></p>
                        
                        <input type="tel" name="tel" placeholder="telefonska št" class="input" value="<?php echo $tel ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["tel"]) ?></p>

                        <button type="submit" name="registracija" class="registracija-gumb">Registracija</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>