<?php

//Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include database and object files
include_once '../objects/playerdata.php';

//Initialize object
$playerdata = new Playerdata();

//Get URL data
$data = json_decode(file_get_contents("php://input"));
$playerdata->get_player_id = $data->player_id;

//Set response code to 200 OK
http_response_code(200);
//Tell the user
echo $playerdata->getData();

?>
