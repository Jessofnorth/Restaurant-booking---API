<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
(Based on code by Malin Larsson, Mittuniversitetet
Email: malin.larsson@miun.se,
https://github.com/MallarMiun/login_curl/blob/master/api/login.php )
*/
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
// check for both username and password
if (isset($data["username"]) && isset($data["password"])) {
    $username = $data["username"];
    $password = $data["password"];
} else {
    http_response_code(400);
    $message = array("message" => "Användarnamn och lösenord måste anges.");
    exit;
}
// create instance of class 
$user = new Login();
// check if usernamne and password are valin in database
if($user -> loginUser($username, $password)){
    http_response_code(200); //correct login info
    $message = array("message" => "Användare inloggad.", "user" => true);
}else{
    http_response_code(401); //wrong login info
    $message = array("message" => "Felaktiga inloggningsuppgifter.");
}
echo json_encode($message);
