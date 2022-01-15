<?php 

    session_start();
    require ("../../config/db_connect.php");

    if (isset($_SESSION['id'])) {

        $id = $_SESSION["id"];

        if (isset($_POST["submit"])) {
            if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
                echo "No upload";
                 /* header("Location: ../templates/nastavitve.php?upload=failure"); */
            } else {
                $fileName = $_FILES["file"]["name"];
                $fileTmpName = $_FILES["file"]["tmp_name"];
                $fileSize = $_FILES["file"]["size"];
                $fileError = $_FILES["file"]["error"];
                $fileType = $_FILES["file"]["type"];

                $fileExt = explode(".",$fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array("jpg","jpeg","png","pdf");

                if (in_array($fileActualExt,$allowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 5000000) {
                            $fileNameNew = "profile" . $_SESSION["id"] . "." . $fileActualExt;
                            $fileDestination = "../../assets/" . $fileNameNew;
                            move_uploaded_file($fileTmpName,$fileDestination);
                            $id = $_SESSION["id"];


                            $sql = "SELECT * FROM profilka WHERE uporabnikID = '$id'";
                            $resultImg = mysqli_query($conn,$sql);

                            $rowImg = mysqli_fetch_assoc($resultImg);

                            if (!empty($rowImg["profilkaID"])) {

                                $sql = "UPDATE profilka 
                                        SET `status` = 0, status_explanation = 'Updated'
                                        WHERE uporabnikID = '$id'";
                                $updated = true;
                                $result = mysqli_query($conn,$sql);
                                echo "update";
                                header("Location: ../templates/nastavitve.php?upload=sucess");
                            } else {
                                $sql = "INSERT INTO 
                                        profilka(uporabnikID,`status`,status_explanation)
                                        VALUES
                                        ('$id','0','Inserted')";

                                $result = mysqli_query($conn,$sql);
                                echo "Insert";
                                $updated = true;
                                header("Location: ../templates/nastavitve.php?upload=sucess");
                            }


                        } else {
                            $sql = "UPDATE profilka 
                            SET `status` = 1, 
                            status_explanation = 'Your file is too big' 
                            WHERE uporabnikID = '$id'";
                            $updated = false;
                        }
                    } else {
                        $sql = "UPDATE profileimg SET `status` = 1, 
                        status_explanation = 'There was an error uploading your file' 
                        WHERE uporabnikID = '$id'";
                        $updated = false;

                        $result = mysqli_query($conn,$sql);
                        echo "There was an error uploading your file";
                    } 
                } else {
                    $sql = "UPDATE profileimg SET `status` = 1, 
                    status_explanation ='you can not upload files of this type'
                     WHERE uporabnikID = '$id'";
                    $result = mysqli_query($conn,$sql);
                    echo "You cannot upload files of this type";
                    $updated = false;
                }
            }
        }
    }


?>