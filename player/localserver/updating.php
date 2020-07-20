<html>
  <head>
    <meta charset="utf-8">
    <title>PiScreen - Updating</title>

    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="css/roboto.css">

    <style>
      body {
        background: #333;
      }

      .icon {
        font-size: 300px;
        color: orange;
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

    <script src="vendor/jquery/jquery.min.js"></script>
  </head>
  <body>
    <div class="main" align="center">
      <i class="fas fa-sync-alt fa-7x icon"></i>
      <h1 class="title">Updaten...</h1>
      <p class="text">De nieuwe bestanden worden nu opgehaald. Zodra dit proces is voltooid zijn de nieuwe wijzigingen te zien!</p>
    </div>
    <script>
    $(document).ready(function(){
      $.post('includes/actions/update.php');
      function checkUpdate() {
        $.post('includes/actions/checkupdate.php', function(data){
          if (data == "false") {
            $('#update').html('Update found!');
            location.replace('player.php');
          }
        });
      }

      setInterval(function(){
        checkUpdate();
      }, 5000);
    });
    </script>
  </body>
</html>
