<?php

echo shell_exec(escapeshellcmd('journalctl -f -u piscreen.service 2>&1'));

?>
