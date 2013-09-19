<?php

$app = require "./core/app.php";

$user = new User($app->db);
$user->insert(array(
	'name' => $_POST['name'],
	'email' => $_POST['email'],
	'city' => $_POST['city']
));

header('Location: index.php');