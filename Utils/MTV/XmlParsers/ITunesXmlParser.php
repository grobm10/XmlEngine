<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlParsers/ITunesXmlParser.php
 */
class ITunesXmlParser extends AbstractXmlParser {

	/**
	 * List of required fields
	 *
	 * @var 	array|string
	 * @staticvar
	 */
	protected $requiredFields = array(
			//TODO: check the required data
			'checksum',
			'container_id',
			'container_position',
			'copyright_cline',
			'description',
			'episode_production_number',
			'file_name',
			'locale',
			'network_name',
			'release_date',
			'sales_start_date',
			'size',
			'territory',
			'title',
			'type'
		);

	/**
	 * Returns an array with the required fcs fields for the given partner field. 
	 * 
	 * @param   	string			$partnerField
	 * @return  	array|string
	 * @static
	 */
	public function getFcsField($partnerField){
		//TODO: Check this list. In the xml examples there are fields out of this list .
		switch ($partnerField) {
			case 'checksum':
				return array('video_mD5Hash');
			case 'container_id':
			case 'unique_id_series':
				return array('video_metadata_dTOSeriesID');
			case 'container_position':
			case 'container_position_episode':
				return array('video_metadata_dTOContainerPosition');
			case 'copyright':
			case 'copyright_cline':
				return array('video_metadata_dTOCopyrightHolder', 'video_metadata_copyrightHolder');
			case 'description':
				return array('video_metadata_dTOLongEpisodeDescription', 'video_metadata_dTOLongDescription', 'video_metadata_dTOShortEpisodeDescription', 'video_metadata_dTOShortDescription');
			case 'episode_long_description':
				return array('video_metadata_dTOLongEpisodeDescription', 'video_metadata_dTOLongDescription');
			case 'episode_production_number':
			case 'unique_id_episode':
				return array('video_metadata_dTOEpisodeID');
			case 'episode_short_description':
				return array('video_metadata_dTOShortEpisodeDescription', 'video_metadata_dTOShortDescription');
			case 'file_name':
				return array('video_fileName');
			case 'genre':
				return array('video_metadata_dTOGenre', 'video_metadata_genre');
			case 'locale':
				return array('video_metadata_seasonLanguage');
			case 'language':
				return array('video_metadata_seasonLanguage');
			case 'network_name':
				return array('video_metadata_network');
			case 'rating':
				return array('video_metadata_tVRating');
			case 'release_date':
				return array('video_metadata_dTOReleaseDate', 'video_metadata_releaseYear');
			case 'sales_start_date':
				return array('video_metadata_airDate', 'video_metadata_licenseStartDate');
			case 'season_description':
				return array('video_metadata_seasonDescription');
			case 'season_number':
				return array('video_metadata_seasonNumber');
			case 'series_description':
				return array('video_metadata_dTOSeriesDescription', 'video_metadata_seriesDescription');
			case 'series_name':
				return array('video_metadata_seriesName');
			case 'size':
				return array('video_size');
			case 'territory':
				return array('region_code');
			case 'title':
				return array('video_metadata_dTOEpisodeName', 'video_metadata_episodeName');
			case 'type':
			case 'video_type':
				return array('video_dTOVideoType');
			case 'unique_id_season':
				return array('video_metadata_dTOSeasonId');
			default:
				throw new Exception('Unexpected iTunes field "'.$partnerField.'". ITunesXmlParser->GetFcsFields().');
				break;
		}
	}
	
	/**
	 * Parses the Partner xml file and return a Bundle object.
	 * 
	 * @param 		string 		$xmlFilePath
	 * @return 		Bundle 
	 * @static
	 */
	public function getBundleFromXml($xmlFilePath){
		$bundle = new Bundle(array(
				'video' => new Video(),
				'language' => new Language(),
				'partner' => AbstractController::GetPartner(),
				'region' => new Region()
			));
		$xml = Xml::XmlFileToObject($xmlFilePath);
		$this->setVideo($bundle, $xml);
		$this->setMetadata($bundle, $xml);
		$this->setCountryValues($bundle, $xml);
		return $bundle;
	}

	/**
	 * An auxiliar method for GetBundleFromXml
	 * 
	 * @param		Object		$bundle
	 * @param		string		$xml
	 * @static
	 */
	private function setVideo(&$bundle, $xml){
		if(!empty($xml->video->assets->asset[0]->data_file[0]->file_name)){
			$value = (string) $xml->video->assets->asset[0]->data_file->file_name;
			$bundle->getVideo()->setFileName($value);
		}
		if(!empty($xml->video->assets->asset[0]->data_file[0]->size)){
			$value = (string) $xml->video->assets->asset[0]->data_file->size;
			$bundle->getVideo()->setSize($value);
		}
		if(!empty($xml->video->assets->asset[0]->data_file[0]->checksum)){
			$value = (string) $xml->video->assets->asset[0]->data_file->checksum;
			$bundle->getVideo()->setMD5Hash($value);
		}
		if(!empty($xml->video->type)){
			$value = (string) $xml->video->type;
			$bundle->getVideo()->setDTOVideoType($value);
		} elseif(!empty($xml->video->video_type)){
			$value = (string) $xml->video->video_type;
			$bundle->getVideo()->setDTOVideoType($value);
		}
	}

	/**
	 * An auxiliar method for GetBundleFromXml
	 * 
	 * @param		Object		$bundle
	 * @param		string		$xml
	 * @static
	 */
	private function setMetadata(&$bundle, $xml){
		$bundle->getVideo()->setMetadata(new Metadata());
		//Set container values			
		if(!empty($xml->video->container_id)){
			$value = (string) $xml->video->container_id;
			$bundle->getVideo()->getMetadata()->setDTOSeriesID($value);
		} elseif(!empty($xml->video->unique_id_series)){
			$value = (string) $xml->video->unique_id_series;
			$bundle->getVideo()->getMetadata()->setDTOSeriesID($value);
		}
		if(!empty($xml->video->container_position)){
			$value = (string) $xml->video->container_position;
			$bundle->getVideo()->getMetadata()->setDTOContainerPosition($value);
		} elseif(!empty($xml->video->container_position_episode)){
			$value = (string) $xml->video->container_position_episode;
			$bundle->getVideo()->getMetadata()->setDTOContainerPosition($value);
		}
		//set products values
		if(!empty($xml->video->products->product[0]->sales_start_date)){
			$value = (string) $xml->video->products->product[0]->sales_start_date;
			$bundle->getVideo()->getMetadata()->setAirDate($value);
			$bundle->getVideo()->getMetadata()->setLicenseStartDate($value);
		}
		//set general metadata
		if(!empty($xml->video->episode_production_number)){
			$value = (string) $xml->video->episode_production_number;
			$bundle->getVideo()->getMetadata()->setDTOEpisodeID($value);
		} elseif(!empty($xml->video->unique_id_episode)){
			$value = (string) $xml->video->unique_id_episode;
			$bundle->getVideo()->getMetadata()->setDTOEpisodeID($value);
		}
		if(!empty($xml->video->title)){
			$value = (string) $xml->video->title;
			$bundle->getVideo()->getMetadata()->setEpisodeName($value);
			$bundle->getVideo()->getMetadata()->setDTOEpisodeName($value);
		}
		if(!empty($xml->video->description)){
			$value = (string) $xml->video->description;
			$bundle->getVideo()->getMetadata()->setDTOLongDescription($value);
			$bundle->getVideo()->getMetadata()->setDTOLongEpisodeDescription($value);
			$bundle->getVideo()->getMetadata()->setDTOShortDescription($value);
			$bundle->getVideo()->getMetadata()->setDTOShortEpisodeDescription($value);
		}
		if(!empty($xml->video->episode_long_description)){
			$value = (string) $xml->video->episode_long_description;
			$bundle->getVideo()->getMetadata()->setDTOLongDescription($value);
			$bundle->getVideo()->getMetadata()->setDTOLongEpisodeDescription($value);
		}
		if(!empty($xml->video->episode_short_description)){
			$value = (string) $xml->video->episode_short_description;
			$bundle->getVideo()->getMetadata()->setDTOShortDescription($value);
			$bundle->getVideo()->getMetadata()->setDTOShortEpisodeDescription($value);
		}
		if(!empty($xml->video->network_name)){
			$value = (string) $xml->video->network_name;
			$bundle->getVideo()->getMetadata()->setNetwork($value);
		}
		if(!empty($xml->video->release_date)){
			$value = (string) $xml->video->release_date;
			$bundle->getVideo()->getMetadata()->setReleaseYear($value);
			$bundle->getVideo()->getMetadata()->setDTOReleaseDate($value);
		}
		if(!empty($xml->video->copyright)){
			$value = (string) $xml->video->copyright;
			$bundle->getVideo()->getMetadata()->setDTOCopyrightHolder($value);
			$bundle->getVideo()->getMetadata()->setCopyrightHolder($value);
		} elseif(!empty($xml->video->copyright_cline)){
			$value = (string) $xml->video->copyright_cline;
			$bundle->getVideo()->getMetadata()->setDTOCopyrightHolder($value);
			$bundle->getVideo()->getMetadata()->setCopyrightHolder($value);
		}
		if(!empty($xml->video->genres->genre[0])){
			$value = (string) $xml->video->genres->genre[0];
			$bundle->getVideo()->getMetadata()->setGenre($value);
			$bundle->getVideo()->getMetadata()->setDTOGenre($value);
		}
		if(!empty($xml->video->ratings) && !empty($xml->video->ratings->rating['system']) && !empty($xml->video->ratings->rating[0])){
			$value = (string) $xml->video->ratings->rating['system'].'/'. (string) $xml->video->ratings->rating[0];
			$bundle->getVideo()->getMetadata()->setTVRating($value);
		}
		if(!empty($xml->video->season_description)){
			$value = (string) $xml->video->season_description;
			$bundle->getVideo()->getMetadata()->setSeasonDescription($value);
		}
		if(!empty($xml->video->season_number)){
			$value = (string) $xml->video->season_number;
			$bundle->getVideo()->getMetadata()->setSeasonNumber($value);
		}
		if(!empty($xml->video->series_description)){
			$value = (string) $xml->video->series_description;
			$bundle->getVideo()->getMetadata()->setDTOSeriesDescription($value);
			$bundle->getVideo()->getMetadata()->setSeriesDescription($value);
		}
		if(!empty($xml->video->series_name)){
			$value = (string) $xml->video->series_name;
			$bundle->getVideo()->getMetadata()->setSeriesName($value);
		}
		if(!empty($xml->video->unique_id_season)){
			$value = (string) $xml->video->unique_id_season;
			$bundle->getVideo()->getMetadata()->setDTOSeasonId($value);
		}
	}

	/**
	 * An auxiliar method  for GetBundleFromXml
	 * 
	 * @param		Object		$bundle
	 * @param		Object		$xml
	 * @static
	 */
	private function setCountryValues(&$bundle, $xml){
		$value = '';
		if(!empty($xml->language)){
			$value = (string) $xml->language;
			self::SetLanguageAndRegion($bundle, $value);
		}
		if(!is_object($bundle->getLanguage()) && !empty($xml->video->assets->asset[0]->data_file->locale['name'])) {
			$value = (string)$xml->video->assets->asset[0]->data_file->locale['name'];
			self::SetLanguageAndRegion($bundle, $value);
		}
		if(!is_object($bundle->getLanguage()) && !empty($xml->video->language)){
			$value = (string) $xml->video->language;
			self::SetLanguageAndRegion($bundle, $value);
		}
		if(!is_object($bundle->getRegion()) && !empty($xml->video->products->product[0]->territory)){
			$value = (string)$xml->video->products->product[0]->territory;
			$region = RegionModel::FindById(strtoupper(trim($value)));
			if(empty($region)){
				$region = RegionModel::FindBy(array('country'=>strtoupper(trim($value))), true);
			}
			$bundle->setRegion($region);
		}
		if(!is_object($bundle->getRegion())) {
			throw new Exception('Unable to parse region from xml metadata. ITunesXmlParser::GetBundleFromXml().');
		}
		if(!is_object($bundle->getLanguage())) {
			//TODO: Log that the language is missed and the default language is assumed
			$bundle->setLanguage($bundle->getRegion()->getLanguage());
		}
		$lang = strtolower($bundle->getLanguage()->getAlt()).'-'.strtoupper($bundle->getRegion()->getCode());
		$bundle->getVideo()->getMetadata()->setSeasonLanguage($lang);
	}
}