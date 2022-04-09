<?php 

session_start();
require("../../config/db_connect.php");
require ("../logic/sporocilo.php");


if (isset($_SESSION['id'])) {
    
    $posiljateljID = mysqli_real_escape_string($conn,$_SESSION['id']);
    $uporabnikID = $posiljateljID;
    /*echo "<pre style='margin-left: 100px;'>";
    var_dump($_SESSION);
    echo "</pre>"; */

    if (isset($_GET['chatID'])) {
        $prejemnikID = mysqli_real_escape_string($conn,$_GET['chatID']);
        $isOkPrejemnik = checkPrejemnikID($prejemnikID);

        if ($isOkPrejemnik != true) {
            Header("Location: sporocilo.php"); 
        }
    }

    if (isset($_POST['poslanoSporocilo'])) {
        $message = mysqli_real_escape_string($conn,$_POST['vnesenoSporocilo']);
        $isOk = checkMessage($message);

        if ($isOk === true) {
            insertMessage($conn,$message,$posiljateljID,$prejemnikID);
        }
        
    }

    

} else {
    Header("Location: domov.php");
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/sporocilo.css">
    <!-- <link type="text/css" rel="stylesheet" href="../../style/global.css"> -->
    <title>PRODAJA VOZIL | SPOROČILO</title>
</head>
<body>
    <?Php require "../templates/StranskiMeni.php" ;?>
    <main>
        <div class='whole-page-wrapper'>
            <div class='close-wrapper'>
                <a href="domov.php" style='display: flex; justify-content: right; align-items: right; align-self: right; margin-right: 20px;'>
                    <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                </a>
            </div>
            <div class='main-content-wrapper'>

    <?php   if (!isset($_GET['chatID'])) { ?>

                <h1>Vaši pogovori</h1>
                <!--<div class="all-users-wrapper-wrapper"> -->
                    <div class='all-users-wrapper'>
                        
                    <?Php 
                        $result = fetchAllUsers($conn,$_SESSION['id']);

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <a class="user-chat-specific" href="<?php echo "sporocilo.php?chatID=$row[uporabnikID]" ?>">
                                <div class='whole-user-info'>
                                    <div class='all-users-info'>
                                        <?php 

                                        echo "<div class='profile-pic-wrapper'>";
                                        if ($row['profilkaID'] == NULL) {
                                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                        } else {
                                            echo "<img src='../../assets/profile$row[uporabnikID].jpg' class='profile-picture'>";
                                        }
                                        echo "</div>";

                                        ?>
                                    </div>
                                    <div class='all-users-chats'>
                                        <p><?php echo htmlspecialchars($row['ime']); echo " "; echo htmlspecialchars($row['priimek']) ?></p>
                                        <p>Začni pogovor s to osebo</p>
                                    </div>
                                </div>
                            </a>
            <?php       }  ?>
                
                    </div>
                <!--</div> -->
        <?php } else { 
            $chatID = mysqli_real_escape_string($conn,$_GET['chatID']);

            $result = fetchAllUsers($conn,$_SESSION['id']);
            

            ?>
                <div class='chat-wrapper'>
                    <div class='left hidden'>
                <?php
                $myData = fetchMyData($conn,$_SESSION['id']);
                ?>
                        <div class='left-header'>
                            <div class='my-profile-pic'>
                                <?php 
                                    while ($myUserData = mysqli_fetch_assoc($myData)) {

                                        echo "<div class='profile-pic-wrapper'>";
                                        if ($myUserData['profilkaID'] == NULL) {
                                            echo "<img src='../../assets/profiledefault.png' class='profile-picture-smaller'>";
                                        } else {
                                            echo "<img src='../../assets/profile$myUserData[uporabnikID].jpg' class='profile-picture-smaller'>";
                                        }
                                        echo "</div>"; 
                                       
                                ?>
                            </div>
                            <div class='my-profile-data'>
                                <p class='pogovori'>Pogovori</p>
                            </div>
                          <?php     }  ?>
                        </div>

                        
                        <div class='all-users-chats scroll'>

                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <a class='user-chat-a user-chat-specific' href='sporocilo.php?chatID=<?php echo $row['uporabnikID'] ?>'>
                                <div class='user-chat'> 
                        <?php
                                    
                                        echo "<div class='profile-pic-wrapper'>";
                                        if ($row['profilkaID'] == NULL) {
                                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                        } else {
                                            echo "<img src='../../assets/profile$row[uporabnikID].jpg' class='profile-picture'>";
                                        }
                                        echo "</div>"; 

                                        echo "<div class='flex-column'>"; ?>
                                        <p><?php echo htmlspecialchars($row['ime']) . " " . htmlspecialchars($row['priimek']) ?></p>
                                        <p>Začni pogovor s to osebo</p>
                                </div>
                            </a>     

                                </div>
                        <?php   }  ?>
                            
                        </div>

                        
                    </div>
                    <div class='right' id="right">
                        <div class='right-header'>

                        <?php 
                            $hisData = fetchHisData($conn,$_GET['chatID']);

                            while ($hisRow = mysqli_fetch_assoc($hisData)) {  ?>
                                <div class='their-profile-pic'>
                                    <?php
                                        echo "<div class='profile-pic-wrapper'>";
                                        if ($hisRow['profilkaID'] == NULL) {
                                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                                        } else {
                                            echo "<img src='../../assets/profile$hisRow[uporabnikID].jpg' class='profile-picture'>";
                                        }
                                        echo "</div>";
                                    ?>
                                </div>
                                <div class='their-profile-data'>
                                    <p>Povezani ste z osebo <?php echo htmlspecialchars($hisRow['ime']) . " " . htmlspecialchars($hisRow['priimek']) ?></p>
                                </div>
                       <?php } ?>
                        
                       


                            
                            
                        </div>

                        <div class='messages' id="messages">

                        <?php 
                            $resultMessage = fetchChatMessages($conn,$posiljateljID,$prejemnikID);

                            if (is_bool($result))  {
                                echo "<div class='messages-wrap'>";
                                    echo "<div class='inner'>Sporočilo ni bilo možno prikazati</div>";
                            } else {
                        ?>


                            <div class='messages-wrap'>
                                <?php 
                                    while ($rowMessage = mysqli_fetch_assoc($resultMessage)) {
                                       
                                        if ($rowMessage['posiljateljID'] === $uporabnikID) {
                                            echo "<div class='inner-right'>";
                                            echo "<p class='sender'>$rowMessage[opis]</p>";
                                            echo "</div>";
                                            
                                        } else {
                                            echo "<div class='inner-left'>";
                                            echo "<p class='receiver'>$rowMessage[opis]</p>";
                                            echo "</div>";
                                        }
                                        
                                    }
                                ?>
                            </div>
                    <?php  } ?>
                        </div>

                        <div class='send-message-wrapper'>
                            
                            <form class='send-message-form' method="POST" action='sporocilo.php?chatID=<?php echo htmlspecialchars($chatID) ?>'>
                                <input type='text' class='input-message' name='vnesenoSporocilo' required>
                                <button type='submit' name='poslanoSporocilo' class='send-message-button'>
                                <svg class='icon' stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="2.5em" width="2.5em" xmlns="http://www.w3.org/2000/svg"><g><path fill="none" d="M0 0h24v24H0z"></path><path d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path></g></svg>
                                </button>
                            </form>
                        </div>
                        
                    </div>
                </div>
     
     <?php  } ?>
            </div>
            <!--<div class="display-on-mobile">

            </div> -->
        </div>
    </main>
    <script>
        console.log("Total height: " + screen.height);

        let divHeight = screen.height;



        //document.getElementById("right").style.height = divHeight + "px";
        //console.log(divRight);
        document.getElementById("messages").style.height = divHeight - 332 + "px";
      
    </script>
</body>
    
</html>