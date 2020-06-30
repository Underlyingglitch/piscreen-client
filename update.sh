#!/bin/bash

echo "Installing piscreen-client"

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

echo "Installing packages"
apt -y update
apt -y upgrade

echo "Removing unnessesary packages"
apt -y autoremove

echo "Downloading new data"
git clone https://github.com/underlyingglitch/piscreen-client update

echo "Installing python packages"
pip install -r requirements.txt

echo "Removing default apache config"
rm /etc/apache2/ports.conf
rm /etc/apache2/sites-enabled/000-default.conf

echo "Copying new configuration"
mv /home/pi/piscreen-client/dist/apache/000-default.conf /etc/apache2/sites-enabled/000-default.conf
mv /home/pi/piscreen-client/dist/apache/ports.conf /etc/apache2/ports.conf

echo "Deleting previous version"
rm -rf /var/www/localserver
rm -rf /var/www/apiserver
rm -rf /var/piscreen-client

echo "Copying webfiles to new location"
mv /home/pi/piscreen-client/player/localserver /var/www
mv /home/pi/piscreen-client/player/apiserver /var/www

echo "Setting up files"
mv /home/pi/piscreen-client/dist/piscreen-client /var

echo "Restarting apache"
systemctl restart apache2

echo "Setting raspi-config variables"
raspi-config nonint do_hostname piscreenclient
raspi-config nonint do_boot_behaviour B4
raspi-config nonint do_overscan 0
raspi-config nonint do_memory_split 256

echo "Setting timezone"
rm /etc/localtime
ln /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime

echo "Installing bootscreen"
rm /usr/share/plymouth/themes/pix
mv /home/pi/piscreen-client/update/dist/files/splash.png /usr/share/plymouth/themes/pix

rm /boot/config.txt
mv /home/pi/piscreen-client/update/dist/files/config.txt /boot/config.txt
dos2unix /boot/config.txt

rm /usr/share/plymouth/themes/pix/pix.script
mv /home/pi/piscreen-client/update/dist/files/pix.script /usr/share/plymouth/themes/pix/pix.script
dos2unix /usr/share/plymouth/themes/pix/pix.script

rm /boot/cmdline.txt
mv /home/pi/piscreen-client/update/dist/files/cmdline.txt /boot/cmdline.txt
dos2unix /boot/cmdline.txt

echo "Installing startup script"
rm /etc/xdg/openbox/autostart
mv /home/pi/piscreen-client/dist/files/autostart /etc/xdg/openbox/autostart
dos2unix /etc/xdg/openbox/autostart

echo "Setting correct chmod settings"
chmod -R 777 /var/www
chmod -R 777 /var/piscreen-client

echo "Creating piscreen service"
mv ~/piscreen-client/dist/files/piscreen.service lib/systemd/system/piscreen.service

chmod 644 /lib/systemd/system/piscreen.service
chmod +x /var/piscreen-client/scripts/piscreen.sh
sudo systemctl daemon-reload
sudo systemctl enable piscreen.service
sudo systemctl start piscreen.service

echo "Rebooting in 10 seconds"
sleep 10
reboot
