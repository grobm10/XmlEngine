<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/LogModel.php
 */

class LogModel extends AbstractModel {

	/**
	 * Saves the Log in the Data Base
	 * 
	 * @param		Log		$log
	 * @static
	 */
	public static function Save(&$log){
		$id = $log->getId();
		$properties = array(
				"processId" => $log->getProcess()->getId(),
				"description" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($log->getDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($log->getDescription(), ENT_COMPAT, self::$Charset, false),
				"isError" => intval($log->getIsError())
			);
		$emptyValues = '';
		if(empty($properties["processId"])){
			$emptyValues .= ' processId';
		}
		if(empty($properties["description"])){
			$emptyValues .= ' description';
		}
		if(empty($properties["isError"])){
			$emptyValues .= ' isError';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('logs', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Log "'.$id.'" in database. (LogModel::save())');
				}
			} else {
				$query->createInsert('logs', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'logs');
					$value = $query->execute();
					$log->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Log in database. (LogModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Log with empty required values:'.$emptyValues.'. (LogModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Log by id
	 * 
	 * @param		int		$id
	 * @return		Log
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'logs', array(), 'id = "'.$id.'"');
		$logArray = $query->execute();
		$log = false;
		if(!empty($logArray)){
			$log = self::CreateObjectFromArray($logArray);
		}
		return $log;
	}

	/**
	 * Finds stored Logs by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Log
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$logsArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$where = '';
			if(is_array($params['where'])){
				//TODO: Use Query::Make() !!!
				$whereArray = array();
				foreach ($params['where'] as $key => $value){
					if(!empty($value)){
						$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
						array_push($whereArray, $key.' = "'.$parsedValue.'"');
					}
				}
				$where = implode(' AND ', $whereArray);
			} else {
				$where = trim($params['where']);
			}
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'logs', null, $where, $orderBy, $limit);
			$arrayArraysLog = $query->execute(true);
			if(!empty($arrayArraysLog)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysLog[0]);
				}
				foreach($arrayArraysLog as $arrayLog){
					array_push($logsArray, self::CreateObjectFromArray($arrayLog));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in LogModel::FindBy()');
		}
		return $logsArray;
	}

	/**
	 * Finds stored Logs by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Log
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$logsArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in LogModel::FindByMultipleValues()');
				}
			}
			$where = implode(' OR ', $whereArray);
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'logs', null, $where, $orderBy, $limit);
			$arrayArraysLog = $query->execute(true);
			if(!empty($arrayArraysLog)){
				foreach($arrayArraysLog as $arrayLog){
					array_push($logsArray, self::CreateObjectFromArray($arrayLog));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in LogModel::FindByMultipleValues()');
		}
		return $logsArray;
	}

	/**
	 * Finds stored Logs by related Process properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Log
	 * @static
	 */
	public static function FindByProcessProperties($params, $expectsOne=false){
		$logsArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'logs.id',
					'logs.processId',
					'logs.description',
					'logs.isError'
				);
			$joinArray = array('processes'=>'processes.id = logs.processId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'processes.'.$key.' = "'.$parsedValue.'"');
				}
			}
			$where = implode(' AND ', $whereArray);
			$orderBy = array();
			if(!empty($params['orderBy'])){
				$orderBy = implode(',', $params['orderBy']);
			}
			$limit = '';
			if(!empty($params['from'])){
				$limit = ''.$params['from'];
				if(!empty($params['amount'])){
					$limit .= ', '.$params['amount'];
				} else {
					$limit .= ', 10';
				}
			}
			$query = new Query();
			$query->createSelect(array('*'), 'logs', $joinArray, $where, $orderBy, $limit);
			$arrayArraysLog = $query->execute(true);
			if(!empty($arrayArraysLog)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysLog[0]);
				}
				foreach($arrayArraysLog as $arrayLog){
					array_push($logsArray, self::CreateObjectFromArray($arrayLog));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in LogModel::FindByProcessProperties()');
		}
		return $logsArray;
	}

	/**
	 * Retrieves all Logs stored in the data base
	 * 
	 * @return		array|Log
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$logsArray = array();
		$params = self::CheckParams($params, self::FetchAll);
		$orderBy = array();
		if(!empty($params['orderBy'])){
			$orderBy = implode(',', $params['orderBy']);
		}
		$limit = '';
		if(!empty($params['from'])){
			$limit = ''.$params['from'];
			if(!empty($params['amount'])){
				$limit .= ', '.$params['amount'];
			} else {
				$limit .= ', 10';
			}
		}
		$query = new Query();
		$query->createSelect(array('*'), 'logs', null, null, $orderBy, $limit);
		$arrayArraysLog = $query->execute(true);
		if(!empty($arrayArraysLog)){
			foreach($arrayArraysLog as $arrayLog){
				array_push($logsArray, self::CreateObjectFromArray($arrayLog));
			}
		}
		return $logsArray;
	}

	/**
	 * Retrieves all Logs that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Log
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$logsArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			if(is_array($params['where']) && isset($params['where']['text']) && isset($params['where']['fields'])){
				$text = trim($params['where']['text']);
				$searchs = array();
				foreach($params['where']['fields'] as $field){
					array_push($searchs, trim($field).' LIKE "%'.$text.'%"');
				}
				$where = implode(' OR ', $searchs);
				$orderBy = array();
				if(!empty($params['orderBy'])){
					$orderBy = implode(',', $params['orderBy']);
				}
				$limit = '';
				if(!empty($params['from'])){
					$limit = ''.$params['from'];
					if(!empty($params['amount'])){
						$limit .= ', '.$params['amount'];
					} else {
						$limit .= ', 10';
					}
				}
				$query = new Query();
				$query->createSelect(array('*'), 'logs', null, $where, $orderBy, $limit);
				$arrayArraysLog = $query->execute(true);
				if(!empty($arrayArraysLog)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysLog[0]);
					}
					foreach($arrayArraysLog as $arrayLog){
						array_push($logsArray, self::CreateObjectFromArray($arrayLog));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. LogModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. LogModel::Search()');
		}
		return $logsArray;
	}

	/**
	 * Retrieves the number of Logs stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM logs');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Log by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('logs', $id);
		return $query->execute();
	}

	/**
	 *  Creates Log object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Log
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["processId"])){
			$emptyValues .= ' processId';
		}
		if(empty($properties["description"])){
			$emptyValues .= ' description';
		}
		if(empty($properties["isError"])){
			$emptyValues .= ' isError';
		}
		if(empty($emptyValues)){
			$properties['process'] = ProcessModel::FindById($properties['processId']);
			if(empty($properties['process'])){
				throw new Exception('Unable to find the Process for the Log.(LogModel::CreateObjectFromArray())');
			}
			return new Log($properties);
		} else {
			throw new Exception('Unable to create Log with empty required values:'.$emptyValues.' for Log "'.$properties['id'].'". (LogModel::CreateObjectFromArray())');
		}
	}
}