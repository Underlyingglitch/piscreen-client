<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PiScreen - Get Started</title>

    <!-- Fonts -->
    <link href="css/roboto.css" rel="stylesheet">

    <style>
      body {
        background: #333;
      }

      .logo {
        max-width: 100%;
        max-height: 100%;
        display: block;
      }

      .title {
        font-family: Roboto;
        font-size: 60px;
        color: white;
      }

      .text {
        font-family: Roboto;
        font-size: 60px;
        color: white;
      }

      .main {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
      }

      .col {
        width: 50%;
      }

      .col-left {
        display: block;
        align: left;
        float: left;
      }

      .col-right {
        display: block;
        align: right;
        float: right;
      }
    </style>

  </head>
  <body>
    <div class="main" align="center">
      <div class="col col-left">
        <img class="logo" src="img/logo_piscreen.png">
      </div>
      <div class="col col-right">
        <p class="text">IP: <?php echo $client_ip; ?></p>
        <p class="text">Code: <?php echo $client_sec_code; ?></p>
      </div>
    </div>
  </body>
</html>
