<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/UserModel.php
 */

class UserModel extends AbstractModel {

	/**
	 * Saves the User in the Data Base
	 * 
	 * @param		User		$user
	 * @static
	 */
	public static function Save(&$user){
		$id = $user->getId();
		$properties = array(
				"password" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($user->getPassword()), ENT_COMPAT, self::$Charset, false) : htmlentities($user->getPassword(), ENT_COMPAT, self::$Charset, false),
				"name" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($user->getName()), ENT_COMPAT, self::$Charset, false) : htmlentities($user->getName(), ENT_COMPAT, self::$Charset, false),
				"lastActionDate" => Date::ParseDate($user->getLastActionDate()),
				"roleId" => $user->getRole()->getId(),
				"active" => intval($user->getActive())
			);
		$emptyValues = '';
		if(empty($id)){
			$emptyValues .= ' id';
		}
		if(empty($properties["password"])){
			$emptyValues .= ' password';
		}
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($properties["lastActionDate"])){
			$emptyValues .= ' lastActionDate';
		}
		if(empty($properties["roleId"])){
			$emptyValues .= ' roleId';
		}
		if(empty($properties["active"])){
			$emptyValues .= ' active';
		}
		if(empty($emptyValues)){
			$query = new Query();
			$dbUser = self::FindById($id);
			if(!empty($dbUser)){
				$query->createUpdate('users', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update User "'.$id.'" in database. (UserModel::save())');
				}
			} else {
				$properties['id'] = $id;
				$query->createInsert('users', $properties, true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to insert User in database. (UserModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save User with empty required values:'.$emptyValues.'. (UserModel::save())');
		}
		return true;
	}

	/**
	 * Finds a User by id
	 * 
	 * @param		int		$id
	 * @return		User
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'users', array(), 'id = "'.$id.'"');
		$userArray = $query->execute();
		$user = false;
		if(!empty($userArray)){
			$user = self::CreateObjectFromArray($userArray);
		}
		return $user;
	}

	/**
	 * Finds stored Users by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|User
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$usersArray = array();
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
			$query->createSelect(array('*'), 'users', null, $where, $orderBy, $limit);
			$arrayArraysUser = $query->execute(true);
			if(!empty($arrayArraysUser)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysUser[0]);
				}
				foreach($arrayArraysUser as $arrayUser){
					array_push($usersArray, self::CreateObjectFromArray($arrayUser));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in UserModel::FindBy()');
		}
		return $usersArray;
	}

	/**
	 * Finds stored Users by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|User
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$usersArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in UserModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'users', null, $where, $orderBy, $limit);
			$arrayArraysUser = $query->execute(true);
			if(!empty($arrayArraysUser)){
				foreach($arrayArraysUser as $arrayUser){
					array_push($usersArray, self::CreateObjectFromArray($arrayUser));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in UserModel::FindByMultipleValues()');
		}
		return $usersArray;
	}

	/**
	 * Finds stored Users by related Role properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|User
	 * @static
	 */
	public static function FindByRoleProperties($params, $expectsOne=false){
		$usersArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'users.id',
					'users.password',
					'users.name',
					'users.lastActionDate',
					'users.roleId',
					'users.active'
				);
			$joinArray = array('roles'=>'roles.id = users.roleId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'roles.'.$key.' = "'.$parsedValue.'"');
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
			$query->createSelect(array('*'), 'users', $joinArray, $where, $orderBy, $limit);
			$arrayArraysUser = $query->execute(true);
			if(!empty($arrayArraysUser)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysUser[0]);
				}
				foreach($arrayArraysUser as $arrayUser){
					array_push($usersArray, self::CreateObjectFromArray($arrayUser));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in UserModel::FindByRoleProperties()');
		}
		return $usersArray;
	}

	/**
	 * Retrieves all Users stored in the data base
	 * 
	 * @return		array|User
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$usersArray = array();
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
		$query->createSelect(array('*'), 'users', null, null, $orderBy, $limit);
		$arrayArraysUser = $query->execute(true);
		if(!empty($arrayArraysUser)){
			foreach($arrayArraysUser as $arrayUser){
				array_push($usersArray, self::CreateObjectFromArray($arrayUser));
			}
		}
		return $usersArray;
	}

	/**
	 * Retrieves all Users that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|User
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$usersArray = array();
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
				$query->createSelect(array('*'), 'users', null, $where, $orderBy, $limit);
				$arrayArraysUser = $query->execute(true);
				if(!empty($arrayArraysUser)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysUser[0]);
					}
					foreach($arrayArraysUser as $arrayUser){
						array_push($usersArray, self::CreateObjectFromArray($arrayUser));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. UserModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. UserModel::Search()');
		}
		return $usersArray;
	}

	/**
	 * Retrieves the number of Users stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM users');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes User by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('users', array('id'=>$id));
		return $query->execute();
	}

	/**
	 *  Creates User object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		User
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["password"])){
			$emptyValues .= ' password';
		}
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($properties["lastActionDate"])){
			$emptyValues .= ' lastActionDate';
		}
		if(empty($properties["roleId"])){
			$emptyValues .= ' roleId';
		}
		if(empty($properties["active"])){
			$emptyValues .= ' active';
		}
		if(empty($emptyValues)){
			$properties['role'] = RoleModel::FindById($properties['roleId']);
			if(empty($properties['role'])){
				throw new Exception('Unable to find the Role for the User.(UserModel::CreateObjectFromArray())');
			}
			return new User($properties);
		} else {
			throw new Exception('Unable to create User with empty required values:'.$emptyValues.' for User "'.$properties['id'].'". (UserModel::CreateObjectFromArray())');
		}
	}
}