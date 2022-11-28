<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
// include header and config
include_once('includes/header.php');
include_once('includes/config.php');
// property for what methods is used
$method = $_SERVER['REQUEST_METHOD'];

// check for method to be POST
if ($method != "POST") {
    http_response_code(405);
    $message = array("message" => "Endast POST anrop tillåts.");
    exit;
}

// convert JSOn to object
$data = json_decode(file_get_contents("php://input"), true);

// create object
$mail = new Mail();

// check that inputs exist 
if (isset($data["name"]) && isset($data["email"]) && isset($data["message"])) {
    $name = $data["name"];
    $email = $data["email"];
    $message = $data["message"];
} else {
    http_response_code(400);
    $message = array("message" => "Namn, epost och meddelande måste anges.");
    exit;
}

// call function to send email
if($mail -> sendMail($name, $email, $message)){
    http_response_code(201); 
    $message = array("message" => "Epost skickad.", "email" => true);
}else{
    http_response_code(401); 
    $message = array("message" => "Det gick inte att skicka mailet.");
}
echo json_encode($message);
