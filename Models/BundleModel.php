<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/BundleModel.php
 */

class BundleModel extends AbstractModel {

	/**
	 * Saves the Bundle in the Data Base
	 * 
	 * @param		Bundle		$bundle
	 * @static
	 */
	public static function Save(&$bundle){
		$id = $bundle->getId();
		$properties = array(
				"videoId" => $bundle->getVideo()->getId(),
				"languageCode" => $bundle->getLanguage()->getCode(),
				"regionCode" => $bundle->getRegion()->getCode(),
				"partnerId" => $bundle->getPartner()->getId(),
				"entityId" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($bundle->getEntityId()), ENT_COMPAT, self::$Charset, false) : htmlentities($bundle->getEntityId(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["videoId"])){
			$emptyValues .= ' videoId';
		}
		if(empty($properties["languageCode"])){
			$emptyValues .= ' languageCode';
		}
		if(empty($properties["regionCode"])){
			$emptyValues .= ' regionCode';
		}
		if(empty($properties["partnerId"])){
			$emptyValues .= ' partnerId';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('bundles', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Bundle "'.$id.'" in database. (BundleModel::save())');
				}
			} else {
				$query->createInsert('bundles', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'bundles');
					$value = $query->execute();
					$bundle->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Bundle in database. (BundleModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Bundle with empty required values:'.$emptyValues.'. (BundleModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Bundle by id
	 * 
	 * @param		int		$id
	 * @return		Bundle
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'bundles', array(), 'id = "'.$id.'"');
		$bundleArray = $query->execute();
		$bundle = false;
		if(!empty($bundleArray)){
			$bundle = self::CreateObjectFromArray($bundleArray);
		}
		return $bundle;
	}

	/**
	 * Finds stored Bundles by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Bundle
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$bundlesArray = array();
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
			$query->createSelect(array('*'), 'bundles', null, $where, $orderBy, $limit);
			$arrayArraysBundle = $query->execute(true);
			if(!empty($arrayArraysBundle)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysBundle[0]);
				}
				foreach($arrayArraysBundle as $arrayBundle){
					array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in BundleModel::FindBy()');
		}
		return $bundlesArray;
	}

	/**
	 * Finds stored Bundles by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Bundle
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$bundlesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in BundleModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'bundles', null, $where, $orderBy, $limit);
			$arrayArraysBundle = $query->execute(true);
			if(!empty($arrayArraysBundle)){
				foreach($arrayArraysBundle as $arrayBundle){
					array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in BundleModel::FindByMultipleValues()');
		}
		return $bundlesArray;
	}

	/**
	 * Finds stored Bundles by related Video properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Bundle
	 * @static
	 */
	public static function FindByVideoProperties($params, $expectsOne=false){
		$bundlesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'bundles.id',
					'bundles.videoId',
					'bundles.languageCode',
					'bundles.regionCode',
					'bundles.partnerId',
					'bundles.entityId'
				);
			$joinArray = array('videos'=>'videos.id = bundles.videoId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'videos.'.$key.' = "'.$parsedValue.'"');
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
			$query->createSelect(array('*'), 'bundles', $joinArray, $where, $orderBy, $limit);
			$arrayArraysBundle = $query->execute(true);
			if(!empty($arrayArraysBundle)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysBundle[0]);
				}
				foreach($arrayArraysBundle as $arrayBundle){
					array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in BundleModel::FindByVideoProperties()');
		}
		return $bundlesArray;
	}

	/**
	 * Finds stored Bundles by related Language properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Bundle
	 * @static
	 */
	public static function FindByLanguageProperties($params, $expectsOne=false){
		$bundlesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'bundles.id',
					'bundles.videoId',
					'bundles.languageCode',
					'bundles.regionCode',
					'bundles.partnerId',
					'bundles.entityId'
				);
			$joinArray = array('languages'=>'languages.code = bundles.languageCode');
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
			$query->createSelect(array('*'), 'bundles', $joinArray, $where, $orderBy, $limit);
			$arrayArraysBundle = $query->execute(true);
			if(!empty($arrayArraysBundle)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysBundle[0]);
				}
				foreach($arrayArraysBundle as $arrayBundle){
					array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in BundleModel::FindByLanguageProperties()');
		}
		return $bundlesArray;
	}

	/**
	 * Finds stored Bundles by related Region properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Bundle
	 * @static
	 */
	public static function FindByRegionProperties($params, $expectsOne=false){
		$bundlesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'bundles.id',
					'bundles.videoId',
					'bundles.languageCode',
					'bundles.regionCode',
					'bundles.partnerId',
					'bundles.entityId'
				);
			$joinArray = array('regions'=>'regions.code = bundles.regionCode');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'regions.'.$key.' = "'.$parsedValue.'"');
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
			$query->createSelect(array('*'), 'bundles', $joinArray, $where, $orderBy, $limit);
			$arrayArraysBundle = $query->execute(true);
			if(!empty($arrayArraysBundle)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysBundle[0]);
				}
				foreach($arrayArraysBundle as $arrayBundle){
					array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in BundleModel::FindByRegionProperties()');
		}
		return $bundlesArray;
	}

	/**
	 * Finds stored Bundles by related Partner properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Bundle
	 * @static
	 */
	public static function FindByPartnerProperties($params, $expectsOne=false){
		$bundlesArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'bundles.id',
					'bundles.videoId',
					'bundles.languageCode',
					'bundles.regionCode',
					'bundles.partnerId',
					'bundles.entityId'
				);
			$joinArray = array('partners'=>'partners.id = bundles.partnerId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'partners.'.$key.' = "'.$parsedValue.'"');
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
			$query->createSelect(array('*'), 'bundles', $joinArray, $where, $orderBy, $limit);
			$arrayArraysBundle = $query->execute(true);
			if(!empty($arrayArraysBundle)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysBundle[0]);
				}
				foreach($arrayArraysBundle as $arrayBundle){
					array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in BundleModel::FindByPartnerProperties()');
		}
		return $bundlesArray;
	}

	/**
	 * Retrieves all Bundles stored in the data base
	 * 
	 * @return		array|Bundle
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$bundlesArray = array();
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
		$query->createSelect(array('*'), 'bundles', null, null, $orderBy, $limit);
		$arrayArraysBundle = $query->execute(true);
		if(!empty($arrayArraysBundle)){
			foreach($arrayArraysBundle as $arrayBundle){
				array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
			}
		}
		return $bundlesArray;
	}

	/**
	 * Retrieves all Bundles that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Bundle
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$bundlesArray = array();
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
				$query->createSelect(array('*'), 'bundles', null, $where, $orderBy, $limit);
				$arrayArraysBundle = $query->execute(true);
				if(!empty($arrayArraysBundle)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysBundle[0]);
					}
					foreach($arrayArraysBundle as $arrayBundle){
						array_push($bundlesArray, self::CreateObjectFromArray($arrayBundle));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. BundleModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. BundleModel::Search()');
		}
		return $bundlesArray;
	}

	/**
	 * Retrieves the number of Bundles stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM bundles');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Bundle by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('bundles', $id);
		return $query->execute();
	}

	/**
	 *  Creates Bundle object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Bundle
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["videoId"])){
			$emptyValues .= ' videoId';
		}
		if(empty($properties["languageCode"])){
			$emptyValues .= ' languageCode';
		}
		if(empty($properties["regionCode"])){
			$emptyValues .= ' regionCode';
		}
		if(empty($properties["partnerId"])){
			$emptyValues .= ' partnerId';
		}
		if(empty($emptyValues)){
			$properties['video'] = VideoModel::FindById($properties['videoId']);
			if(empty($properties['video'])){
				throw new Exception('Unable to find the Video for the Bundle.(BundleModel::CreateObjectFromArray())');
			}
			$properties['language'] = LanguageModel::FindById($properties['languageCode']);
			if(empty($properties['language'])){
				throw new Exception('Unable to find the Language for the Bundle.(BundleModel::CreateObjectFromArray())');
			}
			$properties['region'] = RegionModel::FindById($properties['regionCode']);
			if(empty($properties['region'])){
				throw new Exception('Unable to find the Region for the Bundle.(BundleModel::CreateObjectFromArray())');
			}
			$properties['partner'] = PartnerModel::FindById($properties['partnerId']);
			if(empty($properties['partner'])){
				throw new Exception('Unable to find the Partner for the Bundle.(BundleModel::CreateObjectFromArray())');
			}
			return new Bundle($properties);
		} else {
			throw new Exception('Unable to create Bundle with empty required values:'.$emptyValues.' for Bundle "'.$properties['id'].'". (BundleModel::CreateObjectFromArray())');
		}
	}
}