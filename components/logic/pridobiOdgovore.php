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


            echo "<div class='reply' id='reply$replyID'><p>$rows[reply]</p></div>";

            
            if (!empty($numberOfReplies)) { 
                //echo "There are some replies over here!!! </br>"; ?>
                <button style="background: yellow; margin-bottom: 30px;" onclick="showReplyReplies(<?php echo htmlspecialchars($komentarID); echo ','; echo  htmlspecialchars($nestedLvl); echo ','; echo  htmlspecialchars($rows['odgovorID']); ?>)">Prikaži odgovor</button>
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

            
            if (!empty($numberOfReplies)) { 
                //echo "There are some replies over here!!! </br>"; ?>
                <button style='background: lightgreen;' onclick="showReplyReplies(<?php echo htmlspecialchars($komentarID); echo ','; echo  htmlspecialchars($nestedLvl); echo ','; echo  htmlspecialchars($rows['odgovorID']); ?>)">Prikaži odgovor</button>
<?php           }
        }
        
    }
}




?>
<script src="../../scripts/displayReplies.js"></script>