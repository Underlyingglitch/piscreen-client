<?php

$serverconfig = json_decode(file_get_contents("/var/piscreen-client/data/serverconn.json"), true);
$newplaylist = json_decode(file_get_contents("/var/piscreen-client/data/serverfiles/current.json"), true);

$files = glob("/var/www/localserver/includes/playlist/".'*', GLOB_MARK);
foreach($files as $file) {
  if (!is_dir($file)) {
    unlink($file);
  }
}

$imgs = glob("/var/www/localserver/includes/playlist/imgs/".'*', GLOB_MARK);
foreach($imgs as $img) {
  if (!is_dir($img)) {
    unlink($img);
  }
}

$i = 0;
foreach($newplaylist['media'] as $entry) {
  if ($entry['type'] == "image") {
    $image = file_get_contents('http://'.$serverconfig['hostname'].':31804/player/getpage.php?type=image&id='.$entry['id']);
    file_put_contents("../playlist/imgs/".$entry['id'], $image);
    $template = file_get_contents('../templates/image.html');
    $file = str_replace("IMG_SOURCE_HERE", "includes/playlist/imgs/".$entry['id'], $template);
    file_put_contents("../playlist/".$i.".html", $file);
  } else if ($entry['type'] == "text") {
    $template = file_get_contents('../templates/text.html');
    $file = str_replace("TEXT_INPUT_HERE", $entry['value'], $template);
    file_put_contents("../playlist/".$i.".html", $file);
  }
  $i++;
}

unlink('/var/www/localserver/update.command');

?>
