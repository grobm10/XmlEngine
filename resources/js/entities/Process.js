/**
 * This class represents a Process
 *
 * @author		David Curras
 * @version		February 25, 2013
 */
var Process = function(genericObj) {

	/**
	 * @var		Number
	 */
	var _id = 0;

	/**
	 * @var		Type
	 */
	var _type = new Type();

	/**
	 * @var		State
	 */
	var _state = new State();

	/**
	 * @var		String
	 */
	var _processDate = '';

	/**
	 * @var		Bundle
	 */
	var _bundle = new Bundle();

	/**
	 * @var		String
	 */
	var _issues = '';

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
					case 'TYPE':
						_setType(value);
						break;
					case 'STATE':
						_setState(value);
						break;
					case 'PROCESSDATE':
						_setProcessDate(value);
						break;
					case 'BUNDLE':
						_setBundle(value);
						break;
					case 'ISSUES':
						_setIssues(value);
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
	 * @param		Type		type
	 */
	var _setType = function(type){
		if(Validator.IsInstanceOf('Object', type)){
			_type = new Type(type);
		} else {
			console.error('Function expects an object as param. ( Process.setType )');
		}
	};

	/**
	 * @param		State		state
	 */
	var _setState = function(state){
		if(Validator.IsInstanceOf('Object', state)){
			_state = new State(state);
		} else {
			console.error('Function expects an object as param. ( Process.setState )');
		}
	};

	/**
	 * @param		String		processDate
	 */
	var _setProcessDate = function(processDate){
		_processDate = String(processDate);
	};

	/**
	 * @param		Bundle		bundle
	 */
	var _setBundle = function(bundle){
		if(Validator.IsInstanceOf('Object', bundle)){
			_bundle = new Bundle(bundle);
		} else {
			console.error('Function expects an object as param. ( Process.setBundle )');
		}
	};

	/**
	 * @param		String		issues
	 */
	var _setIssues = function(issues){
		_issues = String(issues);
	};

	/**
	 * @return		Number
	 */
	var _getId = function(){
		return _id;
	};

	/**
	 * @return		Type
	 */
	var _getType = function(){
		return _type;
	};

	/**
	 * @return		State
	 */
	var _getState = function(){
		return _state;
	};

	/**
	 * @return		String
	 */
	var _getProcessDate = function(){
		return _processDate;
	};

	/**
	 * @return		Bundle
	 */
	var _getBundle = function(){
		return _bundle;
	};

	/**
	 * @return		String
	 */
	var _getIssues = function(){
		return _issues;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
				"type":_type,
				"state":_state,
				"processDate":_processDate,
				"bundle":_bundle,
				"issues":_issues
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
		 * @param		Type		type
		 */
		setType : function(type){
			_setType(type);
		},

		/**
		 * @param		State		state
		 */
		setState : function(state){
			_setState(state);
		},

		/**
		 * @param		String		processDate
		 */
		setProcessDate : function(processDate){
			_setProcessDate(processDate);
		},

		/**
		 * @param		Bundle		bundle
		 */
		setBundle : function(bundle){
			_setBundle(bundle);
		},

		/**
		 * @param		String		issues
		 */
		setIssues : function(issues){
			_setIssues(issues);
		},

		/**
		 * @return		Number
		 */
		getId : function(){
			return _getId();
		},

		/**
		 * @return		Type
		 */
		getType : function(){
			return _getType();
		},

		/**
		 * @return		State
		 */
		getState : function(){
			return _getState();
		},

		/**
		 * @return		String
		 */
		getProcessDate : function(){
			return _getProcessDate();
		},

		/**
		 * @return		Bundle
		 */
		getBundle : function(){
			return _getBundle();
		},

		/**
		 * @return		String
		 */
		getIssues : function(){
			return _getIssues();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};