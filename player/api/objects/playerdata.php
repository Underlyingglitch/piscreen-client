<?php

class Playerdata{

  //Database connection and table name
  private $conn;
  private $table_name = "users";
  private $settings_table = "settings";

  public $player_id;
  public $player_name;
  public $ip;
  public $last_checkin;

  public $get_player_id;

  //Constructor with $db as database connection
  // public function __construct($db){
  //   $this->conn = $db;
  // }

  public function savePlayerData() {
    $id = htmlspecialchars(stripslashes($this->player_id));
    $data = array("name" => htmlspecialchars(stripslashes($this->player_name)), "ip" => htmlspecialchars(stripslashes($this->ip)), "last_checkin" => htmlspecialchars(stripslashes($this->last_checkin)));
    file_put_contents('../../data/players/'.$id.'.json', json_encode($data));
    return true;
  }

  public function getData() {
    $id = htmlspecialchars(stripslashes($this->get_player_id));
    return file_get_contents('../../data/players/'.$id.'.json');
  }
}

?>
