/**
 * This class represents a Language
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Language = function(genericObj) {

	/**
	 * @var		String
	 */
	var _code = '';

	/**
	 * @var		String
	 */
	var _alt = '';

	/**
	 * @var		String
	 */
	var _name = '';

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
					case 'ALT':
						_setAlt(value);
						break;
					case 'NAME':
						_setName(value);
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
	 * @param		String		alt
	 */
	var _setAlt = function(alt){
		_alt = String(alt);
	};

	/**
	 * @param		String		name
	 */
	var _setName = function(name){
		_name = String(name);
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
	var _getAlt = function(){
		return _alt;
	};

	/**
	 * @return		String
	 */
	var _getName = function(){
		return _name;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"code":_code,
				"alt":_alt,
				"name":_name
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
		 * @param		String		alt
		 */
		setAlt : function(alt){
			_setAlt(alt);
		},

		/**
		 * @param		String		name
		 */
		setName : function(name){
			_setName(name);
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
		getAlt : function(){
			return _getAlt();
		},

		/**
		 * @return		String
		 */
		getName : function(){
			return _getName();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};