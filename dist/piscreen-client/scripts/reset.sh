#!/bin/bash

if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

rm -rf /var/www/localserver
rm -rf /var/www/apiserver
rm -rf /var/piscreen-client

systemctl restart apache2

git clone https://github.com/underlyingglitch/piscreen-client /home/pi/piscreen-client

sudo sh /home/pi/piscreen-client/install.sh
