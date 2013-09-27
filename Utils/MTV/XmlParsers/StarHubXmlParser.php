<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlParsers/StarHubXmlParser.php
 */
class StarHubXmlParser extends AbstractXmlParser {

	/**
	 * List of required fields
	 *
	 * @var 	array|string
	 * @staticvar
	 */
	protected $requiredFields = array(
			//TODO: check the required data
			'code',
			'containerPosition',
			'copyRightNotice',
			'countryOfOrigin',
			'displayNetwork',
			'episodeNumber',
			'genre',
			'globalEpisodeName',
			'globalSeasonName',
			'globalSeriesName',
			'initialAirDate',
			'localEpisodeName',
			'localSeasonDescription',
			'localSeasonName',
			'localSeriesDescription',
			'localSeriesName',
			'longDescription',
			'productId',
			'runtime',
			'seasonBundleID',
			'shortDescription'
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
			case 'code':
				return array('language_alt');
			case 'containerPosition':
				return array('video_metadata_dTOContainerPosition');
			case 'copyRightNotice':
				return array('video_metadata_dTOCopyrightHolder', 'video_metadata_copyrightHolder');
			case 'countryOfOrigin':
				return array('region_code');
			case 'displayNetwork':
				return array('video_metadata_network');
			case 'episodeNumber':
				return array('video_metadata_episodeNumber');
			case 'genre':
				return array('video_metadata_dTOGenre', 'video_metadata_genre');
			case 'globalEpisodeName':
				return array('video_metadata_episodeName', 'video_metadata_dTOEpisodeName');
			case 'globalSeasonName':
				return array('video_metadata_seasonName', 'video_metadata_dTOSeasonName');
			case 'globalSeriesName':
				return array('video_metadata_seriesName');
			case 'initialAirDate':
				return array('video_metadata_airDate');
			case 'localEpisodeName':
				return array('video_metadata_dTOEpisodeName', 'video_metadata_episodeName');
			case 'localSeasonDescription':
				return array('video_metadata_seasonDescription');
			case 'localSeasonName':
				return array('video_metadata_dTOSeasonName', 'video_metadata_seasonName');
			case 'localSeriesDescription':
				return array('video_metadata_dTOSeriesDescription', 'video_metadata_seriesDescription');
			case 'localSeriesName':
				return array('video_metadata_seriesName');
			case 'longDescription':
				return array('video_metadata_dTOLongEpisodeDescription', 'video_metadata_dTOLongDescription', 'video_metadata_dTOShortEpisodeDescription', 'video_metadata_dTOShortDescription');
			case 'productId':
				return array('video_fileName');
			case 'runtime':
				return array('video_duration');
			case 'seasonBundleID':
				return array('video_metadata_dTOSeasonID');
			case 'shortDescription':
				return array('video_metadata_dTOShortEpisodeDescription', 'video_metadata_dTOShortDescription');
			default:
				throw new Exception('Unexpected StarHub field "'.$partnerField.'". StarHubXmlParser->GetFcsFields().');
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
		if(!empty($xml->ProductId)){
			$value = (string)$xml->ProductId;
			$bundle->getVideo()->setFileName($value);
		}
		if(!empty($xml->Runtime)){
			$value = (string)$xml->Runtime;
			$bundle->getVideo()->setDuration($value);
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
		if(!empty($xml->SeasonBundleID)){
			$value = (string) $xml->SeasonBundleID;
			$bundle->getVideo()->getMetadata()->setDTOSeasonID($value);
		}
		if(!empty($xml->GlobalSeriesName)){
			$value = (string) $xml->GlobalSeriesName;
			$bundle->getVideo()->getMetadata()->setSeriesName($value);
		}
		if(!empty($xml->GlobalSeasonName)){
			$value = (string) $xml->GlobalSeasonName;
			$bundle->getVideo()->getMetadata()->setDTOSeasonName($value);
		}
		if(!empty($xml->GlobalEpisodeName)){
			$value = (string) $xml->GlobalEpisodeName;
			$bundle->getVideo()->getMetadata()->setDTOEpisodeName($value);
			$bundle->getVideo()->getMetadata()->setEpisodeName($value);
		}
		if(!empty($xml->CopyRightNotice)){
			$value = (string) $xml->CopyRightNotice;
			$bundle->getVideo()->getMetadata()->setDTOCopyrightHolder($value);
			$bundle->getVideo()->getMetadata()->setCopyrightHolder($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->LocalSeriesName)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->LocalSeriesName;
			$bundle->getVideo()->getMetadata()->setSeriesName($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->LocalSeriesDescription)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->LocalSeriesDescription;
			$bundle->getVideo()->getMetadata()->setDTOSeriesDescription($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->LocalSeasonName)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->LocalSeasonName;
			$bundle->getVideo()->getMetadata()->setDTOSeasonName($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->LocalSeasonDescription)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->LocalSeasonDescription;
			$bundle->getVideo()->getMetadata()->setSeasonDescription($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->LocalEpisodeName)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->LocalEpisodeName;
			$bundle->getVideo()->getMetadata()->setDTOEpisodeName($value);
			$bundle->getVideo()->getMetadata()->setEpisodeName($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->EpisodeNumber)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->EpisodeNumber;
			$bundle->getVideo()->getMetadata()->setEpisodeNumber($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->ContainerPosition)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->ContainerPosition;
			$bundle->getVideo()->getMetadata()->setDTOContainerPosition($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->ShortDescription)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->ShortDescription;
			$bundle->getVideo()->getMetadata()->setDTOShortEpisodeDescription($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->LongDescription)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->LongDescription;
			$bundle->getVideo()->getMetadata()->setDTOLongEpisodeDescription($value);
		}
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]->DisplayNetwork)){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]->DisplayNetwork;
			$bundle->getVideo()->getMetadata()->setNetwork($value);
		}
		if(!empty($xml->Countries->Country[0]->InitialAirDate)){
			$value = (string) $xml->Countries->Country[0]->InitialAirDate;
			$bundle->getVideo()->getMetadata()->setAirDate($value);
		}
		if(!empty($xml->Genres->Genre[0])){
			$value = (string) $xml->Genres->Genre[0];
			$bundle->getVideo()->getMetadata()->setGenre($value);
			$bundle->getVideo()->getMetadata()->setDTOGenre($value);
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
		if(!empty($xml->Countries->Country[0]->Languages->Language[0]['code'])){
			$value = (string) $xml->Countries->Country[0]->Languages->Language[0]['code'];
			self::SetLanguageAndRegion($bundle, $value);
		}
		if(!is_object($bundle->getRegion()) && !empty($xml->CountryOfOrigin)){
			$value = (string)$xml->CountryOfOrigin;
			$region = RegionModel::FindById(strtoupper(trim($value)));
			if(empty($region)){
				$region = RegionModel::FindBy(array('country'=>strtoupper(trim($value))), true);
			}
			$bundle->setRegion($region);
		}
		if(!is_object($bundle->getRegion()) && !empty($xml->Countries->Country[0]['code'])){
			$value = (string) $xml->Countries->Country[0]['code'];
			$region = RegionModel::FindById(strtoupper(trim($value)));
			if(empty($region)){
				$region = RegionModel::FindBy(array('country'=>strtoupper(trim($value))), true);
			}
			$bundle->setRegion($region);
		}
		if(!is_object($bundle->getRegion())) {
			throw new Exception('Unable to parse region from xml metadata. StarHubXmlParser::GetBundleFromXml().');
		}
		if(!is_object($bundle->getLanguage())) {
			//TODO: Log that the language is missed and the default language is assumed
			$bundle->setLanguage($bundle->getRegion()->getLanguage());
		}
		$lang = strtolower($bundle->getLanguage()->getAlt()).'-'.strtoupper($bundle->getRegion()->getCode());
		$bundle->getVideo()->getMetadata()->setSeasonLanguage($lang);
	}
}