<?php
require_once("Insert.php");
require_once("Get.php");

class Navigation {

    public function add($url) {
        $insert = new Insert;
        $insert->url = $url;
        $insert->status = "NOW";
        $insert->insert();
    }

    public function playnow() {
        $video = new Get;
        printUrlOrError($video, $video->playNow());
    }

    public function playNext() {
        $video = new Get;
        printUrlOrError($video, $video->playNext());
    }

    private function printUrlOrError($video, $videoToPlayNow) {
        if ($videoToPlayNow !== false) {
            echo $video->url;
        }
        else {
            echo "e";
        }
    }
}

?>
