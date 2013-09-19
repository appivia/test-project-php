<?php

require dirname(__FILE__).'/base_model.php';
foreach (glob(dirname(__FILE__).'/../models/*.php') as $filename){
	require $filename;
}

class App {
	
	protected $directory;
	public $db;
	
	public function __construct(){
		$this->directory = dirname(__FILE__);
		$config = require $this->directory.'/config.php';
			
		$this->db = require $this->directory.'/database.php';	
		$this->db->setConfig($config->database);
		$this->db->connect();
	}	
	
	public function renderView($viewfile, $vars = array()) {
		foreach ($vars as $key => $value) {
			$$key = $value;
		}
	
		ob_start();
		include './views/'.$viewfile.'.php';
		$content = ob_get_contents();
		ob_end_clean();
		include './views/layout.php';
	}
	
}

return new App();
