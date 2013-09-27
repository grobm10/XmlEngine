<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/DataBase/Query.php
 */
class Query
{
	private $queryString;
	private $type;
	private $table;
	
	/** 
	 * Create an insert query.
	 * The variable $values must be an associative array as follow: 
	 * 						array('column1' => 'value1', 'column2' => 'value2');
	 * 
	 * @param 	string 			$table
	 * @param 	Array|strings 	$values
	 * @param 	bool 			$allowNull
	 * @return 	string
	 */
	public function createInsert($table, $values, $allowNull=false){
		$this->table = $table;
		$arrayColumns = array();
		$arrayValues = array();
		foreach($values as $column => $value){
			array_push($arrayColumns, $column);
			array_push($arrayValues, $value);
		}
		$stmt = 'INSERT INTO ' . $table . ' (';
		$stmt .= implode(', ', $arrayColumns) . ') VALUES ("';
		if($allowNull){
			$stmt .= implode('", "', $arrayValues) . '")';
			$stmt = str_replace(array('""'), 'NULL', $stmt);
		} else {
			$stmt .= implode('", "', $arrayValues) . '")';
		}
		$this->queryString = $stmt;
		$this->type = 'INSERT';
		return $stmt;
	}
	
	/** 
	 * Create an update query.
	 * The variable $values must be an associative array as follow: 
	 * 						array('column1' => 'value1', 'column2' => 'value2');
	 * 
	 * @param 	string 			$table
	 * @param 	Array|strings 	$values
	 * @param 	string 			$where
	 * @param 	bool 			$allowNull
	 * @return 	string
	 */
	public function createUpdate($table, $values, $where, $allowNull=false){
		$this->table = $table;
		$arraySet = array();
		foreach($values as $column => $value){
			$set = $column . '="' . $value;
			array_push($arraySet, $set);
		}
		$stmt = 'UPDATE ' . $table . ' SET ';
		if($allowNull){
			$stmt .= implode('", ', $arraySet);
			$stmt = str_replace(array('""'), 'NULL', $stmt);
		} else {
			$stmt .= implode('", ', $arraySet);
		}
		$stmt .= '" WHERE ' . $where;
		$this->queryString = $stmt;
		$this->type = 'UPDATE';
		return $stmt;
	}
	
	/** 
	 * Create an delete query.
	 * The variable $id may be an associative array as follow: 
	 * 						array('column1' => 'value1', 'column2' => 'value2');
	 *                      or a single value
	 * 
	 * @param 	string 				$table
	 * @param 	Array|single value 	$values
	 * @param 	string 				$where
	 */
	public function createDelete($table, $values){
		$this->table = $table;
		$arrayTemp = null;
		if (is_array($values)){
			$arrayTemp = array();
			foreach($values as $column => $value){
				$set= $column.'="' . $value .'"' ;
				array_push($arrayTemp, $set);
			}
		} elseif(is_int($values)) { 
			$where = 'id = '.$values;
		} else { 
			$where = 'id = "'.$values.'"';
		}
		if(is_array($arrayTemp)){
			$where .= implode(' AND ', $arrayTemp);	
		}
		$stmt = 'DELETE FROM ' .$table. ' WHERE '. $where;
		$this->queryString = $stmt;
		$this->type = 'DELETE';
		return $stmt;
	}
	
	/** 
	 * Create an select query. 
	 * The variable $fields must be an indexed array. 
	 * The variable $join must be an associative array as follow: 
	 * 						array('tableToJoin' => 'field1 = field2');
	 * 
	 * @param 	Array|strings 	$fields
	 * @param 	string 			$table
	 * @param 	Array|strings 	$joins
	 * @param 	string 			$where
	 * @param 	string 			$order
	 * @return 	string
	 */
	public function createSelect($fields, $table, $joins=array(), $where='', $order='', $limit=''){
		$this->table = $table;
		//$stmt = 'SELECT SQL_NO_CACHE ' . implode(', ', $fields);
		$stmt = 'SELECT ' . implode(', ', $fields);
		$stmt .= ' FROM ' . $table;
		if(!empty($joins)){
			foreach($joins as $joinTable => $relation){
				//TODO: improve the query to allows INNER and RIGHT JOIN
				$stmt .= ' LEFT JOIN ' . $joinTable;
				$stmt .= ' ON ' . $relation;
			}
		}
		if(!empty($where)){
			$stmt .= ' WHERE ' . $where;
		}
		if(!empty($order)){
			$stmt .= ' ORDER BY ' . $order;
		}
		if(!empty($limit)){
			$stmt .= ' LIMIT ' . $limit;
		}
		$this->queryString = $stmt;
		$this->type = 'SELECT';
		return $stmt;
	}
	
	/** 
	 * Creates a Query object with a select statement ready to execute.
	 * Receives a preformated array with the following template:
	 * $params = array(
	 * 		'fields' => array(),
	 * 		'table' => '',
	 * 		'joins' => array(),
	 * 		'where' => array(),
	 * 		'order' => '',
	 * 		'limit' => ''
	 * )	 
	 * 
	 * @param 	Array|mixed 	$param
	 * @return 	Query
	 */
	public static function Make($param){
		$query = new Query();
		$isValid = is_array($params) && isset($params['fields']) && 
					isset($params['table']) && isset($params['joins']) &&
					isset($params['where']) && isset($params['order']) && 
					isset($params['limit']);
		if($isValid){
			//TODO: IMPLEMENT THIS!!!
			$query->createSelect(array('*'), 'bundles', null, $where, $orderBy, $limit);
		} else {
			throw new Exception('Invalid param structure. Query::Make($param)');
		}
		return $query;
	}
	
	/** 
	 * Saves a query
	 * @param 	string		$query 
	 * @return 	mixed
	 */
	public function push($query){
		$query = trim($query);
		if(strlen($query) > 6){
			$type = strtoupper(substr($query, 0, 4));
			switch($type){
				case 'INSE':
					$this->type = 'INSERT';
					break;
				case 'UPDA':
					$this->type = 'UPDATE';
					break;
				case 'DELE':
					$this->type = 'DELETE';
					break;
				case 'SELE':
					$this->type = 'SELECT';
					break;
				case 'SHOW':
					$this->type = 'SHOW';
					break;
				case 'CALL':
					$this->type = 'CALL';
					break;
				default:
					throw new Exception('Undefined Query type. Query.push()');
			}
		}
		$this->queryString = $query;
		return $query;
	}
	
	/** 
	 * Execute the currently query string\
	 * $mustReturnArray is used only for select function
	 * 
	 * @param 	bool 	$mustReturnArray 
	 * @param	string	$host
	 * @param	string	$user
	 * @param	string	$pass
	 * @param	string	$db
	 * @return 	mixed
	 */
	public function execute($mustReturnArray=false, $host=null, $user=null, $pass=null, $db=null){
		$connection = new Connection($host, $user, $pass, $db);
		$result = mysql_query($this->queryString);
		$queryResponse = $result;
		if($result){
			switch (strtoupper($this->type)){
				case 'INSERT':
				case 'UPDATE':
					break;
				case 'DELETE':
					try {
						mysql_query('ALTER TABLE '.$this->table.' AUTO_INCREMENT =1');
					} catch (Exception $e) {
						break;
					}
					break;
				case 'SELECT':
				case 'SHOW':
				case 'CALL':
					$queryResponse = $this->arrayParse($result, $mustReturnArray);
					break;
				default:
					throw new Exception('Unable to recognize the query type');
			}
		} else {
			throw new Exception('"MySQL ' . $this->type . ' error: ' . 
									mysql_error() . '"');
		}
		$connection->close();
		return $queryResponse;
	}
	
	/** 
	 * Parse the mysql query response and return an array with rows
	 * @param 	mysql_res	$result 
	 * @param 	bool 		$mustReturnArray 
	 * @return 	mixed
	 */
	private function arrayParse($result, $mustReturnArray=false){
		$entities = array();
		$length = (mysql_num_rows($result));
		if($mustReturnArray || ($length != 1)){
			for ($i = 0; $i <= ($length - 1); $i++){
				$entities[] = mysql_fetch_assoc($result);
			}
		} else {
			$entities = mysql_fetch_assoc($result);
		}
		return $entities;
	}
}
