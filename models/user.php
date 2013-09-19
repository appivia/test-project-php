<?php

class User extends BaseModel{
	
	const tableName = 'users';
	const className = 'User';
	
	public function getName() {
		return $this->getField('name');
	}
	
	public function getEmail() {
		return $this->getField('email');
	}
	
	public function getCity() {
		return $this->getField('city');
	}
	
}