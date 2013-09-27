<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/TypeModel.php
 */

class TypeModel extends AbstractModel {

	/**
	 * Saves the Type in the Data Base
	 * 
	 * @param		Type		$type
	 * @static
	 */
	public static function Save(&$type){
		$id = $type->getId();
		$properties = array(
				"name" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($type->getName()), ENT_COMPAT, self::$Charset, false) : htmlentities($type->getName(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('types', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Type "'.$id.'" in database. (TypeModel::save())');
				}
			} else {
				$query->createInsert('types', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'types');
					$value = $query->execute();
					$type->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Type in database. (TypeModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Type with empty required values:'.$emptyValues.'. (TypeModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Type by id
	 * 
	 * @param		int		$id
	 * @return		Type
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'types', array(), 'id = "'.$id.'"');
		$typeArray = $query->execute();
		$type = false;
		if(!empty($typeArray)){
			$type = self::CreateObjectFromArray($typeArray);
		}
		return $type;
	}

	/**
	 * Finds stored Types by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Type
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$typesArray = array();
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
			$query->createSelect(array('*'), 'types', null, $where, $orderBy, $limit);
			$arrayArraysType = $query->execute(true);
			if(!empty($arrayArraysType)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysType[0]);
				}
				foreach($arrayArraysType as $arrayType){
					array_push($typesArray, self::CreateObjectFromArray($arrayType));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in TypeModel::FindBy()');
		}
		return $typesArray;
	}

	/**
	 * Finds stored Types by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Type
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$typesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in TypeModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'types', null, $where, $orderBy, $limit);
			$arrayArraysType = $query->execute(true);
			if(!empty($arrayArraysType)){
				foreach($arrayArraysType as $arrayType){
					array_push($typesArray, self::CreateObjectFromArray($arrayType));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in TypeModel::FindByMultipleValues()');
		}
		return $typesArray;
	}

	/**
	 * Retrieves all Types stored in the data base
	 * 
	 * @return		array|Type
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$typesArray = array();
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
		$query->createSelect(array('*'), 'types', null, null, $orderBy, $limit);
		$arrayArraysType = $query->execute(true);
		if(!empty($arrayArraysType)){
			foreach($arrayArraysType as $arrayType){
				array_push($typesArray, self::CreateObjectFromArray($arrayType));
			}
		}
		return $typesArray;
	}

	/**
	 * Retrieves all Types that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Type
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$typesArray = array();
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
				$query->createSelect(array('*'), 'types', null, $where, $orderBy, $limit);
				$arrayArraysType = $query->execute(true);
				if(!empty($arrayArraysType)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysType[0]);
					}
					foreach($arrayArraysType as $arrayType){
						array_push($typesArray, self::CreateObjectFromArray($arrayType));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. TypeModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. TypeModel::Search()');
		}
		return $typesArray;
	}

	/**
	 * Retrieves the number of Types stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM types');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Type by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('types', $id);
		return $query->execute();
	}

	/**
	 *  Creates Type object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Type
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
			return new Type($properties);
		} else {
			throw new Exception('Unable to create Type with empty required values:'.$emptyValues.' for Type "'.$properties['id'].'". (TypeModel::CreateObjectFromArray())');
		}
	}
}