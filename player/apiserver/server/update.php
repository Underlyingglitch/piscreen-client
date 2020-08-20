<?php

if (file_exists('../update')) {
  file_put_contents('../update.command', '');
  echo "Start update. Dit kan enkele minuten duren. Laat de stroom en internetkabels aangesloten.";
} else {
  echo "No update available";
}

?>
