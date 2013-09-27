<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/StateModel.php
 */

class StateModel extends AbstractModel {

	/**
	 * Saves the State in the Data Base
	 * 
	 * @param		State		$state
	 * @static
	 */
	public static function Save(&$state){
		$id = $state->getId();
		$properties = array(
				"name" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($state->getName()), ENT_COMPAT, self::$Charset, false) : htmlentities($state->getName(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('states', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update State "'.$id.'" in database. (StateModel::save())');
				}
			} else {
				$query->createInsert('states', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'states');
					$value = $query->execute();
					$state->setId($value['id']);
				} else {
					throw new Exception('Unable to insert State in database. (StateModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save State with empty required values:'.$emptyValues.'. (StateModel::save())');
		}
		return true;
	}

	/**
	 * Finds a State by id
	 * 
	 * @param		int		$id
	 * @return		State
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'states', array(), 'id = "'.$id.'"');
		$stateArray = $query->execute();
		$state = false;
		if(!empty($stateArray)){
			$state = self::CreateObjectFromArray($stateArray);
		}
		return $state;
	}

	/**
	 * Finds stored States by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|State
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$statesArray = array();
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
			$query->createSelect(array('*'), 'states', null, $where, $orderBy, $limit);
			$arrayArraysState = $query->execute(true);
			if(!empty($arrayArraysState)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysState[0]);
				}
				foreach($arrayArraysState as $arrayState){
					array_push($statesArray, self::CreateObjectFromArray($arrayState));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in StateModel::FindBy()');
		}
		return $statesArray;
	}

	/**
	 * Finds stored States by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|State
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$statesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in StateModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'states', null, $where, $orderBy, $limit);
			$arrayArraysState = $query->execute(true);
			if(!empty($arrayArraysState)){
				foreach($arrayArraysState as $arrayState){
					array_push($statesArray, self::CreateObjectFromArray($arrayState));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in StateModel::FindByMultipleValues()');
		}
		return $statesArray;
	}

	/**
	 * Retrieves all States stored in the data base
	 * 
	 * @return		array|State
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$statesArray = array();
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
		$query->createSelect(array('*'), 'states', null, null, $orderBy, $limit);
		$arrayArraysState = $query->execute(true);
		if(!empty($arrayArraysState)){
			foreach($arrayArraysState as $arrayState){
				array_push($statesArray, self::CreateObjectFromArray($arrayState));
			}
		}
		return $statesArray;
	}

	/**
	 * Retrieves all States that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|State
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$statesArray = array();
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
				$query->createSelect(array('*'), 'states', null, $where, $orderBy, $limit);
				$arrayArraysState = $query->execute(true);
				if(!empty($arrayArraysState)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysState[0]);
					}
					foreach($arrayArraysState as $arrayState){
						array_push($statesArray, self::CreateObjectFromArray($arrayState));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. StateModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. StateModel::Search()');
		}
		return $statesArray;
	}

	/**
	 * Retrieves the number of States stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM states');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes State by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('states', $id);
		return $query->execute();
	}

	/**
	 *  Creates State object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		State
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			return new State($properties);
		} else {
			throw new Exception('Unable to create State with empty required values:'.$emptyValues.' for State "'.$properties['id'].'". (StateModel::CreateObjectFromArray())');
		}
	}
}