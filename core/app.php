<?php

// Load BaseModel and all models from models directory
require dirname(__FILE__).'/base_model.php';
foreach (glob(dirname(__FILE__).'/../models/*.php') as $filename){
	require $filename;
}

/**
 * App
 * provides interface for database manipulation, accessing config and rendering views
 */
class App {
	
	private $directory;
	public $db;
	public $config;
	
	public function __construct(){
		// Save current directory path
		$this->directory = dirname(__FILE__);
		
		// Load configuration options
		$this->config = require $this->directory.'/config.php';
			
		// Load database instance and tell it to connect with given config
		$this->db = require $this->directory.'/database.php';
		$this->db->connect($this->config->database);
	}	
	
	/**
	 * Renders given view with given set of variables
	 * 
	 * param $viewfile: path of the view file relative to the views direcotry, without the ending .php
	 * param $vars: array of variables to be accessed insede the views
	 */
	public function renderView($viewfile, $vars = array()) {
		// Render array to usable variables
		foreach ($vars as $key => $value) {
			$$key = $value;
		}
		
		// Start capturing of output
		ob_start();
		include './views/'.$viewfile.'.php';
		// Assign output to $content which will be rendered in layout
		$content = ob_get_contents();
		// Stop output capturing
		ob_end_clean();
		// Render $content in layout
		include './views/layout.php';
	}
	
}

return new App();
