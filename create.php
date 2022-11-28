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
	$user->insert($data);

	$app->renderJson($user);
} catch (ValidationError $e) {
	$app->renderJson($e, 400);
}
