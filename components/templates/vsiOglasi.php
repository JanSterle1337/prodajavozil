<?php 

session_start();
require ("../../config/db_connect.php");
require ("../logic/oglas.php");

?>
<?php

if (isset($_GET['prodajalecID'])) {
    $sellerID = mysqli_real_escape_string($conn,$_GET['prodajalecID']); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/vsiOglasi.css">
    <title>Oglasi</title>
</head>
<body>
    <?php require("StranskiMeni.php"); ?>    
    <main>
        <div class="oglasi-wrapper">
            
        
            <?php 
                
                $allUserOglasiResult = allSellerOglasi($conn,$sellerID);
                if (mysqli_num_rows($allUserOglasiResult) == 0) {
                    echo "<p>Ta prodajalec nima objavljenih nobenih oglasov</p>";
                } else {
                   echo  "<div class='oglas-wrapper'>";
                    while ($row =  mysqli_fetch_assoc($allUserOglasiResult)) { ?>
                       
                            <a href="oglas.php?id=<?php echo $row["oglasID"] ?>">
                            <div class="oglas">
                                <img class="advert-photo" src="../../storage/<?php echo htmlspecialchars($row["imeSlike"]) ?>"> 
                                <p class="cena"><?php echo htmlspecialchars($row["cena"] . " €"); ?></p>
                                <p class="ime-oglasa"><?php echo htmlspecialchars($row["znamka"] . " " . $row["model"])  ?></p>
                            </div>
                            </a>
                        
        <?php       } 
                  echo "</div>";
                }
            ?>
        </div>
    </main>

    
</body>
</html>


<?php }  else {?>
    
<?php } ?>

