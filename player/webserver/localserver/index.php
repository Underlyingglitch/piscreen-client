<?php

$response = null;
system("ping -c 1 google.com", $response);
if($response == 0) {
    // this means you are connected
    include "start.php";
} else {
  include "noconn.php";
}

?>
