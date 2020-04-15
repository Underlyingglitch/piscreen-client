<?php

header('Access-Control-Allow-Origin: *');

if (isset($_POST['code']) && isset($_POST['name'])) {
  $code = file_get_contents("/home/pi/piscreen-client/dist/data/securitycode");

  if ($code === $_POST['code']) {
    $name = htmlspecialchars(stripslashes(strtolower(str_replace(' ', '', $_POST['name']))));
    shell_exec(escapeshellcmd('sudo raspi-config nonint do_hostname '.$name));
    $data = array("hostname" => $_SERVER['REMOTE_ADDR'], "is_loaded" => 0);
    file_put_contents("/home/pi/piscreen-client/dist/data/serverconn.json", json_encode($data));
    echo "success";
    shell_exec(escapeshellcmd('sudo reboot'));
  } else {
    echo "Foutieve code ingevoerd!";
  }
} else {
  echo "Niet alle data compleet";
}

?>
