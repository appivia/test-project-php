<?php
require_once './core/helpers.php';
require_once './core/errors.php';

// The page was accessed directly or via an invalid method, bail...
if (!isAjaxRequest() || !isRequestMethod('post')) {
  header('Location: /index.php');
  die;
}

$app = require "./core/app.php";

/**
 * Returns the sanitized user data
 */
function getSanitizedData() {
	$args = [
		'name' => FILTER_SANITIZE_STRING,
		'email' => FILTER_SANITIZE_EMAIL,
		'city' => FILTER_SANITIZE_STRING,
	];

	return filter_var_array($_POST, $args, FILTER_NULL_ON_FAILURE);
}

function validateData($data) {
	$errors = [];

	if (empty($data['name'])) {
		$errors['name'] = 'Please provide the name for the user';
	}

	if (empty($data['email'])) {
		$errors['email'] = 'Please provide the user’s e-mail address';
	} else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'The email you provided is not valid';
	}

	if (empty($data['city'])) {
		$errors['city'] = 'Please provide a city for the user';
	}

	if (!empty($errors)) {
		throw new ValidationError(
			'There are errors in the form, please address them and try again', $errors
		);
	}

	return $data;
}

$data = getSanitizedData();

try {
	$valid = validateData($data);
	$user = new User($app->db);
	$user->insert($valid);

	$app->renderJson($user);
} catch (ValidationError $e) {
	$app->renderJson($e, 400);
}
