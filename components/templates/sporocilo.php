<?php 

session_start();
require("../../config/db_connect.php");
require ("../logic/sporocilo.php");


if (isset($_SESSION['id'])) {
    $posiljateljID = mysqli_real_escape_string($conn,$_SESSION['id']);
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
                closing
            </div>
            <div class='main-content-wrapper'>

    <?php   if (!isset($_GET['chatID'])) { ?>

                <h1>Vaši pogovori</h1>
                <div class='all-users-wrapper'>
                    
                <?Php 
                    $result = fetchAllUsers($conn,$_SESSION['id']);

                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <a href="<?php echo "sporocilo.php?chatID=$row[uporabnikID]" ?>">
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
        <?php } else { 
            $chatID = mysqli_real_escape_string($conn,$_GET['chatID']);

            $result = fetchAllUsers($conn,$_SESSION['id']);
            

            ?>
                <div class='chat-wrapper'>
                    <div class='left'>
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
                                   

                                </div>
                        <?php   }  ?>
                            
                        </div>

                        
                    </div>
                    <div class='right'>
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

                        <div class='messages'>
                            <div class='messages-wrap'>
                                <div class="inner">First message</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Hi</div>
                                <div class="inner">Last message</div>
                            </div>
                        </div>

                        <div class='send-message-wrapper'>
                            
                            <form class='send-message-form' method="POST" action='sporocilo.php?chatID=<?php echo htmlspecialchars($chatID) ?>'>
                                <input type='text' name='vnesenoSporocilo' required>
                                <button type='submit' name='poslanoSporocilo'>Pošlji</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
     
     <?php  } ?>
            </div>
        </div>
    </main>
</body>
</html>