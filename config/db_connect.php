<?php 

$user = "Jan Sterle";
$password = "cigan1337";
$host = "localhost";
$database = "prodajavozil";

$conn = mysqli_connect($host,$user,$password,$database);

if ($conn) {
    echo "connected";
} else {
    die ("Connection failed: " . mysqli_connect_error());
}


?>