<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlParsers/FcsXmlParser.php
 */
class FcsXmlParser extends AbstractXmlParser {

	/**
	 * List of required fields
	 *
	 * @var 	array|string
	 * @staticvar
	 */
	protected $requiredFields = array(
			//TODO: check the required data
			'dTOEpisodeID',
			'network',
			'seriesName',
			'episodeNumber',
			'seasonNumber',
			'dTOSeasonID',
			'dTOSeriesID',
			'fileName',
			'fileCreateDate',
			'fileModificationDate',
			'lastAccessed',
			'mD5Hash',
			'size'
		);

	/**
	 * Returns an array with the required fcs fields for the given partner field. 
	 * 
	 * @param   	string			$partnerField
	 * @return  	array|string
	 */
	public function getFcsField($partnerField){
		//TODO: Check this list. In the xml examples there are fields out of this list .
		switch ($partnerField) {
			//Language properties
			case 'language_alt':
				return 'DTO Language Code';
			case 'language_name':
				return 'DTO Language Name';
			//Region properties
			case 'region_code':
				return 'DTO Country Code';
			case 'region_country':
				return 'Country';
			//Video properties
			case 'video_audioCodec':
				return 'Audio Codec';
			case 'video_createdBy':
				return 'Created By';
			case 'video_creationDate':
				return 'Creation Date';
			case 'video_dTOVideoType':
				return 'DTO Video Type';
			case 'video_duration':
				return 'Duration';
			case 'video_fileCreateDate':
				return 'File Create Date';
			case 'video_fileModificationDate':
				return 'File Modification Date';
			case 'video_fileName':
				return 'File Name';
			case 'video_imageSize':
				return 'Image Size';
			case 'video_lastAccessed':
				return 'Last Accessed';
			case 'video_lastModified':
				return 'Last Modified';
			case 'video_mD5Hash':
				return 'MD5Hash';
			case 'video_mD5HashRecal':
				return 'MD5Hash_Recal';
			case 'video_mimeType':
				return 'Mime Type';
			case 'video_size':
				return 'Size';
			case 'video_storedOn':
				return 'Stored On';
			case 'video_videoBitrate':
				return 'Video Bit-rate';
			case 'video_videoCodec':
				return 'Video Codec';
			case 'video_videoElements':
				return 'Video Elements';
			case 'video_videoFrameRate':
				return 'Video Frame Rate';
			case 'video_timecodeOffset':
				return 'Timecode Offset';
			//Metadata properties
			case 'video_metadata_airDate':
				return 'Air Date';
			case 'video_metadata_archiveStatus':
				return 'Archive Status';
			case 'video_metadata_assetGUID':
				return 'Asset GUID';
			case 'video_metadata_assetID':
				return 'Asset ID';
			case 'video_metadata_author':
				return 'Author';
			case 'video_metadata_category':
				return 'Category';
			case 'video_metadata_copyrightHolder':
				return 'Copyright Holder';
			case 'video_metadata_description':
				return 'Description';
			case 'video_metadata_dTOAssetXMLExportstage1':
				return 'DTO Asset XML Export (stage1)';
			case 'video_metadata_dTOContainerPosition':
				return 'DTO Container Position';
			case 'video_metadata_dTOCopyrightHolder':
				return 'DTO Copyright Holder';
			case 'video_metadata_dTOEpisodeID':
				return 'DTO Episode ID';
			case 'video_metadata_dTOEpisodeName':
				return 'DTO Episode Name';
			case 'video_metadata_dTOGenre':
				return 'DTO Genre';
			case 'video_metadata_dTOLongDescription':
				return 'DTO Long Description';
			case 'video_metadata_dTOLongEpisodeDescription':
				return 'DTO Long Episode Description';
			case 'video_metadata_dTORatings':
				return 'DTO Ratings';
			case 'video_metadata_dTOReleaseDate':
				return 'DTO Release Date';
			case 'video_metadata_dTOSalesPrice':
				return 'DTO Sales Price';
			case 'video_metadata_dTOSeasonID':
				return 'DTO Season ID';
			case 'video_metadata_dTOSeasonName':
				return 'DTO Season Name';
			case 'video_metadata_dTOSeriesDescription':
				return 'DTO Series Description';
			case 'video_metadata_dTOSeriesID':
				return 'DTO Series ID';
			case 'video_metadata_dTOShortDescription':
				return 'DTO Short Description';
			case 'video_metadata_dTOShortEpisodeDescription':
				return 'DTO Short Episode Description';
			case 'video_metadata_eMDeliveryAsset':
				return 'EM Delivery -Asset';
			case 'video_metadata_episodeName':
				return 'Episode Name';
			case 'video_metadata_episodeNumber':
				return 'Episode Number';
			case 'video_metadata_forceDTOexportXML':
				return 'Force DTO export XML';
			case 'video_metadata_forceDTOproxyAsset':
				return 'Force DTO proxy -Asset';
			case 'video_metadata_genre':
				return 'Genre';
			case 'video_metadata_keywords':
				return 'Keywords';
			case 'video_metadata_licenseStartDate':
				return 'License Start Date';
			case 'video_metadata_localEntity':
				return 'Local Entity';
			case 'video_metadata_location':
				return 'Location';
			case 'video_metadata_mediaType':
				return 'Media Type';
			case 'video_metadata_metadataSet':
				return 'Metadata Set';
			case 'video_metadata_network':
				return 'Network';
			case 'video_metadata_owner':
				return 'Owner';
			case 'video_metadata_ratingsOverride':
				return 'Ratings_Override';
			case 'video_metadata_ratingSystem':
				return 'Rating System';
			case 'video_metadata_releaseYear':
				return 'Release Year';
			case 'video_metadata_seasonDescription':
				return 'Season Description';
			case 'video_metadata_seasonLanguage':
				return 'Season Language';
			case 'video_metadata_seasonName':
				return 'Season Name';
			case 'video_metadata_seasonNumber':
				return 'Season Number';
			case 'video_metadata_seasonOverride':
				return 'Season_Override';
			case 'video_metadata_seriesDescription':
				return 'Series Description';
			case 'video_metadata_seriesName':
				return 'Series Name';
			case 'video_metadata_status':
				return 'Status';
			case 'video_metadata_storeandtrackversionsofthisasset':
				return 'Store and track versions of this asset';
			case 'video_metadata_syndicationPartnerDelivery':
				return 'Syndication Partner Delivery';
			case 'video_metadata_title':
				return 'Title';
			case 'video_metadata_tVRating':
				return 'TV Rating';
			default:
				throw new Exception('Unexpected fcs field "'.$partnerField.'". FcsXmlParser->getFcsField().');
				break;
		}
	}
	
	/**
	 * Returns the fcs xml field type for a dto property 
	 * 
	 * @param   string $propertyName
	 * @return  string
	 */
	public function getFcsFieldType($propertyName){
		switch ($propertyName) {
			//Language string properties
			case 'language_alt':
			case 'language_name':
			//Region string properties
			case 'region_code':
			case 'region_country':
			//Video string properties
			case 'video_audioCodec':
			case 'video_createdBy':
			case 'video_dTOVideoType':
			case 'video_fileName':
			case 'video_mD5Hash':
			case 'video_mimeType':
			case 'video_storedOn':
			case 'video_videoCodec':
			case 'video_videoElements':
			//Metadata string properties
			case 'video_metadata_airDate':
			case 'video_metadata_archiveStatus':
			case 'video_metadata_assetGUID':
			case 'video_metadata_author':
			case 'video_metadata_category':
			case 'video_metadata_copyrightHolder':
			case 'video_metadata_description':
			case 'video_metadata_dTOContainerPosition':
			case 'video_metadata_dTOCopyrightHolder':
			case 'video_metadata_dTOEpisodeID':
			case 'video_metadata_dTOEpisodeName':
			case 'video_metadata_dTOGenre':
			case 'video_metadata_dTOLongDescription':
			case 'video_metadata_dTOLongEpisodeDescription':
			case 'video_metadata_dTORatings':
			case 'video_metadata_dTOReleaseDate':
			case 'video_metadata_dTOSalesPrice':
			case 'video_metadata_dTOSeasonID':
			case 'video_metadata_dTOSeasonName':
			case 'video_metadata_dTOSeriesDescription':
			case 'video_metadata_dTOSeriesID':
			case 'video_metadata_dTOShortDescription':
			case 'video_metadata_dTOShortEpisodeDescription':
			case 'video_metadata_episodeName':
			case 'video_metadata_episodeNumber':
			case 'video_metadata_genre':
			case 'video_metadata_keywords':
			case 'video_metadata_licenseStartDate':
			case 'video_metadata_location':
			case 'video_metadata_mediaType':
			case 'video_metadata_metadataSet':
			case 'video_metadata_network':
			case 'video_metadata_owner':
			case 'video_metadata_ratingsOverride':
			case 'video_metadata_ratingSystem':
			case 'video_metadata_releaseYear':
			case 'video_metadata_seasonDescription':
			case 'video_metadata_seasonLanguage':
			case 'video_metadata_seasonName':
			case 'video_metadata_seasonNumber':
			case 'video_metadata_seasonOverride':
			case 'video_metadata_seriesDescription':
			case 'video_metadata_seriesName':
			case 'video_metadata_status':
			case 'video_metadata_syndicationPartnerDelivery':
			case 'video_metadata_title':
			case 'video_metadata_tVRating':
				return 'string';
			//Video bool properties
			case 'video_mD5HashRecal':
			//Metadata bool properties
			case 'video_metadata_dTOAssetXMLExportstage1':
			case 'video_metadata_eMDeliveryAsset':
			case 'video_metadata_forceDTOexportXML':
			case 'video_metadata_forceDTOproxyAsset':
			case 'video_metadata_localEntity':
			case 'video_metadata_storeandtrackversionsofthisasset':
				return 'bool';
			//Video int64 properties
			case 'video_size':
			//Metadata int64 properties
			case 'video_metadata_assetID':
				return 'int64';
			//Video float properties
			case 'video_videoBitrate':
				return 'float';
			//Video fraction properties
			case 'video_videoFrameRate':
				return 'fraction';
			//Video dateTime properties
			case 'video_creationDate':
			case 'video_fileCreateDate':
			case 'video_fileModificationDate':
			case 'video_lastAccessed':
			case 'video_lastModified':
				return 'dateTime';
			//Video coords properties
			case 'video_imageSize':
				return 'coords';
			//Video timecode properties
			case 'video_duration':
			case 'video_timecodeOffset':
				return 'timecode';
			default:
				throw new Exception('Unexpected fcs field "'.$propertyName.'". FcsXmlParser->GetFcsFieldType().');
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
		$xml = Xml::XmlFileToObject($xmlFilePath);
		$bundleArray = array();
		if(isset($xml->getMdReply)){
			$bundleArray['entityId'] = (string)$xml->getMdReply->entity['entityId'];
			foreach ($xml->getMdReply->entity->metadata->mdValue as $key => $value){
				$propertyName = lcfirst(str_replace(unserialize(CHARS_TO_REMOVE), '', $value['fieldName']));
				$bundleArray[$propertyName] = (string)$value;
			}
		} elseif(isset($xml->request)){
			$bundleArray['entityId'] = (string)$xml->request['entityId'];
			foreach ($xml->request->params->mdValue as $key => $value){
				$propertyName = lcfirst(str_replace(unserialize(CHARS_TO_REMOVE), '', $value['fieldName']));
				$bundleArray[$propertyName] = (string)$value;
			}
		} else {
			throw new Exception('Unable to parse fcs xml sintax: "'.$xmlFilePath.'". FcsXmlParser->GetBundleFromXml().');
		}
		if(!empty($bundleArray)){
			return AbstractController::GetBundleFromUnidimensionalArray($bundleArray);
		} else {
			return false;
		}
	}
}