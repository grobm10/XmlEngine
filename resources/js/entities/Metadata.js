/**
 * This class represents a Metadata
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Metadata = function(genericObj) {

	/**
	 * @var		Number
	 */
	var _id = 0;

	/**
	 * @var		String
	 */
	var _airDate = '';

	/**
	 * @var		String
	 */
	var _archiveStatus = '';

	/**
	 * @var		String
	 */
	var _assetGUID = '';

	/**
	 * @var		Number
	 */
	var _assetID = 0;

	/**
	 * @var		String
	 */
	var _author = '';

	/**
	 * @var		String
	 */
	var _category = '';

	/**
	 * @var		String
	 */
	var _copyrightHolder = '';

	/**
	 * @var		String
	 */
	var _description = '';

	/**
	 * @var		Boolean
	 */
	var _dTOAssetXMLExportstage1 = false;

	/**
	 * @var		String
	 */
	var _dTOContainerPosition = '';

	/**
	 * @var		String
	 */
	var _dTOCopyrightHolder = '';

	/**
	 * @var		String
	 */
	var _dTOEpisodeID = '';

	/**
	 * @var		String
	 */
	var _dTOEpisodeName = '';

	/**
	 * @var		String
	 */
	var _dTOGenre = '';

	/**
	 * @var		String
	 */
	var _dTOLongDescription = '';

	/**
	 * @var		String
	 */
	var _dTOLongEpisodeDescription = '';

	/**
	 * @var		String
	 */
	var _dTORatings = '';

	/**
	 * @var		String
	 */
	var _dTOReleaseDate = '';

	/**
	 * @var		String
	 */
	var _dTOSalesPrice = '';

	/**
	 * @var		String
	 */
	var _dTOSeasonID = '';

	/**
	 * @var		String
	 */
	var _dTOSeasonName = '';

	/**
	 * @var		String
	 */
	var _dTOSeriesDescription = '';

	/**
	 * @var		String
	 */
	var _dTOSeriesID = '';

	/**
	 * @var		String
	 */
	var _dTOShortEpisodeDescription = '';

	/**
	 * @var		String
	 */
	var _dTOShortDescription = '';

	/**
	 * @var		Boolean
	 */
	var _eMDeliveryAsset = false;

	/**
	 * @var		String
	 */
	var _episodeName = '';

	/**
	 * @var		Number
	 */
	var _episodeNumber = 0;

	/**
	 * @var		Boolean
	 */
	var _forceDTOexportXML = false;

	/**
	 * @var		Boolean
	 */
	var _forceDTOproxyAsset = false;

	/**
	 * @var		String
	 */
	var _genre = '';

	/**
	 * @var		String
	 */
	var _keywords = '';

	/**
	 * @var		String
	 */
	var _licenseStartDate = '';

	/**
	 * @var		Boolean
	 */
	var _localEntity = false;

	/**
	 * @var		String
	 */
	var _location = '';

	/**
	 * @var		String
	 */
	var _mediaType = '';

	/**
	 * @var		String
	 */
	var _metadataSet = '';

	/**
	 * @var		String
	 */
	var _network = '';

	/**
	 * @var		String
	 */
	var _owner = '';

	/**
	 * @var		String
	 */
	var _ratingsOverride = '';

	/**
	 * @var		String
	 */
	var _ratingSystem = '';

	/**
	 * @var		String
	 */
	var _releaseYear = '';

	/**
	 * @var		String
	 */
	var _seasonDescription = '';

	/**
	 * @var		String
	 */
	var _seasonLanguage = '';

	/**
	 * @var		String
	 */
	var _seasonName = '';

	/**
	 * @var		String
	 */
	var _seasonNumber = '';

	/**
	 * @var		String
	 */
	var _seasonOverride = '';

	/**
	 * @var		String
	 */
	var _seriesDescription = '';

	/**
	 * @var		String
	 */
	var _seriesName = '';

	/**
	 * @var		String
	 */
	var _status = '';

	/**
	 * @var		Boolean
	 */
	var _storeandtrackversionsofthisasset = false;

	/**
	 * @var		String
	 */
	var _syndicationPartnerDelivery = '';

	/**
	 * @var		String
	 */
	var _title = '';

	/**
	 * @var		String
	 */
	var _tVRating = '';

	/**
	 * Constructor
	 */
	var init = function() {
		if(Validator.IsInstanceOf('Object', genericObj)){
			$.each(genericObj, function(property, value){
				switch (property.toUpperCase()) {
					case 'ID':
						_setId(value);
						break;
					case 'AIRDATE':
						_setAirDate(value);
						break;
					case 'ARCHIVESTATUS':
						_setArchiveStatus(value);
						break;
					case 'ASSETGUID':
						_setAssetGUID(value);
						break;
					case 'ASSETID':
						_setAssetID(value);
						break;
					case 'AUTHOR':
						_setAuthor(value);
						break;
					case 'CATEGORY':
						_setCategory(value);
						break;
					case 'COPYRIGHTHOLDER':
						_setCopyrightHolder(value);
						break;
					case 'DESCRIPTION':
						_setDescription(value);
						break;
					case 'DTOASSETXMLEXPORTSTAGE1':
						_setDTOAssetXMLExportstage1(value);
						break;
					case 'DTOCONTAINERPOSITION':
						_setDTOContainerPosition(value);
						break;
					case 'DTOCOPYRIGHTHOLDER':
						_setDTOCopyrightHolder(value);
						break;
					case 'DTOEPISODEID':
						_setDTOEpisodeID(value);
						break;
					case 'DTOEPISODENAME':
						_setDTOEpisodeName(value);
						break;
					case 'DTOGENRE':
						_setDTOGenre(value);
						break;
					case 'DTOLONGDESCRIPTION':
						_setDTOLongDescription(value);
						break;
					case 'DTOLONGEPISODEDESCRIPTION':
						_setDTOLongEpisodeDescription(value);
						break;
					case 'DTORATINGS':
						_setDTORatings(value);
						break;
					case 'DTORELEASEDATE':
						_setDTOReleaseDate(value);
						break;
					case 'DTOSALESPRICE':
						_setDTOSalesPrice(value);
						break;
					case 'DTOSEASONID':
						_setDTOSeasonID(value);
						break;
					case 'DTOSEASONNAME':
						_setDTOSeasonName(value);
						break;
					case 'DTOSERIESDESCRIPTION':
						_setDTOSeriesDescription(value);
						break;
					case 'DTOSERIESID':
						_setDTOSeriesID(value);
						break;
					case 'DTOSHORTEPISODEDESCRIPTION':
						_setDTOShortEpisodeDescription(value);
						break;
					case 'DTOSHORTDESCRIPTION':
						_setDTOShortDescription(value);
						break;
					case 'EMDELIVERYASSET':
						_setEMDeliveryAsset(value);
						break;
					case 'EPISODENAME':
						_setEpisodeName(value);
						break;
					case 'EPISODENUMBER':
						_setEpisodeNumber(value);
						break;
					case 'FORCEDTOEXPORTXML':
						_setForceDTOexportXML(value);
						break;
					case 'FORCEDTOPROXYASSET':
						_setForceDTOproxyAsset(value);
						break;
					case 'GENRE':
						_setGenre(value);
						break;
					case 'KEYWORDS':
						_setKeywords(value);
						break;
					case 'LICENSESTARTDATE':
						_setLicenseStartDate(value);
						break;
					case 'LOCALENTITY':
						_setLocalEntity(value);
						break;
					case 'LOCATION':
						_setLocation(value);
						break;
					case 'MEDIATYPE':
						_setMediaType(value);
						break;
					case 'METADATASET':
						_setMetadataSet(value);
						break;
					case 'NETWORK':
						_setNetwork(value);
						break;
					case 'OWNER':
						_setOwner(value);
						break;
					case 'RATINGSOVERRIDE':
						_setRatingsOverride(value);
						break;
					case 'RATINGSYSTEM':
						_setRatingSystem(value);
						break;
					case 'RELEASEYEAR':
						_setReleaseYear(value);
						break;
					case 'SEASONDESCRIPTION':
						_setSeasonDescription(value);
						break;
					case 'SEASONLANGUAGE':
						_setSeasonLanguage(value);
						break;
					case 'SEASONNAME':
						_setSeasonName(value);
						break;
					case 'SEASONNUMBER':
						_setSeasonNumber(value);
						break;
					case 'SEASONOVERRIDE':
						_setSeasonOverride(value);
						break;
					case 'SERIESDESCRIPTION':
						_setSeriesDescription(value);
						break;
					case 'SERIESNAME':
						_setSeriesName(value);
						break;
					case 'STATUS':
						_setStatus(value);
						break;
					case 'STOREANDTRACKVERSIONSOFTHISASSET':
						_setStoreandtrackversionsofthisasset(value);
						break;
					case 'SYNDICATIONPARTNERDELIVERY':
						_setSyndicationPartnerDelivery(value);
						break;
					case 'TITLE':
						_setTitle(value);
						break;
					case 'TVRATING':
						_setTVRating(value);
						break;
				}
			});
		}
	};

	/**
	 * @param		Number		id
	 */
	var _setId = function(id){
		_id = Number(id);
	};

	/**
	 * @param		String		airDate
	 */
	var _setAirDate = function(airDate){
		_airDate = String(airDate);
	};

	/**
	 * @param		String		archiveStatus
	 */
	var _setArchiveStatus = function(archiveStatus){
		_archiveStatus = String(archiveStatus);
	};

	/**
	 * @param		String		assetGUID
	 */
	var _setAssetGUID = function(assetGUID){
		_assetGUID = String(assetGUID);
	};

	/**
	 * @param		Number		assetID
	 */
	var _setAssetID = function(assetID){
		_assetID = Number(assetID);
	};

	/**
	 * @param		String		author
	 */
	var _setAuthor = function(author){
		_author = String(author);
	};

	/**
	 * @param		String		category
	 */
	var _setCategory = function(category){
		_category = String(category);
	};

	/**
	 * @param		String		copyrightHolder
	 */
	var _setCopyrightHolder = function(copyrightHolder){
		_copyrightHolder = String(copyrightHolder);
	};

	/**
	 * @param		String		description
	 */
	var _setDescription = function(description){
		_description = String(description);
	};

	/**
	 * @param		Boolean		dTOAssetXMLExportstage1
	 */
	var _setDTOAssetXMLExportstage1 = function(dTOAssetXMLExportstage1){
		_dTOAssetXMLExportstage1 = Boolean(dTOAssetXMLExportstage1);
	};

	/**
	 * @param		String		dTOContainerPosition
	 */
	var _setDTOContainerPosition = function(dTOContainerPosition){
		_dTOContainerPosition = String(dTOContainerPosition);
	};

	/**
	 * @param		String		dTOCopyrightHolder
	 */
	var _setDTOCopyrightHolder = function(dTOCopyrightHolder){
		_dTOCopyrightHolder = String(dTOCopyrightHolder);
	};

	/**
	 * @param		String		dTOEpisodeID
	 */
	var _setDTOEpisodeID = function(dTOEpisodeID){
		_dTOEpisodeID = String(dTOEpisodeID);
	};

	/**
	 * @param		String		dTOEpisodeName
	 */
	var _setDTOEpisodeName = function(dTOEpisodeName){
		_dTOEpisodeName = String(dTOEpisodeName);
	};

	/**
	 * @param		String		dTOGenre
	 */
	var _setDTOGenre = function(dTOGenre){
		_dTOGenre = String(dTOGenre);
	};

	/**
	 * @param		String		dTOLongDescription
	 */
	var _setDTOLongDescription = function(dTOLongDescription){
		_dTOLongDescription = String(dTOLongDescription);
	};

	/**
	 * @param		String		dTOLongEpisodeDescription
	 */
	var _setDTOLongEpisodeDescription = function(dTOLongEpisodeDescription){
		_dTOLongEpisodeDescription = String(dTOLongEpisodeDescription);
	};

	/**
	 * @param		String		dTORatings
	 */
	var _setDTORatings = function(dTORatings){
		_dTORatings = String(dTORatings);
	};

	/**
	 * @param		String		dTOReleaseDate
	 */
	var _setDTOReleaseDate = function(dTOReleaseDate){
		_dTOReleaseDate = String(dTOReleaseDate);
	};

	/**
	 * @param		String		dTOSalesPrice
	 */
	var _setDTOSalesPrice = function(dTOSalesPrice){
		_dTOSalesPrice = String(dTOSalesPrice);
	};

	/**
	 * @param		String		dTOSeasonID
	 */
	var _setDTOSeasonID = function(dTOSeasonID){
		_dTOSeasonID = String(dTOSeasonID);
	};

	/**
	 * @param		String		dTOSeasonName
	 */
	var _setDTOSeasonName = function(dTOSeasonName){
		_dTOSeasonName = String(dTOSeasonName);
	};

	/**
	 * @param		String		dTOSeriesDescription
	 */
	var _setDTOSeriesDescription = function(dTOSeriesDescription){
		_dTOSeriesDescription = String(dTOSeriesDescription);
	};

	/**
	 * @param		String		dTOSeriesID
	 */
	var _setDTOSeriesID = function(dTOSeriesID){
		_dTOSeriesID = String(dTOSeriesID);
	};

	/**
	 * @param		String		dTOShortEpisodeDescription
	 */
	var _setDTOShortEpisodeDescription = function(dTOShortEpisodeDescription){
		_dTOShortEpisodeDescription = String(dTOShortEpisodeDescription);
	};

	/**
	 * @param		String		dTOShortDescription
	 */
	var _setDTOShortDescription = function(dTOShortDescription){
		_dTOShortDescription = String(dTOShortDescription);
	};

	/**
	 * @param		Boolean		eMDeliveryAsset
	 */
	var _setEMDeliveryAsset = function(eMDeliveryAsset){
		_eMDeliveryAsset = Boolean(eMDeliveryAsset);
	};

	/**
	 * @param		String		episodeName
	 */
	var _setEpisodeName = function(episodeName){
		_episodeName = String(episodeName);
	};

	/**
	 * @param		Number		episodeNumber
	 */
	var _setEpisodeNumber = function(episodeNumber){
		_episodeNumber = Number(episodeNumber);
	};

	/**
	 * @param		Boolean		forceDTOexportXML
	 */
	var _setForceDTOexportXML = function(forceDTOexportXML){
		_forceDTOexportXML = Boolean(forceDTOexportXML);
	};

	/**
	 * @param		Boolean		forceDTOproxyAsset
	 */
	var _setForceDTOproxyAsset = function(forceDTOproxyAsset){
		_forceDTOproxyAsset = Boolean(forceDTOproxyAsset);
	};

	/**
	 * @param		String		genre
	 */
	var _setGenre = function(genre){
		_genre = String(genre);
	};

	/**
	 * @param		String		keywords
	 */
	var _setKeywords = function(keywords){
		_keywords = String(keywords);
	};

	/**
	 * @param		String		licenseStartDate
	 */
	var _setLicenseStartDate = function(licenseStartDate){
		_licenseStartDate = String(licenseStartDate);
	};

	/**
	 * @param		Boolean		localEntity
	 */
	var _setLocalEntity = function(localEntity){
		_localEntity = Boolean(localEntity);
	};

	/**
	 * @param		String		location
	 */
	var _setLocation = function(location){
		_location = String(location);
	};

	/**
	 * @param		String		mediaType
	 */
	var _setMediaType = function(mediaType){
		_mediaType = String(mediaType);
	};

	/**
	 * @param		String		metadataSet
	 */
	var _setMetadataSet = function(metadataSet){
		_metadataSet = String(metadataSet);
	};

	/**
	 * @param		String		network
	 */
	var _setNetwork = function(network){
		_network = String(network);
	};

	/**
	 * @param		String		owner
	 */
	var _setOwner = function(owner){
		_owner = String(owner);
	};

	/**
	 * @param		String		ratingsOverride
	 */
	var _setRatingsOverride = function(ratingsOverride){
		_ratingsOverride = String(ratingsOverride);
	};

	/**
	 * @param		String		ratingSystem
	 */
	var _setRatingSystem = function(ratingSystem){
		_ratingSystem = String(ratingSystem);
	};

	/**
	 * @param		String		releaseYear
	 */
	var _setReleaseYear = function(releaseYear){
		_releaseYear = String(releaseYear);
	};

	/**
	 * @param		String		seasonDescription
	 */
	var _setSeasonDescription = function(seasonDescription){
		_seasonDescription = String(seasonDescription);
	};

	/**
	 * @param		String		seasonLanguage
	 */
	var _setSeasonLanguage = function(seasonLanguage){
		_seasonLanguage = String(seasonLanguage);
	};

	/**
	 * @param		String		seasonName
	 */
	var _setSeasonName = function(seasonName){
		_seasonName = String(seasonName);
	};

	/**
	 * @param		String		seasonNumber
	 */
	var _setSeasonNumber = function(seasonNumber){
		_seasonNumber = String(seasonNumber);
	};

	/**
	 * @param		String		seasonOverride
	 */
	var _setSeasonOverride = function(seasonOverride){
		_seasonOverride = String(seasonOverride);
	};

	/**
	 * @param		String		seriesDescription
	 */
	var _setSeriesDescription = function(seriesDescription){
		_seriesDescription = String(seriesDescription);
	};

	/**
	 * @param		String		seriesName
	 */
	var _setSeriesName = function(seriesName){
		_seriesName = String(seriesName);
	};

	/**
	 * @param		String		status
	 */
	var _setStatus = function(status){
		_status = String(status);
	};

	/**
	 * @param		Boolean		storeandtrackversionsofthisasset
	 */
	var _setStoreandtrackversionsofthisasset = function(storeandtrackversionsofthisasset){
		_storeandtrackversionsofthisasset = Boolean(storeandtrackversionsofthisasset);
	};

	/**
	 * @param		String		syndicationPartnerDelivery
	 */
	var _setSyndicationPartnerDelivery = function(syndicationPartnerDelivery){
		_syndicationPartnerDelivery = String(syndicationPartnerDelivery);
	};

	/**
	 * @param		String		title
	 */
	var _setTitle = function(title){
		_title = String(title);
	};

	/**
	 * @param		String		tVRating
	 */
	var _setTVRating = function(tVRating){
		_tVRating = String(tVRating);
	};

	/**
	 * @return		Number
	 */
	var _getId = function(){
		return _id;
	};

	/**
	 * @return		String
	 */
	var _getAirDate = function(){
		return _airDate;
	};

	/**
	 * @return		String
	 */
	var _getArchiveStatus = function(){
		return _archiveStatus;
	};

	/**
	 * @return		String
	 */
	var _getAssetGUID = function(){
		return _assetGUID;
	};

	/**
	 * @return		Number
	 */
	var _getAssetID = function(){
		return _assetID;
	};

	/**
	 * @return		String
	 */
	var _getAuthor = function(){
		return _author;
	};

	/**
	 * @return		String
	 */
	var _getCategory = function(){
		return _category;
	};

	/**
	 * @return		String
	 */
	var _getCopyrightHolder = function(){
		return _copyrightHolder;
	};

	/**
	 * @return		String
	 */
	var _getDescription = function(){
		return _description;
	};

	/**
	 * @return		Boolean
	 */
	var _getDTOAssetXMLExportstage1 = function(){
		return _dTOAssetXMLExportstage1;
	};

	/**
	 * @return		String
	 */
	var _getDTOContainerPosition = function(){
		return _dTOContainerPosition;
	};

	/**
	 * @return		String
	 */
	var _getDTOCopyrightHolder = function(){
		return _dTOCopyrightHolder;
	};

	/**
	 * @return		String
	 */
	var _getDTOEpisodeID = function(){
		return _dTOEpisodeID;
	};

	/**
	 * @return		String
	 */
	var _getDTOEpisodeName = function(){
		return _dTOEpisodeName;
	};

	/**
	 * @return		String
	 */
	var _getDTOGenre = function(){
		return _dTOGenre;
	};

	/**
	 * @return		String
	 */
	var _getDTOLongDescription = function(){
		return _dTOLongDescription;
	};

	/**
	 * @return		String
	 */
	var _getDTOLongEpisodeDescription = function(){
		return _dTOLongEpisodeDescription;
	};

	/**
	 * @return		String
	 */
	var _getDTORatings = function(){
		return _dTORatings;
	};

	/**
	 * @return		String
	 */
	var _getDTOReleaseDate = function(){
		return _dTOReleaseDate;
	};

	/**
	 * @return		String
	 */
	var _getDTOSalesPrice = function(){
		return _dTOSalesPrice;
	};

	/**
	 * @return		String
	 */
	var _getDTOSeasonID = function(){
		return _dTOSeasonID;
	};

	/**
	 * @return		String
	 */
	var _getDTOSeasonName = function(){
		return _dTOSeasonName;
	};

	/**
	 * @return		String
	 */
	var _getDTOSeriesDescription = function(){
		return _dTOSeriesDescription;
	};

	/**
	 * @return		String
	 */
	var _getDTOSeriesID = function(){
		return _dTOSeriesID;
	};

	/**
	 * @return		String
	 */
	var _getDTOShortEpisodeDescription = function(){
		return _dTOShortEpisodeDescription;
	};

	/**
	 * @return		String
	 */
	var _getDTOShortDescription = function(){
		return _dTOShortDescription;
	};

	/**
	 * @return		Boolean
	 */
	var _getEMDeliveryAsset = function(){
		return _eMDeliveryAsset;
	};

	/**
	 * @return		String
	 */
	var _getEpisodeName = function(){
		return _episodeName;
	};

	/**
	 * @return		Number
	 */
	var _getEpisodeNumber = function(){
		return _episodeNumber;
	};

	/**
	 * @return		Boolean
	 */
	var _getForceDTOexportXML = function(){
		return _forceDTOexportXML;
	};

	/**
	 * @return		Boolean
	 */
	var _getForceDTOproxyAsset = function(){
		return _forceDTOproxyAsset;
	};

	/**
	 * @return		String
	 */
	var _getGenre = function(){
		return _genre;
	};

	/**
	 * @return		String
	 */
	var _getKeywords = function(){
		return _keywords;
	};

	/**
	 * @return		String
	 */
	var _getLicenseStartDate = function(){
		return _licenseStartDate;
	};

	/**
	 * @return		Boolean
	 */
	var _getLocalEntity = function(){
		return _localEntity;
	};

	/**
	 * @return		String
	 */
	var _getLocation = function(){
		return _location;
	};

	/**
	 * @return		String
	 */
	var _getMediaType = function(){
		return _mediaType;
	};

	/**
	 * @return		String
	 */
	var _getMetadataSet = function(){
		return _metadataSet;
	};

	/**
	 * @return		String
	 */
	var _getNetwork = function(){
		return _network;
	};

	/**
	 * @return		String
	 */
	var _getOwner = function(){
		return _owner;
	};

	/**
	 * @return		String
	 */
	var _getRatingsOverride = function(){
		return _ratingsOverride;
	};

	/**
	 * @return		String
	 */
	var _getRatingSystem = function(){
		return _ratingSystem;
	};

	/**
	 * @return		String
	 */
	var _getReleaseYear = function(){
		return _releaseYear;
	};

	/**
	 * @return		String
	 */
	var _getSeasonDescription = function(){
		return _seasonDescription;
	};

	/**
	 * @return		String
	 */
	var _getSeasonLanguage = function(){
		return _seasonLanguage;
	};

	/**
	 * @return		String
	 */
	var _getSeasonName = function(){
		return _seasonName;
	};

	/**
	 * @return		String
	 */
	var _getSeasonNumber = function(){
		return _seasonNumber;
	};

	/**
	 * @return		String
	 */
	var _getSeasonOverride = function(){
		return _seasonOverride;
	};

	/**
	 * @return		String
	 */
	var _getSeriesDescription = function(){
		return _seriesDescription;
	};

	/**
	 * @return		String
	 */
	var _getSeriesName = function(){
		return _seriesName;
	};

	/**
	 * @return		String
	 */
	var _getStatus = function(){
		return _status;
	};

	/**
	 * @return		Boolean
	 */
	var _getStoreandtrackversionsofthisasset = function(){
		return _storeandtrackversionsofthisasset;
	};

	/**
	 * @return		String
	 */
	var _getSyndicationPartnerDelivery = function(){
		return _syndicationPartnerDelivery;
	};

	/**
	 * @return		String
	 */
	var _getTitle = function(){
		return _title;
	};

	/**
	 * @return		String
	 */
	var _getTVRating = function(){
		return _tVRating;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
				"airDate":_airDate,
				"archiveStatus":_archiveStatus,
				"assetGUID":_assetGUID,
				"assetID":_assetID,
				"author":_author,
				"category":_category,
				"copyrightHolder":_copyrightHolder,
				"description":_description,
				"dTOAssetXMLExportstage1":_dTOAssetXMLExportstage1,
				"dTOContainerPosition":_dTOContainerPosition,
				"dTOCopyrightHolder":_dTOCopyrightHolder,
				"dTOEpisodeID":_dTOEpisodeID,
				"dTOEpisodeName":_dTOEpisodeName,
				"dTOGenre":_dTOGenre,
				"dTOLongDescription":_dTOLongDescription,
				"dTOLongEpisodeDescription":_dTOLongEpisodeDescription,
				"dTORatings":_dTORatings,
				"dTOReleaseDate":_dTOReleaseDate,
				"dTOSalesPrice":_dTOSalesPrice,
				"dTOSeasonID":_dTOSeasonID,
				"dTOSeasonName":_dTOSeasonName,
				"dTOSeriesDescription":_dTOSeriesDescription,
				"dTOSeriesID":_dTOSeriesID,
				"dTOShortEpisodeDescription":_dTOShortEpisodeDescription,
				"dTOShortDescription":_dTOShortDescription,
				"eMDeliveryAsset":_eMDeliveryAsset,
				"episodeName":_episodeName,
				"episodeNumber":_episodeNumber,
				"forceDTOexportXML":_forceDTOexportXML,
				"forceDTOproxyAsset":_forceDTOproxyAsset,
				"genre":_genre,
				"keywords":_keywords,
				"licenseStartDate":_licenseStartDate,
				"localEntity":_localEntity,
				"location":_location,
				"mediaType":_mediaType,
				"metadataSet":_metadataSet,
				"network":_network,
				"owner":_owner,
				"ratingsOverride":_ratingsOverride,
				"ratingSystem":_ratingSystem,
				"releaseYear":_releaseYear,
				"seasonDescription":_seasonDescription,
				"seasonLanguage":_seasonLanguage,
				"seasonName":_seasonName,
				"seasonNumber":_seasonNumber,
				"seasonOverride":_seasonOverride,
				"seriesDescription":_seriesDescription,
				"seriesName":_seriesName,
				"status":_status,
				"storeandtrackversionsofthisasset":_storeandtrackversionsofthisasset,
				"syndicationPartnerDelivery":_syndicationPartnerDelivery,
				"title":_title,
				"tVRating":_tVRating
			};
	};

	/**
	 * Executes constructor
	 */
	init();

	/**
	 * Returns public functions
	 */
	return{

		/**
		 * @param		Number		id
		 */
		setId : function(id){
			_setId(id);
		},

		/**
		 * @param		String		airDate
		 */
		setAirDate : function(airDate){
			_setAirDate(airDate);
		},

		/**
		 * @param		String		archiveStatus
		 */
		setArchiveStatus : function(archiveStatus){
			_setArchiveStatus(archiveStatus);
		},

		/**
		 * @param		String		assetGUID
		 */
		setAssetGUID : function(assetGUID){
			_setAssetGUID(assetGUID);
		},

		/**
		 * @param		Number		assetID
		 */
		setAssetID : function(assetID){
			_setAssetID(assetID);
		},

		/**
		 * @param		String		author
		 */
		setAuthor : function(author){
			_setAuthor(author);
		},

		/**
		 * @param		String		category
		 */
		setCategory : function(category){
			_setCategory(category);
		},

		/**
		 * @param		String		copyrightHolder
		 */
		setCopyrightHolder : function(copyrightHolder){
			_setCopyrightHolder(copyrightHolder);
		},

		/**
		 * @param		String		description
		 */
		setDescription : function(description){
			_setDescription(description);
		},

		/**
		 * @param		Boolean		dTOAssetXMLExportstage1
		 */
		setDTOAssetXMLExportstage1 : function(dTOAssetXMLExportstage1){
			_setDTOAssetXMLExportstage1(dTOAssetXMLExportstage1);
		},

		/**
		 * @param		String		dTOContainerPosition
		 */
		setDTOContainerPosition : function(dTOContainerPosition){
			_setDTOContainerPosition(dTOContainerPosition);
		},

		/**
		 * @param		String		dTOCopyrightHolder
		 */
		setDTOCopyrightHolder : function(dTOCopyrightHolder){
			_setDTOCopyrightHolder(dTOCopyrightHolder);
		},

		/**
		 * @param		String		dTOEpisodeID
		 */
		setDTOEpisodeID : function(dTOEpisodeID){
			_setDTOEpisodeID(dTOEpisodeID);
		},

		/**
		 * @param		String		dTOEpisodeName
		 */
		setDTOEpisodeName : function(dTOEpisodeName){
			_setDTOEpisodeName(dTOEpisodeName);
		},

		/**
		 * @param		String		dTOGenre
		 */
		setDTOGenre : function(dTOGenre){
			_setDTOGenre(dTOGenre);
		},

		/**
		 * @param		String		dTOLongDescription
		 */
		setDTOLongDescription : function(dTOLongDescription){
			_setDTOLongDescription(dTOLongDescription);
		},

		/**
		 * @param		String		dTOLongEpisodeDescription
		 */
		setDTOLongEpisodeDescription : function(dTOLongEpisodeDescription){
			_setDTOLongEpisodeDescription(dTOLongEpisodeDescription);
		},

		/**
		 * @param		String		dTORatings
		 */
		setDTORatings : function(dTORatings){
			_setDTORatings(dTORatings);
		},

		/**
		 * @param		String		dTOReleaseDate
		 */
		setDTOReleaseDate : function(dTOReleaseDate){
			_setDTOReleaseDate(dTOReleaseDate);
		},

		/**
		 * @param		String		dTOSalesPrice
		 */
		setDTOSalesPrice : function(dTOSalesPrice){
			_setDTOSalesPrice(dTOSalesPrice);
		},

		/**
		 * @param		String		dTOSeasonID
		 */
		setDTOSeasonID : function(dTOSeasonID){
			_setDTOSeasonID(dTOSeasonID);
		},

		/**
		 * @param		String		dTOSeasonName
		 */
		setDTOSeasonName : function(dTOSeasonName){
			_setDTOSeasonName(dTOSeasonName);
		},

		/**
		 * @param		String		dTOSeriesDescription
		 */
		setDTOSeriesDescription : function(dTOSeriesDescription){
			_setDTOSeriesDescription(dTOSeriesDescription);
		},

		/**
		 * @param		String		dTOSeriesID
		 */
		setDTOSeriesID : function(dTOSeriesID){
			_setDTOSeriesID(dTOSeriesID);
		},

		/**
		 * @param		String		dTOShortEpisodeDescription
		 */
		setDTOShortEpisodeDescription : function(dTOShortEpisodeDescription){
			_setDTOShortEpisodeDescription(dTOShortEpisodeDescription);
		},

		/**
		 * @param		String		dTOShortDescription
		 */
		setDTOShortDescription : function(dTOShortDescription){
			_setDTOShortDescription(dTOShortDescription);
		},

		/**
		 * @param		Boolean		eMDeliveryAsset
		 */
		setEMDeliveryAsset : function(eMDeliveryAsset){
			_setEMDeliveryAsset(eMDeliveryAsset);
		},

		/**
		 * @param		String		episodeName
		 */
		setEpisodeName : function(episodeName){
			_setEpisodeName(episodeName);
		},

		/**
		 * @param		Number		episodeNumber
		 */
		setEpisodeNumber : function(episodeNumber){
			_setEpisodeNumber(episodeNumber);
		},

		/**
		 * @param		Boolean		forceDTOexportXML
		 */
		setForceDTOexportXML : function(forceDTOexportXML){
			_setForceDTOexportXML(forceDTOexportXML);
		},

		/**
		 * @param		Boolean		forceDTOproxyAsset
		 */
		setForceDTOproxyAsset : function(forceDTOproxyAsset){
			_setForceDTOproxyAsset(forceDTOproxyAsset);
		},

		/**
		 * @param		String		genre
		 */
		setGenre : function(genre){
			_setGenre(genre);
		},

		/**
		 * @param		String		keywords
		 */
		setKeywords : function(keywords){
			_setKeywords(keywords);
		},

		/**
		 * @param		String		licenseStartDate
		 */
		setLicenseStartDate : function(licenseStartDate){
			_setLicenseStartDate(licenseStartDate);
		},

		/**
		 * @param		Boolean		localEntity
		 */
		setLocalEntity : function(localEntity){
			_setLocalEntity(localEntity);
		},

		/**
		 * @param		String		location
		 */
		setLocation : function(location){
			_setLocation(location);
		},

		/**
		 * @param		String		mediaType
		 */
		setMediaType : function(mediaType){
			_setMediaType(mediaType);
		},

		/**
		 * @param		String		metadataSet
		 */
		setMetadataSet : function(metadataSet){
			_setMetadataSet(metadataSet);
		},

		/**
		 * @param		String		network
		 */
		setNetwork : function(network){
			_setNetwork(network);
		},

		/**
		 * @param		String		owner
		 */
		setOwner : function(owner){
			_setOwner(owner);
		},

		/**
		 * @param		String		ratingsOverride
		 */
		setRatingsOverride : function(ratingsOverride){
			_setRatingsOverride(ratingsOverride);
		},

		/**
		 * @param		String		ratingSystem
		 */
		setRatingSystem : function(ratingSystem){
			_setRatingSystem(ratingSystem);
		},

		/**
		 * @param		String		releaseYear
		 */
		setReleaseYear : function(releaseYear){
			_setReleaseYear(releaseYear);
		},

		/**
		 * @param		String		seasonDescription
		 */
		setSeasonDescription : function(seasonDescription){
			_setSeasonDescription(seasonDescription);
		},

		/**
		 * @param		String		seasonLanguage
		 */
		setSeasonLanguage : function(seasonLanguage){
			_setSeasonLanguage(seasonLanguage);
		},

		/**
		 * @param		String		seasonName
		 */
		setSeasonName : function(seasonName){
			_setSeasonName(seasonName);
		},

		/**
		 * @param		String		seasonNumber
		 */
		setSeasonNumber : function(seasonNumber){
			_setSeasonNumber(seasonNumber);
		},

		/**
		 * @param		String		seasonOverride
		 */
		setSeasonOverride : function(seasonOverride){
			_setSeasonOverride(seasonOverride);
		},

		/**
		 * @param		String		seriesDescription
		 */
		setSeriesDescription : function(seriesDescription){
			_setSeriesDescription(seriesDescription);
		},

		/**
		 * @param		String		seriesName
		 */
		setSeriesName : function(seriesName){
			_setSeriesName(seriesName);
		},

		/**
		 * @param		String		status
		 */
		setStatus : function(status){
			_setStatus(status);
		},

		/**
		 * @param		Boolean		storeandtrackversionsofthisasset
		 */
		setStoreandtrackversionsofthisasset : function(storeandtrackversionsofthisasset){
			_setStoreandtrackversionsofthisasset(storeandtrackversionsofthisasset);
		},

		/**
		 * @param		String		syndicationPartnerDelivery
		 */
		setSyndicationPartnerDelivery : function(syndicationPartnerDelivery){
			_setSyndicationPartnerDelivery(syndicationPartnerDelivery);
		},

		/**
		 * @param		String		title
		 */
		setTitle : function(title){
			_setTitle(title);
		},

		/**
		 * @param		String		tVRating
		 */
		setTVRating : function(tVRating){
			_setTVRating(tVRating);
		},

		/**
		 * @return		Number
		 */
		getId : function(){
			return _getId();
		},

		/**
		 * @return		String
		 */
		getAirDate : function(){
			return _getAirDate();
		},

		/**
		 * @return		String
		 */
		getArchiveStatus : function(){
			return _getArchiveStatus();
		},

		/**
		 * @return		String
		 */
		getAssetGUID : function(){
			return _getAssetGUID();
		},

		/**
		 * @return		Number
		 */
		getAssetID : function(){
			return _getAssetID();
		},

		/**
		 * @return		String
		 */
		getAuthor : function(){
			return _getAuthor();
		},

		/**
		 * @return		String
		 */
		getCategory : function(){
			return _getCategory();
		},

		/**
		 * @return		String
		 */
		getCopyrightHolder : function(){
			return _getCopyrightHolder();
		},

		/**
		 * @return		String
		 */
		getDescription : function(){
			return _getDescription();
		},

		/**
		 * @return		Boolean
		 */
		getDTOAssetXMLExportstage1 : function(){
			return _getDTOAssetXMLExportstage1();
		},

		/**
		 * @return		String
		 */
		getDTOContainerPosition : function(){
			return _getDTOContainerPosition();
		},

		/**
		 * @return		String
		 */
		getDTOCopyrightHolder : function(){
			return _getDTOCopyrightHolder();
		},

		/**
		 * @return		String
		 */
		getDTOEpisodeID : function(){
			return _getDTOEpisodeID();
		},

		/**
		 * @return		String
		 */
		getDTOEpisodeName : function(){
			return _getDTOEpisodeName();
		},

		/**
		 * @return		String
		 */
		getDTOGenre : function(){
			return _getDTOGenre();
		},

		/**
		 * @return		String
		 */
		getDTOLongDescription : function(){
			return _getDTOLongDescription();
		},

		/**
		 * @return		String
		 */
		getDTOLongEpisodeDescription : function(){
			return _getDTOLongEpisodeDescription();
		},

		/**
		 * @return		String
		 */
		getDTORatings : function(){
			return _getDTORatings();
		},

		/**
		 * @return		String
		 */
		getDTOReleaseDate : function(){
			return _getDTOReleaseDate();
		},

		/**
		 * @return		String
		 */
		getDTOSalesPrice : function(){
			return _getDTOSalesPrice();
		},

		/**
		 * @return		String
		 */
		getDTOSeasonID : function(){
			return _getDTOSeasonID();
		},

		/**
		 * @return		String
		 */
		getDTOSeasonName : function(){
			return _getDTOSeasonName();
		},

		/**
		 * @return		String
		 */
		getDTOSeriesDescription : function(){
			return _getDTOSeriesDescription();
		},

		/**
		 * @return		String
		 */
		getDTOSeriesID : function(){
			return _getDTOSeriesID();
		},

		/**
		 * @return		String
		 */
		getDTOShortEpisodeDescription : function(){
			return _getDTOShortEpisodeDescription();
		},

		/**
		 * @return		String
		 */
		getDTOShortDescription : function(){
			return _getDTOShortDescription();
		},

		/**
		 * @return		Boolean
		 */
		getEMDeliveryAsset : function(){
			return _getEMDeliveryAsset();
		},

		/**
		 * @return		String
		 */
		getEpisodeName : function(){
			return _getEpisodeName();
		},

		/**
		 * @return		Number
		 */
		getEpisodeNumber : function(){
			return _getEpisodeNumber();
		},

		/**
		 * @return		Boolean
		 */
		getForceDTOexportXML : function(){
			return _getForceDTOexportXML();
		},

		/**
		 * @return		Boolean
		 */
		getForceDTOproxyAsset : function(){
			return _getForceDTOproxyAsset();
		},

		/**
		 * @return		String
		 */
		getGenre : function(){
			return _getGenre();
		},

		/**
		 * @return		String
		 */
		getKeywords : function(){
			return _getKeywords();
		},

		/**
		 * @return		String
		 */
		getLicenseStartDate : function(){
			return _getLicenseStartDate();
		},

		/**
		 * @return		Boolean
		 */
		getLocalEntity : function(){
			return _getLocalEntity();
		},

		/**
		 * @return		String
		 */
		getLocation : function(){
			return _getLocation();
		},

		/**
		 * @return		String
		 */
		getMediaType : function(){
			return _getMediaType();
		},

		/**
		 * @return		String
		 */
		getMetadataSet : function(){
			return _getMetadataSet();
		},

		/**
		 * @return		String
		 */
		getNetwork : function(){
			return _getNetwork();
		},

		/**
		 * @return		String
		 */
		getOwner : function(){
			return _getOwner();
		},

		/**
		 * @return		String
		 */
		getRatingsOverride : function(){
			return _getRatingsOverride();
		},

		/**
		 * @return		String
		 */
		getRatingSystem : function(){
			return _getRatingSystem();
		},

		/**
		 * @return		String
		 */
		getReleaseYear : function(){
			return _getReleaseYear();
		},

		/**
		 * @return		String
		 */
		getSeasonDescription : function(){
			return _getSeasonDescription();
		},

		/**
		 * @return		String
		 */
		getSeasonLanguage : function(){
			return _getSeasonLanguage();
		},

		/**
		 * @return		String
		 */
		getSeasonName : function(){
			return _getSeasonName();
		},

		/**
		 * @return		String
		 */
		getSeasonNumber : function(){
			return _getSeasonNumber();
		},

		/**
		 * @return		String
		 */
		getSeasonOverride : function(){
			return _getSeasonOverride();
		},

		/**
		 * @return		String
		 */
		getSeriesDescription : function(){
			return _getSeriesDescription();
		},

		/**
		 * @return		String
		 */
		getSeriesName : function(){
			return _getSeriesName();
		},

		/**
		 * @return		String
		 */
		getStatus : function(){
			return _getStatus();
		},

		/**
		 * @return		Boolean
		 */
		getStoreandtrackversionsofthisasset : function(){
			return _getStoreandtrackversionsofthisasset();
		},

		/**
		 * @return		String
		 */
		getSyndicationPartnerDelivery : function(){
			return _getSyndicationPartnerDelivery();
		},

		/**
		 * @return		String
		 */
		getTitle : function(){
			return _getTitle();
		},

		/**
		 * @return		String
		 */
		getTVRating : function(){
			return _getTVRating();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};