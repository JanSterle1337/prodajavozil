<?php

    session_start();
    if (isset($_SESSION["id"])) {
        unset($_SESSION["id"]);
    }

    if (isset($_SESSION["adminID"])) {
        unset($_SESSION["adminID"]);
    }
    require "../logic/prijava.php";

    $error = "";

    if (isset($_POST["prijava"])) {
        $email = mysqli_real_escape_string($conn,$_POST["eRacun"]);
        $geslo = mysqli_real_escape_string($conn,$_POST["geslo"]);

       if (checkLogin($email,$geslo,$conn, $error)) {
           /*echo "Bomo redirectal"; */
           header("Location: domov.php"); 
       } else {
           /*echo "ne bomo redirectal";*/
       }

    }
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/prijava.css">
    <title>Prijava</title>
</head>
<body>
    <div class="prijava-template-wrapper">
        <div class="box">
            <div class="left">
                <div class="login-wrapper">
                    <h1 class="login-header">Prijava v Prodajavozil.com</h1>
                      <p class="login-subheader">Vpiši svoj e-račun ter geslo</p>  
                      <form class="form" action="prijava.php" method="POST">

                          <input type="email"  name="eRacun" placeholder="e-pošta" class="input">
                          

                          <input type="password" name="geslo" placeholder="geslo" class="input">
                          <p class="error"><?php echo htmlspecialchars($error) ?></p>

                          <button type="submit" name="prijava" class="prijava">Prijava</button>

                      </form>
                </div>
            </div>
            <div class="right">
                <h1 class="hello">Pozdravljen!</h1>
                <p class="text">Če želiš uporabiti vse funkcionalnosti aplikacije,
                    se prosim prijavi ali pa naredi nov račun.</p>
                <form action="registracija.php">
                    <button type="submit" class="registracija">Registracija</button>
                </form>        

            </div>
        </div>      
    </div>
</body>
</html>