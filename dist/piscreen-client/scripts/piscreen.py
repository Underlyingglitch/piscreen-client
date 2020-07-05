#!/usr/bin/env python

import os.path
from os import path
import time

while True:
    time.sleep(3)
    #check for reboot command
    if path.exists('/var/www/apiserver/server/reboot.command'):
        os.remove('/var/www/apiserver/server/reboot.command')
        os.remove('/home/pi/.config/chromium/SingletonLock')
        os.remove('/home/pi/.config/chromium/SingletonCookie')
        os.remove('/home/pi/.config/chromium/SingletonSocket')

        os.system('sudo reboot')
