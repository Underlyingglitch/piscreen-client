<?php

shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonCookie'));
shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonLock'));
shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonSocket'));

shell_exec(escapeshellcmd('sudo crontab -l > mycron'));
shell_exec(escapeshellcmd('sudo echo "* * * * * python /var/piscreen-client/scripts/update.py >/dev/null 2>&1" >> mycron'));
shell_exec(escapeshellcmd('sudo crontab mycron'));
shell_exec(escapeshellcmd('sudo rm mycron'));

shell_exec(escapeshellcmd('sudo reboot'));

?>
