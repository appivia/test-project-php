<?php

$app = require "./core/app.php";

// check if do we have an AJAX request // BUGGY
// if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
// 	exit;
// }

// Create new instance of user
$user = new User($app->db);

// Get json data from the stream and make array from them
$obj = (array) json_decode( file_get_contents("php://input") );

// We need those fields
$fields = ['name', 'email', 'city', 'phone_number'];

// Validation
foreach ($fields as $key) {
	if ( !isset($obj[$key]) ) {
		$app->sendStatusCode(400);
		exit;
	}
	$value = $obj[$key];
	switch ($key) {
		case 'email':
			if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
				$app->sendStatusCode(500);
				exit;
			}
			break;
		case 'name':
			if (empty($value)) {
				$app->sendStatusCode(500);
				exit;
			}
			break;
		case 'phone_number':
			if (!empty($value) && !preg_match("/^\+?[\d\(\)\-\ ]+$/", $value)) {
				$app->sendStatusCode(500);
				exit;
			} else if (!empty($value)) { // remove special characters from phone number and insert just numbers
				preg_match_all("/^\+?\d+/", $obj['phone_number'], $matches);
				$obj['phone_number'] = implode($matches[0], '');
			}
			break;
	}
}

// Insert it to database with POST data
$user->insert(array(
	'name' => $obj['name'],
	'email' => $obj['email'],
	'city' => $obj['city'],
	'phone_number' => $obj['phone_number']
));

// echo $user->id;

// Redirect back to index
// header('Location: index.php');