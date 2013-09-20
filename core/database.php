<?php

/**
 * Database
 * provides interface for database manipulation
 */
class Database {
	
	public $mysqli;
	private $lastQuery;
	private $config;
	
	/**
	 * Connects to database with given config
	 */
	public function connect($config){
		$this->config = $config;	
		$this->mysqli = new mysqli($this->config['address'], $this->config['username'], $this->config['password'], $this->config['database']);
		
		if ($this->mysqli->connect_errno) {
			echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}
		// Set correct encoding
		$this->mysqli->query("SET CHARACTER SET utf8");
	}
	
	/**
	 * Converts mysqli result object to 2-dimensional associative array
	 */
	private function getRows($res){
		$r = array();
		while($row = $res->fetch_assoc()){
			$r[] = $row;
		}
		return $r;
	}
	
	/*
	 * Returns number of affected rows
	 */
	public function affected(){
		return $this->mysqli->affected_rows;
	}
	
	/**
	 * Dies and prints all relevant error information
	 */
	private function handleError() {
		die("(" . $this->mysqli->errno . ") " . $this->mysqli->error." LINE: ".__LINE__." in ".__FILE__." TRACE:<pre> ".print_r(debug_backtrace(),true)."</pre>");	
	}
	
	/**
	 * Get count of rows matched by last query
	 * Works only with standard SELECT FROM queries!!!
	 */
	public function getCount(){
		$q = $this->lastQuery;
		// Prepare query: replace select fields with count, and remove LIMIT
		$q = preg_replace('/SELECT (.*?) FROM/i','SELECT COUNT(*) AS count FROM',$q);
		$q = preg_replace('/LIMIT (.*)/','',$q);
		// Execute query
		$ret = $this->query($q);
		// Return the count field
		return $ret[0]['count'];
	}
	
	/**
	 * Executes given query and returns associative array of results, or true if no rows were returned by DB
	 */
	public function query($q){
		// Save query for later use
		$this->lastQuery = $q;
		// Execute query
		$res = $this->mysqli->query($q) or $this->handleError();
		// Convert result to array if possible
		$ret =  is_object($res)?$this->getRows($res):true;
		return $ret;
	}
}

return new Database();
