<?php 

session_start();
require ("../../config/db_connect.php");
require ("poizvedbe.php");
require ("../logic/errorCheckerFunctions.php");


/*if (isset($_SESSION['adminID'])) { */
    $oglasiArr = array(
       array()
    );

    $modeliArr = array(
        array()
    );

    $averageZnamka = array(
        array()
    );

    $oglasiResult = numberOfZnamkaLastMonth($conn);
    $modeliResult = numberOfModelLastMonth($conn);
    $averageResult = averageCenaAvtov($conn);
    $averageZnamkaResult = averageCenaNaZnamko($conn);
    $najdrazjiResult = najdrazjiAvto($conn);
    $najcenejsiResult = najcenejsiAvto($conn);
    $i = 0;
    while ($row = mysqli_fetch_assoc($oglasiResult)) {
        
        $oglasiArr[$i]["stProdanih"] = $row['koliko'];
        $oglasiArr[$i]["znamka"] = $row["znamka"];
        /*echo "<pre>";
        var_dump($row);
        echo "</pre>"; */
        $i++;
        
    }
    $i = 0;
    while ($rowModel = mysqli_fetch_assoc($modeliResult)) {
        $modeliArr[$i]["stProdanih"] = $rowModel['koliko'];
        $modeliArr[$i]["model"] = $rowModel["model"];
       /* echo "<pre style='margin-left: 100px;'>";
        var_dump($rowModel);
        echo "</pre>"; */
        $i++;
    }

    while ($rowAverage = mysqli_fetch_assoc($averageResult)) {
        $povprecnaCena = $rowAverage['povprecna_cena'];
    }

    $i = 0;
    while ($rowAverageZnamka = mysqli_fetch_assoc($averageZnamkaResult)) {
        $averageZnamka[$i]["znamka"] = $rowAverageZnamka["znamka"];
        $averageZnamka[$i]["povprecna_cena"] = $rowAverageZnamka["povprecna_cena"];

        $i++;
    }

    $najdrazjiAvto = mysqli_fetch_all($najdrazjiResult,MYSQLI_ASSOC);
    $najcenejsiAvto = mysqli_fetch_all($najcenejsiResult,MYSQLI_ASSOC);
    $najdrazji = $najdrazjiAvto[0];
    $najcenejsi = $najcenejsiAvto[0];

    echo "<pre style='margin-left: 100px;'>";
    var_dump($najdrazji);
    echo "</pre>";
    


    
    /*echo "<pre style='margin-left: 100px;'>";
    var_dump($averageZnamka);
    echo count($averageZnamka); */
    echo "</pre>"; 
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

            <div class='stats-wrapper'>
                <div class='stat'>
                    <p>Povprečna cena vozil: <?php echo number_format($povprecnaCena,2,',','') . " €" ?></p>
                    <?php  
                        for ($i = 0; $i < count($averageZnamka); $i++) {
                        echo $averageZnamka[$i]['znamka'] .": " . number_format($averageZnamka[$i]['povprecna_cena'],2,',','')  . " €" . "</br>";
                        }
                        
                    ?>
                </div>

                <div class='stat'>
                    <h1>MAXIMUM - MINIMUM</h1>
                    <p>Najdražji avto: <?php echo  number_format($najdrazji['cena']) . " €"; ?></p>
                    <p>Najcenejši avto: <?php echo  number_format($najcenejsi['cena']) . " €"; ?></p>
                </div>
            </div>

            <div class='graphs-wrapper'>

                <div class='graph'>
                    <canvas id="myCanvas" width="500" height="500"></canvas>
                </div>
                <div class='graph'>
                    <canvas id="st-modelov-prodanih" width="500" height="500"></canvas>
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

let modeliArr = [];
let modelCountArr = [];

<?php for($i = 0; $i < count($oglasiArr); $i++) { ?>

    znamkeArr.push("<?php echo $oglasiArr[$i]["znamka"]; ?>");
    znamkeCountArr.push("<?php echo $oglasiArr[$i]["stProdanih"] ;?>");
<?php } ?>


<?php 

        for ($i = 0; $i < count($modeliArr); $i++) {  ?>
            modeliArr.push("<?php echo $modeliArr[$i]["model"] ?>");
            modelCountArr.push("<?php echo $modeliArr[$i]["stProdanih"];?>");
<?php   } ?>





console.log(znamkeArr);
console.log(znamkeCountArr);
console.log(modeliArr);
console.log(modelCountArr);

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



let myGraph = new Chart("st-modelov-prodanih", {
  type: "bar",
  data: {
    labels: modeliArr,
    datasets: [{
      backgroundColor: barColors,
      data: modelCountArr
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