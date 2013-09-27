/**
 * This class  performs server queries for Type
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var TypeModel = function(){ };

/**
 * Saves a Type in the server
 *
 * @param		Type			type
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.Save = function(type, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'save',
		params : type
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Type from the server and gives it to the callback function
 *
 * @param		int				typeId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.FindById = function(typeId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'FindById',
		params : typeId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Type(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Types from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var typesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					typesArray.push(new Type(genericObject));
				});
				uiFunction(typesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Types from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var typesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					typesArray.push(new Type(genericObject));
				});
				uiFunction(typesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Types from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var typesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					typesArray.push(new Type(genericObject));
				});
				uiFunction(typesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Types from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var typesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					typesArray.push(new Type(genericObject));
				});
				uiFunction(typesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Type stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
TypeModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'type',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var typeCount = parseInt(data.replace('"',''));
				uiFunction(typeCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.TypeModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};