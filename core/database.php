<?php

class Database {
	
	public $mysqli;
	private $lastQuery;
	private $config;
	
	public function setConfig($config) {	
		$this->config = $config;	
	}
	
	public function connect(){
		$this->mysqli = new mysqli($this->config['address'], $this->config['username'], $this->config['password'], $this->config['database']);
		if ($this->mysqli->connect_errno) {
			echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}
		$this->mysqli->query("SET CHARACTER SET utf8");
	}
	
	private function getRows($res){
		$r = array();
		while($row = $res->fetch_assoc()){
			$r[] = $row;
		}
		return $r;
	}
	
	public function affected(){
		return $this->mysqli->affected_rows;
	}
	
	public function getCount(){
		$q = $this->lastQuery;
		$q = preg_replace('/SELECT (.*?) FROM/i','SELECT COUNT(*) FROM',$q);
		$q = preg_replace('/LIMIT (.*)/','',$q);
		$res = $this->mysqli->query($q) or die("(" . $this->mysqli->errno . ") " . $this->mysqli->error." LINE: ".__LINE__." in ".__FILE__." TRACE:<pre> ".print_r(debug_backtrace(),true)."</pre>");
		if (!$res) {
			throw new Exception("Database Error [{$this->mysqli->errno}] {$this->mysqli->error}");
		}
		$ret = $this->getRows($res);
		return $ret[0]['COUNT(*)'];
	}
	
	public function query($q){
		$this->lastQuery = $q;
		$this->log .= $q."\n";
		$res = $this->mysqli->query($q) or die("(" . $this->mysqli->errno . ") " . $this->mysqli->error." LINE: ".__LINE__." in ".__FILE__." TRACE:<pre> ".print_r(debug_backtrace(),true)."</pre>");
		if (!$res) {
			throw new Exception("Database Error [{$this->mysqli->errno}] {$this->mysqli->error}");
		}
		$ret =  is_object($res)?$this->getRows($res):true;
		$this->queries += 1;
		if($ret !== true){
			$rows = count($ret);
			$this->rows += $rows;
			$this->log .= '('.$rows.' rows)'."\n";
		}
		return $ret;
	}
}

return new Database();
