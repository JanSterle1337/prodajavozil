<?php
require ("../../config/db_connect.php");
require ("../logic/forum.php"); ?>
<head>
<link type='text/css' rel='stylesheet' href='../../style/forum.css'>
</head>

<?php
if (isset($_GET["komentarID"]) && isset($_GET['nestedLvl']) && isset($_GET["odgovorjenID"])) {
    $komentarID = mysqli_real_escape_string($conn,$_GET["komentarID"]);
    $nestedLvl = mysqli_real_escape_string($conn,$_GET['nestedLvl']);
    $odgovorjenID = mysqli_real_escape_string($conn,$_GET['odgovorjenID']);

    $result = retrieveReplyReplys($conn,$komentarID,$odgovorjenID,$nestedLvl);
    $nestedLvl++;
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $replyID = $rows["odgovorID"];
            $profilka = $rows['profilkaID'];
            
            $countedReplies = numberOfReplyReplies($conn,$komentarID,$replyID,$nestedLvl);
            
            $numberOfReplies = mysqli_fetch_all($countedReplies,MYSQLI_ASSOC);
          
/*
            echo "<pre>";
            var_dump($numberOfReplies);
            echo "</pre>"; 
*/
            if (isset($numberOfReplies[0]['stReplyov'])) {
                $replyNumber = $numberOfReplies[0]['stReplyov'];
            } else {
                $replyNumber = 0;
            }
            


            $reply = false;

            $seconds = formatDate($replyID,$conn,$reply);
           /* echo "<pre>";
            echo "Seconds: ";
            var_dump($seconds); */
            $timeArr = secondsToTime($seconds);
            /*echo "</pre>"; */
            /*echo "<pre>";
            echo "NUMBER OF REPLYS: </BR>";
            var_dump($numberOfReplies);
            echo "</pre>"; */
            echo "<div class='reply' id='reply$replyID'>";
                echo "<div class='comment-header-wrapper'>";
                    echo "<div class='profile-pic-wrapper'>";
                        if ($profilka == NULL) {
                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                        } else {
                            echo "<img src='../../assets/profile$rows[uporabnikID].jpg' class='profile-picture'>";
                        }
                    echo "</div>";

                    echo "<div class='person-data-wrapper'>";
                        echo "<p class='first-last-name-para'>$rows[ime] $rows[priimek]</p>";
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
                echo "<div class='komentar-text-wrapper'>";
                    echo "<div class='line-wrapper'>";
                        echo "<div class='line'></div>";
                    echo "</div>";

                    echo "<div class='reply-and-buttons-wrapper$replyID'>";
                        echo "<div>";
                            echo "<p class='komentar-para'>$rows[reply]</p>";
                        echo "</div>";
                        if ($replyNumber > 0) {  
                            //echo "There are some replies over here!!! </br>"; ?>
                            <div style="display: flex; margin-left: 20px;">
                                <button class='replying-button' style=" margin-bottom: 30px;" onclick="showReplyReplies(<?php echo htmlspecialchars($komentarID); echo ','; echo  htmlspecialchars($nestedLvl); echo ','; echo  htmlspecialchars($rows['odgovorID']); ?>)">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="17" r="1.3"></circle><path d="M18 4c-2.206 0-4 1.794-4 4v3h-4v-1h-3c-1.104 0-2 .896-2 2v7c0 1.104.896 2 2 2h10c1.104 0 2-.896 2-2v-7c0-1.104-.896-2-2-2h-1v-2c0-1.104.896-2 2-2s2 .896 2 2v3c0 .552.448 1 1 1s1-.448 1-1v-3c0-2.206-1.794-4-4-4zm-1 15h-10v-7h10.003l-.003 7z"></path></svg>
                                </button>
                                <form method="POST" action='../templates/reply.php'> 
                                    <input type='hidden' name="replyingToReplyID" value="<?php echo htmlspecialchars($replyID); ?>">

                                    <input type='hidden' name='neki' value="1">
                                    <input type='hidden' name='nested' value="<?php echo htmlspecialchars($nestedLvl) ?>">

                                    <button class='replying-button' type="submit" name="replyingToReply">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                                    </button>
                                </form>
                            </div>
            <?php       } else { ?>
                            <div style="display: flex; margin-left: 20px;">
                            <form method="POST" action='../templates/reply.php'> 
                                    <input type='hidden' name="replyingToReplyID" value="<?php echo htmlspecialchars($replyID); ?>">

                                    <input type='hidden' name='neki' value="2">
                                    <input type='hidden' name='nested' value="<?Php echo htmlspecialchars($nestedLvl) ?>">

                                    <button class='replying-button' type="submit" name="replyingToReply">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                                    </button>
                            </form>
                            </div>
            <?php       } 
                    echo "</div>";
                echo "</div>";
            echo "</div>";

            
            
        }
    }   
}
else if (isset($_GET["komentarID"]) && isset($_GET['nestedLvl'])) {
    $komentarID = mysqli_real_escape_string($conn,$_GET["komentarID"]);
    $nestedLvl = mysqli_real_escape_string($conn,$_GET['nestedLvl']);

    /*$sql = "SELECT
            odg.opis AS reply,
            odg.nested_level,
            upo.ime,
            upo.priimek,
            kom.opis,
            kom.komentarID AS komentar
            FROM odgovor odg
                INNER JOIN komentar kom ON (kom.komentarID = odg.komentarID)
                INNER JOIN Uporabnik upo ON (upo.uporabnikID = odg.uporabnikID)
            WHERE odg.nested_level = '$nestedLvl' AND kom.komentarID ='$komentarID'"; */
    
    $result = retrieveKomentarReplys($conn,$komentarID,$nestedLvl);
        
    //$result = mysqli_query($conn,$sql);
    $nestedLvl++;
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $replyID = $rows['odgovorID'];
            $profilka = $rows['profilkaID'];
            
            $countedReplies = numberOfReplyReplies($conn,$komentarID,$replyID,$nestedLvl);
            
            
            $numberOfReplies = mysqli_fetch_all($countedReplies,MYSQLI_ASSOC);
           /*
            echo "<pre>";
            var_dump($numberOfReplies);
            echo "</pre>"; */
            if (isset($numberOfReplies[0]['stReplyov'])) {
                $replyNumber = $numberOfReplies[0]['stReplyov'];
            } else {
                $replyNumber = 0;
            }
            
            $reply = false;

            $seconds = formatDate($replyID,$conn,$reply);
            /*echo "<pre>";
            echo "Seconds: ";
            var_dump($seconds); */
            $timeArr = secondsToTime($seconds);
            /*echo "</pre>"; */


            echo "<div class='reply' id='reply$replyID'>";
                echo "<div class='comment-header-wrapper'>";
                    echo "<div class='profile-pic-wrapper'>";
                        
                        if ($profilka == NULL) {
                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                        } else {
                            echo "<img src='../../assets/profile$rows[uporabnikID].jpg' class='profile-picture'>";
                        }
                        
                    echo "</div>";

                    echo "<div class='person-data-wrapper'>";
                        echo "<p class='first-last-name-para'>$rows[ime] $rows[priimek]</p>";
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
                echo "<div class='komentar-text-wrapper'>";
                    echo "<div class='line-wrapper'>";
                        echo "<div class='line'></div>";
                    echo "</div>";
                    echo "<div class='reply-and-buttons-wrapper$replyID'>";
                        echo "<div>";
                            echo "<p class='komentar-para'>$rows[reply]</p>"; 
                        echo "</div>";
                        if ($replyNumber > 0) { 
                            //echo "There are some replies over here!!! </br>"; ?>
                            <div style="display: flex;">
                                <button class='replying-button' onclick="showReplyReplies(<?php echo htmlspecialchars($komentarID); echo ','; echo  htmlspecialchars($nestedLvl); echo ','; echo  htmlspecialchars($rows['odgovorID']); ?>)">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="17" r="1.3"></circle><path d="M18 4c-2.206 0-4 1.794-4 4v3h-4v-1h-3c-1.104 0-2 .896-2 2v7c0 1.104.896 2 2 2h10c1.104 0 2-.896 2-2v-7c0-1.104-.896-2-2-2h-1v-2c0-1.104.896-2 2-2s2 .896 2 2v3c0 .552.448 1 1 1s1-.448 1-1v-3c0-2.206-1.794-4-4-4zm-1 15h-10v-7h10.003l-.003 7z"></path></svg>
                                </button>
                                <form method="POST" action='../templates/reply.php'> 
                                    <input type='hidden' name="replyingToReplyID" value="<?php echo htmlspecialchars($replyID); ?>">

                                    <input type='hidden' name='neki' value="3">
                                    <input type='hidden' name='nested' value='<?php echo htmlspecialchars($nestedLvl) ?>'>

                                    <button class='replying-button' type="submit" name="replyingToReply">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                                    </button>
                                </form>
                            </div>
            <?php   echo "</div>";    } else { ?>
                            <div style="display: flex; margin-left: 20px;">
                            <form method="POST" action='../templates/reply.php'> 
                                    <input type='hidden' name="replyingToReplyID" value="<?php echo htmlspecialchars($replyID); ?>">
                                
                                    <input type='hidden' name='neki' value="4">
                                    <input type='hidden' name='nested' value='<?php echo htmlspecialchars($nestedLvl) ?>'>

                                    <button class='replying-button' type="submit" name="replyingToReply">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="2em" width="2em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                                    </button>
                            </form>
                            </div>
            <?php       } 
                echo "</div>";
            echo "</div>";
            
            
            
        }
        
    }
}




?>
<script src="../../scripts/displayReplies.js"></script>