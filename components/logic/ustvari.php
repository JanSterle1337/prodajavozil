<?php 

require ("../../config/db_connect.php");


$val = $_GET["value"];

$val_M = mysqli_real_escape_string($conn,$val);

$sql = "SELECT imeModela FROM model WHERE znamka = '$val_M'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)> 0) {
    echo "<select name='model'>";
    while ($rows = mysqli_fetch_assoc($result)) {
        echo "<option>" . $rows['imeModela'] . " "  . "</option>";
    }

    echo "</select>";
} else {
    echo "<select>";
    echo "<option>Select Model</option>";
    echo "</select>";
}

?>