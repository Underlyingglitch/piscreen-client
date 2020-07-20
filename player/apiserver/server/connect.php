<?php

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

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,'http://'.$_GET['server'].':31804/connect/confirm.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "client=".$_SERVER['SERVER_ADDR']."&name=".$_GET['name']."&code=".$_GET['code']);
    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);
    ?>
    <html>
      <head>
        <meta charset="utf-8">
        <title>PiScreen - Connected</title>

        <link rel="stylesheet" href="all.css">

        <!-- Fonts -->
        <link rel="stylesheet" href="roboto.css">

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
          <p class="text">De client heeft verbinding gemaakt met de server: <?php echo $_GET['server']; ?></p>
          <p class="text">U kunt dit scherm sluiten</p>
        </div>
      </body>
    </html>
    <?php
  } else {
    ?>
    <html>
      <head>
        <meta charset="utf-8">
        <title>PiScreen - Foutive code</title>

        <link rel="stylesheet" href="/var/www/localserver/vendor/fontawesome/css/all.css">

        <!-- Fonts -->
        <link rel="stylesheet" href="/var/www/localserver/css/roboto.css">

        <style>
          body {
            background: #333;
          }

          .icon {
            font-size: 300px;
            color: red;
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
          <i class="fas fa-times-circle fa-7x icon"></i>
          <h1 class="title">Error</h1>
          <p class="text">Onbekende fout! Probeer het later opnieuw! U kunt dit scherm sluiten</p>
        </div>
      </body>
    </html>
    <?php
  }

} else {
  ?>
  <html>
    <head>
      <meta charset="utf-8">
      <title>PiScreen - Foutive code</title>

      <link rel="stylesheet" href="/var/www/localserver/vendor/fontawesome/css/all.css">

      <!-- Fonts -->
      <link rel="stylesheet" href="/var/www/localserver/css/roboto.css">

      <style>
        body {
          background: #333;
        }

        .icon {
          font-size: 300px;
          color: red;
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
        <i class="fas fa-lock fa-7x icon"></i>
        <h1 class="title">Foutieve code</h1>
        <p class="text">U heeft een foutieve code ingevoerd. Sluit dit scherm, en probeer het opnieuw!</p>
      </div>
    </body>
  </html>
  <?php
}

?>
