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
    $razmerjeMesecResult = razmerjeMedProdanimiMesec($conn);


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


    $rowRazmerje = mysqli_fetch_all($razmerjeMesecResult,MYSQLI_ASSOC); 
    $razmerjeProdanih = $rowRazmerje[0]['stVozil'];
    $razmerjeNeprodanih = $rowRazmerje[1]['stVozil'];

    
    /*echo "<pre style='margin-left: 100px;'>";
    var_dump($rowRazmerje);
    echo "Prodani: " . $razmerjeProdanih . "</br>";
    echo "Neprodani: " . $razmerjeNeprodanih;
    echo "</pre>"; */

    $najdrazjiAvto = mysqli_fetch_all($najdrazjiResult,MYSQLI_ASSOC);
    $najcenejsiAvto = mysqli_fetch_all($najcenejsiResult,MYSQLI_ASSOC);
    $najdrazji = $najdrazjiAvto[0];
    $najcenejsi = $najcenejsiAvto[0];

   
    


    
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
    <div class='closing-wrapper'>
            
    </div>
        <div class="main-page-wrapper">
  
        

            <div class='stats-wrapper'>
                <div class='stat'>
                    <h1 class='heading'>Povprečna cena</h1>
                        <p>Povprečna cena vozil: <?php echo number_format($povprecnaCena,2,',','') . " €" ?></p>
                    <?php  
                        for ($i = 0; $i < count($averageZnamka); $i++) {
                        echo $averageZnamka[$i]['znamka'] .": " . number_format($averageZnamka[$i]['povprecna_cena'],2,',','')  . " €" . "</br>";
                        }
                        
                    ?>
                </div>

                <div class='stat'>
                    <h1 class='heading'>Maximum - Minimum</h1>
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
                    <canvas id="razmerje-prodanih-neprodanih" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
        
    </main>
    

  
  <script>

let znamkeArr = [];
let znamkeCountArr = [];

let modeliArr = [];
let modelCountArr = [];

let stProdNeprodArr = [];



<?php for($i = 0; $i < count($oglasiArr); $i++) { ?>

    znamkeArr.push("<?php echo $oglasiArr[$i]["znamka"]; ?>");
    znamkeCountArr.push("<?php echo $oglasiArr[$i]["stProdanih"] ;?>");
<?php } ?>


<?php 

        for ($i = 0; $i < count($modeliArr); $i++) {  ?>
            modeliArr.push("<?php echo $modeliArr[$i]["model"] ?>");
            modelCountArr.push("<?php echo $modeliArr[$i]["stProdanih"];?>");
<?php   } ?>

stProdNeprodArr[0] = <?php echo $razmerjeNeprodanih; ?>;
stProdNeprodArr[1] = <?php echo  $razmerjeProdanih;?>;




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


/*
let neki = new Chart("razmerje-prodanih-neprodanih", {
  type: 'line',
  data: {
    labels: ["Prodani","neprodani","kupleni","neki"],
    datasets: [{
      label: 'Total prodani',
      data: [1,2,4,3],
      backgroundColor: [
          'red',
          'blue',
          'yellow',
          'green'
      ]
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

*/

let neki = new Chart("razmerje-prodanih-neprodanih", {
  type: 'pie',
  data: {
    labels: ['Prodani v zadnjem mesecu', 'novi oglasi'],
    datasets: [{
      label: '# of Tomatoes',
      data: stProdNeprodArr,
      backgroundColor: [
        '#E29CF3',
        '#9740E9',
        
      ],
      borderColor: [
        '#E29CF3',
        '#9740E9',
      ],
      borderWidth: 1
    }]
  },
  options: {
   	//cutoutPercentage: 40,
    responsive: false,

  }
});



</script>
</body>
</html>