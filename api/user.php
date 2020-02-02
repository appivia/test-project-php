<?php

function validate($newUser) {
    if (strlen($newUser["name"]) < 3) {
        return array("result" => false, "reason" => "user name too short");
    }
    // additional validation belongs here
    return array("result" => true);
}

$newUser = $_GET;
$validationResult = validate($newUser);
if ($validationResult["result"]) {
    $app = require "../core/app.php";

    // Create new instance of user
    $user = new User($app->db);
    // Insert it to database with POST data
    $user->insert(array(
    	'name' => $newUser['name'],
    	'email' => $newUser['email'],
    	'city' => $newUser['city']
    ));
    echo json_encode(array("success" => "User added!"));
} else {
    echo json_encode(array("error" => $validationResult["reason"]));
}
