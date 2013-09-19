<?php

class BaseModel {
	
	protected $db,$id,$fields = array();
	
	public function __construct($db,$id = null,$fields = array()){
		$this->db = $db;
		$this->id = $id;
		if(!empty($fields) && isset($this->id))$this->getFields($fields);
	}	
	
	public function getId(){
		return $this->id;	
	}
	
	protected function getField($field){
		if(array_key_exists($field,$this->fields))return $this->fields[$field];
		else if(isset($this->id)){
			$query = 'SELECT `'.$field.'` FROM `'.static::tableName.'` WHERE `id` = '.$this->id;
			$res = $this->db->query($query);
			if(isset($res[0][$field])){
				$this->fields[$field] = $res[0][$field];
				return $this->fields[$field];
			}else return false;
		}else return false;
	}
	
	protected function getFields($fields){
		if($fields != '*')$fields = '`'.implode('`, `',$fields).'`';
		$query = 'SELECT '.$fields.' FROM `'.static::tableName.'` WHERE `id` = '.$this->id;
		$res = $this->db->query($query);
		if(isset($res[0])){
			foreach($res[0] as $field => $value){
				$this->setField($field, $value);	
			}
		}else return false;
	}
	
	protected function setField($field,$value){
		$this->fields[$field] = $value;
	}
	
	protected function setFields($data){
		foreach ($data as $field => $value){
			$this->setField($field,$value);
		}
	}
	
	public static function escapeString($string){
		if(is_array($string)){
			$ret = array();
			foreach($string as $s)$ret[] = self::escapeString($s);
			return $ret;
		}
		if($string == null)return 'NULL';
		if(!is_numeric($string))return "'".addslashes($string)."'"; 
		return $string;
	}
	
	public static function findFirst($db,$conditions = array(),$order = array(),$fields = array()){
		$ret = self::find($db,$conditions,$order,array(0,1),$fields);
		if(!empty($ret))return $ret[0];
		else return false;
	}
	
	public static function find($db,$conditions = array(),$order = array(),$limit = null,$fields = array()){
		$where = '1';
		foreach($conditions as $key => $condition){
			if(is_array($condition)){
				$condString = implode(', ',self::escapeString($condition));
				$where .= ' AND `'.$key.'` IN ('.$condString.')';
			}else
				$where .= ' AND `'.$key.'` = '.self::escapeString($condition);
		}
		$sort = !empty($order)?'ORDER BY':'';
		foreach($order as $key => $dir){
			$sort .= ' '.$key.' '.$dir;
		}
		$limit = isset($limit)?'LIMIT '.$limit[0].', '.$limit[1]:'';
		if($fields != '*')$fields = '`'.implode('`, `',$fields).'`';
		if($fields == '``')$fields = '`id`';elseif($fields != '*') $fields = '`id`, '.$fields;
		$query = 'SELECT '.$fields.' FROM `'.static::tableName.'` WHERE '.$where.' '.$sort.' '.$limit;
		$res = $db->query($query);
		$ret = array();
		foreach($res as $result){
			$className = static::className;
			$newClass = new $className($db);
			foreach ($result as $field => $value){
				if($field != 'id')$newClass->setField($field, $value);
				else $newClass->setId($value);
			}
			foreach($conditions as $field => $value)if(!is_array($value)){
				if($field != 'id')$newClass->setField($field, $value);
				else $newClass->setId($value);
			}
			$ret[] = $newClass;
		}
		return $ret;
	}
	
	public static function sql($db,$q){
		$res = $db->query($q);
		$ret = array();
		foreach($res as $result){
			$className = static::className;
			$ret[] = new $className($db,$result['id']);
		}
		return $ret;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function delete(){
		if(isset($this->id)) {
			$query = "DELETE FROM ".static::tableName." WHERE `id` = ".$this->id;
			$this->db->query($query);
		}
	}
	
	public function update($data = array()){
		if(isset($this->id)) {
			$this->setFields($data);
			$data = array();
			foreach($this->fields as $field => $value){
				$data[] = '`'.$field.'` = '.self::escapeString($value);
			}
			$dataString = implode(', ', $data);
			$query = "UPDATE `"."` SET ".$dataString." WHERE `id` = ".$this->id;
			$this->db->query($query);
		}
	}
	
	public function insert($data = array()){
		$this->setFields($data);
		$data = $this->fields;
		$columns = implode(',',array_map(function($n){return '`'.$n.'`';},array_keys($data)));
		$values = implode(',',array_map(function($n){return self::escapeString($value);},array_values($data)));
		$query = "INSERT INTO `".static::tableName."` (".$columns.", `created_at`) VALUES (".$values.", NOW())";
		$this->db->query($query);
		$this->id = $this->db->mysqli->insert_id;
	}
	
}