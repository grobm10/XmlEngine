<?php
/**
 * @author		David Curras
 * @version		May 28, 2013
 * @filesource		/Models/VideoModel.php
 */

class VideoModel extends AbstractModel {

	/**
	 * Saves the Video in the Data Base
	 * 
	 * @param		Video		$video
	 * @static
	 */
	public static function Save(&$video){
		$id = $video->getId();
		$properties = array(
				"metadataId" => $video->getMetadata()->getId(),
				"audioCodec" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getAudioCodec()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getAudioCodec(), ENT_COMPAT, self::$Charset, false),
				"createdBy" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getCreatedBy()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getCreatedBy(), ENT_COMPAT, self::$Charset, false),
				"creationDate" => Date::ParseDate($video->getCreationDate()),
				"dTOVideoType" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getDTOVideoType()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getDTOVideoType(), ENT_COMPAT, self::$Charset, false),
				"duration" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getDuration()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getDuration(), ENT_COMPAT, self::$Charset, false),
				"fileCreateDate" => Date::ParseDate($video->getFileCreateDate()),
				"fileModificationDate" => Date::ParseDate($video->getFileModificationDate()),
				"fileName" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getFileName()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getFileName(), ENT_COMPAT, self::$Charset, false),
				"imageSize" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getImageSize()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getImageSize(), ENT_COMPAT, self::$Charset, false),
				"lastAccessed" => Date::ParseDate($video->getLastAccessed()),
				"lastModified" => Date::ParseDate($video->getLastModified()),
				"mD5Hash" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getMD5Hash()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getMD5Hash(), ENT_COMPAT, self::$Charset, false),
				"mD5HashRecal" => intval($video->getMD5HashRecal()),
				"mimeType" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getMimeType()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getMimeType(), ENT_COMPAT, self::$Charset, false),
				"size" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getSize()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getSize(), ENT_COMPAT, self::$Charset, false),
				"storedOn" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getStoredOn()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getStoredOn(), ENT_COMPAT, self::$Charset, false),
				"timecodeOffset" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getTimecodeOffset()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getTimecodeOffset(), ENT_COMPAT, self::$Charset, false),
				"videoBitrate" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getVideoBitrate()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getVideoBitrate(), ENT_COMPAT, self::$Charset, false),
				"videoCodec" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getVideoCodec()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getVideoCodec(), ENT_COMPAT, self::$Charset, false),
				"videoElements" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getVideoElements()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getVideoElements(), ENT_COMPAT, self::$Charset, false),
				"videoFrameRate" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($video->getVideoFrameRate()), ENT_COMPAT, self::$Charset, false) : htmlentities($video->getVideoFrameRate(), ENT_COMPAT, self::$Charset, false)
			);
		$emptyValues = '';
		if(empty($properties["metadataId"])){
			$emptyValues .= ' metadataId';
		}
		if(empty($properties["fileName"])){
			$emptyValues .= ' fileName';
		}
		if(empty($properties["mD5Hash"])){
			$emptyValues .= ' mD5Hash';
		}
		if(empty($properties["size"])){
			$emptyValues .= ' size';
		}
		if(empty($emptyValues)){
			$query = new Query();
			if(!empty($id) && is_int($id)){
				$query->createUpdate('videos', $properties, 'id = "'.$id.'"', true);
				$isExecuted = $query->execute();
				if(!$isExecuted){
					throw new Exception('Unable to update Video "'.$id.'" in database. (VideoModel::save())');
				}
			} else {
				$query->createInsert('videos', $properties, true);
				$isExecuted = $query->execute();
				if($isExecuted){
					//get the last inserted id
					$query->createSelect(array('MAX(id) as id'), 'videos');
					$value = $query->execute();
					$video->setId($value['id']);
				} else {
					throw new Exception('Unable to insert Video in database. (VideoModel::save())');
				}
			}
		} else {
			throw new Exception('Unable to save Video with empty required values:'.$emptyValues.'. (VideoModel::save())');
		}
		return true;
	}

	/**
	 * Finds a Video by id
	 * 
	 * @param		int		$id
	 * @return		Video
	 * @static
	 */
	public static function FindById($id){
		$query = new Query();
		$query->createSelect(array('*'), 'videos', array(), 'id = "'.$id.'"');
		$videoArray = $query->execute();
		$video = false;
		if(!empty($videoArray)){
			$video = self::CreateObjectFromArray($videoArray);
		}
		return $video;
	}

	/**
	 * Finds stored Videos by specific values
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Video
	 * @static
	 */
	public static function FindBy($params, $expectsOne=false){
		$videosArray = array();
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
			$query->createSelect(array('*'), 'videos', null, $where, $orderBy, $limit);
			$arrayArraysVideo = $query->execute(true);
			if(!empty($arrayArraysVideo)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysVideo[0]);
				}
				foreach($arrayArraysVideo as $arrayVideo){
					array_push($videosArray, self::CreateObjectFromArray($arrayVideo));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid argument passed, expects param to be Array in VideoModel::FindBy()');
		}
		return $videosArray;
	}

	/**
	 * Finds stored Videos by multiple values of an specific field
	 * 
	 * @param		array|string		$params
	 * @return		array|Video
	 * @static
	 */
	public static function FindByMultipleValues($params, $expectsOne=false){
		$videosArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			//TODO: Use Query::Make() !!!
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value) && is_array($value)){
					array_push($whereArray, $key.' IN ('.implode(', ', $value).')');
				} else {
					throw new Exception('Invalid param, array expected in VideoModel::FindByMultipleValues()');
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
			$query->createSelect(array('*'), 'videos', null, $where, $orderBy, $limit);
			$arrayArraysVideo = $query->execute(true);
			if(!empty($arrayArraysVideo)){
				foreach($arrayArraysVideo as $arrayVideo){
					array_push($videosArray, self::CreateObjectFromArray($arrayVideo));
				}
			}
		} else {
			throw new Exception('Invalid param, array expected in VideoModel::FindByMultipleValues()');
		}
		return $videosArray;
	}

	/**
	 * Finds stored Videos by related Metadata properties
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Video
	 * @static
	 */
	public static function FindByMetadataProperties($params, $expectsOne=false){
		$videosArray = array();
		if(is_array($params)){
			$params = self::CheckParams($params);
			$selectFields = array(
					'videos.id',
					'videos.metadataId',
					'videos.audioCodec',
					'videos.createdBy',
					'videos.creationDate',
					'videos.dTOVideoType',
					'videos.duration',
					'videos.fileCreateDate',
					'videos.fileModificationDate',
					'videos.fileName',
					'videos.imageSize',
					'videos.lastAccessed',
					'videos.lastModified',
					'videos.mD5Hash',
					'videos.mD5HashRecal',
					'videos.mimeType',
					'videos.size',
					'videos.storedOn',
					'videos.timecodeOffset',
					'videos.videoBitrate',
					'videos.videoCodec',
					'videos.videoElements',
					'videos.videoFrameRate'
				);
			$joinArray = array('metadata'=>'metadata.id = videos.metadataId');
			$whereArray = array();
			foreach ($params['where'] as $key => $value){
				if(!empty($value)){
					$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);
					array_push($whereArray, 'metadata.'.$key.' = "'.$parsedValue.'"');
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
			$query->createSelect(array('*'), 'videos', $joinArray, $where, $orderBy, $limit);
			$arrayArraysVideo = $query->execute(true);
			if(!empty($arrayArraysVideo)){
				if($expectsOne){
					return self::CreateObjectFromArray($arrayArraysVideo[0]);
				}
				foreach($arrayArraysVideo as $arrayVideo){
					array_push($videosArray, self::CreateObjectFromArray($arrayVideo));
				}
			} elseif($expectsOne){
				return false;
			}
		} else {
			throw new Exception('Invalid param, array expected in VideoModel::FindByMetadataProperties()');
		}
		return $videosArray;
	}

	/**
	 * Retrieves all Videos stored in the data base
	 * 
	 * @return		array|Video
	 * @static
	 */
	public static function FetchAll($params=array('orderBy', 'from', 'amount')){
		$videosArray = array();
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
		$query->createSelect(array('*'), 'videos', null, null, $orderBy, $limit);
		$arrayArraysVideo = $query->execute(true);
		if(!empty($arrayArraysVideo)){
			foreach($arrayArraysVideo as $arrayVideo){
				array_push($videosArray, self::CreateObjectFromArray($arrayVideo));
			}
		}
		return $videosArray;
	}

	/**
	 * Retrieves all Videos that matches the search text
	 * 
	 * @param		array|string		$params
	 * @param		bool				$expectsOne
	 * @return		array|Video
	 * @static
	 */
	public static function Search($params, $expectsOne=false){
		$videosArray = array();
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
				$query->createSelect(array('*'), 'videos', null, $where, $orderBy, $limit);
				$arrayArraysVideo = $query->execute(true);
				if(!empty($arrayArraysVideo)){
					if($expectsOne){
						return self::CreateObjectFromArray($arrayArraysVideo[0]);
					}
					foreach($arrayArraysVideo as $arrayVideo){
						array_push($videosArray, self::CreateObjectFromArray($arrayVideo));
					}
				} elseif($expectsOne){
					return false;
				}
			} else {
				throw new Exception('Unable to perform search with invalid params. VideoModel::Search()');
			}
		} else {
			throw new Exception('Unable to perform search with invalid params. VideoModel::Search()');
		}
		return $videosArray;
	}

	/**
	 * Retrieves the number of Videos stored in the data base
	 * 
	 * @return		int
	 * @static
	 */
	public static function GetCount(){
		$query = new Query();
		$query->push('SELECT count(*) as count FROM videos');
		$result = $query->execute();
		return $result['count'];
	}

	/**
	 *  Deletes Video by id
	 * 
	 * @param		int		$id
	 * @static
	 */
	public static function Delete($id){
		$query = new Query();
		$query->createDelete('videos', $id);
		return $query->execute();
	}

	/**
	 *  Creates Video object from the basic properties
	 * 
	 * @param		array|string		$properties
	 * @return		Video
	 * @static
	 */
	public static function CreateObjectFromArray($properties){
		$emptyValues = '';
		if(empty($properties["id"])){
			$emptyValues .= ' id';
		}
		if(empty($properties["metadataId"])){
			$emptyValues .= ' metadataId';
		}
		if(empty($properties["fileName"])){
			$emptyValues .= ' fileName';
		}
		if(empty($properties["mD5Hash"])){
			$emptyValues .= ' mD5Hash';
		}
		if(empty($properties["size"])){
			$emptyValues .= ' size';
		}
		if(empty($emptyValues)){
			$properties['metadata'] = MetadataModel::FindById($properties['metadataId']);
			if(empty($properties['metadata'])){
				throw new Exception('Unable to find the Metadata for the Video.(VideoModel::CreateObjectFromArray())');
			}
			return new Video($properties);
		} else {
			throw new Exception('Unable to create Video with empty required values:'.$emptyValues.' for Video "'.$properties['id'].'". (VideoModel::CreateObjectFromArray())');
		}
	}
}