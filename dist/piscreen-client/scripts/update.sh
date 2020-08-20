#!/bin/bash

echo "Updating piscreen-client"

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

rm -rf /var/www/apiserver
rm -rf /var/www/localserver
rm -rf /home/pi/piscreen-client

git clone https://github.com/Underlyingglitch/piscreen-client /home/pi/piscreen-client

sudo sh /home/pi/piscreen-client/update.sh
