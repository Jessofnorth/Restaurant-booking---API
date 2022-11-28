<?php 
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
// autoinclude classes
spl_autoload_register(function ($class_name){
    include 'classes/' . $class_name . '.class.php';
});

// database config
$devmode = false;

if($devmode){
    error_reporting(-1);
    ini_set('display_errors', 1); 
    define('DBHOST', 'localhost');
    define('DBUSER', 'johans');
    define('DBPASS', 'password');
    define('DBDATABASE', 'johans'); 
} else{
    //database settings - for MIUN
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "jeej2100");
    define("DBPASS", "ETbCrUvJBv");
    define("DBDATABASE", "jeej2100");
};  