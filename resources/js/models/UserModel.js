/**
 * This class  performs server queries for User
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var UserModel = function(){ };

/**
 * Saves a User in the server
 *
 * @param		User			user
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.Save = function(user, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'save',
		params : user
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a User from the server and gives it to the callback function
 *
 * @param		int				userId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.FindById = function(userId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'FindById',
		params : userId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new User(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Users from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var usersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					usersArray.push(new User(genericObject));
				});
				uiFunction(usersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Users from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var usersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					usersArray.push(new User(genericObject));
				});
				uiFunction(usersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Users from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.FindByRoleProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'FindByRoleProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var usersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					usersArray.push(new User(genericObject));
				});
				uiFunction(usersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.FindByRoleProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Users from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var usersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					usersArray.push(new User(genericObject));
				});
				uiFunction(usersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Users from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var usersArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					usersArray.push(new User(genericObject));
				});
				uiFunction(usersArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of User stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
UserModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'user',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var userCount = parseInt(data.replace('"',''));
				uiFunction(userCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.UserModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};