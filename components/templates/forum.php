<?php

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");


if (isset($_SESSION['id'])) {
    $id = mysqli_real_escape_string($conn,$_SESSION['id']);
    if (isset($_GET['temaID'])) {
        $temaID = mysqli_real_escape_string($conn,$_GET['temaID']);
        if (isset($_POST['add-komentar'])) {
            $komentar = mysqli_real_escape_string($conn,$_POST['komentar']);
            $isKomentarOk = checkKomentar($conn,$komentar);
            if ($isKomentarOk == true) {
                $isInserted = insertKomentar($conn,$komentar,$id,$temaID);
                if ($isInserted === true) {
                    Header("Location: forum.php?temaID=$temaID");
                } else {
                    echo "Error napakaaaaaaaaaaa";
                }
            }
        }
    }
} else {
    echo "Neprijavljen";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/forum.css">
    <title>PRODAJAVOZIL | FORUM</title>
</head>
<body>
  <?php require ("StranskiMeni.php"); ?>
    <main>
        <div class="forum-wrapper">

        <div class="nova-tema-wrapper">
            <?php 
                if (isset($_SESSION['id']) && !isset($_GET['temaID'])) {  ?>
                 <form action="novaTema.php" METHOD="POST">
                    <label for="novaTema">Ustvari novo temo</label>
                    <button type="submit" name="novaTema" class="nova-tema-gumb">Nova tema</button>
                 </form>  
           <?Php }  ?>
            
        </div>

        <div class="teme-wrapper">
        <?php if (!isset($_GET['temaID'])) { 
            echo "<div class='teme-wrapper'>";
                $allTeme = getAllTeme($conn);
                while ($row = mysqli_fetch_assoc($allTeme)) {
                    echo "<a href='forum.php?temaID=$row[temaID]'>";
                    echo "<div class='tema-wrapper'>
                            <p class='left'>$row[naslov]</p>
                            <p class='right'>$row[created_at]</p>
                          </div>";
                    echo "</a>"; 

                }
            echo "</div>";
                ?>
            <?php } else { 
                echo "<div class='tema-wrapper'>";
                $temaID = mysqli_real_escape_string($conn,$_GET['temaID']);

                $temaData = getSingleTema($conn,$temaID);

                if (!is_bool($temaData)) { 
                    while ($row = mysqli_fetch_assoc($temaData)) {
                        echo "<div class='tema'>";
                            echo "<div class='naslov'>";
                                echo "<div class='naslov'>";
                                    echo "<h1>" . $row['naslov'] . "</h1>";
                                    echo "<p>" . $row['razprava'];
                                echo "</div>";
                            echo "</div>";
                    }


                if (isset($_SESSION['id'])) {
                    ?>
                <div class='add-komentar-wrapper'>
                    <form class='add-komentar-form' action="forum.php?temaID=<?php echo htmlspecialchars($temaID); ?>" method="POST">
                        <div class="input-komentar">
                            <label for="komentar">Dodaj nov komenentar</label>
                            <textarea name='komentar'></textarea>
                        </div>
                        <div class='button-komentar'>
                            <button type="submit" name="add-komentar">Post</button>
                        </div>
                    </form>
                </div>

          <?php  }  ?>

                <div class="komentar-section-wrapper">
                    <?php 
                        $allKomentarji = allKomentarji($conn,$temaID);
                        
                        while ($row = mysqli_fetch_assoc($allKomentarji)) {
                            echo "<div class='komentar'>";
                                echo "<p>$row[opis]</p>";
                            echo "</div>";
                        }
                    
                    ?>
                </div>
        
       <?php     } ?>

               
                
                   
                </div>  <!--  od tema-wrapper -->
          <?php } ?>
        </div>
    </main>
</body>
</html>