<?php

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");


$komentarValidation = array(
    "validated" => true,
    "message" => "",
);





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
                    $komentarValidation["validated"] = true;
                    $komentarValidation['message'] = "Komentar je bil uspešno dodan v temo.";
                   
                } else {
                    $komentarValidation['validated'] = false;
                    $komentarValidation["message"] = "Napaka pri vnosu komentarja.";
                  
                    
                }
            } else {
                $komentarValidation['validated'] = false;
                $komentarValidation["message"] = "Napaka pri vnosu komentarja.";
                
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

                        $komentar = true;

                        $temaID = $row['temaID'];

                        $seconds = formatDate($temaID,$conn,$komentar);
                        $timeArr = secondsToTime($seconds);
                        

                        echo "<div class='tema'>";
                            echo "<div class='tema-header-wrapper'>";

                                echo "<div class='tema-creator-wrapper'>";

                                    echo "<div class='profile-pic-wrapper'>";
                                    if ($row['profilkaID'] == NULL) {
                                        echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                    } else {
                                        echo "<img src='../../assets/profile$row[uporabnikID].jpg' class='profile-picture'>";
                                    }
                                    echo "</div>";

                                    echo "<div class='person-data-wrapper'>";
                                        echo "<p class='first-last-name-para'>" . $row['ime'] . " " . $row['priimek'] . "</p>";
                                        
                                            
                                    
                                        foreach ($timeArr as $timeDelimiter => $value) {
                                           
                                            if ($value > 0) {
                                                if ($value === 1) {
                                                    echo "<p class='date-para'>$value $timeDelimiter o nazaj</p>";
                                                    break;
                                                }
                                                else if ($value === 2) {
                                                    echo "<p class='date-para'>$value $timeDelimiter i nazaj</p>";
                                                    break;
                                                } else {
                                                    echo "<p class='date-para'>$value $timeDelimiter nazaj</p>";
                                                    break;
                                                }
                                                
                                            }
                                        }
                                    echo "</div>";

                                   

                                echo "</div>";

                                echo "<div class='naslov'>";
                                    echo "<div class='naslov'>";
                                        echo "<h1 class='naslov-para'>" . $row['naslov'] . "</h1>";
                                        echo "<p class='razprava'>" . $row['razprava'];
                                        
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                    }


                    if (isset($_SESSION['id'])) {
                        ?>
                    <div class='add-komentar-wrapper'>
                        <form class='add-komentar-form' action="forum.php?temaID=<?php echo htmlspecialchars($temaID); ?>" method="POST">
                            <div class="input-komentar">
                                <label for="komentar" class='add-komentar'>
                                    Dodaj nov komentar
                                </label>
                            </div>
                            <div class='input-button-komentar'>
                                <textarea class='input-komentar' name='komentar'></textarea>
                                <?php 
                                    if ($komentarValidation['validated'] === true) {
                                        echo "<p class='ok'>" . htmlspecialchars($komentarValidation['message']) . "</p>";
                                    } else {
                                        echo "<p class='notOk'>" . htmlspecialchars($komentarValidation['message']) . "</p>";
                                    }
                                ?>
                                <button type="submit" name="add-komentar" class='objavi-komentar'>Objavi</button>
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

                            $countedReplies = numberOfReplys($conn,$komentarID,$nestedLvlStevec);
                            $numberOfReplies = mysqli_fetch_all($countedReplies,MYSQLI_ASSOC);

                            if (isset($numberOfReplies[0]['stReplyov'])) {
                                $replyNumber = $numberOfReplies[0]['stReplyov'];
                            } else {
                                $replyNumber = 0;
                            }


                            $komentar = true;

                            $seconds = formatDate($komentarID,$conn,$komentar);
                            /*echo "<pre>";
                            echo "Seconds: ";
                            var_dump($seconds); */
                            $timeArr = secondsToTime($seconds);
                           /* echo "</pre>"; */

                            echo "<div>";
                               /* echo "<pre>";
                                var_dump($rowKomentar);
                                echo "</pre>"; */
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
/*
                                            if ($komentarOpis == "nekineki") {
                                                echo "<pre>";
                                                var_dump($timeArr);
                                                echo "</pre>";
                                            }
                                            echo "</br></br></br>";
*/
                                            if (is_int($timeArr) && $timeArr === 0) {
                                                echo "<p class='date-para'>1 sekundo nazaj</p>";
                                            } else {
                                                foreach ($timeArr as $timeDelimiter => $value) {
                                                    if ($value > 0) {
                                                        if ($value === 1) {
                                                            echo "<p class='date-para'>$value $timeDelimiter o nazaj</p>";
                                                            break;
                                                        }
                                                        else if ($value === 2) {
                                                            echo "<p class='date-para'>$value $timeDelimiter i nazaj</p>";
                                                            break;
                                                        } else {
                                                            echo "<p class='date-para'>$value $timeDelimiter nazaj</p>";
                                                            break;
                                                        }
                                                        
                                                    }
                                                }
                                            }


                                            

                                            
                                        echo "</div>";
                                    echo "</div>";

                                    echo "<div class='komentar-text-wrapper'>";

                                        echo "<div class='line-wrapper'>";
                                            echo "<div class='line'></div>";
                                        echo "</div>";

                                        echo "<div class='komentar' id='komentar$komentarID'>";
                                        echo "<p class='komentar-para'>$komentarOpis</p>";
                                            echo "<div style='display: flex;'>";
                                            if ($replyNumber > 0) {
                                                echo "<button onclick=showReplies($komentarID,1)>"; ?>
                                                     <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="17" r="1.3"></circle><path d="M18 4c-2.206 0-4 1.794-4 4v3h-4v-1h-3c-1.104 0-2 .896-2 2v7c0 1.104.896 2 2 2h10c1.104 0 2-.896 2-2v-7c0-1.104-.896-2-2-2h-1v-2c0-1.104.896-2 2-2s2 .896 2 2v3c0 .552.448 1 1 1s1-.448 1-1v-3c0-2.206-1.794-4-4-4zm-1 15h-10v-7h10.003l-.003 7z"></path></svg>
                                        <?php        echo "</button>";
                                            }
                                                
                                                   
                                                    
                                                echo "<form method='POST' action='../templates/reply.php'>";
                                                    
                                                    echo "<input type='hidden' name='replyingTo' value='$komentarID'>";
                                                    echo "<input type='hidden' name='replyingToTema' value='$temaID'>";
                                                    echo "<button type='submit' name='posljiKomentar'>"; ?>
                                                    
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                                        <?php       echo "</button>"; 
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