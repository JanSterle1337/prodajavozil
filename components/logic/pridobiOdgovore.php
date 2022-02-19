<?php
require ("../../config/db_connect.php");
require ("../logic/forum.php");


if (isset($_GET["komentarID"]) && isset($_GET['nestedLvl']) && isset($_GET["odgovorjenID"])) {
    $komentarID = mysqli_real_escape_string($conn,$_GET["komentarID"]);
    $nestedLvl = mysqli_real_escape_string($conn,$_GET['nestedLvl']);
    $odgovorjenID = mysqli_real_escape_string($conn,$_GET['odgovorjenID']);

    $result = retrieveReplyReplys($conn,$komentarID,$odgovorjenID,$nestedLvl);
    $nestedLvl++;
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $replyID = $rows["odgovorID"];
          
            $countedReplies = numberOfReplys($conn,$komentarID,$nestedLvl);
            
            $numberOfReplies = mysqli_fetch_all($countedReplies,MYSQLI_ASSOC);
            echo "<pre>";
            echo "NUMBER OF REPLYS: </BR>";
            var_dump($numberOfReplies);
            echo "</pre>";
            echo "<div class='reply' id='reply$replyID'><p>$rows[reply]</p></div>";

            
            if (!empty($numberOfReplies)) {  
                //echo "There are some replies over here!!! </br>"; ?>
                <div style="display: flex;">
                    <button style="background: yellow; margin-bottom: 30px;" onclick="showReplyReplies(<?php echo htmlspecialchars($komentarID); echo ','; echo  htmlspecialchars($nestedLvl); echo ','; echo  htmlspecialchars($rows['odgovorID']); ?>)">Prikaži odgovor</button>
                    <form method="POST" action='../logic/reply.php'> 
                        <input type='hidden' name="replyingToReplyID">
                        <input type="text" name='replyingTo' required>
                        <button type="submit" name="replyingToReply">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                        </button>
                    </form>
                </div>
<?php       } else { ?>
                <div style="display: flex;">
                <form method="POST" action='../logic/reply.php'> 
                        <input type='hidden' name="replyingToReplyID">
                        <input type="text" name='replyingTo' required>
                        <button type="submit" name="replyingToReply">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                        </button>
                </form>
                </div>
<?php       } 
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
            
            $countedReplies = numberOfReplys($conn,$komentarID,$nestedLvl);
            
            $numberOfReplies = mysqli_fetch_all($countedReplies,MYSQLI_ASSOC);


            echo "<div class='reply' id='reply$replyID'><p>$rows[reply]</p></div>";
            echo "Hello noobs</br>";
            
            if (!empty($numberOfReplies)) { 
                //echo "There are some replies over here!!! </br>"; ?>
                <div style="display: flex;">
                    <button style='background: lightgreen;' onclick="showReplyReplies(<?php echo htmlspecialchars($komentarID); echo ','; echo  htmlspecialchars($nestedLvl); echo ','; echo  htmlspecialchars($rows['odgovorID']); ?>)">Prikaži odgovor</button>
                    <form method="POST" action='../logic/reply.php'> 
                        <input type='hidden' name="replyingToReplyID">
                        <input type="text" name='replyingTo' required>
                        <button type="submit" name="replyingToReply">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M9.079 11.9l4.568-3.281a.719.719 0 000-1.238L9.079 4.1A.716.716 0 008 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"></path></svg>
                        </button>
                    </form>
                </div>
<?php           }
        }
        
    }
}




?>
<script src="../../scripts/displayReplies.js"></script>