<?php

class BaseModel {
	
	protected $db;
	protected $id;
	protected $fields = array();
	
	/**
	 * Creates new model instance
	 * param $db: database instance
	 * param $id: record's id, null id usually means new record
	 * param $fields: eager load given fields, use '*' for all fields 
	 */
	public function __construct($db,$id = null,$fields = array()){
		$this->db = $db;
		$this->id = $id;
		if(!empty($fields) && isset($this->id))$this->getFields($fields);
	}	
	
	/**
	 * Get current record's id
	 */
	public function getId(){
		return $this->id;	
	}
	
	/**
	 * Retrieves given field from memory or database
	 */
	protected function getField($field){
		// Retrieve from memory if exists
		if(array_key_exists($field,$this->fields)){
			return $this->fields[$field];
		}
		// Only retrieve from DB if we know the id
		else if(isset($this->id)){
			$query = 'SELECT `'.$field.'` FROM `'.static::tableName.'` WHERE `id` = '.$this->id;
			// Execute query
			$res = $this->db->query($query);
			// If result contains the field, save it and return it
			if(isset($res[0][$field])){
				$this->setField($field, $res[0][$field]);
				return $this->fields[$field];
			}else return false;
		}else return false;
	}
	
	/**
	 * Retrieve multiple fields from database
	 * Use '*' for all fields
	 */
	protected function getFields($fields = array()){
		// Prepare string with fields
		if($fields != '*')$fields = '`'.implode('`, `',$fields).'`';
		$query = 'SELECT '.$fields.' FROM `'.static::tableName.'` WHERE `id` = '.$this->id;
		// Execute query
		$res = $this->db->query($query);
		// If result exits, save and return it
		if(isset($res[0])){
			$ret = array();
			foreach($res[0] as $field => $value){
				$this->setField($field, $value);	
				$ret[$field] = $value;
			}
			return $ret;
		}else return false;
	}
	
	/**
	 * Sets given field
	 */
	protected function setField($field,$value){
		$this->fields[$field] = $value;
	}
	
	/**
	 * Sets given fields
	 */
	protected function setFields($data){
		foreach ($data as $field => $value){
			$this->setField($field,$value);
		}
	}
	
	/**
	 * Escapes values for inserting them into database
	 * Can also handle array of value
	 */
	public static function escapeValue($value){
		// Handle arrays
		if(is_array($value)){
			$ret = array();
			foreach($value as $v)$ret[] = self::escapeValue($v);
			return $ret;
		}
		// Parse null values
		if($value === null)return 'NULL';
		// Escape string values
		if(!is_numeric($value))return "'".htmlentities(addslashes($value))."'"; 
		return $value;
	}
	
	/**
	 * Finds one record using given criteria
	 * param $fields: Eager load given fields
	 * param $conditions: array of WHERE conditions
	 * param $order: array of ORDER BY criteria
	 */
	public static function findFirst($db,$fields = array(),$conditions = array(),$order = array()){
		// Executes find with LIMIT 0, 1
		$ret = self::find($db,$fields,$conditions,$order,array(0,1));
		// If result exists return it
		if(!empty($ret))return $ret[0];
		else return false;
	}
	
	/**
	 * Finds records using given criteria
	 * param $fields: Eager load given fields
	 * param $conditions: array of WHERE conditions
	 * param $order: array of ORDER BY criteria
	 * param $limit: array in form array(a,b)
	 */
	public static function find($db,$fields = array(),$conditions = array(),$order = array(),$limit = null){
		// Build query	
		$where = self::buildWhere($conditions);
		$sort = self::buildOrderBy($order);
		$limit = self::buildLimit($limit);
		$select = self::buildSelect($fields);
		$query = 'SELECT '.$select.' FROM `'.static::tableName.'` WHERE '.$where.' '.$sort.' '.$limit;
		// Execute query
		$res = $db->query($query);
		$ret = array();
		// Create instance of current model for each row
		$className = static::className;
		foreach($res as $result){
			// New instance
			$newClass = new $className($db);
			// Set all fields retrieved from database
			foreach ($result as $field => $value){
				if($field != 'id')$newClass->setField($field, $value);
				else $newClass->setId($value);
			}
			// Also set fields specified by conditions
			foreach($conditions as $field => $value)if(!is_array($value)){
				if($field != 'id')$newClass->setField($field, $value);
				else $newClass->setId($value);
			}
			$ret[] = $newClass;
		}
		return $ret;
	}

	/**
	 * Builds WHERE string based on given conditions
	 * Can handle basic equality or IN using array as condition value
	 */
	private static function buildWhere($conditions){
		$where = '1';
		foreach($conditions as $key => $condition){
			if(is_array($condition)){
				$condString = implode(', ',self::escapeValue($condition));
				$where .= ' AND `'.$key.'` IN ('.$condString.')';
			}else
				$where .= ' AND `'.$key.'` = '.self::escapeValue($condition);
		}	
		return $where;
	}
	
	/**
	 * Builds ORDER BY string based on given array
	 */
	private static function buildOrderBy($order){
		$sort = !empty($order)?'ORDER BY':'';
		foreach($order as $key => $dir){
			$sort .= ' '.$key.' '.$dir;
		}
		return $sort;
	}
	
	/**
	 * Builds LIMIT string based on given array
	 */
	private static function buildLimit($limit){
		return $limit = isset($limit)?'LIMIT '.$limit[0].', '.$limit[1]:'';
	}
	
	/**
	 * Builds SELECT string based on given array
	 */
	private static function buildSelect($fields){
		if($fields != '*')$fields = '`'.implode('`, `',$fields).'`';
		// If $fields was empty array select at least id
		if($fields == '``'){
			$fields = '`id`';
		}
		// If $fields doesn't contain id select it too
		elseif($fields != '*' && !in_array('id', $fields)){
			$fields = '`id`, '.$fields;
		}
		return $fields;
	}
	
	/**
	 * Builds UPDATE data string from given data
	 */
	private static function buildUpdateData($data){
		$datas = array();
		foreach($data as $field => $value){
			$datas[] = '`'.$field.'` = '.self::escapeValue($value);
		}
		$dataString = implode(', ', $datas);	
		return $dataString;
	}
	
	/**
	 * Builds INSERT data strings from given data
	 * Returns array(
	 * 	'columns' => 'column string',
	 * 	'values'  => 'values string'
	 * );
	 */
	private static function buildInsertData($data){
		$columns = '`'.implode('`, `',array_keys($data)).'`';
		$values = implode(',',self::escapeValue(array_values($data)));
		return array(
			'columns' 	=> $columns,
			'values' 	=> $values
		);
	}
	
	/**
	 * Get list of instances using custom query
	 */
	public static function sql($db,$q){
		$res = $db->query($q);
		$ret = array();
		$className = static::className;
		foreach($res as $result){
			// Create new instance
			$ret[] = new $className($db,$result['id']);
		}
		return $ret;
	}
	
	/**
	 * Set id for current record
	 */
	public function setId($id){
		$this->id = $id;
	}
	
	/**
	 * Delete current record from database
	 */
	public function delete(){
		// Delete only if we know the id
		if(isset($this->id)) {
			$query = "DELETE FROM ".static::tableName." WHERE `id` = ".$this->id;
			$this->db->query($query);
		}
	}
	
	/**
	 * Update current record with given data
	 * Also fields set with setField will be updated
	 */
	public function update($data = array()){
		// Update only if we know the id
		if(isset($this->id)) {
			// Overwrite current field values with given data
			$this->setFields($data);
			$dataString = self::buildUpdateData($this->fields);
			$query = "UPDATE `"."` SET ".$dataString." WHERE `id` = ".$this->id;
			$this->db->query($query);
		}
	}
	
	/**
	 * Insert current record with given data
	 * Also fields set with setField will be inserted
	 */
	public function insert($data = array()){
		// Overwrite current field values with given data
		$this->setFields($data);		
		$insertStrings = self::buildInsertData($this->fields);
		$query = "INSERT INTO `".static::tableName."` (".$insertStrings['columns'].", `created_at`) VALUES (".$insertStrings['values'].", NOW())";
		$this->db->query($query);
		// Retrieve id of inserted record
		$this->id = $this->db->mysqli->insert_id;
	}
	
}
