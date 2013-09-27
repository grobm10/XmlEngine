<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/RegionModel.php
 */

class RegionModel extends AbstractModel {

	/**
	 * Saves the Region in the Data Base
	 * 
	 * @param		Region		$region
	 * @static
	 */
	public static function Save(&$region){
		$id = $region->getCode();
		$properties = array(
				"country" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($region->getCountry()), ENT_COMPAT, self::$Charset, false) : htmlentities($region->getCountry(), ENT_COMPAT, self::$Charset, false),
				"languageCode" => $region->getLanguage()->getCode()
			);
		$emptyValues = '';
		if(empty($id)){
			$emptyValues .= ' code';
		}
		if(empty($properties["country"])){
			$emptyValues .= ' country';
		}
		if(empty($properties["languageCode"])){
			$emptyValues .= ' languageCode';
		}
		if(empty($emptyValues)){
			$query = new Query();
			$dbRegion = self::FindById($id);
			if(!empty($dbRegion)){
				$query->createUpdate('regions', $properties, 'code = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Region "'.$code.'" in database. (RegionModel::save())');
				}
			} else {
				$properties['code'] = $id;
				$query->createInsert('regions', $properties, true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to insert Region in database. (RegionModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Region with empty required values:'.$emptyValues.'. (RegionModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Region by id
	 * 
	 * @param		int		$id
	 * @return		Region
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'regions', array(), 'code = "'.$id.'"');
		$regionArray = $query->execute();
		$region = false;
		if(!empty($regionArray)){
			$region = self::CreateObjectFromArray($regionArray);
		}
		return $region;
	}

	/**
	 * Finds stored Regions by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Region
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$regionsArray = array();
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
			$query->createSelect(array('*'), 'regions', null, $where, $orderBy, $limit);
			$arrayArraysRegion = $query->execute(true);
			if(!empty($arrayArraysRegion)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysRegion[0]);
				}
				foreach($arrayArraysRegion as $arrayRegion){
					array_push($regionsArray, self::CreateObjectFromArray($arrayRegion));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in RegionModel::FindBy()');
		}
		return $regionsArray;
	}

	/**
	 * Finds stored Regions by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Region
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$regionsArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in RegionModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'regions', null, $where, $orderBy, $limit);
			$arrayArraysRegion = $query->execute(true);
			if(!empty($arrayArraysRegion)){
				foreach($arrayArraysRegion as $arrayRegion){
					array_push($regionsArray, self::CreateObjectFromArray($arrayRegion));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in RegionModel::FindByMultipleValues()');
		}
		return $regionsArray;
	}

	/**
	 * Finds stored Regions by related Language properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Region
	 * @static
	 */
	public static function FindByLanguageProperties($params, $expectsOne=false){
		$regionsArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'regions.code',
					'regions.country',
					'regions.languageCode'
				);
			$joinArray = array('languages'=>'languages.code = regions.languageCode');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'languages.'.$key.' = "'.$parsedValue.'"');
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
			$query->createSelect(array('*'), 'regions', $joinArray, $where, $orderBy, $limit);
			$arrayArraysRegion = $query->execute(true);
			if(!empty($arrayArraysRegion)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysRegion[0]);
				}
				foreach($arrayArraysRegion as $arrayRegion){
					array_push($regionsArray, self::CreateObjectFromArray($arrayRegion));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in RegionModel::FindByLanguageProperties()');
		}
		return $regionsArray;
	}

	/**
	 * Retrieves all Regions stored in the data base
	 * 
	 * @return		array|Region
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$regionsArray = array();
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
		$query->createSelect(array('*'), 'regions', null, null, $orderBy, $limit);
		$arrayArraysRegion = $query->execute(true);
		if(!empty($arrayArraysRegion)){
			foreach($arrayArraysRegion as $arrayRegion){
				array_push($regionsArray, self::CreateObjectFromArray($arrayRegion));
			}
		}
		return $regionsArray;
	}

	/**
	 * Retrieves all Regions that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Region
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$regionsArray = array();
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
				$query->createSelect(array('*'), 'regions', null, $where, $orderBy, $limit);
				$arrayArraysRegion = $query->execute(true);
				if(!empty($arrayArraysRegion)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysRegion[0]);
					}
					foreach($arrayArraysRegion as $arrayRegion){
						array_push($regionsArray, self::CreateObjectFromArray($arrayRegion));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. RegionModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. RegionModel::Search()');
		}
		return $regionsArray;
	}

	/**
	 * Retrieves the number of Regions stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM regions');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Region by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('regions', array('code'=>$id));
		return $query->execute();
	}

	/**
	 *  Creates Region object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Region
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["code"])){
			$emptyValues .= ' code';
		}
		if(empty($properties["country"])){
			$emptyValues .= ' country';
		}
		if(empty($properties["languageCode"])){
			$emptyValues .= ' languageCode';
		}
		if(empty($emptyValues)){
			$properties['language'] = LanguageModel::FindById($properties['languageCode']);
			if(empty($properties['language'])){
				throw new Exception('Unable to find the Language for the Region.(RegionModel::CreateObjectFromArray())');
			}
			return new Region($properties);
		} else {
			throw new Exception('Unable to create Region with empty required values:'.$emptyValues.' for Region "'.$properties['code'].'". (RegionModel::CreateObjectFromArray())');
		}
	}
}