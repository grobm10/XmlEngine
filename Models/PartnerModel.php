<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/PartnerModel.php
 */

class PartnerModel extends AbstractModel {

	/**
	 * Saves the Partner in the Data Base
	 * 
	 * @param		Partner		$partner
	 * @static
	 */
	public static function Save(&$partner){
		$id = $partner->getId();
		$properties = array(
				"name" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($partner->getName()), ENT_COMPAT, self::$Charset, false) : htmlentities($partner->getName(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["name"])){
			$emptyValues .= ' name';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('partners', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Partner "'.$id.'" in database. (PartnerModel::save())');
				}
			} else {
				$query->createInsert('partners', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'partners');
					$value = $query->execute();
					$partner->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Partner in database. (PartnerModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Partner with empty required values:'.$emptyValues.'. (PartnerModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Partner by id
	 * 
	 * @param		int		$id
	 * @return		Partner
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'partners', array(), 'id = "'.$id.'"');
		$partnerArray = $query->execute();
		$partner = false;
		if(!empty($partnerArray)){
			$partner = self::CreateObjectFromArray($partnerArray);
		}
		return $partner;
	}

	/**
	 * Finds stored Partners by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Partner
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$partnersArray = array();
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
			$query->createSelect(array('*'), 'partners', null, $where, $orderBy, $limit);
			$arrayArraysPartner = $query->execute(true);
			if(!empty($arrayArraysPartner)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysPartner[0]);
				}
				foreach($arrayArraysPartner as $arrayPartner){
					array_push($partnersArray, self::CreateObjectFromArray($arrayPartner));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in PartnerModel::FindBy()');
		}
		return $partnersArray;
	}

	/**
	 * Finds stored Partners by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Partner
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$partnersArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in PartnerModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'partners', null, $where, $orderBy, $limit);
			$arrayArraysPartner = $query->execute(true);
			if(!empty($arrayArraysPartner)){
				foreach($arrayArraysPartner as $arrayPartner){
					array_push($partnersArray, self::CreateObjectFromArray($arrayPartner));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in PartnerModel::FindByMultipleValues()');
		}
		return $partnersArray;
	}

	/**
	 * Retrieves all Partners stored in the data base
	 * 
	 * @return		array|Partner
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$partnersArray = array();
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
		$query->createSelect(array('*'), 'partners', null, null, $orderBy, $limit);
		$arrayArraysPartner = $query->execute(true);
		if(!empty($arrayArraysPartner)){
			foreach($arrayArraysPartner as $arrayPartner){
				array_push($partnersArray, self::CreateObjectFromArray($arrayPartner));
			}
		}
		return $partnersArray;
	}

	/**
	 * Retrieves all Partners that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Partner
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$partnersArray = array();
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
				$query->createSelect(array('*'), 'partners', null, $where, $orderBy, $limit);
				$arrayArraysPartner = $query->execute(true);
				if(!empty($arrayArraysPartner)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysPartner[0]);
					}
					foreach($arrayArraysPartner as $arrayPartner){
						array_push($partnersArray, self::CreateObjectFromArray($arrayPartner));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. PartnerModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. PartnerModel::Search()');
		}
		return $partnersArray;
	}

	/**
	 * Retrieves the number of Partners stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM partners');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Partner by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('partners', $id);
		return $query->execute();
	}

	/**
	 *  Creates Partner object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Partner
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
			return new Partner($properties);
		} else {
			throw new Exception('Unable to create Partner with empty required values:'.$emptyValues.' for Partner "'.$properties['id'].'". (PartnerModel::CreateObjectFromArray())');
		}
	}
}