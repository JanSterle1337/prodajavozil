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
            <div class="header-team-wrapper">
                <div class="nova-tema-wrapper">
                    <?php  //ce je uporabnik prijavljen in je nastavljen pogled na vse teme
                        if (isset($_SESSION['id']) && !isset($_GET['temaID'])) {  ?>
                        <form action="novaTema.php" METHOD="POST">
                            <label for="novaTema">Ustvari novo temo</label>
                            <button type="submit" name="novaTema" class="nova-tema-gumb">Nova tema</button>
                        </form>  
                <?Php }  ?>
                    
                </div>

                <div  class="search-tema-wrapper">
                    <form action="search.php" METHOD="POST" class="search-form-wrapper">
                    <div>
                        <input type="text" name="search-tema"/>
                    </div>
                    <div>
                        <button type="submit"  name="submit-search">Išči</button>
                    </div>
                    </form>
                        
                </div>
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
                                    echo "<p>" . "Temo ustvaril: " . $row['ime'] . " " . $row['priimek'] . "</p>";
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
                        
                        $nestedLvlStevec = 1; 
                       
                        while ($rowKomentar = mysqli_fetch_assoc($allKomentarji)) {
                            $komentarID = $rowKomentar['komentarID'];
                            $komentarOpis = $rowKomentar['opis'];
                            $komentarUstvarjen = $rowKomentar['created_at'];

                            $seconds = formatDate($komentarID,$conn);
                            echo "<pre>";
                            echo "Seconds: ";
                            var_dump($seconds);
                            echo "</pre>";

                            echo "<div>";
                                echo "<pre>";
                                var_dump($rowKomentar);
                                echo "</pre>";
                                echo "<div class='all-comment-wrapper'>";
                                    echo "<div class='comment-header-wrapper'>";
                                        echo "<div class='profile-pic-wrapper'>";
                                            if ($rowKomentar['profilkaID'] == NULL) {
                                                echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                            } else {
                                                echo "<img src='../../assets/profile$rowKomentar[uporabnikID].jpg' class='profile-picture'>";
                                            }
                                        echo "</div>";

                                        echo "<div class='person-data-wrapper'>";
                                            echo "<p class='first-last-name-para'>$rowKomentar[ime]  $rowKomentar[priimek]</p>";
                                            echo "<p class='date-para'></p>";
                                        echo "</div>";
                                    echo "</div>";

                                    echo "<div class='komentar-text-wrapper'>";

                                        echo "<div class='line-wrapper'>";
                                            echo "<div class='line'></div>";
                                        echo "</div>";

                                        echo "<div class='komentar' id='komentar$komentarID'>";
                                        echo "<p>$komentarOpis</p>";
                                            echo "<div style='display: flex;'>";
                                                echo "<button onclick=showReplies($komentarID,1)>";
                                                    echo "<svg stroke='currentColor' fill='currentColor' stroke-width='0' viewBox='0 0 24 24' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg'><path d='M12,9c-1.642,0-3,1.359-3,3c0,1.642,1.358,3,3,3c1.641,0,3-1.358,3-3C15,10.359,13.641,9,12,9z'></path><path d='M12,5c-7.633,0-9.927,6.617-9.948,6.684L1.946,12l0.105,0.316C2.073,12.383,4.367,19,12,19s9.927-6.617,9.948-6.684 L22.054,12l-0.105-0.316C21.927,11.617,19.633,5,12,5z M12,17c-5.351,0-7.424-3.846-7.926-5C4.578,10.842,6.652,7,12,7 c5.351,0,7.424,3.846,7.926,5C19.422,13.158,17.348,17,12,17z'></path></svg>";
                                                echo "</button>";
                                                echo "<form method='POST' action='../logic/reply.php'>";
                                                    echo "<input type='text' name='replyComment' placeholder='odgovori'/>";
                                                    echo "<input type='hidden' name='replyingTo' value='$komentarID'>";
                                                    echo "<button type='submit' name='posljiKomentar'>Odgovori</button>";
                                                echo "</form>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>"; //wrapper for the whole comment
                            echo "</div>";
                        }
                        
                           
                        ?>
       <?php     }  //!isbool($temaData) ?>      
            </div>  <!--  od tema-wrapper -->
          <?php } ?>
        </div>
    </main>
<script src="../../scripts/displayReplies.js">

    /*
    function showReplies(komenterID,nestedLvl) {

        let replyDivs = document.getElem
            console.log("showReplies");
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("reply" + komenterID).innerHTML = this.responseText;
                    console.log(this.responseText);
                } else {
                    console.log("Neki ne dela");
                }
            }
            xmlhttp.open("GET", "../logic/pridobiOdgovore.php?komentarID="+komenterID+"&nestedLvl="+nestedLvl,true);
            xmlhttp.send();
    } */
</script>
</body>
</html>