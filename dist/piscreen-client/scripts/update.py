import requests, json, hashlib, os, time

while True:
    time.sleep(3)

    # Get local server connection
    with open('/var/piscreen-client/data/serverconn.json') as f:
        connection = json.loads(f.read())
    f.close()

    with open('/var/piscreen-client/data/securitycode') as f:
        securitycode = f.read()
    f.close()

    with open('/var/piscreen-client/data/serverfiles/current.json') as f:
        file = f.read().replace("\'", '').replace(" ", "")
        current = hashlib.md5(file.encode()).hexdigest()
    f.close()

    # Get update check from connected server
    response = requests.get('http://{}:31804/player/checkupdate.php?code={}&hash={}'.format(connection['hostname'], securitycode, current)).text

    if (response == "true"):
        # Get current playlist
        # Get new playlist details
        details = requests.get('http://{}:31804/player/getplaylist.php?code={}'.format(connection['hostname'], securitycode)).text

        details = details.rstrip("\n")

        if details == "empty":
            #no playlist
            os.remove('/var/piscreen-client/data/serverfiles/current.json')

            with open('/var/piscreen-client/data/serverfiles/current.json', 'w+') as f:
                f.write('[]')
            os.system('touch /var/www/localserver/update.command')
        else:
            details = json.loads(details)

            os.remove('/var/piscreen-client/data/serverfiles/current.json')

            with open('/var/piscreen-client/data/serverfiles/current.json', 'w+') as f:
                f.write(json.dumps(details))
            os.system('touch /var/www/localserver/update.command')
    else:
        print('No update!')
