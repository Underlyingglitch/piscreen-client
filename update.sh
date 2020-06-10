#!/bin/bash

echo "Updating piscreen-client"

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

echo "Updating packages"
apt-get -y update
apt-get -y upgrade

echo "Updating webfiles"
echo "Downloading files"
git clone https://github.com/Underlyingglitch/piscreen-client piscreen-client-update
cd piscreen-client-update
echo "Removing old files"
rm -rf ../../player
echo "Copying new files"
cp -r player ../../player

echo "restarting services"
systemctl restart piscreen-server-api.service
systemctl restart piscreen-server-controlpanel.service

mv dist/scripts/piscreen-client-localserver.service /lib/systemd/system/piscreen-client-localserver.service
mv dist/scripts/piscreen-client-apiserver.service /lib/systemd/system/piscreen-client-apiserver.service
chmod 644 /lib/systemd/system/piscreen-client-localserver.service
chmod 644 /lib/systemd/system/piscreen-client-apiserver.service
chmod +x /home/pi/piscreen-client/player/localserver.py
chmod +x /home/pi/piscreen-client/player/apiserver.py

systemctl enable piscreen-client-localserver.service
systemctl enable piscreen-client-apiserver.service
systemctl start piscreen-client-localserver.service
systemctl start piscreen-client-apiserver.service

echo "Removing tmp files"
cd ../../
rm -rf piscreen-server-update
