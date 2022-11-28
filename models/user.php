<?php
require_once './core/errors.php';

/**
 * User model
 */
class User extends BaseModel implements JsonSerializable
{
	// Define neccessary constansts so we know from which table to load data
	const tableName = 'users';
	// ClassName constant is important for find and findOne static functions to work
	const className = 'User';

	// Create getter functions

	public function getName() {
		return $this->getField('name');
	}

	public function getEmail() {
		return $this->getField('email');
	}

	public function getCity() {
		return $this->getField('city');
	}

	public function jsonSerialize() {
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'email' => $this->getEmail(),
			'city' => $this->getCity(),
		];
	}

	/**
	 * Validates the data for a user instance. Throws a ValidationError in case tha data is invalid
	 *
	 * param $source: the array to retrieve and sanitize the data from
	 */
	public static function validateData($source) {
		$errors = [];

		// Sanitize the data
		$data = filter_var_array($source, [
			'name' => FILTER_SANITIZE_STRING,
			'email' => FILTER_SANITIZE_EMAIL,
			'city' => FILTER_SANITIZE_STRING,
		], FILTER_NULL_ON_FAILURE);

		// Validate the data
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
}
