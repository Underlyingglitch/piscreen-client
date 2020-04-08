<?php

echo "<div style='display: none'>";
$response = null;
system("ping -c 1 google.com", $response);
echo "</div>";
if($response == 0) {
    $client_ip = "Some IP";
    $client_sec_code = "Sec code";
    include "start.php";
} else {
  include "noconn.php";
}

?>
