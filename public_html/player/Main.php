<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once("Insert.php");
require_once("Get.php");

$mode = $_POST['m'];

if ($mode == "add") {
    add();
}
else if ($mode == "playnow") {
    playnow();
}
else if ($mode == "next") {
    playNext();
}

function add() {
    $url = $_POST['url'];

    $insert = new Insert;

    $insert->url = $url;
    $insert->status = "NOW";
    $insert->insert();
}

function playnow() {
    $video = new Get;
    longOrShortUrl($video, $video->playNow());
}

function playNext() {
    $video = new Get;
    longOrShortUrl($video, $video->playNext());
}

function longOrShortUrl($video, $videoToPlayNow) {
    if ($videoToPlayNow !== false) {
        echo $video->url;
    }
    else {
        echo "e";
    }
}

?>
