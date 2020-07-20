<?php

$current = json_decode(file_get_contents("/var/piscreen-client/data/serverfiles/current.json"), true);

$playlistlength = count($current['media']);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>PiScreen - Player</title>

  <link rel="stylesheet" href="vendor/fontawesome/css/all.css">

  <!-- Fonts -->
  <link rel="stylesheet" href="css/roboto.css">

  <style>
    body {
      background: #000;
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
  </style>

  <script src="vendor/jquery/jquery.min.js"></script>
</head>
  <body>
    <div class="main" align="center"></div>
  </body>

  <script>
  $(document).ready(function(){
    function checkUpdate() {
      $.post('includes/actions/checkupdate.php', function(data){
        if (data == "true") {
          location.replace('updating.php');
        }
      });
    }

    setInterval(function(){
      checkUpdate();
    }, 2000);

    var length = <?php echo $playlistlength; ?>;
    var current = 0;
    if (length == 0) {
      $('.main').load('includes/templates/noplaylist.html');
    } else {
      // setInterval(nextSlide, 5000);
      nextSlide();

      function nextSlide() {
        $('.main').html('');
        $('.main').load('includes/playlist/'+current+'.html');
        setTimeout(function(){
          if (current == length-1) {
            current = 0;
          } else {
            current++;
          }
          nextSlide();
        }, 5000);
      }
    }
  });
  </script>
</html>
