/**
 * This class represents a User
 *
 * @author		David Curras
 * @version		December 4, 2012
 */
var User = function(genericObj) {

	/**
	 * @var		String
	 */
	var _id = '';

	/**
	 * @var		String
	 */
	var _password = '';

	/**
	 * @var		String
	 */
	var _name = '';

	/**
	 * @var		String
	 */
	var _lastActionDate = '';

	/**
	 * @var		Role
	 */
	var _role = new Role();

	/**
	 * @var		Boolean
	 */
	var _active = false;

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
					case 'PASSWORD':
						_setPassword(value);
						break;
					case 'NAME':
						_setName(value);
						break;
					case 'LASTACTIONDATE':
						_setLastActionDate(value);
						break;
					case 'ROLE':
						_setRole(value);
						break;
					case 'ACTIVE':
						_setActive(value);
						break;
				}
			});
		}
	};

	/**
	 * @param		String		id
	 */
	var _setId = function(id){
		_id = String(id);
	};

	/**
	 * @param		String		password
	 */
	var _setPassword = function(password){
		_password = String(password);
	};

	/**
	 * @param		String		name
	 */
	var _setName = function(name){
		_name = String(name);
	};

	/**
	 * @param		String		lastActionDate
	 */
	var _setLastActionDate = function(lastActionDate){
		_lastActionDate = String(lastActionDate);
	};

	/**
	 * @param		Role		role
	 */
	var _setRole = function(role){
		if(Validator.IsInstanceOf('Object', role)){
			_role = new Role(role);
		} else {
			console.error('Function expects an object as param. ( User.setRole )');
		}
	};

	/**
	 * @param		Boolean		active
	 */
	var _setActive = function(active){
		_active = Boolean(active);
	};

	/**
	 * @return		String
	 */
	var _getId = function(){
		return _id;
	};

	/**
	 * @return		String
	 */
	var _getPassword = function(){
		return _password;
	};

	/**
	 * @return		String
	 */
	var _getName = function(){
		return _name;
	};

	/**
	 * @return		String
	 */
	var _getLastActionDate = function(){
		return _lastActionDate;
	};

	/**
	 * @return		Role
	 */
	var _getRole = function(){
		return _role;
	};

	/**
	 * @return		Boolean
	 */
	var _getActive = function(){
		return _active;
	};

	/**
	 * @return		JSON
	 */
	var _convertToArray = function(){
		return {
				"id":_id,
				"password":_password,
				"name":_name,
				"lastActionDate":_lastActionDate,
				"role":_role,
				"active":_active
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
		 * @param		String		id
		 */
		setId : function(id){
			_setId(id);
		},

		/**
		 * @param		String		password
		 */
		setPassword : function(password){
			_setPassword(password);
		},

		/**
		 * @param		String		name
		 */
		setName : function(name){
			_setName(name);
		},

		/**
		 * @param		String		lastActionDate
		 */
		setLastActionDate : function(lastActionDate){
			_setLastActionDate(lastActionDate);
		},

		/**
		 * @param		Role		role
		 */
		setRole : function(role){
			_setRole(role);
		},

		/**
		 * @param		Boolean		active
		 */
		setActive : function(active){
			_setActive(active);
		},

		/**
		 * @return		String
		 */
		getId : function(){
			return _getId();
		},

		/**
		 * @return		String
		 */
		getPassword : function(){
			return _getPassword();
		},

		/**
		 * @return		String
		 */
		getName : function(){
			return _getName();
		},

		/**
		 * @return		String
		 */
		getLastActionDate : function(){
			return _getLastActionDate();
		},

		/**
		 * @return		Role
		 */
		getRole : function(){
			return _getRole();
		},

		/**
		 * @return		Boolean
		 */
		getActive : function(){
			return _getActive();
		},

		/**
		 * @return		JSON
		 */
		convertToArray : function(){
			return _convertToArray();
		}
	};
};