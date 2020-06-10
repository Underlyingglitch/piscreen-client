<?php

//Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include database and object files
include_once '../objects/server.php';

//Initialize object
$server = new Server();

//Get URL data
$server->connect_name = htmlspecialchars(stripslashes(strtolower(str_replace(' ', '', $_GET['name']))));
$server->connect_code = htmlspecialchars(stripslashes($_GET['code']));

if ($server->isCode()) {
  $server->server_location = $_GET['server'];
  if ($server->connect()) {
    //Set response code to 200 OK
    http_response_code(200);
    //Tell the user
    $connect = file_get_contents('http://'.$_GET['server'].':31804/connect/confirm.php?client='.$_SERVER['SERVER_ADDR'].'&name='.$_GET['name'].'&code='.$_GET['code']);
    ?>
    <html>
      <head>
        <meta charset="utf-8">
        <title>PiScreen - Connected</title>

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
        </div>

        <script>
        fetch("reboot.php", {
          method: "POST"
        }).then(res => {
          console.log("Request complete! response:", res);
        });
        </script>
      </body>
    </html>
    <?php
  } else {
    //Set response code to 503 Service unavailable
    http_response_code(503);
    //Tell the user
    echo json_encode(array("message" => "Error while connecting"));
  }

} else {
  //Set response code to 503 Service unavailable
  http_response_code(503);
  //Tell the user
  echo json_encode(array("message" => "Incorrect code"));
}

?>
