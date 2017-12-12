<?php

	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
	
	$server = 'localhost'; // server address

	// Define global variables
	define('ROOT_URL', 'http://'.$server.'/tracer_system'); // App root directory
	define('DB_SERVER', $server); // Database server
	define('DB_NAME', 'lccdo_tracer'); // Database name
	define('DB_USERNAME', 'janerz2018'); // Database username
	define('DB_PASSWORD', 'AhfqiOXyhA3fKjXv'); // Database password
	define('PROJECT_NAME','Lourdes College Tracer System');


	// Connection to database using PHP Database Object (PDO) method
	try {
    	$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  	}catch(PDOException $e) {
    	die("ERROR: Could not connect. " . $e->getMessage());
  	}

