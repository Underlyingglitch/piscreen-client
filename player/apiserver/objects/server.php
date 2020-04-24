<?php

class Server {

  private $datapath = "../../../dist/data";
  private $securitycode;

  public $connect_name;
  public $connect_code;
  public $server_location;

  public function __construct() {
    $this->securitycode = file_get_contents("/home/pi/piscreen-client/dist/data/securitycode");
  }

  function connect() {
    $data = array("hostname" => $this->server_location, "is_loaded" => 0);
    file_put_contents("/home/pi/piscreen-client/dist/data/serverconn.json", json_encode($data));
    return true;
  }

  function isCode() {
    //Check if code is match
    if ($this->connect_code === $this->securitycode) {
      shell_exec(escapeshellcmd('sudo raspi-config nonint do_hostname '.$this->connect_name));
      return true;
    }
  }

}

?>
