<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
include("config.php");


//connect to DB
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_errno > 0) {
    die("Database connection failed." . $db->connect_error);
}

// SQL querys 
$sql = "DROP TABLE IF EXISTS johans_menu;";
$sql .= "
CREATE TABLE johans_menu(
    menu_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    price INT(11) NOT NULL,
    category VARCHAR(32) NOT NULL,
    info TEXT NOT NULL
);
";

$sql .= "DROP TABLE IF EXISTS johans_booking;";
$sql .= "
CREATE TABLE johans_booking(
    booking_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    phone VARCHAR(32) NOT NULL,
    email VARCHAR(128) NOT NULL,
    date DATE,
    count INT(11) NOT NULL,
    message TEXT NOT NULL
);
";

$sql .= "DROP TABLE IF EXISTS johans_users;";
$sql .= "
CREATE TABLE johans_users(
    user_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(128) NOT NULL,
    password VARCHAR(256) NOT NULL
);
";
echo "<pre>$sql</pre>";

//send SQL to server 
if ($db->multi_query($sql)) {
    echo "Tables installed.";
} else {
    echo "Could not create tables in database";
}

// add admin account to users table
$user = new Login();
$user->createUser("adminjohans", "PastaIAllaFormer456");


