/**
 * This class  performs server queries for State
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var StateModel = function(){ };

/**
 * Saves a State in the server
 *
 * @param		State			state
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.Save = function(state, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'save',
		params : state
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a State from the server and gives it to the callback function
 *
 * @param		int				stateId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.FindById = function(stateId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'FindById',
		params : stateId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new State(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves States from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var statesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					statesArray.push(new State(genericObject));
				});
				uiFunction(statesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves States from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var statesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					statesArray.push(new State(genericObject));
				});
				uiFunction(statesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all States from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var statesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					statesArray.push(new State(genericObject));
				});
				uiFunction(statesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all States from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var statesArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					statesArray.push(new State(genericObject));
				});
				uiFunction(statesArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of State stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
StateModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'state',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var stateCount = parseInt(data.replace('"',''));
				uiFunction(stateCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.StateModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};