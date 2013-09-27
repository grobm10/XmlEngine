<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Metadata extends AbstractEntity {

	/**
	 * @var		int
	 */
	protected $id = null;

	/**
	 * @var		string
	 */
	protected $airDate = null;

	/**
	 * @var		string
	 */
	protected $archiveStatus = null;

	/**
	 * @var		string
	 */
	protected $assetGUID = null;

	/**
	 * @var		int
	 */
	protected $assetID = null;

	/**
	 * @var		string
	 */
	protected $author = null;

	/**
	 * @var		string
	 */
	protected $category = null;

	/**
	 * @var		string
	 */
	protected $copyrightHolder = null;

	/**
	 * @var		text
	 */
	protected $description = null;

	/**
	 * @var		bool
	 */
	protected $dTOAssetXMLExportstage1 = null;

	/**
	 * @var		string
	 */
	protected $dTOContainerPosition = null;

	/**
	 * @var		string
	 */
	protected $dTOCopyrightHolder = null;

	/**
	 * @var		string
	 */
	protected $dTOEpisodeID = null;

	/**
	 * @var		string
	 */
	protected $dTOEpisodeName = null;

	/**
	 * @var		string
	 */
	protected $dTOGenre = null;

	/**
	 * @var		text
	 */
	protected $dTOLongDescription = null;

	/**
	 * @var		text
	 */
	protected $dTOLongEpisodeDescription = null;

	/**
	 * @var		string
	 */
	protected $dTORatings = null;

	/**
	 * @var		string
	 */
	protected $dTOReleaseDate = null;

	/**
	 * @var		string
	 */
	protected $dTOSalesPrice = null;

	/**
	 * @var		string
	 */
	protected $dTOSeasonID = null;

	/**
	 * @var		string
	 */
	protected $dTOSeasonName = null;

	/**
	 * @var		text
	 */
	protected $dTOSeriesDescription = null;

	/**
	 * @var		string
	 */
	protected $dTOSeriesID = null;

	/**
	 * @var		text
	 */
	protected $dTOShortEpisodeDescription = null;

	/**
	 * @var		text
	 */
	protected $dTOShortDescription = null;

	/**
	 * @var		bool
	 */
	protected $eMDeliveryAsset = null;

	/**
	 * @var		string
	 */
	protected $episodeName = null;

	/**
	 * @var		int
	 */
	protected $episodeNumber = null;

	/**
	 * @var		bool
	 */
	protected $forceDTOexportXML = null;

	/**
	 * @var		bool
	 */
	protected $forceDTOproxyAsset = null;

	/**
	 * @var		string
	 */
	protected $genre = null;

	/**
	 * @var		string
	 */
	protected $keywords = null;

	/**
	 * @var		string
	 */
	protected $licenseStartDate = null;

	/**
	 * @var		bool
	 */
	protected $localEntity = null;

	/**
	 * @var		string
	 */
	protected $location = null;

	/**
	 * @var		string
	 */
	protected $mediaType = null;

	/**
	 * @var		string
	 */
	protected $metadataSet = null;

	/**
	 * @var		string
	 */
	protected $network = null;

	/**
	 * @var		string
	 */
	protected $owner = null;

	/**
	 * @var		string
	 */
	protected $ratingsOverride = null;

	/**
	 * @var		string
	 */
	protected $ratingSystem = null;

	/**
	 * @var		string
	 */
	protected $releaseYear = null;

	/**
	 * @var		text
	 */
	protected $seasonDescription = null;

	/**
	 * @var		string
	 */
	protected $seasonLanguage = null;

	/**
	 * @var		string
	 */
	protected $seasonName = null;

	/**
	 * @var		string
	 */
	protected $seasonNumber = null;

	/**
	 * @var		string
	 */
	protected $seasonOverride = null;

	/**
	 * @var		text
	 */
	protected $seriesDescription = null;

	/**
	 * @var		string
	 */
	protected $seriesName = null;

	/**
	 * @var		string
	 */
	protected $status = null;

	/**
	 * @var		bool
	 */
	protected $storeandtrackversionsofthisasset = null;

	/**
	 * @var		string
	 */
	protected $syndicationPartnerDelivery = null;

	/**
	 * @var		string
	 */
	protected $title = null;

	/**
	 * @var		string
	 */
	protected $tVRating = null;

	/**
	 * @param		int		$id
	 */
	public function setId($id){
		$this->id = intval($id);
	}

	/**
	 * @param		string		$airDate
	 */
	public function setAirDate($airDate){
		$this->airDate = substr(strval($airDate), 0, 255);
	}

	/**
	 * @param		string		$archiveStatus
	 */
	public function setArchiveStatus($archiveStatus){
		$this->archiveStatus = substr(strval($archiveStatus), 0, 255);
	}

	/**
	 * @param		string		$assetGUID
	 */
	public function setAssetGUID($assetGUID){
		$this->assetGUID = substr(strval($assetGUID), 0, 255);
	}

	/**
	 * @param		int		$assetID
	 */
	public function setAssetID($assetID){
		$this->assetID = intval($assetID);
	}

	/**
	 * @param		string		$author
	 */
	public function setAuthor($author){
		$this->author = substr(strval($author), 0, 255);
	}

	/**
	 * @param		string		$category
	 */
	public function setCategory($category){
		$this->category = substr(strval($category), 0, 255);
	}

	/**
	 * @param		string		$copyrightHolder
	 */
	public function setCopyrightHolder($copyrightHolder){
		$this->copyrightHolder = substr(strval($copyrightHolder), 0, 255);
	}

	/**
	 * @param		text		$description
	 */
	public function setDescription($description){
		$this->description = substr(strval($description), 0, 4096);
	}

	/**
	 * @param		bool		$dTOAssetXMLExportstage1
	 */
	public function setDTOAssetXMLExportstage1($dTOAssetXMLExportstage1){
		$this->dTOAssetXMLExportstage1 = $dTOAssetXMLExportstage1;
	}

	/**
	 * @param		string		$dTOContainerPosition
	 */
	public function setDTOContainerPosition($dTOContainerPosition){
		$this->dTOContainerPosition = substr(strval($dTOContainerPosition), 0, 255);
	}

	/**
	 * @param		string		$dTOCopyrightHolder
	 */
	public function setDTOCopyrightHolder($dTOCopyrightHolder){
		$this->dTOCopyrightHolder = substr(strval($dTOCopyrightHolder), 0, 255);
	}

	/**
	 * @param		string		$dTOEpisodeID
	 */
	public function setDTOEpisodeID($dTOEpisodeID){
		$this->dTOEpisodeID = substr(strval($dTOEpisodeID), 0, 255);
	}

	/**
	 * @param		string		$dTOEpisodeName
	 */
	public function setDTOEpisodeName($dTOEpisodeName){
		$this->dTOEpisodeName = substr(strval($dTOEpisodeName), 0, 255);
	}

	/**
	 * @param		string		$dTOGenre
	 */
	public function setDTOGenre($dTOGenre){
		$this->dTOGenre = substr(strval($dTOGenre), 0, 255);
	}

	/**
	 * @param		text		$dTOLongDescription
	 */
	public function setDTOLongDescription($dTOLongDescription){
		$this->dTOLongDescription = substr(strval($dTOLongDescription), 0, 4096);
	}

	/**
	 * @param		text		$dTOLongEpisodeDescription
	 */
	public function setDTOLongEpisodeDescription($dTOLongEpisodeDescription){
		$this->dTOLongEpisodeDescription = substr(strval($dTOLongEpisodeDescription), 0, 4096);
	}

	/**
	 * @param		string		$dTORatings
	 */
	public function setDTORatings($dTORatings){
		$this->dTORatings = substr(strval($dTORatings), 0, 255);
	}

	/**
	 * @param		string		$dTOReleaseDate
	 */
	public function setDTOReleaseDate($dTOReleaseDate){
		$this->dTOReleaseDate = substr(strval($dTOReleaseDate), 0, 255);
	}

	/**
	 * @param		string		$dTOSalesPrice
	 */
	public function setDTOSalesPrice($dTOSalesPrice){
		$this->dTOSalesPrice = substr(strval($dTOSalesPrice), 0, 255);
	}

	/**
	 * @param		string		$dTOSeasonID
	 */
	public function setDTOSeasonID($dTOSeasonID){
		$this->dTOSeasonID = substr(strval($dTOSeasonID), 0, 255);
	}

	/**
	 * @param		string		$dTOSeasonName
	 */
	public function setDTOSeasonName($dTOSeasonName){
		$this->dTOSeasonName = substr(strval($dTOSeasonName), 0, 255);
	}

	/**
	 * @param		text		$dTOSeriesDescription
	 */
	public function setDTOSeriesDescription($dTOSeriesDescription){
		$this->dTOSeriesDescription = substr(strval($dTOSeriesDescription), 0, 4096);
	}

	/**
	 * @param		string		$dTOSeriesID
	 */
	public function setDTOSeriesID($dTOSeriesID){
		$this->dTOSeriesID = substr(strval($dTOSeriesID), 0, 255);
	}

	/**
	 * @param		text		$dTOShortEpisodeDescription
	 */
	public function setDTOShortEpisodeDescription($dTOShortEpisodeDescription){
		$this->dTOShortEpisodeDescription = substr(strval($dTOShortEpisodeDescription), 0, 4096);
	}

	/**
	 * @param		text		$dTOShortDescription
	 */
	public function setDTOShortDescription($dTOShortDescription){
		$this->dTOShortDescription = substr(strval($dTOShortDescription), 0, 4096);
	}

	/**
	 * @param		bool		$eMDeliveryAsset
	 */
	public function setEMDeliveryAsset($eMDeliveryAsset){
		$this->eMDeliveryAsset = $eMDeliveryAsset;
	}

	/**
	 * @param		string		$episodeName
	 */
	public function setEpisodeName($episodeName){
		$this->episodeName = substr(strval($episodeName), 0, 255);
	}

	/**
	 * @param		int		$episodeNumber
	 */
	public function setEpisodeNumber($episodeNumber){
		$this->episodeNumber = intval($episodeNumber);
	}

	/**
	 * @param		bool		$forceDTOexportXML
	 */
	public function setForceDTOexportXML($forceDTOexportXML){
		$this->forceDTOexportXML = $forceDTOexportXML;
	}

	/**
	 * @param		bool		$forceDTOproxyAsset
	 */
	public function setForceDTOproxyAsset($forceDTOproxyAsset){
		$this->forceDTOproxyAsset = $forceDTOproxyAsset;
	}

	/**
	 * @param		string		$genre
	 */
	public function setGenre($genre){
		$this->genre = substr(strval($genre), 0, 255);
	}

	/**
	 * @param		string		$keywords
	 */
	public function setKeywords($keywords){
		$this->keywords = substr(strval($keywords), 0, 255);
	}

	/**
	 * @param		string		$licenseStartDate
	 */
	public function setLicenseStartDate($licenseStartDate){
		$this->licenseStartDate = substr(strval($licenseStartDate), 0, 255);
	}

	/**
	 * @param		bool		$localEntity
	 */
	public function setLocalEntity($localEntity){
		$this->localEntity = $localEntity;
	}

	/**
	 * @param		string		$location
	 */
	public function setLocation($location){
		$this->location = substr(strval($location), 0, 255);
	}

	/**
	 * @param		string		$mediaType
	 */
	public function setMediaType($mediaType){
		$this->mediaType = substr(strval($mediaType), 0, 255);
	}

	/**
	 * @param		string		$metadataSet
	 */
	public function setMetadataSet($metadataSet){
		$this->metadataSet = substr(strval($metadataSet), 0, 255);
	}

	/**
	 * @param		string		$network
	 */
	public function setNetwork($network){
		$this->network = substr(strval($network), 0, 255);
	}

	/**
	 * @param		string		$owner
	 */
	public function setOwner($owner){
		$this->owner = substr(strval($owner), 0, 255);
	}

	/**
	 * @param		string		$ratingsOverride
	 */
	public function setRatingsOverride($ratingsOverride){
		$this->ratingsOverride = substr(strval($ratingsOverride), 0, 255);
	}

	/**
	 * @param		string		$ratingSystem
	 */
	public function setRatingSystem($ratingSystem){
		$this->ratingSystem = substr(strval($ratingSystem), 0, 255);
	}

	/**
	 * @param		string		$releaseYear
	 */
	public function setReleaseYear($releaseYear){
		$this->releaseYear = substr(strval($releaseYear), 0, 255);
	}

	/**
	 * @param		text		$seasonDescription
	 */
	public function setSeasonDescription($seasonDescription){
		$this->seasonDescription = substr(strval($seasonDescription), 0, 4096);
	}

	/**
	 * @param		string		$seasonLanguage
	 */
	public function setSeasonLanguage($seasonLanguage){
		$this->seasonLanguage = substr(strval($seasonLanguage), 0, 255);
	}

	/**
	 * @param		string		$seasonName
	 */
	public function setSeasonName($seasonName){
		$this->seasonName = substr(strval($seasonName), 0, 255);
	}

	/**
	 * @param		string		$seasonNumber
	 */
	public function setSeasonNumber($seasonNumber){
		$this->seasonNumber = substr(strval($seasonNumber), 0, 255);
	}

	/**
	 * @param		string		$seasonOverride
	 */
	public function setSeasonOverride($seasonOverride){
		$this->seasonOverride = substr(strval($seasonOverride), 0, 255);
	}

	/**
	 * @param		text		$seriesDescription
	 */
	public function setSeriesDescription($seriesDescription){
		$this->seriesDescription = substr(strval($seriesDescription), 0, 4096);
	}

	/**
	 * @param		string		$seriesName
	 */
	public function setSeriesName($seriesName){
		$this->seriesName = substr(strval($seriesName), 0, 255);
	}

	/**
	 * @param		string		$status
	 */
	public function setStatus($status){
		$this->status = substr(strval($status), 0, 255);
	}

	/**
	 * @param		bool		$storeandtrackversionsofthisasset
	 */
	public function setStoreandtrackversionsofthisasset($storeandtrackversionsofthisasset){
		$this->storeandtrackversionsofthisasset = $storeandtrackversionsofthisasset;
	}

	/**
	 * @param		string		$syndicationPartnerDelivery
	 */
	public function setSyndicationPartnerDelivery($syndicationPartnerDelivery){
		$this->syndicationPartnerDelivery = substr(strval($syndicationPartnerDelivery), 0, 255);
	}

	/**
	 * @param		string		$title
	 */
	public function setTitle($title){
		$this->title = substr(strval($title), 0, 255);
	}

	/**
	 * @param		string		$tVRating
	 */
	public function setTVRating($tVRating){
		$this->tVRating = substr(strval($tVRating), 0, 255);
	}

	/**
	 * @return		int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		string
	 */
	public function getAirDate(){
		return $this->airDate;
	}

	/**
	 * @return		string
	 */
	public function getArchiveStatus(){
		return $this->archiveStatus;
	}

	/**
	 * @return		string
	 */
	public function getAssetGUID(){
		return $this->assetGUID;
	}

	/**
	 * @return		int
	 */
	public function getAssetID(){
		return $this->assetID;
	}

	/**
	 * @return		string
	 */
	public function getAuthor(){
		return $this->author;
	}

	/**
	 * @return		string
	 */
	public function getCategory(){
		return $this->category;
	}

	/**
	 * @return		string
	 */
	public function getCopyrightHolder(){
		return $this->copyrightHolder;
	}

	/**
	 * @return		text
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * @return		bool
	 */
	public function getDTOAssetXMLExportstage1(){
		return $this->dTOAssetXMLExportstage1;
	}

	/**
	 * @return		string
	 */
	public function getDTOContainerPosition(){
		return $this->dTOContainerPosition;
	}

	/**
	 * @return		string
	 */
	public function getDTOCopyrightHolder(){
		return $this->dTOCopyrightHolder;
	}

	/**
	 * @return		string
	 */
	public function getDTOEpisodeID(){
		return $this->dTOEpisodeID;
	}

	/**
	 * @return		string
	 */
	public function getDTOEpisodeName(){
		return $this->dTOEpisodeName;
	}

	/**
	 * @return		string
	 */
	public function getDTOGenre(){
		return $this->dTOGenre;
	}

	/**
	 * @return		text
	 */
	public function getDTOLongDescription(){
		return $this->dTOLongDescription;
	}

	/**
	 * @return		text
	 */
	public function getDTOLongEpisodeDescription(){
		return $this->dTOLongEpisodeDescription;
	}

	/**
	 * @return		string
	 */
	public function getDTORatings(){
		return $this->dTORatings;
	}

	/**
	 * @return		string
	 */
	public function getDTOReleaseDate(){
		return $this->dTOReleaseDate;
	}

	/**
	 * @return		string
	 */
	public function getDTOSalesPrice(){
		return $this->dTOSalesPrice;
	}

	/**
	 * @return		string
	 */
	public function getDTOSeasonID(){
		return $this->dTOSeasonID;
	}

	/**
	 * @return		string
	 */
	public function getDTOSeasonName(){
		return $this->dTOSeasonName;
	}

	/**
	 * @return		text
	 */
	public function getDTOSeriesDescription(){
		return $this->dTOSeriesDescription;
	}

	/**
	 * @return		string
	 */
	public function getDTOSeriesID(){
		return $this->dTOSeriesID;
	}

	/**
	 * @return		text
	 */
	public function getDTOShortEpisodeDescription(){
		return $this->dTOShortEpisodeDescription;
	}

	/**
	 * @return		text
	 */
	public function getDTOShortDescription(){
		return $this->dTOShortDescription;
	}

	/**
	 * @return		bool
	 */
	public function getEMDeliveryAsset(){
		return $this->eMDeliveryAsset;
	}

	/**
	 * @return		string
	 */
	public function getEpisodeName(){
		return $this->episodeName;
	}

	/**
	 * @return		int
	 */
	public function getEpisodeNumber(){
		return $this->episodeNumber;
	}

	/**
	 * @return		bool
	 */
	public function getForceDTOexportXML(){
		return $this->forceDTOexportXML;
	}

	/**
	 * @return		bool
	 */
	public function getForceDTOproxyAsset(){
		return $this->forceDTOproxyAsset;
	}

	/**
	 * @return		string
	 */
	public function getGenre(){
		return $this->genre;
	}

	/**
	 * @return		string
	 */
	public function getKeywords(){
		return $this->keywords;
	}

	/**
	 * @return		string
	 */
	public function getLicenseStartDate(){
		return $this->licenseStartDate;
	}

	/**
	 * @return		bool
	 */
	public function getLocalEntity(){
		return $this->localEntity;
	}

	/**
	 * @return		string
	 */
	public function getLocation(){
		return $this->location;
	}

	/**
	 * @return		string
	 */
	public function getMediaType(){
		return $this->mediaType;
	}

	/**
	 * @return		string
	 */
	public function getMetadataSet(){
		return $this->metadataSet;
	}

	/**
	 * @return		string
	 */
	public function getNetwork(){
		return $this->network;
	}

	/**
	 * @return		string
	 */
	public function getOwner(){
		return $this->owner;
	}

	/**
	 * @return		string
	 */
	public function getRatingsOverride(){
		return $this->ratingsOverride;
	}

	/**
	 * @return		string
	 */
	public function getRatingSystem(){
		return $this->ratingSystem;
	}

	/**
	 * @return		string
	 */
	public function getReleaseYear(){
		return $this->releaseYear;
	}

	/**
	 * @return		text
	 */
	public function getSeasonDescription(){
		return $this->seasonDescription;
	}

	/**
	 * @return		string
	 */
	public function getSeasonLanguage(){
		return $this->seasonLanguage;
	}

	/**
	 * @return		string
	 */
	public function getSeasonName(){
		return $this->seasonName;
	}

	/**
	 * @return		string
	 */
	public function getSeasonNumber(){
		return $this->seasonNumber;
	}

	/**
	 * @return		string
	 */
	public function getSeasonOverride(){
		return $this->seasonOverride;
	}

	/**
	 * @return		text
	 */
	public function getSeriesDescription(){
		return $this->seriesDescription;
	}

	/**
	 * @return		string
	 */
	public function getSeriesName(){
		return $this->seriesName;
	}

	/**
	 * @return		string
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * @return		bool
	 */
	public function getStoreandtrackversionsofthisasset(){
		return $this->storeandtrackversionsofthisasset;
	}

	/**
	 * @return		string
	 */
	public function getSyndicationPartnerDelivery(){
		return $this->syndicationPartnerDelivery;
	}

	/**
	 * @return		string
	 */
	public function getTitle(){
		return $this->title;
	}

	/**
	 * @return		string
	 */
	public function getTVRating(){
		return $this->tVRating;
	}

}