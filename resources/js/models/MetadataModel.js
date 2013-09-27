/**
 * This class  performs server queries for Metadata
 *
 * @author		David Curras
 * @version		March 6, 2013
 */
var MetadataModel = function(){ };

/**
 * Saves a Metadata in the server
 *
 * @param		Metadata			metadata
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.Save = function(metadata, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'save',
		params : metadata
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				uiFunction(data, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.Save()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves a Metadata from the server and gives it to the callback function
 *
 * @param		int				metadataId
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.FindById = function(metadataId, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'FindById',
		params : metadataId
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObject = JSON.parse(data);
				uiFunction(new Metadata(genericObject), callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.FindById()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Metadatas from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.FindBy = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'FindBy',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var metadatasArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					metadatasArray.push(new Metadata(genericObject));
				});
				uiFunction(metadatasArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.FindBy()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves Metadatas from the server that matches the queryParams
 * filters and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'FindByMultipleValues',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var metadatasArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					metadatasArray.push(new Metadata(genericObject));
				});
				uiFunction(metadatasArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.FindByMultipleValues()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Metadatas from the server and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.FetchAll = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'FetchAll',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var metadatasArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					metadatasArray.push(new Metadata(genericObject));
				});
				uiFunction(metadatasArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.FetchAll()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};

/**
 * Retrieves all Metadatas from the server that matches
 * the searchText and gives it to the callback function
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.Search = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'Search',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var genericObjectsArray = JSON.parse(data);
				var metadatasArray = new Array();
				$.each(genericObjectsArray, function(index, genericObject){
					metadatasArray.push(new Metadata(genericObject));
				});
				uiFunction(metadatasArray, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.Search()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};/**
 * Retrieves the number of Metadata stored in the server
 *
 * @param		object			queryParams
 * @param		function		uiFunction
 * @param		object			uiExtraParams
 * @static
 */
MetadataModel.GetCount = function(queryParams, uiFunction, uiExtraParams){
	var ajaxParams = {
		obj : 'metadata',
		action : 'GetCount',
		params : queryParams
	};
	var callbackFunction = function(data, callbackExtraParams){
			if(data){
				var metadataCount = parseInt(data.replace('"',''));
				uiFunction(metadataCount, callbackExtraParams);
			} else {
				console.error("Unable to parse server response.MetadataModel.GetCount()");
			}
		};
	Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);
};