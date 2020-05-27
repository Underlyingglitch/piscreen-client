<?php

//Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include database and object files
include_once '../objects/server.php';

//Initialize object
$server = new Server();

//Get URL data
$data = json_decode(file_get_contents("php://input"));
$serverip = $data->ip;

shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonCookie'));
shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonLock'));
shell_exec(escapeshellcmd('sudo rm -rf /home/pi/.config/chromium/SingletonSocket'));
shell_exec(escapeshellcmd('sudo reboot'));

?>
