<?php

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");


if (isset($_SESSION['id'])) {
    echo "prijavljen";
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
                if (isset($_SESSION['id'])) {  ?>
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
            <?php } else { ?>
                <div class="tema-wrapper">
                    <div class="tema">
                        <div class="naslov"></div>
                    </div>
                </div>

          <?php } ?>
        </div>
    </main>
</body>
</html>