<?php

$app = require "./core/app.php";

$users = User::find($app->db,'*');

$app->renderView('index', array(
	'users' => $users
));
