/**
 * This class represents a Log
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var Log = function(genericObj) {

	/**
	 * @var		Number
	 */
	var _id = 0;

	/**
	 * @var		Process
	 */
	var _process = new Process();

	/**
	 * @var		String
	 */
	var _description = '';

	/**
	 * @var		Boolean
	 */
	var _isError = false;

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
					case 'PROCESS':
						_setProcess(value);
						break;
					case 'DESCRIPTION':
						_setDescription(value);
						break;
					case 'ISERROR':
						_setIsError(value);
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
	 * @param		Process		process
	 */
	var _setProcess = function(process){
		if(Validator.IsInstanceOf('Object', process)){
			_process = new Process(process);
		} else {
			console.error('Function expects an object as param. ( Log.setProcess )');
		}
	};

	/**
	 * @param		String		description
	 */
	var _setDescription = function(description){
		_description = String(description);
	};

	/**
	 * @param		Boolean		isError
	 */
	var _setIsError = function(isError){
		_isError = Boolean(isError);
	};

	/**
	 * @return		Number
	 */
	var _getId = function(){
		return _id;
	};

	/**
	 * @return		Process
	 */
	var _getProcess = function(){
		return _process;
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
	var _getIsError = function(){
		return _isError;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
				"process":_process,
				"description":_description,
				"isError":_isError
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
		 * @param		Process		process
		 */
		setProcess : function(process){
			_setProcess(process);
		},

		/**
		 * @param		String		description
		 */
		setDescription : function(description){
			_setDescription(description);
		},

		/**
		 * @param		Boolean		isError
		 */
		setIsError : function(isError){
			_setIsError(isError);
		},

		/**
		 * @return		Number
		 */
		getId : function(){
			return _getId();
		},

		/**
		 * @return		Process
		 */
		getProcess : function(){
			return _getProcess();
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
		getIsError : function(){
			return _getIsError();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};