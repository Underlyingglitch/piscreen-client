<?php

echo "<div style='display: none'>";
$response = null;
system("ping -c 1 google.com", $response);
echo "</div>";
if($response == 0) {

  if (file_exists("/var/piscreen-client/data/serverconn.json")) {
    //Getting local config file
    $json = file_get_contents("/var/piscreen-client/data/serverconn.json");
    $array = json_decode($json, true);

    if ($array['is_loaded'] === 0) {
      $server_ip = $array['hostname'];
      include "success.php";
    } else if ($array['is_loaded'] === 1) {
      include "player.php";
    } else {
      include "failed.php";
    }
  } else {
    //Getting the local IP address of the server
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_connect($sock, "8.8.8.8", 53);
    socket_getsockname($sock, $name);

    //Security code
    //Check if code is present
    if (file_get_contents("/var/piscreen-client/data/securitycode") != "") {
      //Get code from file and display to page
      $code = file_get_contents("/var/piscreen-client/data/securitycode");
    } else {
      //Generate code and put in file
      $code = mt_rand(100000, 999999);
      file_put_contents("/var/piscreen-client/data/securitycode", $code);
    }

    //Setting page variables
    $client_ip = $name;
    $client_sec_code = $code;
    include "start.php";
  }
} else {
  if (file_exists("/var/piscreen-client/data/serverconn.json")) {
    include "player.php";
  } else {
    include "noconn.php";
  }
}

?>
