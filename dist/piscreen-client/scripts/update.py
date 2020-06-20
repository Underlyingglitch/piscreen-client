import requests, json

with open('/var/piscreen-client/data/serverconn.json') as f:
    connection = json.load(f)

f.close()

response = json.load(requests.get('http://{}:31804/player/checkupdate.php'.format(connection['hostname'])).text)

with open('/var/piscreen-client/data/serverfiles/current.json') as f:
    data = json.load(f)

if (response['last_updated'] != data['last_updated']):
    #Update local files with new server files
