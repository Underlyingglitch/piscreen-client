import os

with open('../data/playername') as f:
    name = f.read()

os.system('sudo raspi-config nonint do_hostname '+name)
os.system('sudo reboot')
