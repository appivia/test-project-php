<?php
require_once './core/helpers.php';
require_once './core/errors.php';

// The page was accessed directly or via an invalid method, bail...
if (!isAjaxRequest() || !isRequestMethod('delete')) {
  header('Location: /index.php');
  die;
}

$app = require "./core/app.php";

try {
	$id = filter_var($_REQUEST['id'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

	if (!$id) {
		throw new ValidationError('The User ID provided is not valid');
	}

	$user = User::findFirst($app->db, '*', ['id' => $id]);

	if (!$user) {
		throw new NotFoundError('User was not found');
	}

	$user->delete();

	http_response_code(204);
} catch (ValidationError $e) {
	$app->renderJson($e, 400);
} catch (NotFoundError $e) {
	http_response_code(404);
}
