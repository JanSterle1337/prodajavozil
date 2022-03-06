<?php 
    session_start();
    require ("../../config/db_connect.php");
    require ("../logic/oglas.php");
    require ("../logic/errorCheckerFunctions.php");
    if (isset($_GET['id'])) {
        $oglasID = mysqli_real_escape_string($conn,$_GET['id']);
      
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
    <link type="text/css" rel="stylesheet" href="../../style/domov.css">
    <link type="text/css" rel="stylesheet" href="../../style/global.css">
    <link type="text/css" rel="stylesheet" href="../../style/oglas.css">
    <title>Oglas</title>

    
</head>
<body>

    <?php require "../templates/StranskiMeni.php "?>

    <main>
        <?php 
            $retrievedData = getOglasInfo($conn,$oglasID);
            $retrievedPhotoData= getPhotosInfo($conn,$oglasID);

            while ($row = mysqli_fetch_assoc($retrievedData)) {
                $sellerID = $row["uporabnikID"];
               /* echo "<pre>";
                var_dump($row);
                echo "</pre>";  */
            }

            while ($row = mysqli_fetch_assoc($retrievedPhotoData)) {
              /*  echo "<pre>";
                var_dump($row);
                echo "</pre>"; */
                $photoNameArr[] = $row['imeSlike'];
            }

            //echo json_encode($photoNameArr);

            if (isset($_SESSION['id']) && $_SESSION['id'] == $sellerID) { ?>
            
            <div class='close-wrapper'>
                <a href="domov.php" style='display: flex; justify-content: right; align-items: right; align-self: right; margin-right: 20px;'>
                    <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                </a>
            </div>

            <div class="oglas-wrapper">
                <div class="gallery-wrapper" id="gallery-wrap">
                <div class="heading" id="head">
                    <h1>Oglas</h1>
                </div>
                <div class="gallery"></div>
                <div class="oglas-info">
                    <div class="button-wrapper"></div>
                    <div class="info">
                        <div class="left">
                            <h2>Specifični podatki</h2>
    
                            <?php 
                            $retrievedData = getOglasInfo($conn,$oglasID);
                            while ($row = mysqli_fetch_assoc($retrievedData)) {
                                foreach ($row as $key => $value) {
                                        if ($key != "oglasID" && 
                                            $key != "opis" &&
                                            $key != "status" &&
                                            $key != "created_at" &&
                                            $key != "uporabnikID"
                                            ) {
                                                if ($key == "cena") {
                                                    echo "<p class='value'><span class='key'>$key: </span>$value €</p>";
                                                }
                                                else if ($key == "prevozeniKm") {
                                                    echo "<p class='value'><span class='key'>$key: </span>$value Km</p>";
                                                }
                                                else {
                                                    echo "<p class='value'><span class='key'>$key: </span>$value</p>";
                                                }

                                                
                                            }
                                        
                                }
                               /* echo "<pre>";
                                var_dump($row);
                                echo "</pre>"; */
                            }
                             ?>
                        </div>
                        <div class="right">
                            <h2>Opis</h2>
                            <?php
                            $retrievedData = getOglasInfo($conn,$oglasID);
                            while ($row = mysqli_fetch_assoc($retrievedData)) {
                                if ($row["opis"]) {
                                    echo "<p class='value'>$row[opis]</p>";
                                }
                            }
                            ?>
                        </div>
                        
                        <?php 
                            $retrievedData = getOglasInfo($conn,$oglasID);
                            /*echo mysqli_num_rows($retrievedData); */
                            while ($row = mysqli_fetch_assoc($retrievedData)) {
                             /*   echo "<pre>";
                                var_dump($row);
                                echo "</pre>"; */

                            }
                        ?>
                    </div>
                    <div class="edit-delete-wrapper">
                        <form action="../logic/redirect.php" METHOD="POST">
                            <input type="hidden" name="sellerID" value="<?php echo htmlspecialchars($sellerID); ?>"/>
                            <input type="hidden" name="userID" value="<?Php echo htmlspecialchars($_SESSION['id']) ?>"/>
                            <input type="hidden" name="oglasID" value="<?Php echo htmlspecialchars($oglasID) ?>"/>
                            <button type="submit" name="posodobi">Posodobi oglas</button>
                            <button type="submit" name="izbrisi">Izbriši oglas</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
<?php } else {  ?>

    <div class='close-wrapper'>
                <a href="domov.php" style='display: flex; justify-content: right; align-items: right; align-self: right; margin-right: 20px;'>
                    <svg class='icon' stroke="black" fill="gray" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 0 1-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path></svg>
                </a>
    </div>

        <div class="oglas-wrapper">
            <div class="gallery-wrapper" id="gallery-wrap">
                <div class='heading' id='head'>
                    <h1>Oglas</h1>
                </div>
                <div class="gallery"></div>
                <div class="oglas-info">
                    <div class="button-wrapper"></div>
                    <div class="info">
                        <div class="left">
                            <h2>Specifični podatki</h2>
    
                            <?php 
                            $retrievedData = getOglasInfo($conn,$oglasID);
                            while ($row = mysqli_fetch_assoc($retrievedData)) {
                                foreach ($row as $key => $value) {
                                        if ($key != "oglasID" && 
                                            $key != "opis" &&
                                            $key != "status" &&
                                            $key != "created_at" &&
                                            $key != "uporabnikID"
                                            ) {
                                                if ($key == "cena") {
                                                    echo "<p class='value'><span class='key'>$key: </span>$value €</p>";
                                                }
                                                else if ($key == "prevozeniKm") {
                                                    echo "<p class='value'><span class='key'>$key: </span>$value Km</p>";
                                                }
                                                else {
                                                    echo "<p class='value'><span class='key'>$key: </span>$value</p>";
                                                }

                                                
                                            }
                                        
                                }
                               /* echo "<pre>";
                                var_dump($row);
                                echo "</pre>"; */
                            }
                             ?>
                        </div>
                        <div class="right">
                            <h2>Opis</h2>
                            <?php
                            $retrievedData = getOglasInfo($conn,$oglasID);
                            while ($row = mysqli_fetch_assoc($retrievedData)) {
                                if ($row["opis"]) {
                                    echo "<p class='value'>$row[opis]</p>";
                                }
                            }
                            ?>
                        </div>

                        <?php 
                            $retrievedData = getOglasInfo($conn,$oglasID);
                            /*echo mysqli_num_rows($retrievedData); */
                            while ($row = mysqli_fetch_assoc($retrievedData)) {
                             /*   echo "<pre>";
                                var_dump($row);
                                echo "</pre>"; */

                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="user-info-wrapper">
                <div class="heading" id="head">
                    <h1>Prodajalec</h1>
                </div>
                <div class="profilka-wrapper">
                <?php
                    
                        $profilkaData = getProfilkaInfo($conn,$sellerID);
                        if (mysqli_num_rows($profilkaData) == 0) {
                            echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                        } else {
                            $rowImg = mysqli_fetch_assoc($profilkaData);

                            if ($rowImg["status"] == 0) {
                                $sellerID = $rowImg['uporabnikID'];
                                echo "<img src='../../assets/profile".$sellerID.".jpg' class='profile-picture'>";
                            } else {
                                echo "<img src='../../assets/profiledefault.png' class='profile-picture'>";
                            }
                        }                    
                        
                        
                        
                    /*  echo "<pre>";
                        var_dump($rowSeller);
                        echo "</pre>"; */
                ?>
                </div>
                <div class="user-info">
                <?php
                    $sellerData = getSellerInfo($conn,$sellerID);
                    $rowSeller = mysqli_fetch_assoc($sellerData);
                   
                    foreach ($rowSeller as $key => $value) {
                        if ($key !=="uporabnikID") {
                            if ($key !== "created_at") {
                                echo "<div><p class='value'>$value</p></div>";
                            }
                          
                        } else {
                            $sellerID = mysqli_real_escape_string($conn,$value);
                            
                        } 

                        if ($key === "created_at") {
                            $isUporabnikUstvarjen = "uporabnikUstvarjen";
                            $seconds = formatDate($sellerID,$conn,$isUporabnikUstvarjen);
                            $timeArr = secondsToTime($seconds);
                            if (!is_array($timeArr)) {
                                echo "<p class='value'>Uporabnik se je pridružil pred 1 sekundo</p>";
                            } else {

                                foreach ($timeArr as $timeDelimiter => $value) {
                                            
                                    if ($value > 0) {
                                        if ($value === 1) {
                                            echo "<p class='right centered'>Uporabnik se je pridružil $value $timeDelimiter o nazaj</p>";
                                            break;
                                        }
                                        else if ($value === 2) {
                                            echo "<p class='right centered'>Uporabnik se je pridružil$value $timeDelimiter i nazaj</p>";
                                            break;
                                        } else {
                                            echo "<p class='right centered'>Uporabnik se je pridružil $value $timeDelimiter nazaj</p>";
                                            break;
                                        }
                                        
                                    }
                                }

                        }
                        
                        }
                        
                    }
                    
                ?>
                
                </div>
                <div class="info-footer">
                    <form action="../logic/redirect.php" METHOD="POST" class="redirect">

                        <?php 

                        if (isset($_SESSION['id'])) { ?>
                            <input type="hidden" name="uporabnik" value="<?php echo htmlspecialchars($_SESSION['id']); ?>"/>
                <?php   } else { ?>
                            <input type="hidden" name="uporabnik" value="<?php echo "no_user" ?>"/>
                <?php   } ?>   

                        <input type="hidden" name="sellerID" value="<?php echo htmlspecialchars($sellerID); ?>"/>
                        <button class='poslji-button' type="submit" name="sporocilo">Pošlji sporočilo</button>
                        <button class='vsi-oglasi-button' type="submit" name="ogled">Vsi oglasi prodajalca</button>
                    </form>        
                </div>
            </div>
        </div>
<?php } ?>
    </main>


<script type="text/javascript">
        let data = <?php echo json_encode($photoNameArr); ?>;
        //console.log(data);
        

        let galleryWrapper = document.getElementById("gallery-wrap");
        //console.log("Gallery wrapper: " + galleryWrapper);
        


        let gallery = document.getElementsByClassName("gallery")[0];
        //console.log("Gallery: " + gallery);

       // gallery.className="gallery";
        for(let i = 0; i < data.length; i++) {
            let img = document.createElement("img");
            img.className = "oglas-photo";
            img.id = "photo" + i;
            img.src = "../../storage/" + data[i];
           // console.log(img);
            /*let imgBackground = document.createElement("img");
            imgBackground.className = "background-photo";
            imgBackground.src = img.src; 
            gallery.appendChild(imgBackground); */
            gallery.appendChild(img);
           // console.log(img);

           
            
        
            if (i > 0) {
                img.style.display="none";
            } else {

                

                /*
                gallery.style.backgroundImage = 'url(' + img.src + ')';
                gallery.style.backgroundSize = "cover";
                gallery.style.filter = "blur(" + 8 + "px)"; */


            }

        }
      //  galleryWrapper.appendChild(gallery);

        let nodeList = gallery.childNodes;    

        

        let buttonForw = document.createElement("button");
        let ForwSVG = document.createElement("svg");
        buttonForw.className = "forward";


        buttonForw.innerHTML = "Naprej";


        buttonForw.addEventListener("click", function () {

            for (let i = 0; i < nodeList.length; i++) {
                //console.log(nodeList[i].id);
                if (nodeList[i].style.display != "none" && (i + 1) < nodeList.length) {
                    nodeList[i].style.display = "none";
                    nodeList[i+1].style.display = "flex";
                    
                    break;
                } else if (nodeList[i].style.display != "none" && (i+1) == nodeList.length) {
                    nodeList[i].style.display = "none";
                    nodeList[0].style.display = "flex";
                    break;
                }
                
            }
            /*console.log(gallery.offsetHeight); */
            
        });

        let buttonBack = document.createElement("button");
        buttonBack.className = "backward";
        buttonBack.innerHTML = "Nazaj";

        buttonBack.addEventListener("click",function () {
            for (let i = 0; i < nodeList.length; i++) {
               //console.log(nodeList[i].id);
                if (nodeList[i].style.display != "none" && (i - 1)  >= 0) {
                    nodeList[i].style.display = "none";
                    nodeList[i-1].style.display = "flex";
                    break;
                } else if (nodeList[i].style.display != "none" && (i-1) < 0) {
                    nodeList[i].style.display = "none";
                    nodeList[nodeList.length-1].style.display = "flex";
                    break;
                }
                
            }
        });


        let buttonWrapper = document.getElementsByClassName("button-wrapper")[0];
        //buttonWrapper.className = "oglas-info";
        buttonWrapper.appendChild(buttonBack);
        buttonWrapper.appendChild(buttonForw);
</script>
</body>
</html>