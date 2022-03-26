<?php 
require ("../logic/registracija.php");
session_start();
$uporabnisko_ime = "";
$geslo = "";
$email = "";

    if (isset($_POST['registracija'])) {

        $uporabnisko_ime = mysqli_real_escape_string($conn,$_POST['username']);
        $email = mysqli_real_escape_string($conn,$_POST["eposta"]);
        $geslo = mysqli_real_escape_string($conn,$_POST['geslo']);

        if (checkIme($uporabnisko_ime,$errors,$conn,$validation)) {
            $validation["ime"] = true;
        } else {
            $validation["ime"] = false;
            echo "ime false";
        }

        if (checkGeslo($geslo,$errors, $conn, $validation)) {
            $validation["geslo"] = true;
        } else {
            $validation["geslo"] = false;
            echo "geslo false";
        }

        if (checkEmail($email,$errors,$conn,$validation)) {
            $validation["email"] = true;
        } else {
            $validation["email"] = false;
            echo "email false";
        }


        if ($validation['ime'] === true && $validation['geslo'] === true && $validation['email'] === true) {
            $sql = "INSERT INTO 
            `admin`(uporabnisko_ime,ePosta,geslo)
            VALUES('$uporabnisko_ime','$email','$geslo');";

            if (mysqli_query($conn,$sql)) {

                $last_id = mysqli_insert_id($conn);

                $_SESSION['adminID'] = $last_id;
                
                Header("Location: dashboard.php");

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
                    <form style="display: flex; flex-direction: column; align-items: center;">
                        <button type="submit" class="prijava">prijava</button>
                    </form>  
                </div>
            </div>
            <div class="right">
                
                <div class="form-wrapper">
                    <h1 class="register-heading">Registriraj svoj račun</h1>
                    <form class="form" action="registracija.php" method="POST">
                       
                        <input type="text" name="username" placeholder="username" class="input" value="<?php echo $uporabnisko_ime ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["ime"]) ?></p>

                        <input type="email" name="eposta" placeholder="E-racun" class="input" value="<?php echo $email ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["email"]) ?></p>
                        

                        <input type="password" name="geslo" placeholder="geslo" class="input" value="<?php echo $geslo ?>">
                        <p class="error"><?php echo htmlspecialchars($errors["geslo"]) ?></p>
                        
                       
                        <button type="submit" name="registracija" class="registracija-gumb">Registracija</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>