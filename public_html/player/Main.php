<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once("Navigation.php");

$mode = $_POST['m'];
$navi = new Navigation;

if ($mode == "add") {
    $navi->add($_POST['url']);
}
else if ($mode == "playnow") {
    $navi->playnow();
}
else if ($mode == "next") {
    $navi->playNext();
}
else {
    echo "error";
}

?>
