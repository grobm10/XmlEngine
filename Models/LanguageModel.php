<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/LanguageModel.php
 */

class LanguageModel extends AbstractModel {

	/**
	 * Saves the Language in the Data Base
	 * 
	 * @param		Language		$language
	 * @static
	 */
	public static function Save(&$language){
		$id = $language->getCode();
		$properties = array(
				"alt" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($language->getAlt()), ENT_COMPAT, self::$Charset, false) : htmlentities($language->getAlt(), ENT_COMPAT, self::$Charset, false),
				"name" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($language->getName()), ENT_COMPAT, self::$Charset, false) : htmlentities($language->getName(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($id)){
			$emptyValues .= ' code';
		}
		if(empty($properties["alt"])){
			$emptyValues .= ' alt';
		}
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			$query = new Query();
			$dbLanguage = self::FindById($id);
			if(!empty($dbLanguage)){
				$query->createUpdate('languages', $properties, 'code = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Language "'.$code.'" in database. (LanguageModel::save())');
				}
			} else {
				$properties['code'] = $id;
				$query->createInsert('languages', $properties, true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to insert Language in database. (LanguageModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Language with empty required values:'.$emptyValues.'. (LanguageModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Language by id
	 * 
	 * @param		int		$id
	 * @return		Language
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'languages', array(), 'code = "'.$id.'"');
		$languageArray = $query->execute();
		$language = false;
		if(!empty($languageArray)){
			$language = self::CreateObjectFromArray($languageArray);
		}
		return $language;
	}

	/**
	 * Finds stored Languages by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Language
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$languagesArray = array();
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
			$query->createSelect(array('*'), 'languages', null, $where, $orderBy, $limit);
			$arrayArraysLanguage = $query->execute(true);
			if(!empty($arrayArraysLanguage)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysLanguage[0]);
				}
				foreach($arrayArraysLanguage as $arrayLanguage){
					array_push($languagesArray, self::CreateObjectFromArray($arrayLanguage));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in LanguageModel::FindBy()');
		}
		return $languagesArray;
	}

	/**
	 * Finds stored Languages by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Language
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$languagesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in LanguageModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'languages', null, $where, $orderBy, $limit);
			$arrayArraysLanguage = $query->execute(true);
			if(!empty($arrayArraysLanguage)){
				foreach($arrayArraysLanguage as $arrayLanguage){
					array_push($languagesArray, self::CreateObjectFromArray($arrayLanguage));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in LanguageModel::FindByMultipleValues()');
		}
		return $languagesArray;
	}

	/**
	 * Retrieves all Languages stored in the data base
	 * 
	 * @return		array|Language
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$languagesArray = array();
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
		$query->createSelect(array('*'), 'languages', null, null, $orderBy, $limit);
		$arrayArraysLanguage = $query->execute(true);
		if(!empty($arrayArraysLanguage)){
			foreach($arrayArraysLanguage as $arrayLanguage){
				array_push($languagesArray, self::CreateObjectFromArray($arrayLanguage));
			}
		}
		return $languagesArray;
	}

	/**
	 * Retrieves all Languages that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Language
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$languagesArray = array();
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
				$query->createSelect(array('*'), 'languages', null, $where, $orderBy, $limit);
				$arrayArraysLanguage = $query->execute(true);
				if(!empty($arrayArraysLanguage)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysLanguage[0]);
					}
					foreach($arrayArraysLanguage as $arrayLanguage){
						array_push($languagesArray, self::CreateObjectFromArray($arrayLanguage));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. LanguageModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. LanguageModel::Search()');
		}
		return $languagesArray;
	}

	/**
	 * Retrieves the number of Languages stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM languages');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Language by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('languages', array('code'=>$id));
		return $query->execute();
	}

	/**
	 *  Creates Language object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Language
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["code"])){
			$emptyValues .= ' code';
		}
		if(empty($properties["alt"])){
			$emptyValues .= ' alt';
		}
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			return new Language($properties);
		} else {
			throw new Exception('Unable to create Language with empty required values:'.$emptyValues.' for Language "'.$properties['code'].'". (LanguageModel::CreateObjectFromArray())');
		}
	}
}