<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
// include header and config
include_once('includes/header.php');
include_once('includes/config.php');
// property for what methods is used
$method = $_SERVER['REQUEST_METHOD'];
$guest = new Guests();
// check for method to be POST
if ($method != "GET") {
    http_response_code(405);
    $message = array("message" => "Endast GET anrop tillåts.");
    exit;
}
// check for both username and password
if (isset($_GET["date"])) {
    $date = $_GET["date"];
    if (!$guest->setDate($date)) return false;
    $seats = $guest->countGuests($date);
    if ($seats['guests'] != null) {
        $seats = $seats['guests'];
    } else {
        $seats = 0;
    }

    if ($seats == 0) {
        // return no available seats
        $message = array("seats" => 0);
        http_response_code(200);
    } else {
        // returns number of free seats
        $message = array("seats" => $seats);
        http_response_code(200);
    }
} else {
    http_response_code(400);
    $message = array("message" => "Count och Date måste anges.");
    exit;
}

echo json_encode($message);
