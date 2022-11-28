<?php
/**
 * @return Boolean whether the current request is an ajax request
 */
function isAjaxRequest() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * @return Boolean whether the current request is using a given method
 */
function isRequestMethod($method) {
	return strtolower($_SERVER['REQUEST_METHOD']) === strtolower($method);
}
