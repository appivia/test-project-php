<?php

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

	public function jsonSerialize()
	{
		return [
			'name' => $this->getName(),
			'email' => $this->getEmail(),
			'city' => $this->getCity(),
		];
	}
}
