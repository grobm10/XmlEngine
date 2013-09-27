/**
 * This class represents a Region
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Region = function(genericObj) {

	/**
	 * @var		String
	 */
	var _code = '';

	/**
	 * @var		String
	 */
	var _country = '';

	/**
	 * @var		Language
	 */
	var _language = new Language();

	/**
	 * Constructor
	 */
	var init = function() {
		if(Validator.IsInstanceOf('Object', genericObj)){
			$.each(genericObj, function(property, value){
				switch (property.toUpperCase()) {
					case 'CODE':
						_setCode(value);
						break;
					case 'COUNTRY':
						_setCountry(value);
						break;
					case 'LANGUAGE':
						_setLanguage(value);
						break;
				}
			});
		}
	};

	/**
	 * @param		String		code
	 */
	var _setCode = function(code){
		_code = String(code);
	};

	/**
	 * @param		String		country
	 */
	var _setCountry = function(country){
		_country = String(country);
	};

	/**
	 * @param		Language		language
	 */
	var _setLanguage = function(language){
		if(Validator.IsInstanceOf('Object', language)){
			_language = new Language(language);
		} else {
			console.error('Function expects an object as param. ( Region.setLanguage )');
		}
	};

	/**
	 * @return		String
	 */
	var _getCode = function(){
		return _code;
	};

	/**
	 * @return		String
	 */
	var _getCountry = function(){
		return _country;
	};

	/**
	 * @return		Language
	 */
	var _getLanguage = function(){
		return _language;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"code":_code,
				"country":_country,
				"language":_language
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
		 * @param		String		code
		 */
		setCode : function(code){
			_setCode(code);
		},

		/**
		 * @param		String		country
		 */
		setCountry : function(country){
			_setCountry(country);
		},

		/**
		 * @param		Language		language
		 */
		setLanguage : function(language){
			_setLanguage(language);
		},

		/**
		 * @return		String
		 */
		getCode : function(){
			return _getCode();
		},

		/**
		 * @return		String
		 */
		getCountry : function(){
			return _getCountry();
		},

		/**
		 * @return		Language
		 */
		getLanguage : function(){
			return _getLanguage();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};