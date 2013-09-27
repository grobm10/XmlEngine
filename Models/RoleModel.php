<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/RoleModel.php
 */

class RoleModel extends AbstractModel {

	/**
	 * Saves the Role in the Data Base
	 * 
	 * @param		Role		$role
	 * @static
	 */
	public static function Save(&$role){
		$id = $role->getId();
		$properties = array(
				"name" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($role->getName()), ENT_COMPAT, self::$Charset, false) : htmlentities($role->getName(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('roles', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Role "'.$id.'" in database. (RoleModel::save())');
				}
			} else {
				$query->createInsert('roles', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'roles');
					$value = $query->execute();
					$role->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Role in database. (RoleModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Role with empty required values:'.$emptyValues.'. (RoleModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Role by id
	 * 
	 * @param		int		$id
	 * @return		Role
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'roles', array(), 'id = "'.$id.'"');
		$roleArray = $query->execute();
		$role = false;
		if(!empty($roleArray)){
			$role = self::CreateObjectFromArray($roleArray);
		}
		return $role;
	}

	/**
	 * Finds stored Roles by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Role
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$rolesArray = array();
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
			$query->createSelect(array('*'), 'roles', null, $where, $orderBy, $limit);
			$arrayArraysRole = $query->execute(true);
			if(!empty($arrayArraysRole)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysRole[0]);
				}
				foreach($arrayArraysRole as $arrayRole){
					array_push($rolesArray, self::CreateObjectFromArray($arrayRole));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in RoleModel::FindBy()');
		}
		return $rolesArray;
	}

	/**
	 * Finds stored Roles by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Role
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$rolesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in RoleModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'roles', null, $where, $orderBy, $limit);
			$arrayArraysRole = $query->execute(true);
			if(!empty($arrayArraysRole)){
				foreach($arrayArraysRole as $arrayRole){
					array_push($rolesArray, self::CreateObjectFromArray($arrayRole));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in RoleModel::FindByMultipleValues()');
		}
		return $rolesArray;
	}

	/**
	 * Retrieves all Roles stored in the data base
	 * 
	 * @return		array|Role
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$rolesArray = array();
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
		$query->createSelect(array('*'), 'roles', null, null, $orderBy, $limit);
		$arrayArraysRole = $query->execute(true);
		if(!empty($arrayArraysRole)){
			foreach($arrayArraysRole as $arrayRole){
				array_push($rolesArray, self::CreateObjectFromArray($arrayRole));
			}
		}
		return $rolesArray;
	}

	/**
	 * Retrieves all Roles that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Role
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$rolesArray = array();
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
				$query->createSelect(array('*'), 'roles', null, $where, $orderBy, $limit);
				$arrayArraysRole = $query->execute(true);
				if(!empty($arrayArraysRole)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysRole[0]);
					}
					foreach($arrayArraysRole as $arrayRole){
						array_push($rolesArray, self::CreateObjectFromArray($arrayRole));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. RoleModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. RoleModel::Search()');
		}
		return $rolesArray;
	}

	/**
	 * Retrieves the number of Roles stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM roles');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Role by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('roles', $id);
		return $query->execute();
	}

	/**
	 *  Creates Role object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Role
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
			return new Role($properties);
		} else {
			throw new Exception('Unable to create Role with empty required values:'.$emptyValues.' for Role "'.$properties['id'].'". (RoleModel::CreateObjectFromArray())');
		}
	}
}