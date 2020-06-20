import requests, json

# Get local server connection
with open('/var/piscreen-client/data/serverconn.json') as f:
    connection = json.load(f)
f.close()

with open('/var/piscreen-client/data/securitycode') as f:
    securitycode = f.read()
f.close()

# Get update check from connected server
response = json.load(requests.get('http://{}:31804/player/checkupdate.php?code={}'.format(connection['hostname'], securitycode)).text)

# Get current playlist
with open('/var/piscreen-client/data/serverfiles/current.json') as f:
    data = json.load(f)

    # Check if playlist is up to date
    if (response['last_updated'] != data['last_updated']):
        # Update local files with new server files
        # Get new playlist details
        details = json.load(requests.get('http://{}:31804/player/getlastplaylist.php?code={}'.format(connection['hostname'], securitycode)).text)

        # Set last updated to new date
        data['last_updated'] = response['last_updated']

        # Create new local playlist
        data['slides'] = details['data']

        # Write new data to file
        f.write(json.dumps(data))

        print(f.read())
