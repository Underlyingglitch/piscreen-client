#!/bin/bash

echo "Installing piscreen-client"

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

echo "Installing packages"
apt-get -y update
apt-get -y install php
apt-get -y install lightdm
apt-get -y install plymouth plymouth-themes
apt-get -y install pix-plym-splash
apt-get -y install --no-install-recommends xserver-xorg x11-xserver-utils xinit openbox
apt-get -y install --no-install-recommends chromium-browser
apt-get -y install unclutter

echo "Setting raspi-config variables"
raspi-config nonint do_hostname piscreenclient
raspi-config nonint do_boot_behaviour B4
raspi-config nonint do_overscan 0
raspi-config nonint do_memory_split 256

echo "Setting timezone"
rm /etc/localtime
ln /usr/share/soneinfo/Europe/Amsterdam /etc/localtime

echo "Removing unnessesary packages"
apt -y autoremove

echo "Removing apache2"
apt-get -y remove apache2
apt-get -y purge apache2

echo "Installing bootscreen"
mv /home/pi/piscreen-client/dist/files/splash.png /usr/share/plymouth/themes/pix
rm /boot/config.txt
mv /home/pi/piscreen-client/dist/files/config.txt /boot/config.txt
rm /usr/share/plymouth/themes/pix/pix.script
mv /home/pi/piscreen-client/dist/files/pix.script /usr/share/plymouth/themes/pix/pix.script
rm /boot/cmdline.txt
mv /home/pi/piscreen-client/dist/files/cmdline.txt /boot/cmdline.txt

echo "Installing startup script"
rm /etc/xdg/openbox/autostart
mv /home/pi/piscreen-client/dist/files/autostart /etc/xdg/openbox/autostart

echo "Creating services"
mv dist/scripts/piscreen-client-localserver.service /lib/systemd/system/piscreen-client-localserver.service
chmod 644 /lib/systemd/system/piscreen-client-localserver.service
chmod +x /home/pi/piscreen-client/player/localserver.py

echo "Reloading startup sequence"
systemctl daemon-reload

echo "Starting services"
systemctl enable piscreen-client-localserver.service
systemctl start piscreen-client-localserver.service
