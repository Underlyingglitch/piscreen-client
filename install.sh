#!/bin/bash

echo "Installing piscreen-client"

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

echo "Installing packages"
apt-get -y update
apt-get -y install php

echo "Removing unnessesary packages"
apt -y autoremove

echo "Removing apache2"
apt-get -y remove apache2
apt-get -y purge apache2

echo "Creating startup scripts"
mv dist/scripts/piscreen-client-networkcheck.service /lib/systemd/system/piscreen-client-networkcheck.service
chmod 644 /lib/systemd/system/piscreen-client-networkcheck.service
chmod +x /home/pi/piscreen-client/player/networkcheck.py

echo "Reloading startup sequence"
systemctl daemon-reload

echo "Starting services"
systemctl enable piscreen-client-networkcheck.service
systemctl start piscreen-client-networkcheck.service
