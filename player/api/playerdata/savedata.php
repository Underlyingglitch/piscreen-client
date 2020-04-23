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
$playerdata->player_id = $data->player_id;
$playerdata->player_name = $data->player_name;
$playerdata->ip = $data->ip_address;
$playerdata->last_checkin = $data->last_checkin;

if ($playerdata->savePlayerData()) {
  //Set response code to 200 OK
  http_response_code(200);
  //Tell the user
  echo json_encode(array("message" => "Successfully saved data"));
} else {
  //Set response code to 503 Service unavailable
  http_response_code(503);
  //Tell the user
  echo json_encode(array("message" => "Error while saving info"));
}

?>
