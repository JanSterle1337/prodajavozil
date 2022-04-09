<?Php 

session_start();
require("../../config/db_connect.php");
require("../logic/reply.php");
require("../logic/forum.php");



$komentarValidation = array(
    "validated" => true,
    "message" => "",
);





if (isset($_SESSION['id'])) {
    $uporabnikID = mysqli_real_escape_string($conn,$_SESSION['id']);
    //echo "Sem prijavlen in poskusam replyat";

    if (isset($_POST['replyingTo']) && isset($_POST['replyingToTema'])) {
        $komentarID = mysqli_real_escape_string($conn,$_POST['replyingTo']);
        $temaID = mysqli_real_escape_string($conn,$_POST['replyingToTema']);
        $repliedComment = retrieveComment($conn,$temaID,$komentarID);
        $myData = retrieveMyData($conn,$uporabnikID);

        
        
    } else {
        /*Header("Location: forum.php"); */
    }


    if (isset($_POST['neki']) && isset($_POST['nested']) && isset($_POST['replyingToReplyID'])) {
        $nestedLvl = mysqli_real_escape_string($conn,$_POST['nested']);
        $replyID = mysqli_real_escape_string($conn,$_POST['replyingToReplyID']);
        $repliedReply = retrieveReply($conn,$nestedLvl,$replyID);
        
        

        $myReplyData = retrieveMyData($conn,$uporabnikID);
        /*
        echo "<pre>";
        echo "Ta stevlika jeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee: NEKI" . $_POST['neki'] . "</br>";
        echo "Nested level jeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee NESTED: " . $_POST['nested'] . "</br>";
        echo "Replying to idddddddddddddddddddddddddddddddddddd replying:" . $_POST['replyingToReplyID'] . "</br>"; 
        echo "</pre>"; */
    }

    

    
} else {
    //echo "Nisem prijavlen in poskusam replyat";
    Header("Location: ../templates/prijava.php");
}



if (isset($_POST['tema']) && isset($_POST['replyingToKomentar'])) {
    $temaID = mysqli_real_escape_string($conn,$_POST['tema']);
    $komentarID = mysqli_real_escape_string($conn,$_POST['replyingToKomentar']);

    if (isset($_POST['ustvariReply'])) {
        $reply = mysqli_real_escape_string($conn,$_POST['reply-input']);
        $komentarID = mysqli_real_escape_string($conn,$_POST['replyingToKomentar']);
        $isOk = checkKomentar($conn,$reply);
        if ($isOk == true) {
            $isInserted = insertReply($conn,$komentarID,$reply,$uporabnikID);
            if ($isInserted === true) {
                $komentarValidation["validated"] = true;
                $komentarValidation['message'] = "Komentar je bil uspešno dodan v temo.";
                Header("Location: forum.php?temaID=$temaID"); 
              
            
            } else {

                $komentarValidation['validated'] = false;
                $komentarValidation["message"] = $isInserted;
            
                
            }
        } else {
            $komentarValidation['validated'] = false;
            $komentarValidation["message"] = "Napaka pri vnosu komentarja."; 
        }
    }


    
}


if (isset($_POST['ustvariReplyReply'])) {
    $komentarID = mysqli_real_escape_string($conn,$_POST['komentar']);
    
    $odgovorjenID = mysqli_real_escape_string($conn,$_POST['replyingToReply']);
    $nestedLvl = mysqli_real_escape_string($conn,$_POST['nested']);
    $replyText = mysqli_real_escape_string($conn,$_POST['reply-reply-input']);

    $isOk = checkKomentar($conn,$replyText);

    $temaData = getTema($conn,$komentarID);
    $temaRow = mysqli_fetch_all($temaData,MYSQLI_ASSOC);
    $temaID = $temaRow[0]['temaID'];

    if ($isOk === true) {
        $isInserted = insertReplyReply($conn,$komentarID,$odgovorjenID,$nestedLvl,$replyText,$uporabnikID);

        if ($isInserted === true) {
            $komentarValidation["validated"] = true;
            $komentarValidation['message'] = "Komentar je bil uspešno dodan v temo.";
            Header("Location: forum.php?temaID=$temaID"); 
        } else {
            $komentarValidation['message'] ="Napaka pri vnosu odgovora";
            $komentarValidation['validated'] = false;
            
        }
    } else {
        
        $komentarValidation['message'] ="Napaka pri vnosu odgovora";
        $komentarValidation['validated'] = false;
    }

    
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
    <?Php 
        require ("../templates/StranskiMeni.php");
    ?>
        <main>
            <div class='reply-page-wrapper'>

                <div class='close-wrapper'>

                    <?php

                    if (!isset($temaID)) {  ?>
                        <a href="forum.php" class='middle-center'>
                            <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                        </a>
         <?php      } else { ?>
                        <a class='middle-center' href="forum.php?temaID=<?Php echo htmlspecialchars($temaID); ?>">
                            <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                        </a>
         <?php      }?>

                    
                    
                </div>


                <div class='main-page-content'>
            <?php
                if (isset($repliedComment)) {

                
                    if (is_bool($repliedComment)) {
                        echo "To je bool";
                    } else {
                        $data = mysqli_fetch_all($repliedComment,MYSQLI_ASSOC); 
                        $rowKomentar = $data[0];

                        $myInfo = mysqli_fetch_all($myData,MYSQLI_ASSOC);
                        $rowInfo = $myInfo[0];

                        $komentarOpis = $rowKomentar['opis'];
                        
                        $komentar = true;

                        $seconds = formatDate($komentarID,$conn,$komentar);
                            /*echo "<pre>";
                            echo "Seconds: ";
                            var_dump($seconds); */
                        $timeArr = secondsToTime($seconds);


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
                                            echo "<div class='line line-bottom'></div>";
                                        echo "</div>";
                                        
                                        echo "<div>";
                                            echo "<div class='komentar omejitev-visine' id='komentar$komentarID'>";
                                                echo "<p class='komentar-para'>$komentarOpis</p>";
                                            echo "</div>";
                                            echo "<div class='nested'>";
                                                echo "<div class='comment-header-wrapper'>";
                                                    echo "<div class='profile-pic-wrapper'>";
                                                        if ($rowInfo['profilkaID'] == NULL) {
                                                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                                        } else {
                                                            echo "<img src='../../assets/profile$rowInfo[uporabnikID].jpg' class='profile-picture'>";
                                                        }
                                                       
                                                    echo "</div>";

                                                    echo "<div class='person-data-wrapper'>";
                                                        echo "<p class='first-last-name-para'>$rowInfo[ime]  $rowInfo[priimek]</p>";
                                                    echo "</div>";

                                                    
                                                    

                                                echo "</div>";

                                                echo "<div class='komentar-text-wrapper'>";
                                                    echo "<div class='line-wrapper'>";
                                                        echo "<div class='line line-bottom'></div>";
                                                    echo "</div>";
                                                    echo "<div class='add-reply'>"; ?>
                                                        <form action='reply.php' method='POST' class='column-direction'>
                                                            <input type='hidden' name='tema' value="<?php echo htmlspecialchars($temaID) ?>">
                                                            <input type='hidden' name='replyingToKomentar' value="<?php echo htmlspecialchars($komentarID) ?>">
                                                            <textarea class='input-komentar vnos-replya' name='reply-input'></textarea>
                                                            <?php
                                                            if ($komentarValidation['validated'] === false) { ?>
                                                                <p class='notOk'><?php echo htmlspecialchars($komentarValidation['message']) ?></p>
                                                       <?php   }?>


                                                            
                                                            <button class='objavi-komentar' type="submit" name='ustvariReply'>Objavi</button>
                                                        </form>
                                                <?Php    echo "</div>";
                                                echo "</div>";


                                            echo "</div>";
                                        echo "</div>";

                                    echo "</div>";
                        echo "</div>";
                    }} else if (isset($repliedReply)) {

                        if (is_bool($repliedReply)) {
                            echo "To je bool reply";
                        } else {
                            $data = mysqli_fetch_all($repliedReply,MYSQLI_ASSOC); 
                            /*
                            echo "<pre>";
                            var_dump($data);
                            echo "</pre>"; */
                            $rowReply = $data[0];
                            $komentarID = $rowReply['komentarID'];
    
                            $myInfo = mysqli_fetch_all($myReplyData,MYSQLI_ASSOC);
                            $rowInfo = $myInfo[0];
    
                            $replyOpis = $rowReply['opis'];
    
                            $komentar = false;
    
                            $seconds = formatDate($replyID,$conn,$komentar);
                                /*echo "<pre>";
                                echo "Seconds: ";
                                var_dump($seconds); */
                            $timeArr = secondsToTime($seconds);
    
    
                            echo "<div class='comment-header-wrapper'>";
                                            echo "<div class='profile-pic-wrapper'>";
                                                if ($rowReply['profilkaID'] == NULL) {
                                                    echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                                } else {
                                                    echo "<img src='../../assets/profile$rowReply[uporabnikID].jpg' class='profile-picture'>";
                                                }
                                            echo "</div>";
    
                                            echo "<div class='person-data-wrapper'>";
                                                echo "<p class='first-last-name-para'>$rowReply[ime]  $rowReply[priimek]</p>";
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
                                                echo "<div class='line line-bottom'></div>";
                                            echo "</div>";
                                            
                                            echo "<div>";
                                                echo "<div class='komentar omejitev-visine' id='komentar$replyID'>";
                                                    echo "<p class='komentar-para'>$replyOpis</p>";
                                                echo "</div>";
                                                echo "<div class='nested'>";
                                                    echo "<div class='comment-header-wrapper'>";
                                                        echo "<div class='profile-pic-wrapper'>";
                                                            if ($rowInfo['profilkaID'] == NULL) {
                                                                echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                                            } else {
                                                                echo "<img src='../../assets/profile$rowInfo[uporabnikID].jpg' class='profile-picture'>";
                                                            }
                                                           
                                                        echo "</div>";
    
                                                        echo "<div class='person-data-wrapper'>";
                                                            echo "<p class='first-last-name-para'>$rowInfo[ime]  $rowInfo[priimek]</p>";
                                                        echo "</div>";
    
                                                        
                                                        
    
                                                    echo "</div>";
    
                                                    echo "<div class='komentar-text-wrapper'>";
                                                        echo "<div class='line-wrapper'>";
                                                            echo "<div class='line line-bottom'></div>";
                                                        echo "</div>";
                                                        echo "<div class='add-reply'>"; ?>
                                                            <form action='reply.php' method='POST' class='column-direction'>
                                                                <input type='hidden' name='komentar' value="<?php echo htmlspecialchars($komentarID) ?>">
                                                                <input type='hidden' name='tema' value="<?php echo htmlspecialchars($temaID) ?>">
                                                                <input type='hidden' name='replyingToReply' value="<?php echo htmlspecialchars($replyID) ?>">
                                                                <input type='hidden' name='nested' value="<?php echo htmlspecialchars($nestedLvl); ?>">
                                                                <textarea class='input-komentar vnos-replya' name='reply-reply-input'></textarea>
                                                        <?php   if ($komentarValidation['validated'] === false) { ?>
                                                                <p class='notOk'><?php echo htmlspecialchars($komentarValidation['message']) ?></p>
                                                       <?php   }?>
                                                                
                                                                <button class='objavi-komentar' type="submit" name='ustvariReplyReply'>Objavi</button>
                                                            </form>
                                                    <?Php    echo "</div>";
                                                    echo "</div>";
    
    
                                                echo "</div>";
                                            echo "</div>";
    
                                        echo "</div>";
                            echo "</div>";
                        }

                    } else if ($komentarValidation['validated'] === false) {
                        echo "<p>Napaka pri vnosu odgovora</p>";
                    }
             ?></div>
            </div>
        </main>
</body>
</html>