<?php

shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonCookie'));
shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonLock'));
shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonSocket'));
shell_exec(escapeshellcmd('sudo reboot'));

?>
