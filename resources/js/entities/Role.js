/**
 * This class represents a Role
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Role = function(genericObj) {

	/**
	 * @var		Number
	 */
	var _id = 0;

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
					case 'ID':
						_setId(value);
						break;
					case 'NAME':
						_setName(value);
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
	 * @param		String		name
	 */
	var _setName = function(name){
		_name = String(name);
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
	var _getName = function(){
		return _name;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
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
		 * @param		Number		id
		 */
		setId : function(id){
			_setId(id);
		},

		/**
		 * @param		String		name
		 */
		setName : function(name){
			_setName(name);
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