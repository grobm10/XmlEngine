<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/MetadataModel.php
 */

class MetadataModel extends AbstractModel {

	/**
	 * Saves the Metadata in the Data Base
	 * 
	 * @param		Metadata		$metadata
	 * @static
	 */
	public static function Save(&$metadata){
		$id = $metadata->getId();
		$properties = array(
				"airDate" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getAirDate()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getAirDate(), ENT_COMPAT, self::$Charset, false),
				"archiveStatus" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getArchiveStatus()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getArchiveStatus(), ENT_COMPAT, self::$Charset, false),
				"assetGUID" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getAssetGUID()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getAssetGUID(), ENT_COMPAT, self::$Charset, false),
				"assetID" => $metadata->getAssetID(),
				"author" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getAuthor()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getAuthor(), ENT_COMPAT, self::$Charset, false),
				"category" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getCategory()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getCategory(), ENT_COMPAT, self::$Charset, false),
				"copyrightHolder" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getCopyrightHolder()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getCopyrightHolder(), ENT_COMPAT, self::$Charset, false),
				"description" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDescription(), ENT_COMPAT, self::$Charset, false),
				"dTOAssetXMLExportstage1" => intval($metadata->getDTOAssetXMLExportstage1()),
				"dTOContainerPosition" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOContainerPosition()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOContainerPosition(), ENT_COMPAT, self::$Charset, false),
				"dTOCopyrightHolder" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOCopyrightHolder()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOCopyrightHolder(), ENT_COMPAT, self::$Charset, false),
				"dTOEpisodeID" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOEpisodeID()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOEpisodeID(), ENT_COMPAT, self::$Charset, false),
				"dTOEpisodeName" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOEpisodeName()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOEpisodeName(), ENT_COMPAT, self::$Charset, false),
				"dTOGenre" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOGenre()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOGenre(), ENT_COMPAT, self::$Charset, false),
				"dTOLongDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOLongDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOLongDescription(), ENT_COMPAT, self::$Charset, false),
				"dTOLongEpisodeDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOLongEpisodeDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOLongEpisodeDescription(), ENT_COMPAT, self::$Charset, false),
				"dTORatings" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTORatings()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTORatings(), ENT_COMPAT, self::$Charset, false),
				"dTOReleaseDate" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOReleaseDate()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOReleaseDate(), ENT_COMPAT, self::$Charset, false),
				"dTOSalesPrice" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOSalesPrice()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOSalesPrice(), ENT_COMPAT, self::$Charset, false),
				"dTOSeasonID" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOSeasonID()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOSeasonID(), ENT_COMPAT, self::$Charset, false),
				"dTOSeasonName" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOSeasonName()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOSeasonName(), ENT_COMPAT, self::$Charset, false),
				"dTOSeriesDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOSeriesDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOSeriesDescription(), ENT_COMPAT, self::$Charset, false),
				"dTOSeriesID" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOSeriesID()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOSeriesID(), ENT_COMPAT, self::$Charset, false),
				"dTOShortEpisodeDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOShortEpisodeDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOShortEpisodeDescription(), ENT_COMPAT, self::$Charset, false),
				"dTOShortDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getDTOShortDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getDTOShortDescription(), ENT_COMPAT, self::$Charset, false),
				"eMDeliveryAsset" => intval($metadata->getEMDeliveryAsset()),
				"episodeName" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getEpisodeName()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getEpisodeName(), ENT_COMPAT, self::$Charset, false),
				"episodeNumber" => $metadata->getEpisodeNumber(),
				"forceDTOexportXML" => intval($metadata->getForceDTOexportXML()),
				"forceDTOproxyAsset" => intval($metadata->getForceDTOproxyAsset()),
				"genre" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getGenre()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getGenre(), ENT_COMPAT, self::$Charset, false),
				"keywords" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getKeywords()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getKeywords(), ENT_COMPAT, self::$Charset, false),
				"licenseStartDate" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getLicenseStartDate()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getLicenseStartDate(), ENT_COMPAT, self::$Charset, false),
				"localEntity" => intval($metadata->getLocalEntity()),
				"location" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getLocation()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getLocation(), ENT_COMPAT, self::$Charset, false),
				"mediaType" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getMediaType()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getMediaType(), ENT_COMPAT, self::$Charset, false),
				"metadataSet" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getMetadataSet()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getMetadataSet(), ENT_COMPAT, self::$Charset, false),
				"network" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getNetwork()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getNetwork(), ENT_COMPAT, self::$Charset, false),
				"owner" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getOwner()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getOwner(), ENT_COMPAT, self::$Charset, false),
				"ratingsOverride" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getRatingsOverride()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getRatingsOverride(), ENT_COMPAT, self::$Charset, false),
				"ratingSystem" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getRatingSystem()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getRatingSystem(), ENT_COMPAT, self::$Charset, false),
				"releaseYear" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getReleaseYear()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getReleaseYear(), ENT_COMPAT, self::$Charset, false),
				"seasonDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeasonDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeasonDescription(), ENT_COMPAT, self::$Charset, false),
				"seasonLanguage" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeasonLanguage()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeasonLanguage(), ENT_COMPAT, self::$Charset, false),
				"seasonName" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeasonName()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeasonName(), ENT_COMPAT, self::$Charset, false),
				"seasonNumber" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeasonNumber()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeasonNumber(), ENT_COMPAT, self::$Charset, false),
				"seasonOverride" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeasonOverride()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeasonOverride(), ENT_COMPAT, self::$Charset, false),
				"seriesDescription" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeriesDescription()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeriesDescription(), ENT_COMPAT, self::$Charset, false),
				"seriesName" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSeriesName()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSeriesName(), ENT_COMPAT, self::$Charset, false),
				"status" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getStatus()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getStatus(), ENT_COMPAT, self::$Charset, false),
				"storeandtrackversionsofthisasset" => intval($metadata->getStoreandtrackversionsofthisasset()),
				"syndicationPartnerDelivery" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getSyndicationPartnerDelivery()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getSyndicationPartnerDelivery(), ENT_COMPAT, self::$Charset, false),
				"title" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getTitle()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getTitle(), ENT_COMPAT, self::$Charset, false),
				"tVRating" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($metadata->getTVRating()), ENT_COMPAT, self::$Charset, false) : htmlentities($metadata->getTVRating(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["dTOEpisodeID"])){
			$emptyValues .= ' dTOEpisodeID';
		}
		if(empty($properties["dTOSeasonID"])){
			$emptyValues .= ' dTOSeasonID';
		}
		if(empty($properties["dTOSeriesID"])){
			$emptyValues .= ' dTOSeriesID';
		}
		if(empty($properties["episodeNumber"])){
			$emptyValues .= ' episodeNumber';
		}
		if(empty($properties["network"])){
			$emptyValues .= ' network';
		}
		if(empty($properties["seriesName"])){
			$emptyValues .= ' seriesName';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('metadata', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Metadata "'.$id.'" in database. (MetadataModel::save())');
				}
			} else {
				$query->createInsert('metadata', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'metadata');
					$value = $query->execute();
					$metadata->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Metadata in database. (MetadataModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Metadata with empty required values:'.$emptyValues.'. (MetadataModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Metadata by id
	 * 
	 * @param		int		$id
	 * @return		Metadata
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'metadata', array(), 'id = "'.$id.'"');
		$metadataArray = $query->execute();
		$metadata = false;
		if(!empty($metadataArray)){
			$metadata = self::CreateObjectFromArray($metadataArray);
		}
		return $metadata;
	}

	/**
	 * Finds stored Metadata by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Metadata
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$metadataArray = array();
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
			$query->createSelect(array('*'), 'metadata', null, $where, $orderBy, $limit);
			$arrayArraysMetadata = $query->execute(true);
			if(!empty($arrayArraysMetadata)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysMetadata[0]);
				}
				foreach($arrayArraysMetadata as $arrayMetadata){
					array_push($metadataArray, self::CreateObjectFromArray($arrayMetadata));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in MetadataModel::FindBy()');
		}
		return $metadataArray;
	}

	/**
	 * Finds stored Metadata by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Metadata
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$metadataArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in MetadataModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'metadata', null, $where, $orderBy, $limit);
			$arrayArraysMetadata = $query->execute(true);
			if(!empty($arrayArraysMetadata)){
				foreach($arrayArraysMetadata as $arrayMetadata){
					array_push($metadataArray, self::CreateObjectFromArray($arrayMetadata));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in MetadataModel::FindByMultipleValues()');
		}
		return $metadataArray;
	}

	/**
	 * Retrieves all Metadata stored in the data base
	 * 
	 * @return		array|Metadata
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$metadataArray = array();
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
		$query->createSelect(array('*'), 'metadata', null, null, $orderBy, $limit);
		$arrayArraysMetadata = $query->execute(true);
		if(!empty($arrayArraysMetadata)){
			foreach($arrayArraysMetadata as $arrayMetadata){
				array_push($metadataArray, self::CreateObjectFromArray($arrayMetadata));
			}
		}
		return $metadataArray;
	}

	/**
	 * Retrieves all Metadata that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Metadata
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$metadataArray = array();
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
				$query->createSelect(array('*'), 'metadata', null, $where, $orderBy, $limit);
				$arrayArraysMetadata = $query->execute(true);
				if(!empty($arrayArraysMetadata)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysMetadata[0]);
					}
					foreach($arrayArraysMetadata as $arrayMetadata){
						array_push($metadataArray, self::CreateObjectFromArray($arrayMetadata));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. MetadataModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. MetadataModel::Search()');
		}
		return $metadataArray;
	}

	/**
	 * Retrieves the number of Metadata stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM metadata');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Metadata by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('metadata', $id);
		return $query->execute();
	}

	/**
	 *  Creates Metadata object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Metadata
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["dTOEpisodeID"])){
			$emptyValues .= ' dTOEpisodeID';
		}
		if(empty($properties["dTOSeasonID"])){
			$emptyValues .= ' dTOSeasonID';
		}
		if(empty($properties["dTOSeriesID"])){
			$emptyValues .= ' dTOSeriesID';
		}
		if(empty($properties["episodeNumber"])){
			$emptyValues .= ' episodeNumber';
		}
		if(empty($properties["network"])){
			$emptyValues .= ' network';
		}
		if(empty($properties["seriesName"])){
			$emptyValues .= ' seriesName';
		}
		if(empty($emptyValues)){
			return new Metadata($properties);
		} else {
			throw new Exception('Unable to create Metadata with empty required values:'.$emptyValues.' for Metadata "'.$properties['id'].'". (MetadataModel::CreateObjectFromArray())');
		}
	}
}