<?php

$content = json_decode(file_get_contents("/var/piscreen-client/data/serverconn.json"), true);

$content['is_loaded'] = 1;

file_put_contents("var/piscreen-client/data/serverconn.json", json_encode($content));

?>

<html>
  <head>
    <meta charset="utf-8">
    <title>PiScreen - Install Succeeded</title>

    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="css/roboto.css">

    <style>
      body {
        background: #333;
      }

      .icon {
        font-size: 300px;
        color: green;
      }

      .title {
        font-family: Roboto;
        font-size: 90px;
        color: white;
      }

      .text {
        font-family: Roboto;
        font-size: 30px;
        color: white;
      }

      .main {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
      }
    </style>
  </head>
  <body>
    <div class="main" align="center">
      <i class="fas fa-check-circle fa-7x icon"></i>
      <h1 class="title">Geslaagd</h1>
      <p class="text">De client heeft verbinding gemaakt met de server: <?php echo $server_ip; ?></p>
      <div id="countdown"></div>
    </div>
    <script>
    var timeleft = 20;
    var downloadTimer = setInterval(function(){
      if(timeleft <= 0){
        clearInterval(downloadTimer);
        document.getElementById("countdown").innerHTML = "Doorsturen....";
        window.location.replace("player.php");
      } else {
        document.getElementById("countdown").innerHTML = "Scherm sluit over: "+timeleft+" seconden";
      }
      timeleft -= 1;
    }, 1000);
    </script>
  </body>
</html>
