<?php

// Init app instance
require_once './core/errors.php';
$app = require "./core/app.php";

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) : null;

try {
	if (!$id) {
		throw new ValidationError('User ID was invalid');
	}

	$user = User::findFirst($app->db, '*', ['id' => $id]);

	if (!$user) {
		throw new NotFoundError('User was not found');
	}

	$data = User::validateData($_POST);

	$user = new User($app->db, $id);
	$user->update($data);

	http_response_code(204);
} catch (ValidationError | NotFoundError $e) {
	$app->renderJson($e, 400);
}
