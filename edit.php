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

	$app->renderView('edit', ['user' => $user]);
} catch (ValidationError | NotFoundError $e) {
	http_response_code(404);
	$app->renderView('not-found');
}
