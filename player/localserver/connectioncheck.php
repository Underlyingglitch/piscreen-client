<?php

echo "<div style='display: none'>";
$response = null;
system("ping -c 1 google.com", $response);
echo "</div>";
if($response == 0) {
  echo "online";
} else {
  echo "offline";
}

?>
