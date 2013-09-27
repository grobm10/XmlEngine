/**
 * This class represents a Video
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Video = function(genericObj) {

	/**
	 * @var		Number
	 */
	var _id = 0;

	/**
	 * @var		Metadata
	 */
	var _metadata = new Metadata();

	/**
	 * @var		String
	 */
	var _audioCodec = '';

	/**
	 * @var		String
	 */
	var _createdBy = '';

	/**
	 * @var		String
	 */
	var _creationDate = '';

	/**
	 * @var		String
	 */
	var _dTOVideoType = '';

	/**
	 * @var		String
	 */
	var _duration = '';

	/**
	 * @var		String
	 */
	var _fileCreateDate = '';

	/**
	 * @var		String
	 */
	var _fileModificationDate = '';

	/**
	 * @var		String
	 */
	var _fileName = '';

	/**
	 * @var		String
	 */
	var _imageSize = '';

	/**
	 * @var		String
	 */
	var _lastAccessed = '';

	/**
	 * @var		String
	 */
	var _lastModified = '';

	/**
	 * @var		String
	 */
	var _mD5Hash = '';

	/**
	 * @var		Boolean
	 */
	var _mD5HashRecal = false;

	/**
	 * @var		String
	 */
	var _mimeType = '';

	/**
	 * @var		String
	 */
	var _size = '';

	/**
	 * @var		String
	 */
	var _storedOn = '';

	/**
	 * @var		String
	 */
	var _timecodeOffset = '';

	/**
	 * @var		String
	 */
	var _videoBitrate = '';

	/**
	 * @var		String
	 */
	var _videoCodec = '';

	/**
	 * @var		String
	 */
	var _videoElements = '';

	/**
	 * @var		String
	 */
	var _videoFrameRate = '';

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
					case 'METADATA':
						_setMetadata(value);
						break;
					case 'AUDIOCODEC':
						_setAudioCodec(value);
						break;
					case 'CREATEDBY':
						_setCreatedBy(value);
						break;
					case 'CREATIONDATE':
						_setCreationDate(value);
						break;
					case 'DTOVIDEOTYPE':
						_setDTOVideoType(value);
						break;
					case 'DURATION':
						_setDuration(value);
						break;
					case 'FILECREATEDATE':
						_setFileCreateDate(value);
						break;
					case 'FILEMODIFICATIONDATE':
						_setFileModificationDate(value);
						break;
					case 'FILENAME':
						_setFileName(value);
						break;
					case 'IMAGESIZE':
						_setImageSize(value);
						break;
					case 'LASTACCESSED':
						_setLastAccessed(value);
						break;
					case 'LASTMODIFIED':
						_setLastModified(value);
						break;
					case 'MD5HASH':
						_setMD5Hash(value);
						break;
					case 'MD5HASHRECAL':
						_setMD5HashRecal(value);
						break;
					case 'MIMETYPE':
						_setMimeType(value);
						break;
					case 'SIZE':
						_setSize(value);
						break;
					case 'STOREDON':
						_setStoredOn(value);
						break;
					case 'TIMECODEOFFSET':
						_setTimecodeOffset(value);
						break;
					case 'VIDEOBITRATE':
						_setVideoBitrate(value);
						break;
					case 'VIDEOCODEC':
						_setVideoCodec(value);
						break;
					case 'VIDEOELEMENTS':
						_setVideoElements(value);
						break;
					case 'VIDEOFRAMERATE':
						_setVideoFrameRate(value);
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
	 * @param		Metadata		metadata
	 */
	var _setMetadata = function(metadata){
		if(Validator.IsInstanceOf('Object', metadata)){
			_metadata = new Metadata(metadata);
		} else {
			console.error('Function expects an object as param. ( Video.setMetadata )');
		}
	};

	/**
	 * @param		String		audioCodec
	 */
	var _setAudioCodec = function(audioCodec){
		_audioCodec = String(audioCodec);
	};

	/**
	 * @param		String		createdBy
	 */
	var _setCreatedBy = function(createdBy){
		_createdBy = String(createdBy);
	};

	/**
	 * @param		String		creationDate
	 */
	var _setCreationDate = function(creationDate){
		_creationDate = String(creationDate);
	};

	/**
	 * @param		String		dTOVideoType
	 */
	var _setDTOVideoType = function(dTOVideoType){
		_dTOVideoType = String(dTOVideoType);
	};

	/**
	 * @param		String		duration
	 */
	var _setDuration = function(duration){
		_duration = String(duration);
	};

	/**
	 * @param		String		fileCreateDate
	 */
	var _setFileCreateDate = function(fileCreateDate){
		_fileCreateDate = String(fileCreateDate);
	};

	/**
	 * @param		String		fileModificationDate
	 */
	var _setFileModificationDate = function(fileModificationDate){
		_fileModificationDate = String(fileModificationDate);
	};

	/**
	 * @param		String		fileName
	 */
	var _setFileName = function(fileName){
		_fileName = String(fileName);
	};

	/**
	 * @param		String		imageSize
	 */
	var _setImageSize = function(imageSize){
		_imageSize = String(imageSize);
	};

	/**
	 * @param		String		lastAccessed
	 */
	var _setLastAccessed = function(lastAccessed){
		_lastAccessed = String(lastAccessed);
	};

	/**
	 * @param		String		lastModified
	 */
	var _setLastModified = function(lastModified){
		_lastModified = String(lastModified);
	};

	/**
	 * @param		String		mD5Hash
	 */
	var _setMD5Hash = function(mD5Hash){
		_mD5Hash = String(mD5Hash);
	};

	/**
	 * @param		Boolean		mD5HashRecal
	 */
	var _setMD5HashRecal = function(mD5HashRecal){
		_mD5HashRecal = Boolean(mD5HashRecal);
	};

	/**
	 * @param		String		mimeType
	 */
	var _setMimeType = function(mimeType){
		_mimeType = String(mimeType);
	};

	/**
	 * @param		String		size
	 */
	var _setSize = function(size){
		_size = String(size);
	};

	/**
	 * @param		String		storedOn
	 */
	var _setStoredOn = function(storedOn){
		_storedOn = String(storedOn);
	};

	/**
	 * @param		String		timecodeOffset
	 */
	var _setTimecodeOffset = function(timecodeOffset){
		_timecodeOffset = String(timecodeOffset);
	};

	/**
	 * @param		String		videoBitrate
	 */
	var _setVideoBitrate = function(videoBitrate){
		_videoBitrate = String(videoBitrate);
	};

	/**
	 * @param		String		videoCodec
	 */
	var _setVideoCodec = function(videoCodec){
		_videoCodec = String(videoCodec);
	};

	/**
	 * @param		String		videoElements
	 */
	var _setVideoElements = function(videoElements){
		_videoElements = String(videoElements);
	};

	/**
	 * @param		String		videoFrameRate
	 */
	var _setVideoFrameRate = function(videoFrameRate){
		_videoFrameRate = String(videoFrameRate);
	};

	/**
	 * @return		Number
	 */
	var _getId = function(){
		return _id;
	};

	/**
	 * @return		Metadata
	 */
	var _getMetadata = function(){
		return _metadata;
	};

	/**
	 * @return		String
	 */
	var _getAudioCodec = function(){
		return _audioCodec;
	};

	/**
	 * @return		String
	 */
	var _getCreatedBy = function(){
		return _createdBy;
	};

	/**
	 * @return		String
	 */
	var _getCreationDate = function(){
		return _creationDate;
	};

	/**
	 * @return		String
	 */
	var _getDTOVideoType = function(){
		return _dTOVideoType;
	};

	/**
	 * @return		String
	 */
	var _getDuration = function(){
		return _duration;
	};

	/**
	 * @return		String
	 */
	var _getFileCreateDate = function(){
		return _fileCreateDate;
	};

	/**
	 * @return		String
	 */
	var _getFileModificationDate = function(){
		return _fileModificationDate;
	};

	/**
	 * @return		String
	 */
	var _getFileName = function(){
		return _fileName;
	};

	/**
	 * @return		String
	 */
	var _getImageSize = function(){
		return _imageSize;
	};

	/**
	 * @return		String
	 */
	var _getLastAccessed = function(){
		return _lastAccessed;
	};

	/**
	 * @return		String
	 */
	var _getLastModified = function(){
		return _lastModified;
	};

	/**
	 * @return		String
	 */
	var _getMD5Hash = function(){
		return _mD5Hash;
	};

	/**
	 * @return		Boolean
	 */
	var _getMD5HashRecal = function(){
		return _mD5HashRecal;
	};

	/**
	 * @return		String
	 */
	var _getMimeType = function(){
		return _mimeType;
	};

	/**
	 * @return		String
	 */
	var _getSize = function(){
		return _size;
	};

	/**
	 * @return		String
	 */
	var _getStoredOn = function(){
		return _storedOn;
	};

	/**
	 * @return		String
	 */
	var _getTimecodeOffset = function(){
		return _timecodeOffset;
	};

	/**
	 * @return		String
	 */
	var _getVideoBitrate = function(){
		return _videoBitrate;
	};

	/**
	 * @return		String
	 */
	var _getVideoCodec = function(){
		return _videoCodec;
	};

	/**
	 * @return		String
	 */
	var _getVideoElements = function(){
		return _videoElements;
	};

	/**
	 * @return		String
	 */
	var _getVideoFrameRate = function(){
		return _videoFrameRate;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
				"metadata":_metadata,
				"audioCodec":_audioCodec,
				"createdBy":_createdBy,
				"creationDate":_creationDate,
				"dTOVideoType":_dTOVideoType,
				"duration":_duration,
				"fileCreateDate":_fileCreateDate,
				"fileModificationDate":_fileModificationDate,
				"fileName":_fileName,
				"imageSize":_imageSize,
				"lastAccessed":_lastAccessed,
				"lastModified":_lastModified,
				"mD5Hash":_mD5Hash,
				"mD5HashRecal":_mD5HashRecal,
				"mimeType":_mimeType,
				"size":_size,
				"storedOn":_storedOn,
				"timecodeOffset":_timecodeOffset,
				"videoBitrate":_videoBitrate,
				"videoCodec":_videoCodec,
				"videoElements":_videoElements,
				"videoFrameRate":_videoFrameRate
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
		 * @param		Metadata		metadata
		 */
		setMetadata : function(metadata){
			_setMetadata(metadata);
		},

		/**
		 * @param		String		audioCodec
		 */
		setAudioCodec : function(audioCodec){
			_setAudioCodec(audioCodec);
		},

		/**
		 * @param		String		createdBy
		 */
		setCreatedBy : function(createdBy){
			_setCreatedBy(createdBy);
		},

		/**
		 * @param		String		creationDate
		 */
		setCreationDate : function(creationDate){
			_setCreationDate(creationDate);
		},

		/**
		 * @param		String		dTOVideoType
		 */
		setDTOVideoType : function(dTOVideoType){
			_setDTOVideoType(dTOVideoType);
		},

		/**
		 * @param		String		duration
		 */
		setDuration : function(duration){
			_setDuration(duration);
		},

		/**
		 * @param		String		fileCreateDate
		 */
		setFileCreateDate : function(fileCreateDate){
			_setFileCreateDate(fileCreateDate);
		},

		/**
		 * @param		String		fileModificationDate
		 */
		setFileModificationDate : function(fileModificationDate){
			_setFileModificationDate(fileModificationDate);
		},

		/**
		 * @param		String		fileName
		 */
		setFileName : function(fileName){
			_setFileName(fileName);
		},

		/**
		 * @param		String		imageSize
		 */
		setImageSize : function(imageSize){
			_setImageSize(imageSize);
		},

		/**
		 * @param		String		lastAccessed
		 */
		setLastAccessed : function(lastAccessed){
			_setLastAccessed(lastAccessed);
		},

		/**
		 * @param		String		lastModified
		 */
		setLastModified : function(lastModified){
			_setLastModified(lastModified);
		},

		/**
		 * @param		String		mD5Hash
		 */
		setMD5Hash : function(mD5Hash){
			_setMD5Hash(mD5Hash);
		},

		/**
		 * @param		Boolean		mD5HashRecal
		 */
		setMD5HashRecal : function(mD5HashRecal){
			_setMD5HashRecal(mD5HashRecal);
		},

		/**
		 * @param		String		mimeType
		 */
		setMimeType : function(mimeType){
			_setMimeType(mimeType);
		},

		/**
		 * @param		String		size
		 */
		setSize : function(size){
			_setSize(size);
		},

		/**
		 * @param		String		storedOn
		 */
		setStoredOn : function(storedOn){
			_setStoredOn(storedOn);
		},

		/**
		 * @param		String		timecodeOffset
		 */
		setTimecodeOffset : function(timecodeOffset){
			_setTimecodeOffset(timecodeOffset);
		},

		/**
		 * @param		String		videoBitrate
		 */
		setVideoBitrate : function(videoBitrate){
			_setVideoBitrate(videoBitrate);
		},

		/**
		 * @param		String		videoCodec
		 */
		setVideoCodec : function(videoCodec){
			_setVideoCodec(videoCodec);
		},

		/**
		 * @param		String		videoElements
		 */
		setVideoElements : function(videoElements){
			_setVideoElements(videoElements);
		},

		/**
		 * @param		String		videoFrameRate
		 */
		setVideoFrameRate : function(videoFrameRate){
			_setVideoFrameRate(videoFrameRate);
		},

		/**
		 * @return		Number
		 */
		getId : function(){
			return _getId();
		},

		/**
		 * @return		Metadata
		 */
		getMetadata : function(){
			return _getMetadata();
		},

		/**
		 * @return		String
		 */
		getAudioCodec : function(){
			return _getAudioCodec();
		},

		/**
		 * @return		String
		 */
		getCreatedBy : function(){
			return _getCreatedBy();
		},

		/**
		 * @return		String
		 */
		getCreationDate : function(){
			return _getCreationDate();
		},

		/**
		 * @return		String
		 */
		getDTOVideoType : function(){
			return _getDTOVideoType();
		},

		/**
		 * @return		String
		 */
		getDuration : function(){
			return _getDuration();
		},

		/**
		 * @return		String
		 */
		getFileCreateDate : function(){
			return _getFileCreateDate();
		},

		/**
		 * @return		String
		 */
		getFileModificationDate : function(){
			return _getFileModificationDate();
		},

		/**
		 * @return		String
		 */
		getFileName : function(){
			return _getFileName();
		},

		/**
		 * @return		String
		 */
		getImageSize : function(){
			return _getImageSize();
		},

		/**
		 * @return		String
		 */
		getLastAccessed : function(){
			return _getLastAccessed();
		},

		/**
		 * @return		String
		 */
		getLastModified : function(){
			return _getLastModified();
		},

		/**
		 * @return		String
		 */
		getMD5Hash : function(){
			return _getMD5Hash();
		},

		/**
		 * @return		Boolean
		 */
		getMD5HashRecal : function(){
			return _getMD5HashRecal();
		},

		/**
		 * @return		String
		 */
		getMimeType : function(){
			return _getMimeType();
		},

		/**
		 * @return		String
		 */
		getSize : function(){
			return _getSize();
		},

		/**
		 * @return		String
		 */
		getStoredOn : function(){
			return _getStoredOn();
		},

		/**
		 * @return		String
		 */
		getTimecodeOffset : function(){
			return _getTimecodeOffset();
		},

		/**
		 * @return		String
		 */
		getVideoBitrate : function(){
			return _getVideoBitrate();
		},

		/**
		 * @return		String
		 */
		getVideoCodec : function(){
			return _getVideoCodec();
		},

		/**
		 * @return		String
		 */
		getVideoElements : function(){
			return _getVideoElements();
		},

		/**
		 * @return		String
		 */
		getVideoFrameRate : function(){
			return _getVideoFrameRate();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};