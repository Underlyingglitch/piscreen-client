<?php

echo "<div style='display: none'>";
$response = null;
system("ping -c 1 google.com", $response);
echo "</div>";
if($response == 0) {
  //Getting the local IP address of the server
  $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
  socket_connect($sock, "8.8.8.8", 53);
  socket_getsockname($sock, $name);

  //Security code
  //Check if code is present
  if (file_exists("/home/pi/piscreen-client/dist/data/securitycode")) {
    //Get code from file and display to page
    $code = file_get_contents("/home/pi/piscreen-client/dist/data/securitycode");
  } else {
    //Generate code and put in file
    $code = mt_rand(100000, 999999);
    file_put_contents("/home/pi/piscreen-client/dist/data/securitycode", $code);
  }

  //Setting page variables
  $client_ip = $name;
  $client_sec_code = $code;
  include "start.php";
} else {
  include "noconn.php";
}

?>
