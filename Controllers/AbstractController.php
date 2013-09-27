<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Controllers/AbstractController.php
 */
abstract class AbstractController {

    /**
     * The current partner name
     * @staticvar		Partner
     */
    protected static $Partner;
	
    /**
     * The current process type
     * @staticvar		Type
     */
    protected static $Process;
	
	/**
	 * Sets the current partner.
	 *
	 * @param		mixed		$partner
	 */
	public static function SetPartner($partner){
		if (is_object($partner)){
			self::$Partner = $partner;
		} elseif((intval($partner) > 0) && !is_bool($partner)){
			self::$Partner = PartnerModel::FindById($partner);
		} elseif(is_string($partner)){
			self::$Partner = PartnerModel::FindBy(array('name'=>$partner), true);
		} else {
			throw new Exception('Unexpected type for parameter partner. (AbstractController::SetPartner)');
		}
		if(!is_object(self::$Partner)){
			throw new Exception('Unable to set the partner. (AbstractController::SetPartner)');
		}
	}

    /**
     * Gets the current partner
	 *
     * @return		Partner
     */
    public static function GetPartner(){
    	return self::$Partner;
    }

    /**
     * Gets the current process type
	 *
     * @return		Type
     */
    public static function GetProcess(){
    	return self::$Process;
    }
	
	/**
	 * The list of xml file names
	 * @var		array|string
	 */
    protected $xmlFiles;
    
    /**
     * The current Bundle object
     * @var		Bundle
     */
    protected $bundle;
	
	/**
	 * Sets the xml files for the transporter stacks.
	 *
	 * @param		string		$source		
	 */
	protected function setXmlFiles($source){
		switch (strtolower(self::$Partner->getName())){
			case ITUNES:
				if(get_class($this) == 'TransporterController'){
					$this->xmlFiles = File::GetFilesList($source, array('.itmsp'));
				} else {
					$this->xmlFiles = File::GetFilesList($source, array('.xml'));
				}
				break;
			case SONY:
			case STARHUB:
			case XBOX:
				$this->xmlFiles = File::GetFilesList($source, array('.xml'));
				break;
			default:
				throw new Exception('Unexpected partner "' . self::$Partner->getName() . '". (AbstractController->setXmlFiles)');
		}
	}

	/** 
	 * Generates a minimal Bundle from the file name
	 * info and the binary file properties.
	 * 
	 * @param		string		$filePath
	 * @param		bool		$hasBinary
	 * @return		Bundle
	 * @static
	 */
	public static function GetBundleFromFileName($filePath, $hasBinary){
		if (file_exists($filePath)){
			$xmlFileInfo = File::GetInfo($filePath);
			$infoArray = self::ParseFileName($xmlFileInfo['name']);
			$metadata = array();
			$metadata['network'] = $infoArray['network'];
			$metadata['seriesName'] = $infoArray['series'];
			$metadata['episodeNumber'] = $infoArray['episode'];
			$metadata['seasonNumber'] = $infoArray['season'];
			$metadata['dTOEpisodeID'] = $xmlFileInfo['name'];
			$metadata['dTOSeasonID'] = $infoArray['region'].'_'.$infoArray['network'].'_'.$infoArray['series'].'_'.$infoArray['season'];
			$metadata['dTOSeriesID'] = $infoArray['region'].'_'.$infoArray['network'].'_'.$infoArray['series'];
			$region = RegionModel::FindById($infoArray['region']);
			if(!is_object($region)){
				throw new Exception('Unable to find Region id for "'.$filePath.'". AbstractController::GetBundleFromFileName().');
			}
			$language = $region->getLanguage();
			$video = array('metadata'=> new Metadata($metadata));
			if($hasBinary){
				$binaryFolder = $xmlFileInfo['parent_folder'];
				if($xmlFileInfo['extension'] == 'itmsp'){
					$binaryFolder = $filePath;
				}
				$binaryFileInfo = self::FindBinaryProperties($metadata['dTOEpisodeID'], $binaryFolder);
				if(empty($binaryFileInfo)) {
					throw new Exception('Unable to find binary file for '.$filePath.'. AbstractController::GetBundleFromFileName().');
				}
				$video['fileName'] = $binaryFileInfo['full_name'];
				$video['fileCreateDate'] = $binaryFileInfo['creation_date'];
				$video['fileModificationDate'] = $binaryFileInfo['modification_date'];
				$video['lastAccessed'] = $binaryFileInfo['last_access_date'];
				$video['mD5Hash'] = $binaryFileInfo['md5'];
				$video['size'] = $binaryFileInfo['size'];
			}
			$partner = AbstractController::GetPartner();
			return new Bundle(array(
					'language'=> $language,
					'partner' => $partner,
					'region'=> $region,
					'video'=> new Video($video)
				));
		} else {
			throw new Exception('"'.$filePath.'" not exist. AbstractController::GetBundleFromFileName().');
		}
	}
	
	/** 
	 * Parses the file name 
	 * 
	 * @param		string		$fileName
	 * @param		bool		$throwException
	 * @return		array
	 * @static
	 */
	public static function ParseFileName($fileName, $throwException=true){
		$errors = '';
		$data = array(
			'region'=>null,
			'network'=>null,
			'series'=>null,
			'season'=>null,
			'episode'=>null
		);
		$nameArray = explode('_', $fileName);
		if(count($nameArray) == 4 || count($nameArray) == 5){
			if(strlen($nameArray[0]) == 2 && Validate::StringAlpha($nameArray[0])){
				$region = RegionModel::FindById(strtoupper($nameArray[0]));
				if(!empty($region)){
					$data['region'] = $nameArray[0];
				} else {
					$errors .= 'The given region "'.$nameArray[0].'" is not in the region list. '."\n";
				}
			} else {
				$errors .= '"'.$fileName.'" does not match the file name convention for Region. '."\n";
			}
			if(strlen($nameArray[1]) > 0 && Validate::StringAlphaNumeric($nameArray[1])){
				$networks = unserialize(VALID_NETWORKS);
				if(in_array(strtoupper(trim($nameArray[1])), $networks)){
					$data['network'] = $nameArray[1];
				} else {
					$errors .= 'The given network "'.strtoupper(trim($nameArray[1])).'" is not in the valid network list. '."\n";
				}
			} else {
				$errors .= '"'.$fileName.'" does not match the file name convention for Network. '."\n";
			}
			if(strlen($nameArray[2]) > 0 && Validate::StringAlphaNumeric($nameArray[2])){
				$data['series'] = $nameArray[2];
			} else {
				$errors .= '"'.$fileName.'" does not match the file name convention for Series Name. '."\n";
			}
			if(strlen($nameArray[3]) > 0 && Validate::StringNumeric($nameArray[3])){
				$data['season'] = substr($nameArray[3], 0, (count($nameArray[3])-3));
				$data['episode'] = substr($nameArray[3], -2);
			} else {
				$errors .= '"'.$fileName.'" does not match the file name convention for season and episode number. '."\n";
			}
			if(!empty($errors)){
				if($throwException){
					throw new Exception($errors.'AbstractController::ParseFileName()');
				} else {
					$data = $errors;
				}
			}
		} else {
			$errors .= '"'.$fileName.'" does not match the file name convention. ';
		}
		return $data;
	}
	
	/**
	 * Sets the file permissions for inbox and outbox remote folders
	 */
	public static function SetRemotePermissions(){
		$command1 = 'chmod -R 775 '.REMOTE_INBOX;
		$command2 = 'chmod -R 775 '.REMOTE_OUTBOX;
		$ssh = new Ssh2(REMOTE_SERVER_IP);
		if ($ssh->auth(REMOTE_SERVER_USER, REMOTE_SERVER_PASS)) {
			$output = $ssh->exec($command1, $command2);
			$lines = explode("\n", $output['output']);
		} else {
			throw new Exception('An error has ocurred during the authentication. ITunesTransporter::Upload().');
		}
	}
	
	/**
	 * Unsets the file permissions for inbox and outbox remote folders
	 */
	public static function UnsetRemotePermissions(){
		$command1 = 'chmod -R 755 '.REMOTE_INBOX;
		$command2 = 'chmod -R 755 '.REMOTE_OUTBOX;
		$ssh = new Ssh2(REMOTE_SERVER_IP);
		if ($ssh->auth(REMOTE_SERVER_USER, REMOTE_SERVER_PASS)) {
			$output = $ssh->exec($command1, $command2);
			$lines = explode("\n", $output['output']);
		} else {
			throw new Exception('An error has ocurred during the authentication. ITunesTransporter::Upload().');
		}
	}
	
	/**
	 * Looks for the binary info matching the
	 * metadata file name in the given folder
	 * 
	 * @param		string			$fileName
	 * @param		string			$folderPath
	 * @return		string
	 * @static		static
	 */
	public static function FindBinaryProperties($fileName, $folderPath){
		$info = array();
		$videoFileExtensions = unserialize(VIDEO_FILE_EXTENSIONS);
		if (is_dir($folderPath)){
			if ($dh = opendir($folderPath)){
				while (($file = readdir($dh)) !== false){
					if((substr($file, 0, 1) != '.') && !is_dir($file)){
						$videoName = File::GetNameWithoutExtension($file);
						$videoExtension = File::GetExtensionFromPath($file);
						if(($videoName == $fileName) && in_array($videoExtension, $videoFileExtensions)){
							return File::GetInfo($folderPath . '/' .  $file);
						}
					}
				}
				closedir($dh);
				return array();
			} else {
				throw new Exception('Directory '.$folderPath.' is not readable. AbstractController::FindBinaryProperties().');
			}
		} else {
			throw new Exception('Not such directory '.$folderPath.'. AbstractController::FindBinaryProperties().');
		}
	}
	
	/**
	 * Parses the xml file and creates a Bundle with the current partner format
	 * 
	 * @param		string			$filePath
	 * @param		string			$partnerName
	 * @return		Bundle
	 */
	protected function getBundle($filePath, $partnerName=null){
		$partnerName = empty($partnerName) ? strtolower(self::$Partner->getName()) : strtolower($partnerName);
		$parser = null;
		switch ($partnerName){
			case FCS:
				$parser = new FcsXmlParser();
				break;
			case ITUNES:
				$parser = new ITunesXmlParser();
				break;
			case SONY:
				$parser = new SonyXmlParser();
				break;
			case STARHUB:
				$parser = new StarHubXmlParser();
				break;
			case XBOX:
				$parser = new XboxXmlParser();
				break;
			default:
				throw new Exception('Unexpected partner name "'.self::$Partner->getName().'". AbstractController->getBundle().');
		}
		return $parser->getBundleFromXml($filePath);
	}
	
	/**
	 * Replaces the bundle1 properties with the bundle2 non empty properties
	 *
	 * @param		Bundle		$bundle1
	 * @param		Bundle		$bundle2
	 * @return 		Bundle
	 */
	public function mergeBundles($bundle1, $bundle2){
		$bundle1Array = $bundle1->convertToArray();
		$bundle2Array = $bundle2->convertToArray();
		$mergedArray = Arrays::RecursiveMerge($bundle1Array, $bundle2Array);
		$mergedArray['video']['metadata'] = new Metadata($mergedArray['video']['metadata']);
		$mergedArray['video'] = new Video($mergedArray['video']);
		$mergedArray['language'] = new Language($mergedArray['language']);
		$mergedArray['partner'] = new Partner($mergedArray['partner']);
		$mergedArray['region']['language'] = new Language($mergedArray['region']['language']);
		$mergedArray['region'] = new Region($mergedArray['region']);
		return new Bundle($mergedArray);		
	}
	
	/**
	 * Looks in the data base to match the current bundle or
	 * the current metadata and fill in empty values
	 *
	 * @param		Bundle		$bundle
	 */
	public function fillWithStoredValues(&$bundle){
		//TODO: Test this feature in all posible ways
		$dbVideo = VideoModel::FindBy(array('fileName'=>$bundle->getVideo()->getFileName()), true);
		if(is_object($dbVideo)){
			$dbBundle = BundleModel::FindBy(array('videoId'=>$dbVideo->getId(), 'partnerId'=>$bundle->getPartner()->getId()), true);
			if(is_object($dbBundle)){
				$bundle = $this->mergeBundles($dbBundle, $bundle);
			} else {
				$dbBundle = new Bundle(array(
						'video' => $dbVideo,
						'language' => $bundle->getLanguage(),
						'partner' => $bundle->getPartner(),
						'region' => $bundle->getRegion()
					));
				$bundle = $this->mergeBundles($dbBundle, $bundle);
			}
		} else {
			$dbMetadata = MetadataModel::FindBy(array('dTOEpisodeID'=>$bundle->getVideo()->getMetadata()->getDTOEpisodeID()), true);
			if(is_object($dbMetadata)){
				$currentMetadataArray = $bundle->getVideo()->getMetadata()->convertToArray();
				$mergedMetadataArray = Arrays::RecursiveMerge($dbMetadata->convertToArray(), $currentMetadataArray);
				$bundle->getVideo()->setMetadata(new Metadata($mergedMetadataArray));
			}
		}
	}
	
	/**
	 * Returns the a bundle object from the unidimensional bundle array
	 * 
	 * @param   	string		$bundleArray
	 * @return  	string
	 * @static
	 */
	public static function GetBundleFromUnidimensionalArray($bundleArray){
		$bundle = new Bundle(array(
				'video' => new Video(array('metadata' => new Metadata())),
				'language' => new Language(),
				'partner' => AbstractController::GetPartner(),
				'region' => new Region()
			));
		foreach($bundleArray as $key => $value){
			$value = trim($value);
			if(!empty($value)){
				switch($key) {
					//Language properties
					case 'entityId':
						$bundle->setEntityId($value);
						break;
					//Language properties
					case 'dTOLanguageCode':
						AbstractXmlParser::SetLanguageAndRegion($bundle, $value);
						break;
					case 'dTOLanguageName':
						if(is_string($bundle->getLanguage()->getCode())){
							AbstractXmlParser::SetLanguageAndRegion($bundle, $value);
						}
						break;
					//Region properties
					case 'dTOCountryCode':
						AbstractXmlParser::SetRegion($bundle, $value);
						break;
					case 'country':
						AbstractXmlParser::SetRegion($bundle, $value);
						break;
					//Video properties
					case 'audioCodec':
						$bundle->getVideo()->setAudioCodec($value);
						break;
					case 'createdBy':
						$bundle->getVideo()->setCreatedBy($value);
						break;
					case 'creationDate':
						$bundle->getVideo()->setCreationDate($value);
						break;
					case 'dTOVideoType':
						$bundle->getVideo()->setDTOVideoType($value);
						break;
					case 'duration':
						$bundle->getVideo()->setDuration($value);
						break;
					case 'fileCreateDate':
						$bundle->getVideo()->setFileCreateDate($value);
						break;
					case 'fileModificationDate':
						$bundle->getVideo()->setFileModificationDate($value);
						break;
					case 'fileName':
						$bundle->getVideo()->setFileName($value);
						break;
					case 'imageSize':
						$bundle->getVideo()->setImageSize($value);
						break;
					case 'lastAccessed':
						$bundle->getVideo()->setLastAccessed($value);
						break;
					case 'lastModified':
						$bundle->getVideo()->setLastModified($value);
						break;
					case 'mD5Hash':
						$bundle->getVideo()->setMD5Hash($value);
						break;
					case 'mD5HashRecal':
						$bundle->getVideo()->setMD5HashRecal($value);
						break;
					case 'mimeType':
						$bundle->getVideo()->setMimeType($value);
						break;
					case 'size':
						$bundle->getVideo()->setSize($value);
						break;
					case 'storedOn':
						$bundle->getVideo()->setStoredOn($value);
						break;
					case 'videoBitrate':
						$bundle->getVideo()->setVideoBitrate($value);
						break;
					case 'videoCodec':
						$bundle->getVideo()->setVideoCodec($value);
						break;
					case 'videoElements':
						$bundle->getVideo()->setVideoElements($value);
						break;
					case 'videoFrameRate':
						$bundle->getVideo()->setVideoFrameRate($value);
						break;
					case 'timecodeOffset':
						$bundle->getVideo()->setTimecodeOffset($value);
						break;
					//Metadata properties
					case 'airDate':
						$bundle->getVideo()->getMetadata()->setAirDate($value);
						break;
					case 'archiveStatus':
						$bundle->getVideo()->getMetadata()->setArchiveStatus($value);
						break;
					case 'assetGUID':
						$bundle->getVideo()->getMetadata()->setAssetGUID($value);
						break;
					case 'assetID':
						$bundle->getVideo()->getMetadata()->setAssetID($value);
						break;
					case 'author':
						$bundle->getVideo()->getMetadata()->setAuthor($value);
						break;
					case 'category':
						$bundle->getVideo()->getMetadata()->setCategory($value);
						break;
					case 'copyrightHolder':
						$bundle->getVideo()->getMetadata()->setCopyrightHolder($value);
						break;
					case 'description':
						$bundle->getVideo()->getMetadata()->setDescription($value);
						break;
					case 'dTOAssetXMLExportstage1':
						$bundle->getVideo()->getMetadata()->setDTOAssetXMLExportstage1($value);
						break;
					case 'dTOContainerPosition':
						$bundle->getVideo()->getMetadata()->setDTOContainerPosition($value);
						break;
					case 'dTOCopyrightHolder':
						$bundle->getVideo()->getMetadata()->setDTOCopyrightHolder($value);
						break;
					case 'dTOEpisodeID':
						$bundle->getVideo()->getMetadata()->setDTOEpisodeID($value);
						break;
					case 'dTOEpisodeName':
						$bundle->getVideo()->getMetadata()->setDTOEpisodeName($value);
						break;
					case 'dTOGenre':
						$bundle->getVideo()->getMetadata()->setDTOGenre($value);
						break;
					case 'dTOLongDescription':
						$bundle->getVideo()->getMetadata()->setDTOLongDescription($value);
						break;
					case 'dTOLongEpisodeDescription':
						$bundle->getVideo()->getMetadata()->setDTOLongEpisodeDescription($value);
						break;
					case 'dTORatings':
						$bundle->getVideo()->getMetadata()->setDTORatings($value);
						break;
					case 'dTOReleaseDate':
						$bundle->getVideo()->getMetadata()->setDTOReleaseDate($value);
						break;
					case 'dTOSalesPrice':
						$bundle->getVideo()->getMetadata()->setDTOSalesPrice($value);
						break;
					case 'dTOSeasonID':
						$bundle->getVideo()->getMetadata()->setDTOSeasonID($value);
						break;
					case 'dTOSeasonName':
						$bundle->getVideo()->getMetadata()->setDTOSeasonName($value);
						break;
					case 'dTOSeriesDescription':
						$bundle->getVideo()->getMetadata()->setDTOSeriesDescription($value);
						break;
					case 'dTOSeriesID':
						$bundle->getVideo()->getMetadata()->setDTOSeriesID($value);
						break;
					case 'dTOShortDescription':
						$bundle->getVideo()->getMetadata()->setDTOShortDescription($value);
						break;
					case 'dTOShortEpisodeDescription':
						$bundle->getVideo()->getMetadata()->setDTOShortEpisodeDescription($value);
						break;
					case 'eMDeliveryAsset':
						$bundle->getVideo()->getMetadata()->setEMDeliveryAsset($value);
						break;
					case 'episodeName':
						$bundle->getVideo()->getMetadata()->setEpisodeName($value);
						break;
					case 'episodeNumber':
						$bundle->getVideo()->getMetadata()->setEpisodeNumber($value);
						break;
					case 'forceDTOexportXML':
						$bundle->getVideo()->getMetadata()->setForceDTOexportXML($value);
						break;
					case 'forceDTOproxyAsset':
						$bundle->getVideo()->getMetadata()->setForceDTOproxyAsset($value);
						break;
					case 'genre':
						$bundle->getVideo()->getMetadata()->setGenre($value);
						break;
					case 'keywords':
						$bundle->getVideo()->getMetadata()->setKeywords($value);
						break;
					case 'licenseStartDate':
						$bundle->getVideo()->getMetadata()->setLicenseStartDate($value);
						break;
					case 'localEntity':
						$bundle->getVideo()->getMetadata()->setLocalEntity($value);
						break;
					case 'location':
						$bundle->getVideo()->getMetadata()->setLocation($value);
						break;
					case 'mediaType':
						$bundle->getVideo()->getMetadata()->setMediaType($value);
						break;
					case 'metadataSet':
						$bundle->getVideo()->getMetadata()->setMetadataSet($value);
						break;
					case 'network':
						$bundle->getVideo()->getMetadata()->setNetwork($value);
						break;
					case 'owner':
						$bundle->getVideo()->getMetadata()->setOwner($value);
						break;
					case 'ratingsOverride':
						$bundle->getVideo()->getMetadata()->setRatingsOverride($value);
						break;
					case 'ratingSystem':
						$bundle->getVideo()->getMetadata()->setRatingSystem($value);
						break;
					case 'releaseYear':
						$bundle->getVideo()->getMetadata()->setReleaseYear($value);
						break;
					case 'seasonDescription':
						$bundle->getVideo()->getMetadata()->setSeasonDescription($value);
						break;
					case 'seasonLanguage':
						$bundle->getVideo()->getMetadata()->setSeasonLanguage($value);
						break;
					case 'seasonNumber':
						$bundle->getVideo()->getMetadata()->setSeasonNumber($value);
						break;
					case 'seasonOverride':
						$bundle->getVideo()->getMetadata()->setSeasonOverride($value);
						break;
					case 'seriesDescription':
						$bundle->getVideo()->getMetadata()->setSeriesDescription($value);
						break;
					case 'seriesName':
						$bundle->getVideo()->getMetadata()->setSeriesName($value);
						break;
					case 'status':
						$bundle->getVideo()->getMetadata()->setStatus($value);
						break;
					case 'storeandtrackversionsofthisasset':
						$bundle->getVideo()->getMetadata()->setStoreandtrackversionsofthisasset($value);
						break;
					case 'syndicationPartnerDelivery':
						$bundle->getVideo()->getMetadata()->setSyndicationPartnerDelivery($value);
						break;
					case 'title':
						$bundle->getVideo()->getMetadata()->setTitle($value);
						break;
					case 'tVRating':
						$bundle->getVideo()->getMetadata()->setTVRating($value);
						break;
					default:
						throw new Exception('Unexpected field "'.$key.'". AbstractController->GetBundleFromUnidimensionalArray().');
						break;
				}
			}
		}
		return $bundle;
	}
	
    /**
     * Runs the process for each file into $xmlFiles 
     */
    public abstract function runForAll();
    
    /**
     * Runs the process for an especific file 
     * @param		mixed		$params
     */
    public abstract function run($params);
    
    /**
     * Cleans up the processed files
     * @param		mixed		$params
     */
    public abstract function cleanUp($files);
}