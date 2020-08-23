#!/usr/bin/env python

import os.path
from os import path
import time, requests

def rebootCheck():
    if path.exists('/var/www/apiserver/server/reboot.command'):
        os.remove('/var/www/apiserver/server/reboot.command')
        os.remove('/home/pi/.config/chromium/SingletonLock')
        os.remove('/home/pi/.config/chromium/SingletonCookie')
        os.remove('/home/pi/.config/chromium/SingletonSocket')

        os.system('sudo reboot')

def resetCheck():
    if path.exists('/var/www/apiserver/server/reset.command'):
        #Perform reset action
        os.system('sudo sh reset.sh')

def updatecheck():
    #Check for updates
    try:
        newversion = requests.get('https://raw.githubusercontent.com/Underlyingglitch/piscreen-client/master/CURRENT_VERSION').text.strip()
    except requests.exceptions.ConnectionError:
        with open('/var/piscreen-client/data/CURRENT_VERSION') as f:
            newversion = f.read().strip()
        f.close()

    with open('/var/piscreen-client/data/CURRENT_VERSION') as f:
        currentversion = f.read().strip()
    f.close()
    if (newversion != currentversion):
        # Update available
        with open('/var/www/apiserver/update', 'w') as f:
            f.write('update available')
        f.close()

def updateInstall():
    if path.exists('/var/www/apiserver/update.command'):
        print('starting')
        os.remove('/var/www/apiserver/update.command')
        os.remove('/var/www/apiserver/update')
        os.system('sudo sh /var/piscreen-client/scripts/update.sh')

while True:
    time.sleep(3)
    rebootCheck()
    resetCheck()
    updatecheck()
    updateInstall()
