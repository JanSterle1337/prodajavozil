<?php

session_start();
require ("../../config/db_connect.php");
require ("../logic/forum.php");


$komentarValidation = array(
    "validated" => true,
    "message" => "",
);





if (isset($_SESSION['id'])) {

    $uporabnikID = $_SESSION['id'];

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
            
                <div class='close-wrapper'>

                <?php

                if (!isset($temaID)) {  ?>
                    <a href="forum.php" class='middle-center'>
                        <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                    </a>
                <?php      } else { ?>
                    <a class='middle-center' href="forum.php">
                        <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                    </a>
                <?php      }?>



                </div>       
            </div>


            <?php  //ce je uporabnik prijavljen in je nastavljen pogled na vse teme
                        if (isset($_SESSION['id']) && !isset($_GET['temaID'])) {  ?>
                <div class="nova-tema-form-wrapper">
                        <form action="novaTema.php" METHOD="POST">
                            
                            <button class='objavi-komentar' type="submit" name="novaTema" class="nova-tema-gumb">Nova tema</button>
                        </form> 
                </div> 
                <?Php } ?>

                

            <div class="teme-wrapper">
        <?php if (!isset($_GET['temaID'])) { 
            echo "<div class='teme'>";
                $allTeme = getAllTeme($conn);
                while ($row = mysqli_fetch_assoc($allTeme)) {
                    echo "<a class='naslov-datum' href='forum.php?temaID=$row[temaID]'>";
                    echo "<div class='tema-wrapper'>";
                        echo "<p class='left bold'>$row[naslov]</p>";

                        $komentar = "temaUstvarjena";

                        $temaID = $row['temaID'];

                        $seconds = formatDate($temaID,$conn,$komentar);
                        $timeArr = secondsToTime($seconds);


                        foreach ($timeArr as $timeDelimiter => $value) {
                                           
                            if ($value > 0) {
                                if ($value === 1) {
                                    echo "<p class='right centered'>$value $timeDelimiter o nazaj</p>";
                                    break;
                                }
                                else if ($value === 2) {
                                    echo "<p class='right centered'>$value $timeDelimiter i nazaj</p>";
                                    break;
                                } else {
                                    echo "<p class='right centered'>$value $timeDelimiter nazaj</p>";
                                    break;
                                }
                                
                            }
                        }

                    
                        echo "</a>"; 

                       
                        if (isset($uporabnikID)) {
                            echo "<div class='right-right'>";
                            if ($row['uporabnikID'] === $uporabnikID) { ?>
                            <a href='posodobiTemo.php?temaID=<?php echo htmlspecialchars($temaID) ?>' class='posodobi-temo-link'>
                                <svg class='update-icon' stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zM16.045 4.401l1.587 1.585-1.59 1.584-1.586-1.585L16.045 4.401zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zM4 20H20V22H4z"></path></svg>
                            </a>

                            <a href='izbrisiTemo.php' class='posodobi-temo-link'>
                                <svg class='delete-icon' stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                            </a>
            <?php           }
                            echo "</div>";
                        }?>

          
                        

     <?php              


                        //echo "<p class='right'>$row[created_at]</p>";
                      echo "</div>";
                    

                }
            echo "</div>";
                ?>
            <?php } else { 
                echo "<div class='tema-wrapper'>";
                $temaID = mysqli_real_escape_string($conn,$_GET['temaID']);

                $temaData = getSingleTema($conn,$temaID);

                if (!is_bool($temaData)) { 
                    while ($row = mysqli_fetch_assoc($temaData)) {

                        $komentar = "temaUstvarjena";

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