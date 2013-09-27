/**
 * This class  performs server queries for Role
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var RoleModel = function(){ };

/**
 * Saves a Role in the server
 *
 * @param		Role			role
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.Save = function(role, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'save',
		params : role
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Role from the server and gives it to the callback function
 *
 * @param		int				roleId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.FindById = function(roleId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'FindById',
		params : roleId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Role(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Roles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var rolesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					rolesArray.push(new Role(genericObject));
				});
				uiFunction(rolesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Roles from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var rolesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					rolesArray.push(new Role(genericObject));
				});
				uiFunction(rolesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Roles from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var rolesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					rolesArray.push(new Role(genericObject));
				});
				uiFunction(rolesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Roles from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var rolesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					rolesArray.push(new Role(genericObject));
				});
				uiFunction(rolesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Role stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
RoleModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'role',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var roleCount = parseInt(data.replace('"',''));
				uiFunction(roleCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.RoleModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};