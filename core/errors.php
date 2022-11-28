<?php

class ValidationError extends Exception implements JsonSerializable
{
	/**
	 * @var {Array} the errors for every form element
	 */
	private $_errors = [];

	/**
	 * Constructs a validation error by providing a message and a list of errors
	 * as an associative array
	 *
	 * param $message: The overall error message
	 * param $errors: The error message per field
	 */
	public function __construct($message, $errors = [])
	{
		parent::__construct($message);
		$this->_errors = $errors;
	}

	public function getErrors()
	{
		return $this->_errors;
	}

	public function jsonSerialize()
	{
		return [
			'error' => true,
			'message' => $this->message,
			'errors' => $this->getErrors(),
		];
	}
}

class NotFounderror extends Exception {
}
