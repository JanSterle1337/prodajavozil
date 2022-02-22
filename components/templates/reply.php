<?Php 

session_start();
require("../../config/db_connect.php");
require("../logic/reply.php");
require("../logic/forum.php");



$komentarValidation = array(
    "validated" => true,
    "message" => "",
);


if (isset($_POST['neki'])) {
    echo "<pre>";
    echo "Ta stevlika jeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee: " . $_POST['neki'];
}


if (isset($_SESSION['id'])) {
    $uporabnikID = mysqli_real_escape_string($conn,$_SESSION['id']);
    echo "Sem prijavlen in poskusam replyat";

    if (isset($_POST['replyingTo']) && isset($_POST['replyingToTema'])) {
        $komentarID = mysqli_real_escape_string($conn,$_POST['replyingTo']);
        $temaID = mysqli_real_escape_string($conn,$_POST['replyingToTema']);
        $repliedComment = retrieveComment($conn,$temaID,$komentarID);
        $myData = retrieveMyData($conn,$uporabnikID);

        
        
    } else {
        /*Header("Location: forum.php"); */
    }

    

    
} else {
    echo "Nisem prijavlen in poskusam replyat";
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
               echo "Tema idddddddddddddddddddddddddddd: $temaID";
            
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
                                                        <form action='reply.php' method='POST'>
                                                            <input type='hidden' name='tema' value="<?php echo htmlspecialchars($temaID) ?>">
                                                            <input type='hidden' name='replyingToKomentar' value="<?php echo htmlspecialchars($komentarID) ?>">
                                                            <textarea class='input-komentar' name='reply-input'></textarea>
                                                            <p></p>
                                                            <button class='objavi-komentar' type="submit" name='ustvariReply'>Objavi</button>
                                                        </form>
                                                <?Php    echo "</div>";
                                                echo "</div>";


                                            echo "</div>";
                                        echo "</div>";

                                    echo "</div>";
                        echo "</div>";
                    }}  
             ?>
            </div>
        </main>
</body>
</html>