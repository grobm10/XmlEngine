/**
 * This class  performs server queries for Log
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var LogModel = function(){ };

/**
 * Saves a Log in the server
 *
 * @param		Log			log
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.Save = function(log, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'save',
		params : log
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Log from the server and gives it to the callback function
 *
 * @param		int				logId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.FindById = function(logId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'FindById',
		params : logId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Log(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Logs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var logsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					logsArray.push(new Log(genericObject));
				});
				uiFunction(logsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Logs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var logsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					logsArray.push(new Log(genericObject));
				});
				uiFunction(logsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Logs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.FindByProcessProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'FindByProcessProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var logsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					logsArray.push(new Log(genericObject));
				});
				uiFunction(logsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.FindByProcessProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Logs from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var logsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					logsArray.push(new Log(genericObject));
				});
				uiFunction(logsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Logs from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var logsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					logsArray.push(new Log(genericObject));
				});
				uiFunction(logsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Log stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
LogModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'log',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var logCount = parseInt(data.replace('"',''));
				uiFunction(logCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.LogModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};