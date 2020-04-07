import socket, time, os

def internet(host="8.8.8.8", port=53, timeout=3):
  try:
    socket.setdefaulttimeout(timeout)
    socket.socket(socket.AF_INET, socket.SOCK_STREAM).connect((host, port))
    return True
  except socket.error as ex:
    print(ex)
    return False

while True:
    time.sleep(1)
    if internet():
        print('Online')
    else:
        print('Offline')
        os.system('chromium-browser --kiosk /home/pi/piscreen-client/dist/pages/noconn.html')
