<?php 
require("../koneksi.php");

session_start();

if(!isset($_SESSION['id'])){
  $_SESSION['msg'] = 'anda harus log in  untuk mengakses halaman ini';
  header('Location:../login.php');
}
$sesID = $_SESSION['id'];
$sesName = $_SESSION['username'];
$sesLvl = $_SESSION['level'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
  />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="../img/logo2.png" type="image/x-icon" />
  <title>MOP Green | Home Page</title>
  <style type="text/css">
    .sht h3{
      color: #3751FF;
      font-weight: bold;
    }
    .klt h3{
      color: #FF0000;
      font-weight: bold;
    }
    body{
      background-color: #2e3338;
    }
  </style>
</head>
<body >
  <!-- top navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#sidebar"
      aria-controls="offcanvasExample"
      >
      <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
    </button>
    <a
    class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
    href="#"
    >MOP Green
  </a>
  <button
  class="navbar-toggler"
  type="button"
  data-bs-toggle="collapse"
  data-bs-target="#topNavBar"
  aria-controls="topNavBar"
  aria-expanded="false"
  aria-label="Toggle navigation"
  >
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="topNavBar">
  <div class="d-flex ms-auto my-3 my-lg-0">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a
        class="nav-link dropdown-toggle ms-2"
        href="#"
        role="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        >
        <h8><?=$sesName?></h8>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
      </ul>
    </li>
  </ul>
</div>
</div>
</div>
</nav>
<!-- top navigation bar -->
<!-- offcanvas -->
<div
class="offcanvas offcanvas-start sidebar-nav bg-dark"
tabindex="-1"
id="sidebar"
>
<div class="offcanvas-body p-0">
  <nav class="navbar-dark">
    <ul class="navbar-nav">
      <li><hr class="dropdown-divider bg-light" /></li>
      <li>
        <a href="home.php" class="nav-link px-3 active">
          <span class="me-2"><i class="bi bi-speedometer2"></i></span>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="my-1"><hr class="dropdown-divider bg-light" /></li>
      <li>
        <div class="text-muted small fw-bold text-uppercase px-2 mb-1">
          Menu
        </div>
      </li>
      <li>
        <a href="map.php" class="nav-link px-3">
          <span class="me-2"><i class="bi bi-map"></i></span>
          <span>Map Dan Lokasi Sensor</span>
        </a>
      </li>
      <?php if ($sesLvl==1): ?>
        <li>
          <a href="controlling.php" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-cpu"></i></span>
            <span>Controlling</span>
          </a>
        </li>
      <?php endif ?>
      <li>
        <a href="logview.php" class="nav-link px-3">
          <span class="me-2"><i class="bi bi-view-list"></i></span>
          <span>Log View</span>
        </a>
      </li>
      <li>
        <a href="cctv.php" class="nav-link px-3">
          <span class="me-2"><i class="bi bi-camera"></i></span>
          <span>CCTV Controling</span>
        </a>
      </li>
      <?php if ($sesLvl==1): ?>
      <li>
        <a href="manage_user.php" class="nav-link px-3">
          <span class="me-2"><i class="bi bi-gear"></i></span>
          <span>Manage User</span>
        </a>
      </li>
      <?php endif ?>
    </ul>
  </nav>
</div>
</div>
<!-- offcanvas -->
<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 text-white">
        <h4>Dashboard</h4>
      </div>
      <div class="col-md-6">
        <h5 class="text-end text-white" id="time"></h5>
      </div>
    </div>
    <div class="card col-lg-3 col-md-3 col-sm-3 bg-dark">
      <div class="card-body">
        <div class="row text-white">
          <div class="col-md-6 col-sm-6 col-12 sht">
            <strong>Suhu</strong>
            <h3>51&deg;</h3>
          </div>
          <div class="col-md-6 col-sm-6 col-12 klt">
            <strong>Kelembapan</strong>
            <h3>51 <span>HR</span></h3>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-3">
        <select class="btn btn-dark text-start" id="listRoom" onchange="getSelectedValue();">
          <option value="Room 1">Room 1</option>
          <option value="Room 2">Room 2</option>
          <option value="Room 3">Room 3</option>
        </select>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
       <div class="alert alert-primary alert-dismissible">
        <h5><strong>Status Koneksi Broker MQTT</strong></h5>
        <div id="messages"></div>
      </div>      
    </div>          
  </div>
  <div class="row">
    <div class="col-lg-9 col-md-6 col-sm-6 col-6 mb-8">
      <div class="card h-100 bg-dark text-white">
        <div class="card-header">
          <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
          Chart Data Room 1
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <p class="text-center">
                <strong>Suhu</strong>
              </p>
              <div class="chart">                      
                <canvas id="chartTEMP" height="180" style="height: 180px;"></canvas>            
              </div>                    
            </div>
            <div class="col-sm-6">
              <p class="text-center">
                <strong>Kelembapan</strong>
              </p>
              <div class="chart">                      
                <canvas id="chartHUM" height="180" style="height: 180px;"></canvas>           
              </div>                    
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-4">
      <div class="card h-100 bg-dark text-white">
        <div class="card-header">
          <!-- <span class="me-2"><i class="bi bi-speedometer"></i></span> -->
          <h4 class="text-center" style="margin-bottom: -4px; font-weight: bold;">TODAY</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 text-center sht">
              <h6>Suhu Tertinggi</h6>
              <h3>51&deg;</h3>
            </div>
            <div class="col-md-6 text-center klt">
              <h6>Kelembapan Tertinggi</h6>
              <h3>51 <span>HR</span></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-center sht">
              <h6>Suhu Terendah</h6>
              <h3>51&deg;</h3>
            </div>
            <div class="col-md-6 text-center klt">
              <h6>Kelembapan Terendah</h6>
              <h3>51 <span>HR</span></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-center sht">
              <h6>Rata - Rata Suhu</h6>
              <h3>51&deg;</h3>
            </div>
            <div class="col-md-6 text-center klt">
              <h6>Rata - Rata Kelembapan</h6>
              <h3>51 <span>HR</span></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.5.1.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js"></script>
<script src="js/script.js"></script>
<!-- Chart timeseries -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@1.9.0"></script>
<!-- Chart Speed DHT11 -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>  
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/dataviz.js"></script>  
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<!-- Paho MQTT Client -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="../canvasjs.min.js"></script> -->
<script type="text/javascript">
  var timeDisplay = document.getElementById("time");
  function refreshTime() {
    var dateString = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
    var formattedString = dateString.replace(", ", " - ");
    timeDisplay.innerHTML = formattedString;
  }

  setInterval(refreshTime, 1000);
</script>
<script>
/*-----------------------------------------------------
  BAGIAN MQTT YANG TERKONEKSI DENGAN MESSAGE BROKER
  -----------------------------------------------------*/   
// Menentuan alamat IP dan PORT message broker
var host = "192.168.1.1";  
var port = 9001; 

// Konstruktor koneksi antara client dan message broker
var client = new Paho.MQTT.Client(host, port, "/ws",
  "myclientid_" + parseInt(Math.random() * 100, 10));   

// Menjalin koneksi antara client dan message broker
client.onConnectionLost = function (responseObject) {            
  document.getElementById("messages").innerHTML += "Koneksi Ke Broker MQTT Putus - " + responseObject.errorMessage + "<br/>";
};

// variabel global data sensor IoT Development Board
// website berposisi sebagai subscriber
var humi = 0;
var temp = 0;
var sr04 = 0;
var ldr = 0;
var keypad = "";

// Mendapatkan payload dari transimisi data IoT Development Board
// kemudian memilah dan melimpahkanya ke varibael berdasarkan TOPIC.
client.onMessageArrived = function (message) {    
  if (message.destinationName == "/ldr") {
    ldr = message.payloadString;
  } else if (message.destinationName == "/sr04") {
    sr04 = message.payloadString;
  } else if (message.destinationName == "/dht") {
    var dht = JSON.parse(message.payloadString);
    humi = dht.kelembaban;
    temp = dht.suhu;
  } else if (message.destinationName == "/remoteir") {
    keypad = message.payloadString;
  }
  
  document.getElementById("hitTEMP").innerHTML = temp + " °C";
  document.getElementById("hitHUM").innerHTML = humi + " H";
  document.getElementById("hitLDR").innerHTML = ldr + " Lux";
  document.getElementById("hitSR04").innerHTML = sr04 + " cm";  
  document.getElementById("kodekeypad").innerHTML = keypad; 
};

// Option mqtt dengan mode subscribe dan qos diset 1
var options = {
  timeout: 3,
  keepAliveInterval: 30,
  onSuccess: function () {
    document.getElementById("messages").innerHTML += "Koneksi Ke Broker MQTT Sukses" + "<br/>";       
    client.subscribe("/dht", {qos: 1});
    client.subscribe("/ldr", {qos: 1});
    client.subscribe("/sr04", {qos: 1});
    client.subscribe("/remoteir", {qos: 1});
  },

  onFailure: function (message) {
    document.getElementById("messages").innerHTML += "Koneksi ke Broker MQTT Gagal - " + message.errorMessage + "<br/>";                
  },

  userName:"AdminMQTT",
  password:"pwd123"
};

if (location.protocol == "https:") {
  options.useSSL = true;
}

document.getElementById("messages").innerHTML += "Koneksi Ke Broker MQTT - Alamat: " + host + ":" + port + "<br/>";
client.connect(options);
</script>
<script>
  /*------------------------------------------------------------
  BAGIAN CHART CANVAS
  https://nagix.github.io/chartjs-plugin-streaming/latest/
  ------------------------------------------------------------*/  
// Enumerasi tipe warna  
var chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

var color = Chart.helpers.color;
var saiki = new Date();
var dinoiki = saiki.toString();

/*--------------------------
  CHART TEMPERATUR DHT11
  --------------------------*/ 
// Update data sensor dht11
function onRefreshTEMP(chart) {
  chart.data.datasets[0].data.push({
    x: Date.now(),
    y: temp
  });
}

var configTEMP = {
  type: 'line',
  data: {
    datasets: [     
    {
      label: 'Temperatur (°C)',
      backgroundColor: color(chartColors.red).alpha(0.6).rgbString(),
      borderColor: chartColors.red,
      borderWidth: 1,     
      data: []
    }]
  },
  
  options: {
    title: {
      display: true,
      text: dinoiki
    },

    scales: {
      xAxes: [{
        type: 'realtime',
        realtime: {
          duration: 10000,
          refresh: 1500,
          delay: 2000,
          onRefresh: onRefreshTEMP
        }
      }],

      yAxes: [{
       type: 'linear',
       display: true,
       scaleLabel: {
         display: true,
         labelString: 'value'
       }
     }]
   },

   tooltips: {
     mode: 'nearest',
     intersect: false
   },

   hover: {
     mode: 'nearest',
     intersect: false
   }      
 }
};

/*--------------------------
  CHART KELEMBABAN DHT11
  --------------------------*/ 
// Update data sensor dht11
function onRefreshHUM(chart) {
  chart.data.datasets[0].data.push({
    x: Date.now(),
    y: humi
  });
}

var configHUM = {
  type: 'bar',
  data: {
    datasets: [     
    {
      label: 'Kelembaban (H)',
      backgroundColor: color(chartColors.blue).alpha(0.6).rgbString(),
      borderColor: chartColors.blue,
      borderWidth: 1,     
      data: []
    }]
  },
  
  options: {
    title: {
      display: true,
      text: dinoiki
    },

    scales: {
      xAxes: [{
        type: 'realtime',
        realtime: {
          duration: 10000,
          refresh: 1500,
          delay: 2000,
          onRefresh: onRefreshHUM
        }
      }],

      yAxes: [{
       type: 'linear',
       display: true,
       scaleLabel: {
         display: true,
         labelString: 'value'
       }
     }]
   },

   tooltips: {
     mode: 'nearest',
     intersect: false
   },

   hover: {
     mode: 'nearest',
     intersect: false
   }      
 }
};
window.onload = function() {
  // onload chart temperatur sensor DHT11
  var ctxTEMP = document.getElementById('chartTEMP').getContext('2d');
  window.chartTEMP = new Chart(ctxTEMP, configTEMP);
  
  // onload chart kelembaban sensor DHT11
  var ctxHUM = document.getElementById('chartHUM').getContext('2d');
  window.chartHUM = new Chart(ctxHUM, configHUM);
};
</script>
<script>
/*----------------------------
  BAGIAN SPEED CHART DHT11
  ----------------------------*/
  am4core.ready(function() {

  // Themes begin
  am4core.useTheme(am4themes_dataviz);
  am4core.useTheme(am4themes_animated);
  // Themes end
  
  //------------------------------------------
  //                Temperature
  //------------------------------------------
  
  // create chart
  var charttemp = am4core.create("chartdivtemp", am4charts.GaugeChart);
  charttemp.innerRadius = am4core.percent(82);
  
  /**
   * Normal axis
   */

   var axistemp = charttemp.xAxes.push(new am4charts.ValueAxis());
   axistemp.min = 0;
   axistemp.max = 100;
   axistemp.strictMinMax = true;
   axistemp.renderer.radius = am4core.percent(80);
   axistemp.renderer.inside = true;
   axistemp.renderer.line.strokeOpacity = 1;
   axistemp.renderer.ticks.template.disabled = false
   axistemp.renderer.ticks.template.strokeOpacity = 1;
   axistemp.renderer.ticks.template.length = 10;
   axistemp.renderer.grid.template.disabled = true;
   axistemp.renderer.labels.template.radius = 40;
   axistemp.renderer.labels.template.adapter.add("text", function(text) {
     return text + "°C";
   })

  /**
   * Axis for ranges
   */

   var colorSet = new am4core.ColorSet();

   var axis2temp = charttemp.xAxes.push(new am4charts.ValueAxis());
   axis2temp.min = 0;
   axis2temp.max = 100;
   axis2temp.strictMinMax = true;
   axis2temp.renderer.labels.template.disabled = true;
   axis2temp.renderer.ticks.template.disabled = true;
   axis2temp.renderer.grid.template.disabled = true;

   var range0temp = axis2temp.axisRanges.create();
   range0temp.value = 0;
   range0temp.endValue = 50;
   range0temp.axisFill.fillOpacity = 1;
   range0temp.axisFill.fill = colorSet.getIndex(0);

   var range1temp = axis2temp.axisRanges.create();
   range1temp.value = 50;
   range1temp.endValue = 100;
   range1temp.axisFill.fillOpacity = 1;
   range1temp.axisFill.fill = colorSet.getIndex(2);

  /**
   * Label
   */

   var labeltemp = charttemp.radarContainer.createChild(am4core.Label);
   labeltemp.isMeasured = false;
   labeltemp.fontSize = 45;
   labeltemp.x = am4core.percent(50);
   labeltemp.y = am4core.percent(100);
   labeltemp.horizontalCenter = "middle";
   labeltemp.verticalCenter = "bottom";
   labeltemp.text = "50%";


  /**
   * Hand
   */

   var handtemp = charttemp.hands.push(new am4charts.ClockHand());
   handtemp.axis = axis2temp;
   handtemp.innerRadius = am4core.percent(20);
   handtemp.startWidth = 10;
   handtemp.pin.disabled = true;
   handtemp.value = 50;

   handtemp.events.on("propertychanged", function(ev) {
     range0temp.endValue = ev.target.value;
     range1temp.value = ev.target.value;
     labeltemp.text = axis2temp.positionToValue(handtemp.currentPosition).toFixed(1);
     axis2temp.invalidate();
   });

  //------------------------------------------
  //                Humidity
  //------------------------------------------  

  // create chart
  var charthumi = am4core.create("chartdivhumi", am4charts.GaugeChart);
  charthumi.innerRadius = am4core.percent(82);
  
  /**
   * Normal axis
   */

   var axishumi = charthumi.xAxes.push(new am4charts.ValueAxis());
   axishumi.min = 0;
   axishumi.max = 100;
   axishumi.strictMinMax = true;
   axishumi.renderer.radius = am4core.percent(80);
   axishumi.renderer.inside = true;
   axishumi.renderer.line.strokeOpacity = 1;
   axishumi.renderer.ticks.template.disabled = false
   axishumi.renderer.ticks.template.strokeOpacity = 1;
   axishumi.renderer.ticks.template.length = 10;
   axishumi.renderer.grid.template.disabled = true;
   axishumi.renderer.labels.template.radius = 40;
   axishumi.renderer.labels.template.adapter.add("text", function(text) {
     return text + "H";
   })

  /**
   * Axis for ranges
   */ 

   var axis2humi = charthumi.xAxes.push(new am4charts.ValueAxis());
   axis2humi.min = 0;
   axis2humi.max = 100;
   axis2humi.strictMinMax = true;
   axis2humi.renderer.labels.template.disabled = true;
   axis2humi.renderer.ticks.template.disabled = true;
   axis2humi.renderer.grid.template.disabled = true;

   var range0humi = axis2humi.axisRanges.create();
   range0humi.value = 0;
   range0humi.endValue = 50;
   range0humi.axisFill.fillOpacity = 1;
   range0humi.axisFill.fill = colorSet.getIndex(0);

   var range1humi = axis2humi.axisRanges.create();
   range1humi.value = 50;
   range1humi.endValue = 100;
   range1humi.axisFill.fillOpacity = 1;
   range1humi.axisFill.fill = colorSet.getIndex(2);

  /**
   * Label
   */

   var labelhumi = charthumi.radarContainer.createChild(am4core.Label);
   labelhumi.isMeasured = false;
   labelhumi.fontSize = 45;
   labelhumi.x = am4core.percent(50);
   labelhumi.y = am4core.percent(100);
   labelhumi.horizontalCenter = "middle";
   labelhumi.verticalCenter = "bottom";
   labelhumi.text = "50%";


  /**
   * Hand
   */

   var handhumi = charthumi.hands.push(new am4charts.ClockHand());
   handhumi.axis = axis2humi;
   handhumi.innerRadius = am4core.percent(20);
   handhumi.startWidth = 10;
   handhumi.pin.disabled = true;
   handhumi.value = 50;

   handhumi.events.on("propertychanged", function(ev) {
     range0humi.endValue = ev.target.value;
     range1humi.value = ev.target.value;
     labelhumi.text = axis2humi.positionToValue(handhumi.currentPosition).toFixed(1);
     axis2humi.invalidate();
   });

  //------------------------------------------
  //             Animasi & Data
  //------------------------------------------
  setInterval(function() {    
   var valuetemp = Math.round(temp);
   var valuehumi = Math.round(humi);

   var animationtemp = new am4core.Animation(handtemp, {
    property: "value",
    to: valuetemp
  }, 1000, am4core.ease.cubicOut).start();

   var animationhumi = new am4core.Animation(handhumi, {
    property: "value",
    to: valuehumi
  }, 1000, am4core.ease.cubicOut).start();

 }, 1500);
  
});   
</script>
<script type="text/javascript">
  function getSelectedValue(){
    var selectedValue = document.getElementById("listRoom").value;
    console.log(selectedValue);
  }
</script>
</body>
</html>