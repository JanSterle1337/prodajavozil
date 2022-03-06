<?php 

session_start();
require ("../../config/db_connect.php");
require ("poizvedbe.php");
require ("../logic/errorCheckerFunctions.php");


/*if (isset($_SESSION['adminID'])) { */
    $oglasiArr = array(
       array()
    );

    $oglasiResult = numberOfZnamkaLastMonth($conn);
    $i = 0;
    while ($row = mysqli_fetch_assoc($oglasiResult)) {
        
        $oglasiArr[$i]["stProdanih"] = $row['koliko'];
        $oglasiArr[$i]["znamka"] = $row["znamka"];
        /*echo "<pre>";
        var_dump($row);
        echo "</pre>"; */
        $i++;
        
    }


    
   /* echo "<pre style='margin-left: 100px;'>";
    var_dump($oglasiArr);
    echo count($oglasiArr);
    echo "</pre>"; */
/*}*/


?>


<!DOCTYPE html>
<html lang="en">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../style/stats.css">
    <title>PRODAJAVOZIL | STATISTIKA</title>
</head>
<body>
    <?php require ("Sidebar.php") ?>
    <main>
        <div class="main-page-wrapper">
            <div class='graphs-wrapper'>
                <div class='graph'>
                    <canvas id="myCanvas" width="500" height="500"></canvas>
                </div>
                <div class='graph'>
                    neki
                </div>
                <div class='graph'>
                    neki
                </div>
                <div class='graph'>
                    neki
                </div>
            </div>
        </div>
        
    </main>
    

  
  <script>

let znamkeArr = [];
let znamkeCountArr = [];
<?php for($i = 0; $i < count($oglasiArr); $i++) { ?>

    znamkeArr.push("<?php echo $oglasiArr[$i]["znamka"]; ?>");
    znamkeCountArr.push("<?php echo $oglasiArr[$i]["stProdanih"] ?>");
<?php } ?>

console.log(znamkeArr);
console.log(znamkeCountArr);


let barColors = ["#E29CF3", "#E29CF3","#9740E9","#6764EF","#9B9DA2"];



let myChart = new Chart("myCanvas", {
  type: "bar",
  data: {
    labels: znamkeArr,
    datasets: [{
      backgroundColor: barColors,
      data: znamkeCountArr
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Število novih prodajanih vozil v zadnjem mesecu"
    },
    responsive: false,
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
            },
        }],
    },
  },
});
</script>
</body>
</html>