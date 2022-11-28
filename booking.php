<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
// include header and config
include_once('includes/header.php');
include_once('includes/config.php');
// property for what methods is used
$method = $_SERVER['REQUEST_METHOD'];
$booking = new Booking();
// if ID is sent save in property
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
// if date is sent save in property
if (isset($_GET['date'])) {
    if ($booking->setDate($_GET['date'])) {
        $date = $_GET['date'];
    }
}
// switch depending on what method is used
switch ($method) {
    case 'GET':
        // if id is sent
        if (isset($id)) {
            $message = $booking->getBookingById($id);
        } elseif (isset($date)) {
            // if date is sent
            $message = $booking->getBookingFromDate($date);
        } else {
            $message = $booking->getBooking();
        }
        if (count($message) === 0) {
            // message to return to caller
            $message = array("message" => "Det finns ingen bokning.");
            // HTTP response NOT FOUND 
            http_response_code(404);
        } else {
            // HTTP response OK 
            http_response_code(200);
        }
        break;

    case 'POST':
        // convert JSON to object 
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['name']) && isset($data['phone']) && isset($data['email']) && isset($data['count']) && isset($data['date'])) {
            $name = $data['name'];
            $phone = $data['phone'];
            $email = $data['email'];
            $date = $data['date'];
            $message = $data['message'];
            $count = $data['count'];
            // set input
            if ($booking->setName($name) && $booking->setPhone($phone) && $booking->setEmail($email) && $booking->setMessage($message) && $booking->setCount($count) && $booking->setDate($date)) {
                // create booking
                if ($booking->createBooking()) {
                    $message = array("message" => "Bokningen är tillagd!");
                    // HTTP response CREATED 
                    http_response_code(201);
                } else {
                    $message = array("message" => "Fel vid lagring av bokning.");
                    // HTTP response INTERNAL SERVER ERROR
                    http_response_code(500);
                }
            } else {
                //  input fail
                $message = array("message" => "Alla fällt måste vara ifyllda!");
                // HTTP response BAD REQUEST
                http_response_code(400);
            }
        }
        break;
    case 'PUT':
        // convert JSON to object 
        $data = json_decode(file_get_contents("php://input"), true);
        // set input
        if ($booking->setBookingWithID($id, $data["name"], $data["phone"], $data["email"], $data["date"], $data["message"], $data["count"])) {
            // create booking
            if ($booking->updateBooking()) {
                $message = array("message" => "Bokning med ID " . $id . " är uppdaterad!");
                // HTTP response CREATED 
                http_response_code(201);
            } else {
                $message = array("message" => "Fel vid uppdatering av bokning.");
                // HTTP response INTERNAL SERVER ERROR
                http_response_code(500);
            }
        } else {
            //  input fail
            $message = array("message" => "Alla fällt måste vara ifyllda!");
            // HTTP response BAD REQUEST
            http_response_code(400);
        }
        break;

    case 'DELETE':
        // error msg if no ID
        if (!isset($id)) {
            // HTTP response Bad request
            http_response_code(400);
            // message to return to caller
            $message = array("message" => "Inget ID skickat.");
        } else {
            if ($booking->deleteBooking($id)) {
                // HTTP response OK
                http_response_code(200);
                // message to return to caller
                $message = array("message" => "Bokning med ID " . $id . " är raderad.");
            }
        }
        break;
}
// Send response to caller 
echo json_encode($message);
