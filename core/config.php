<?php

class Config {
	
	protected $directory;
	public $database;
	
	public function __construct() {
		$this->directory = dirname(__FILE__);
		
		require $this->directory.'/../config/database.php';
		$this->database = $database;
	}
	
}

return new Config();
