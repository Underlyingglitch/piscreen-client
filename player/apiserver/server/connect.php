<?php

//Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include database and object files
include_once '../objects/server.php';

//Initialize object
$server = new Server();

//Get URL data
$server->connect_name = htmlspecialchars(stripslashes(strtolower(str_replace(' ', '', $_POST['name']))));
$server->connect_code = htmlspecialchars(stripslashes($_POST['code']));

if ($server->isCode()) {
  $server->server_location = $_SERVER['REMOTE_ADDR'];
  if ($server->connect()) {
    //Set response code to 200 OK
    http_response_code(200);
    //Tell the user
    echo "success";
  } else {
    //Set response code to 503 Service unavailable
    http_response_code(503);
    //Tell the user
    echo json_encode(array("message" => "Error while connecting"));
  }

} else {
  //Set response code to 503 Service unavailable
  http_response_code(503);
  //Tell the user
  echo json_encode(array("message" => "Incorrect code"));
}

?>
