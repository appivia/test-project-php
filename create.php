<?php
require_once './core/helpers.php';
require_once './core/errors.php';

// The page was accessed directly or via an invalid method, bail...
if (!isAjaxRequest() || !isRequestMethod('post')) {
  header('Location: /index.php');
  die;
}

$app = require "./core/app.php";

try {
	$data = User::validateData($_POST);

	$user = new User($app->db);

	// Check if the user already exists
	$existing = User::findFirst($app->db, '*', ['email' => $data['email']]);

	if ($existing) {
		throw new ValidationError('User with email ' . $data['email'] . ' already exists');
	}

	$user->insert($data);
	$app->renderJson($user);
} catch (ValidationError $e) {
	$app->renderJson($e, 400);
}
