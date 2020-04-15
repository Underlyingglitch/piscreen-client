<?php

if (isset($_POST['code']) && isset($_POST['name'])) {
  $code = file_get_contents("/home/pi/piscreen-client/dist/data/securitycode");

  if ($code === $_POST['code']) {
    $name = htmlspecialchars(stripslashes(strtolower(str_replace(' ', '', $_POST['name']))));
    file_put_contents("/home/pi/piscreen-client/dist/data/playername", $name);
    $command = escapeshellcmd('/home/pi/piscreen-client/dist/scripts/setup.py');
    $output = shell_exec($command);
    echo $output;
  } else {
    echo "Foutieve code ingevoerd!";
  }
} else {
  echo "Niet alle data compleet";
}

?>
