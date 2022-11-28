<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
// make the webservice accessible from everywhere 
header('Access-Control-Allow-Origin: *');

// set JSON as format 
header('Content-Type: application/json');

// Accepted methods, GET, PUT, POST, DELETE
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

// Allowed headers 
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
