/**
 * This class represents a Bundle
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Bundle = function(genericObj) {

	/**
	 * @var		Number
	 */
	var _id = 0;

	/**
	 * @var		Video
	 */
	var _video = new Video();

	/**
	 * @var		Language
	 */
	var _language = new Language();

	/**
	 * @var		Region
	 */
	var _region = new Region();

	/**
	 * @var		Partner
	 */
	var _partner = new Partner();

	/**
	 * @var		String
	 */
	var _entityId = '';

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
					case 'VIDEO':
						_setVideo(value);
						break;
					case 'LANGUAGE':
						_setLanguage(value);
						break;
					case 'REGION':
						_setRegion(value);
						break;
					case 'PARTNER':
						_setPartner(value);
						break;
					case 'ENTITYID':
						_setEntityId(value);
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
	 * @param		Video		video
	 */
	var _setVideo = function(video){
		if(Validator.IsInstanceOf('Object', video)){
			_video = new Video(video);
		} else {
			console.error('Function expects an object as param. ( Bundle.setVideo )');
		}
	};

	/**
	 * @param		Language		language
	 */
	var _setLanguage = function(language){
		if(Validator.IsInstanceOf('Object', language)){
			_language = new Language(language);
		} else {
			console.error('Function expects an object as param. ( Bundle.setLanguage )');
		}
	};

	/**
	 * @param		Region		region
	 */
	var _setRegion = function(region){
		if(Validator.IsInstanceOf('Object', region)){
			_region = new Region(region);
		} else {
			console.error('Function expects an object as param. ( Bundle.setRegion )');
		}
	};

	/**
	 * @param		Partner		partner
	 */
	var _setPartner = function(partner){
		if(Validator.IsInstanceOf('Object', partner)){
			_partner = new Partner(partner);
		} else {
			console.error('Function expects an object as param. ( Bundle.setPartner )');
		}
	};

	/**
	 * @param		String		entityId
	 */
	var _setEntityId = function(entityId){
		_entityId = String(entityId);
	};

	/**
	 * @return		Number
	 */
	var _getId = function(){
		return _id;
	};

	/**
	 * @return		Video
	 */
	var _getVideo = function(){
		return _video;
	};

	/**
	 * @return		Language
	 */
	var _getLanguage = function(){
		return _language;
	};

	/**
	 * @return		Region
	 */
	var _getRegion = function(){
		return _region;
	};

	/**
	 * @return		Partner
	 */
	var _getPartner = function(){
		return _partner;
	};

	/**
	 * @return		String
	 */
	var _getEntityId = function(){
		return _entityId;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
				"video":_video,
				"language":_language,
				"region":_region,
				"partner":_partner,
				"entityId":_entityId
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
		 * @param		Video		video
		 */
		setVideo : function(video){
			_setVideo(video);
		},

		/**
		 * @param		Language		language
		 */
		setLanguage : function(language){
			_setLanguage(language);
		},

		/**
		 * @param		Region		region
		 */
		setRegion : function(region){
			_setRegion(region);
		},

		/**
		 * @param		Partner		partner
		 */
		setPartner : function(partner){
			_setPartner(partner);
		},

		/**
		 * @param		String		entityId
		 */
		setEntityId : function(entityId){
			_setEntityId(entityId);
		},

		/**
		 * @return		Number
		 */
		getId : function(){
			return _getId();
		},

		/**
		 * @return		Video
		 */
		getVideo : function(){
			return _getVideo();
		},

		/**
		 * @return		Language
		 */
		getLanguage : function(){
			return _getLanguage();
		},

		/**
		 * @return		Region
		 */
		getRegion : function(){
			return _getRegion();
		},

		/**
		 * @return		Partner
		 */
		getPartner : function(){
			return _getPartner();
		},

		/**
		 * @return		String
		 */
		getEntityId : function(){
			return _getEntityId();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};