

<?php 

require ("../../config/db_connect.php");


$val = $_GET["value"];

$val_M = mysqli_real_escape_string($conn,$val);

$sql = "SELECT imeModela FROM model WHERE znamka = '$val_M'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)> 0) {
    echo "<select name='model' id='poll' style=' width: 15rem; height: 3rem; font-size: 1.5rem;padding: 5px;'>";
    echo "<option value='Vsi modeli'>Vsi modeli</option>";
    while ($rows = mysqli_fetch_assoc($result)) {
        echo "<option>" . $rows['imeModela'] . " "  . "</option>";
    }

    echo "</select>";
} else {
    echo "<select name='model' id='poll' style=' width: 15rem; height: 3rem; font-size: 1.5rem;padding: 5px;'>";
    echo "<option>Select Model</option>";
    echo "</select>";
}

?>