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
    </div>
  </body>
</html>
