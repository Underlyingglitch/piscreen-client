<?php

header('Access-Control-Allow-Origin: *');

if (file_exists('../localserver/update.command')) {
  echo "Updating";
} else if (file_exists('../update')) {
  echo "Update available";
} else {
  echo "OK";
}

?>
