#!/bin/bash

echo "Updating piscreen-client"

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

echo "Installing packages"
apt -y update
apt -y upgrade
apt -y install python3-pip php7.3 curl php7.3-curl libapache2-mod-php lightdm plymouth plymouth-themes pix-plym-splash unclutter dos2unix
apt -y install --no-install-recommends xserver-xorg x11-xserver-utils xinit openbox chromium-browser

echo "Removing unnessesary packages"
apt -y autoremove

echo "Installing python packages"
pip3 install -r /home/pi/piscreen-client/requirements.txt

echo "Removing default apache config"
rm /etc/apache2/ports.conf
rm /etc/apache2/sites-enabled/000-default.conf

echo "Copying playlist files to tmp location"
mv /var/www/localserver/includes/playlist /var

echo "Copying new configuration"
mv /home/pi/piscreen-client/dist/apache/000-default.conf /etc/apache2/sites-enabled/000-default.conf
mv /home/pi/piscreen-client/dist/apache/ports.conf /etc/apache2/ports.conf

echo "Removing old files"
rm -rf /var/www/apiserver
rm -rf /var/www/localserver

echo "Copying webfiles to new location"
mv /home/pi/piscreen-client/player/localserver /var/www
mv /home/pi/piscreen-client/player/apiserver /var/www
mv /var/playlist /var/www/localserver/includes
mv /home/pi/piscreen-client/dist/piscreen-client/scripts /var/piscreen-client

echo "Restarting apache"
systemctl restart apache2

echo "Setting timezone"
rm /etc/localtime
ln /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime

echo "Installing bootscreen"
mv /home/pi/piscreen-client/dist/files/splash.png /usr/share/plymouth/themes/pix
rm /boot/config.txt
mv /home/pi/piscreen-client/dist/files/config.txt /boot/config.txt
dos2unix /boot/config.txt
chmod 755 /boot/config.txt
rm /usr/share/plymouth/themes/pix/pix.script
mv /home/pi/piscreen-client/dist/files/pix.script /usr/share/plymouth/themes/pix/pix.script
dos2unix /usr/share/plymouth/themes/pix/pix.script
chmod 644 /usr/share/plymouth/themes/pix/pix.script
rm /boot/cmdline.txt
mv /home/pi/piscreen-client/dist/files/cmdline.txt /boot/cmdline.txt
dos2unix /boot/cmdline.txt
chmod 755 /boot/cmdline.txt

echo "Changing config files"
rm /etc/chromium-browser/default
mv /home/pi/piscreen-client/dist/files/default /etc/chromium-browser/default
chmod 644 /etc/chromium-browser/default

echo "Setting correct chmod settings"
chmod -R 777 /var/www
chmod -R 777 /var/piscreen-client

echo "Creating services"
mv /home/pi/piscreen-client/dist/files/piscreen.service /lib/systemd/system/piscreen.service
mv /home/pi/piscreen-client/dist/files/piscreen-updater.service /lib/systemd/system/piscreen-updater.service
chmod 644 /lib/systemd/system/piscreen.service
chmod 644 /lib/systemd/system/piscreen-updater.service
chmod +x /var/piscreen-client/scripts/piscreen.py
chmod +x /var/piscreen-client/scripts/update.py
systemctl daemon-reload
systemctl enable piscreen.service
systemctl enable piscreen-updater.service
systemctl start piscreen.service
systemctl start piscreen-updater.service

mv /home/pi/piscreen-client/CURRENT_VERSION /var/piscreen-client/data/CURRENT_VERSION

rm -rf /home/pi/piscreen-client

echo "Rebooting in 10 seconds"
sleep 10
reboot
