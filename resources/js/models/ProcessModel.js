/**
 * This class  performs server queries for Process
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var ProcessModel = function(){ };

/**
 * Saves a Process in the server
 *
 * @param		Process			process
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.Save = function(process, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'save',
		params : process
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Process from the server and gives it to the callback function
 *
 * @param		int				processId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FindById = function(processId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FindById',
		params : processId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Process(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Processs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Processs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Processs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FindByTypeProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FindByTypeProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FindByTypeProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Processs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FindByStateProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FindByStateProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FindByStateProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Processs from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FindByBundleProperties = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FindByBundleProperties',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FindByBundleProperties()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Processs from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Processs from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var processsArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					processsArray.push(new Process(genericObject));
				});
				uiFunction(processsArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Process stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
ProcessModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'process',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var processCount = parseInt(data.replace('"',''));
				uiFunction(processCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.ProcessModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};