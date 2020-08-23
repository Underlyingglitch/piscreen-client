<?php

if (file_exists('../update')) {
  file_put_contents('../update.command', '');
  ?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title></title>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
      <p>Start update. Dit kan enkele minuten duren. Fouten op het scherm van de player worden vanzelf opgelost. Laat de stroom en internetkabels aangesloten</p>

      <div style="width: 100%" id="status">

      </div>


    </body>

    <script>
      $(document).ready(function(){
        function getStatus(){
          $.get('updatestatus.php', function(data){
            $('#status').html(data);
          });
        }

        setInterval(getStatus(), 1000);
      });
    </script>
  </html>
  <?php
} else {
  echo "No update available";
}

?>
