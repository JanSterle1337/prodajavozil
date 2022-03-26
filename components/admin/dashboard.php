<?php 

session_start();
require ("../../config/db_connect.php");
require ("poizvedbe.php");

/*echo "<pre style='margin-left: 100px;'>";
var_dump($_SESSION['adminID']);
echo "</pre>"; */

if (isset($_SESSION['adminID'])) { 
        if (isset($_POST['ban'])) {
            
            $uporabnikID = $_POST["uporabnik"];
           
            
            $isData = checkForAlreadyBan($conn,$uporabnikID);

           /* echo "<pre style='margin-left: 100px;'>";
                echo "isData: " . "</br>";
                var_dump($isData);
            echo "</pre>"; */

            if (is_bool($isData)) {
                $isInserted = insertAndBan($conn,$uporabnikID);
                /*echo "<pre style='margin-left: 100px;'>";
                var_dump($isInserted);
                echo "</pre>"; */
            }
            else {
                $isUpdated = updateAndBan($conn,$uporabnikID);
                /*echo "<pre style='margin-left: 100px;'>";
                var_dump($isUpdated);
                echo "</pre>"; */
            }

            /*echo "<pre style='margin-left: 100px;'>";
            var_dump($isData);
            echo "</pre>"; */
        }


        if (isset($_POST['unban'])) {
            $uporabnikID = $_POST["uporabnik"];
            $isData = checkForAlreadyBan($conn,$uporabnikID);

            if (!is_bool($isData)) {
                $isUpdated = updateAndUnban($conn,$uporabnikID);
            }
        }

        if (isset($_POST['odstraniOglas'])) {
            $oglasID = $_POST['oglasID'];
            $isNeki = isAlreadyOdstranjen($conn,$oglasID);
            if ($isNeki === false) {

                insertAndOdstrani($conn,$oglasID);
                /*echo "Nekiiiiiiiiiiiiiiiiiiiiiiii " . "jaoooo"; */
            }
           
        }

        if (isset($_POST['dodajOglas'])) {
            $oglasID = $_POST['oglasID'];
            deleteAndOdstrani($conn,$oglasID);

            
        }

} else {
    Header("Location: ../templates/prijava.php");
}


$allUsersResult = getAllUsers($conn);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | PANEL</title>
    <link type="text/css" rel="stylesheet" href="../../style/dashboard.css">
</head>
<body>
    <?php require("Sidebar.php"); ?>

    <main>
        <div class='whole-page-wrapper'>
            <h1 class="heading">Odstrani uporabnike</h1>
            <div class='users-wrapper'>

                <table class="table">
                    <tr>
                        <td>ID</td>
                        <td>ime</td>
                        <td>priimek</td>
                        <td>račun ustvarjen</td>
                        <td>stanje</td>
                    </tr>
                <?php 

                while ($rowUporabnik = mysqli_fetch_assoc($allUsersResult)) {
                    echo "<tr>";
                    
                        echo "<td>$rowUporabnik[uporabnikID]</td>";
                        echo "<td>$rowUporabnik[ime]</td>";
                        echo "<td>$rowUporabnik[priimek]</td>";
                        echo "<td>$rowUporabnik[created_at]</td>";
                        echo "<td>";
                            echo "<form action='dashboard.php' METHOD='POST'>"; ?>
                                <input type='hidden' name='uporabnik' value="<?php echo $rowUporabnik['uporabnikID']; ?>">
                               
                         <?php  
                                 $isData = checkIsBanned($conn,$rowUporabnik['uporabnikID']);
                         
                                 if ($isData === true) {
                                    echo "<button class='dodaj-button smaller' type='submit' name='unban'>Unban</button>";
                                 } else {
                                    echo "<button class='odstrani-button smaller' type='submit' name='ban'>Ban</button>";
                                 }

                               
                            echo "</form>";
                        echo "</td>";
                    echo "<tr>";
                }

                ?>
                </table>
            </div>


            <div>
                <h1 class="heading">Vsi oglasi</h1>
            </div>

            <div class="oglasi-wrapper">
                <div class="oglas-wrapper">
                <?php
                    $resultOglas = getAllOglasi($conn);

                        while ($rowOglas = mysqli_fetch_assoc($resultOglas)) { ?>
                        <a class="a-oglas" href="../templates/oglas.php?id=<?php echo $rowOglas["oglasID"] ?>">
                            <div class="oglas">
                                <img class="advert-photo" src="../../storage/<?php echo htmlspecialchars($rowOglas["imeSlike"]) ?>"> 
                                <div class="flex-row space-around">
                                    <div class="flex-column">
                                        <p class="cena"><?php echo htmlspecialchars($rowOglas["cena"] . " €"); ?></p>
                                        <p class="ime-oglasa"><?php echo htmlspecialchars($rowOglas["znamka"] . " " . $rowOglas["model"])  ?></p>
                                    </div>
                                    <form class="flex-column vertical-center" method="POST" action="dashboard.php">
                                        <input type="hidden" name="oglasID" value="<?php echo $rowOglas['oglasID']; ?>"/>
                                        <button class="odstrani-button" type="submit" name="odstraniOglas">Odstrani oglas</button>
                                    </form>
                                </div>
                            </div>
                        </a>
            <?php   }   ?>
                </div>
            </div>


            <div>
                <h1 class="heading">Odstranjeni oglasi</h1>
                
            </div>

            <div class="oglasi-wrapper">
                <div class="oglas-wrapper">
                <?php
                    $resultOdstranjen = getOdstranjeniOglasi($conn);

                    $stOdstranjenih = mysqli_num_rows($resultOdstranjen);
                   /* echo "Odstranjeni: " . $stOdstranjenih . "</br>"; */

                   if ($stOdstranjenih > 0) {

                   

                        while ($rowOdstranjen = mysqli_fetch_assoc($resultOdstranjen)) { ?>
                        <a class="a-oglas" href="../templates/oglas.php?id=<?php echo $rowOdstranjen["oglasID"] ?>">
                            <div class="oglas">
                                <img class="advert-photo" src="../../storage/<?php echo htmlspecialchars($rowOdstranjen["imeSlike"]) ?>"> 
                                <div class="flex-row space-around">
                                    <div class="flex-column">
                                        <p class="cena"><?php echo htmlspecialchars($rowOdstranjen["cena"] . " €"); ?></p>
                                        <p class="ime-oglasa"><?php echo htmlspecialchars($rowOdstranjen["znamka"] . " " . $rowOdstranjen["model"])  ?></p>
                                    </div>
                                    <form class="flex-column vertical-center"  method="POST" action="dashboard.php">
                                        <input type="hidden" name="oglasID" value="<?php echo $rowOdstranjen['oglasID']; ?>"/>
                                        <button class="dodaj-button" type="submit" name="dodajOglas">Dodaj oglas</button>
                                    </form>
                                </div>
                            </div>
                        </a>
            <?php   }} else {
                echo "<p>Noben oglas ni odstranjen</p>";
            }   ?>
                </div>
            </div>

        </div>
    </main>

    
</body>
</html>