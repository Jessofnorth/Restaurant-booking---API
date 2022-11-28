<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
// include header and config
include_once('includes/header.php');
include_once('includes/config.php');
// property for what methods is used
$method = $_SERVER['REQUEST_METHOD'];
// create instance of class 
$menu = new Menu();
// if ID is sent save in property
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
// if category is sent save in property
if (isset($_GET['category'])) {
    if ($menu->setCategory($_GET['category'])){
        $category = $_GET['category'];
    }
}
// switch depending on what method is used
switch ($method) {
    case 'GET':
        //  if ID is sent
        if (isset($id)) {
            $message = $menu->getMenuById($id);
        } elseif (isset($category)) {
            // if category is sent
            if ($menu->setCategory($category)){
                $message = $menu->getMenuByCategory($category);
            }
        } else {
            // normal get
            $message = $menu->getMenu();
        }

        if (count($message) === 0) {
            // message to return to caller
            $message = array("message" => "Det finns inga rätter på menyn.");
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
        if (isset($data['name']) && isset($data['price']) && isset($data['category']) && isset($data['info'])) {
            $name = $data['name'];
            $price = $data['price'];
            $category = $data['category'];
            $info = $data['info'];
            // set input
            if ($menu->setName($name) &&$menu->setPrice($price) && $menu->setCategory($category) && $menu->setInfo($info)) {
                // create dish
                if ($menu->createDish()) {
                    $message = array("message" => "Rätten är tillagd på menyn!");
                    // HTTP response CREATED 
                    http_response_code(201);
                } else {
                    $message = array("message" => "Fel vid lagring av rätten.");
                    // HTTP response INTERNAL SERVER ERROR
                    http_response_code(500);
                }
            } else {
                //  input fail
                $message = array("message" => "Alla fällt måste vara ifyllda!");
                // HTTP response BAD REQUEST
                http_response_code(400);
            }
        } else {
            //  input fail
            $message = array("message" => "Alla fällt måste vara ifyllda!");
            // HTTP response BAD REQUEST
            http_response_code(400);
        }

        break;

    case 'PUT':
        // convert JSON to object 
        $data = json_decode(file_get_contents("php://input"), true);
        // set input
        if ($menu->setDishWithID($id, $data["name"], $data["price"], $data["info"])) {
            // update dish
            if ($menu->updateDish()) {
                $message = array("message" => "Rätten med ID " . $id . " är uppdaterad!");
                // HTTP response CREATED 
                http_response_code(201);
            } else {
                $message = array("message" => "Fel vid uppdatering av rätten.");
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
            if ($menu->deleteDish($id)) {
                // HTTP response OK
                http_response_code(200);
                // message to return to caller
                $message = array("message" => "Rätt med ID " . $id . " är raderad.");
            }
        }
        break;
}
// Send response to caller 
echo json_encode($message);
